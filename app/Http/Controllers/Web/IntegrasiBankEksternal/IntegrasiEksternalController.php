<?php

namespace Vanguard\Http\Controllers\Web\IntegrasiBankEksternal;

use Illuminate\Http\Request;
use Throwable;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\DatBankSecret;
use Vanguard\Models\RefBank;
use Vanguard\Models\RefEndpointType;

class IntegrasiEksternalController extends Controller
{
    public function index(){

        return view('integrasi_eksternal/index');
    }

    public function getBank($id){
        try {
            $isBankExist = DatBankSecret::where('code_bank', $id)->count();
            if($isBankExist){
                return response()->json([
                    'status' => [
                        'code' => 400,
                        'msg' => "Bank Sudah pernah terintegrasi!! \nharap hubungi tim teknik untuk informasi lebih lanjut"
                    ]
                ], 400);
            }

            $databank = RefBank::where('bank_id', $id)->get();
            if(count($databank) == 0){
                return response()->json([
                    'status' => [
                        'code' => 404,
                        'msg' => 'Bank tidak ditemukan'
                    ]
                ], 404);
            }

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'OK'
                ], 'data' => $databank[0]
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => $th
                ]
            ], 500);
        }
    }

    public function renderFormEndpoint(){
        $data = RefEndpointType::all();
        $blade = view('integrasi_eksternal/component/formAdd', compact('data'))->render();

        return response()->json([
            'status' => [
                'code' => 200,
                'msg' => 'OK'
            ], 'view' => $blade
        ], 200);
    }
}
