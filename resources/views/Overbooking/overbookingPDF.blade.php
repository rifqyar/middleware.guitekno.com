<head>
    <title>Overbooking - Middleware</title>
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/kemendagri.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/kemendagri.png') }}" sizes="16x16" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('assets/img/icons/kemendagri.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('assets/img/icons/kemendagri.png') }}" />
</head>
<h1 style="text-align: center">Overbooking Transaction</h1>
<p>Tanggal Cetak: {{ date('d F Y') }}</p>
{{-- <p>Author: {{ auth()->user()->present()->nameOrEmail }}</p> --}}
<table class="table" style="margin-left: -15px; font-size: 10px;width: 50%;">
    <thead>
        <tr>
            {{-- <th>Action</th> --}}
            <th>Status</th>
            <th>Partner ID</th>
            <th>Bank Pengirim</th>
            <th>Rekening Pengirim</th>
            <th>Jumlah Pengirim</th>
            <th>Notes</th>
            <th>Bank Penerima</th>
            <th>Rekening Penerima</th>
            <th>Jumlah Penerima</th>
            <th>Waktu Transaksi</th>
            <th>Deskripsi</th>
            <th>Status Pesan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($overbooking as $data)
            <tr>
                @if ($data->status_text === 'Processed')
                    <td><span class="badge badge-pill bg-warning mr-2 text-dark">{{ $data->status_text }}</span></td>
                    {{-- @elseif($data->status_text === 'Process')
                    <td><span
                            class="badge badge-pill bg-warning text-dark mr-2 text-dark">{{ $data->status_text }}</span>
                    </td> --}}
                @elseif($data->status_text === 'Success')
                    <td><span class="badge badge-pill bg-success mr-2 text-light">{{ $data->status_text }}</span></td>
                @else
                    <td><span class="badge badge-pill bg-danger mr-2 text-light">{{ $data->status_text }}</span></td>
                @endif

                <td>{{ $data->tbk_id }}</td>
                <td>{{ $data->sender_bank_name }}</td>
                <td>{{ $data->tbk_sender_account }}</td>
                {{-- <td>Rp {{ number_format($data->tbk_sender_amount, 3, ',', '.') }}</td> --}}
                <td>Rp {{ number_format($data->tbk_sender_amount, 0, ',', '.') }}</td>
                <td>{{ $data->tbk_notes }}</td>
                <td>{{ $data->recipient_bank_name }}</td>
                <td>{{ $data->tbk_recipient_account }}</td>
                <td>Rp {{ number_format($data->tbk_recipient_amount, 0, ',', '.') }}</td>
                <td>{{ $data->tbk_execution_time }}</td>
                <td>{{ $data->tbk_sp2d_desc }}</td>
                <td>{{ $data->status_message }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
