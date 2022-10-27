<?php

namespace Vanguard\Http\Controllers\Web\Overbooking;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Vanguard\Models\DatBankSecret;
use Vanguard\Models\RefRunState;
use Vanguard\Models\TrxOverBooking;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Vanguard\Models\LogCallback;
use Illuminate\Support\Arr;

class OverbookingController extends Controller
{
    private $headerStyle;
    private $fontStyle;
    private $fontStylePdf;
    private $status;
    private $role;
    private $province_id;
    private $dati_id;

    public function __construct()
    {
        $this->headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FCE0E0E0',
                ],
            ],
        ];

        $this->fontStyle = [
            'font' => [
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ];

        $this->fontStylePdf = [
            'font' => [
                'size' => 25,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ];
        $this->status = [
            'code' => ['000', '001', '002', '100'],
            'success' => ['000', '001', '002'],
            'process' => ['100'],
            'message' => [
                '000' => '<span class="badge badge-pill bg-success text-white">Success</span>',
                '001' => '<span class="badge badge-pill bg-success text-white">Success no tax</span>',
                '002' => '<span class="badge badge-pill bg-success text-white">Success no potongan</span>',
                '100' => '<span class="badge badge-pill bg-warning text-dark">Processed</span>'
            ]
        ];
    }

    public function index()
    {
        $data['banks'] = DatBankSecret::get();
        $data['types'] = TrxOverBooking::select('tbk_type')->groupBy('tbk_type')->get();
        // $status = TrxOverBooking::select('ras_id')->with('ras')->groupBy('ras_id')->get();
        $data['recipient_name'] = TrxOverBooking::select('tbk_recipient_name')->whereNotNull('tbk_recipient_name')->distinct()->pluck('tbk_recipient_name')->toArray();
        $data['name'] = implode(',', $data['recipient_name']);
        $data['states'] = RefRunState::get();

        return view('Overbooking.indexnew', $data);
    }

    public function data(Request $request)
    {
        $overBooking = $this->getData($request);

        /** Baru nih gaes tapi jgn dipake ini mah gabut aja */
        // $overBooking = $this->getDataNew($request);

        return DataTables::of($overBooking)->addIndexColumn()
            ->editColumn('tbk_amount', function ($data) {
                return Helper::getRupiah($data->tbk_amount);
            })
            ->editColumn('tbk_execution_time', function ($data) {
                return Helper::getFormatWib($data->tbk_execution_time);
            })
            ->addColumn('Callback', function ($data) {
                if ($data->logCallback && $data->logCallback->lcb_request) {
                    $res = base64_encode($data->logCallback->lcb_request);
                    return '<button type="button" class="btn btn-primary btn-sm" onclick="openDetailCallback(`' . $res . '`)">Open</button>';
                } else {
                    return '-';
                }
            })
            ->addColumn('Actions', function ($data) {
                if ($data->request_data) {
                    $res = base64_encode($data->request_data);
                    return '<button type="button" class="btn btn-primary btn-sm" onclick="openDetailTransaksi(`' . $res . '`)">Detail</button>';
                } else {
                    return '-';
                }
            })
            // ->addColumn('State', function($data) {

            // })
            ->editColumn('ras_id', function ($data) {
                // dd($data);
                if (in_array($data->ras_id,  $this->status['code'])) {
                    return $this->status['message'][$data->ras_id];
                } else {
                    return '<span class="badge badge-pill bg-danger text-white">Failed</span>';
                }
            })
            ->rawColumns(['Callback', 'Actions', 'ras_id'])
            ->make(true);
    }

    public function exportToFile(Request $request)
    {
        if ($request->parameter) {
            if ($request->parameter == 'between') {
                $tanggal = "$request->start_date - $request->end_date";
            } else {
                $tanggal = "$request->start_date";
            }
        } else {
            $tanggal = '';
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setCellValue('A1', 'Transaksi Overbooking');
        $sheet->setCellValue('A2', 'Tanggal ' . $tanggal);
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');

        $sheet->setCellValue('A4', 'Bank Pengirim');
        $sheet->setCellValue('B4', 'Bank Penerima');
        $sheet->setCellValue('C4', 'Nama Penerima');
        $sheet->setCellValue('D4', 'Rekening Penerima');
        $sheet->setCellValue('E4', 'Total Transfer');
        $sheet->setCellValue('F4', 'No SP2D');
        $sheet->setCellValue('G4', 'Tipe');
        $sheet->setCellValue('H4', 'Tanggal Pengiriman');
        $sheet->setCellValue('I4', 'Status');
        $sheet->setCellValue('J4', 'Keterangan');
        $spreadsheet->getActiveSheet()->getStyle('A1:J4')->applyFromArray($this->headerStyle);
        $startRow = 5;
        $startCol = 'A';


        $datas = $this->getData($request)->get();
        foreach ($datas as $key => $value) {
            $sheet->setCellValue("{$startCol}{$startRow}", $value->senderBank->bank_name);
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", $value->receiverBank->bank_name);
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", $value->tbk_recipient_name);
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", $value->tbk_recipient_account);
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", Helper::getRupiah($value->tbk_amount));
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", $value->tbk_sp2d_no);
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", $value->tbk_type);
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", Helper::getFormatWib($value->tbk_execution_time));
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", (in_array($value->ras->ras_id, $this->status['success']) ? "Success" : $value->ras->ras_id == '100') ? "Processed" : "Failed");
            $startCol++;
            $sheet->setCellValue("{$startCol}{$startRow}", $value->tbk_sp2d_desc);
            $startRow++;
            $startCol = 'A';
        }

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        // $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $startRow--;

        if ($request->button == 'pdf') {
            $spreadsheet->getActiveSheet()
                ->getStyle("A1:J{$startRow}")
                ->applyFromArray($this->fontStylePdf);
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
            $path = storage_path("/app/transaksi_overbooking.pdf");
            $writer->save($path);
            return response()->download($path, 'transaksi_overbooking' . time() . '.pdf');
        }
        $spreadsheet->getActiveSheet()
            ->getStyle("A1:J{$startRow}")
            ->applyFromArray($this->fontStyle);
        $writer = new Xlsx($spreadsheet);
        $path = storage_path("/app/transaksi_overbooking.xlsx");
        $writer->save($path);
        return response()->download($path, 'transaksi_overbooking' . time() . '.xlsx');
    }

    public function getCallbackLast($id)
    {
        $res = LogCallback::where('lcb_partnerid', $id)->orderBy('lcb_created', 'desc')->first();

        return response()->json([
            'data' => $res
        ]);
    }

    private function getData($request)
    {
        // dd($request->start_date);
        $overBooking = TrxOverBooking::with('senderBank')
            ->with('receiverBank')
            ->with('ras')
            ->with('logCallback');

        if ($request->order[0]['column'] == 0) $overBooking->orderBy('tbk_created', 'desc');

        if ($request->tbk_partnerid) $overBooking->where('tbk_partnerid', $request->tbk_partnerid);

        if ($request->tbk_recipient_name) {
            $upper_tbk_recipient_name = strtoupper($request->tbk_recipient_name);
            $overBooking->where('tbk_recipient_name', 'LIKE', "%{$upper_tbk_recipient_name}%");
        }

        if ($request->tbk_recipient_account) $overBooking->where('tbk_recipient_account', $request->tbk_recipient_account);

        if ($request->tbk_sp2d_no) $overBooking->where('tbk_sp2d_no', $request->tbk_sp2d_no);

        if ($request->sender_bank) $overBooking->where('tbk_sender_bank_id', $request->sender_bank);

        if ($request->recipient_bank) $overBooking->where('tbk_recipient_bank_id', $request->recipient_bank);

        if ($request->type) $overBooking->where('tbk_type', $request->type);

        if ($request->ras_status) {
            if ($request->ras_status != 'failed') {
                $overBooking->whereIn('ras_id', $this->status[$request->ras_status]);
            } else {
                $overBooking->whereNotIn('ras_id', $this->status['code']);
            }
        }
        if ($request->parameter) {
            if ($request->parameter == 'between') {
                $overBooking->whereBetween('tbk_execution_time', [$request->start_date, $request->end_date]);
            } else {
                $overBooking->where('tbk_execution_time', $request->parameter, $request->start_date);
            }
        }
        if (env('APP_ENV') == 'production') {
            $overBooking->where('state', '01');
        } else {
            if ($request->state) $overBooking->where('state', $request->state);
        }

        if($request->tanggal == ''){
            $overBooking->orderBy('tbk_created', 'desc');
        }else{
            $overBooking->where('tbk_created', '=', $request->tanggal);
        }


        /** Filter by user */
        $this->role = auth()->user()->present()->role_id;
        $this->province_id = auth()->user()->present()->province_id;
        $this->dati_id = auth()->user()->present()->dati_id;

        switch ($this->role) {
            case 4:
                $overBooking->where(function ($query) {
                    $query->where('prop_id', $this->province_id);
                });
                break;
            case 5:
                $overBooking->where(function ($query) {
                    $query->where('prop_id', $this->province_id);
                    $query->where('dati2_id', $this->dati_id);
                });
                break;
            default:
                break;
        }

        return $overBooking;
    }

    private function getDataNew($request)
    {
        $paramFilter = ["tbk_partnerid", 'tbk_recipent_name', 'tbk_recipient_account', 'tbk_sp2d_no', 'sender_bank', 'recipient_bank', 'type', 'ras_status', 'parameter', 'start_date', 'end_date'];
        $queryFilter = ["tbk_partnerid", 'tbk_recipent_name', 'tbk_recipient_account', 'tbk_sp2d_no', 'tbk_sender_bank_id', 'tbk_recipient_bank_id', 'tbk_type', 'ras_id'];

        $overBooking = TrxOverBooking::with('senderBank')
            ->with('receiverBank')
            ->with('ras')
            ->with('logCallback');

        for ($i = 0; $i < count($paramFilter); $i++) {
            if (array_key_exists($paramFilter[$i], $request->all()) && $request->all()[$paramFilter[$i]] != null) {
                if ($paramFilter[$i] != 'parameter' && $paramFilter[$i] != 'start_date' && $paramFilter[$i] != 'end_date') {
                    if ($paramFilter[$i] == 'ras_status') {
                        $overBooking->whereIn($queryFilter[$i], $this->status[$request->all()[$paramFilter[$i]]]);
                    } else {
                        $overBooking->where($queryFilter[$i], $request->all()[$paramFilter[$i]]);
                    }
                }
                if ($paramFilter[$i] == 'parameter') {
                    if ($request->all()[$paramFilter[$i]] == 'between') {
                        $overBooking->whereBetween('tbk_execution_time', [$request->all()[$paramFilter[$i + 1]], $request->all()[$paramFilter[$i + 2]]]);
                    } else {
                        if ($paramFilter[$i] != 'end_date') {
                            $overBooking->where('tbk_execution_time', $request->parameter, $request->all()[$paramFilter[$i]]);
                        }
                    }
                }
            }
        }

        dd($overBooking->toSql());
        return $overBooking;
    }
}
