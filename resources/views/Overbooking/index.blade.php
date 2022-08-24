@extends('layouts.app')

@section('page-title', __('Transaction - Overbooking'))
@section('page-heading', __('Transaction - Overbooking'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Log Transaction')
    </li>
    <li class="breadcrumb-item active">
        @lang('SIPD')
    </li>
@stop
@section('content')
    <script type='text/javascript'
        src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <div id="overbooking-component">
        <div class="card" id="list-data">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table t-overbooking" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Sender Bank Name</th>
                                <th>Transaction Created</th>
                                <th>Sender Ammount</th>
                                <th>Notes</th>
                                <th>Transaction Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['trans'] as $table)
                                <tr>
                                    <td>{{ $table->bank_pengirim }}</td>
                                    <td>{{ substr($table->tanggal, 0, 10) }}</td>
                                    <td>{{ $table->jumlah }}</td>
                                    <td>{{ $table->keterangan }}</td>
                                    <td>{{ $table->tipe }}</td>
                                    <td class="badge badge-warning">{{ $table->status }}</td>
                                    @if ($table->status == 'Success')
                                        <td class="badge badge-success">{{ $table->status }}</td>
                                    @elseif ($table->status == 'Process')
                                        <td class="badge badge-warning">{{ $table->status }}</td>
                                    @else
                                        <td class="badge badge-danger">{{ $table->status }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('assets/js/masterAPI.js') }}"></script>
    <script src="{{ url('vendor/plugins/history_overbooking/main.js') }}"></script>

@stop
