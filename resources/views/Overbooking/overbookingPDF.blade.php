<head>
    <title>Overbooking - Middleware</title>
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/kemendagri.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/kemendagri.png') }}" sizes="16x16" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('assets/img/icons/kemendagri.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('assets/img/icons/kemendagri.png') }}" />
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .badge {
                transition: none;
            }
        }

        a.badge:hover,
        a.badge:focus {
            text-decoration: none;
        }

        .badge:empty {
            display: none;
        }

        .btn .badge {
            position: relative;
            top: -1px;
        }

        .badge-pill {
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem;
        }

        .text-light {
            color: #f8f9fa !important;
        }

        a.text-light:hover,
        a.text-light:focus {
            color: #cbd3da !important;
        }

        .text-dark {
            color: #343a40 !important;
        }

        a.text-dark:hover,
        a.text-dark:focus {
            color: #121416 !important;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem !important;
        }
    </style>
</head>
<h1 style="text-align: center">Overbooking Transaction</h1>
<p>Tanggal Cetak: {{ date('d F Y') }}</p>
{{-- <p>Author: {{ auth()->user()->present()->nameOrEmail }}</p> --}}
<table class="table" style="margin-left: -35px; font-size: 11.5px;width: 50%;">
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
            {{ dd($data) }}
            <tr>
                @if ($data->status_text === 'Processed')
                    <td><span class="badge badge-pill bg-warning mr-2 text-dark">{{ $data->status_text }}</span></td>
                @elseif($data->status_text === 'Success')
                    <td><span class="badge badge-pill bg-success mr-2 text-light">{{ $data->status_text }}</span></td>
                @else
                    <td><span class="badge badge-pill bg-danger mr-2 text-light">{{ $data->status_text }}</span></td>
                @endif

                <td>{{ $data->tbk_partnerid }}</td>
                <td>{{ $data->sender_bank_name }}</td>
                <td>{{ $data->tbk_sender_account }}</td>
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
