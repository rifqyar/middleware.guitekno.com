<head>
    <title>Overbooking - Middleware</title>
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<h1>Overbooking</h1>
<table class="table" style="margin-left: -20px; font-size: 10px;width: 50%;">
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
                <td>{{ $data->status_text }}</td>
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
