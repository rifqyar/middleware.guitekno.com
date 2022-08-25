@extends('layouts.app')

@section('page-title', __('Log - Callback'))
@section('page-heading', __('Log Callback'))

@section('content')
    <div id="overbooking-component">
        <div class="card" id="list-data">
            <div class="card-body">
                <div>
                    <h6>Filter</h6>
                    <form class="form-group" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="sr-only">RST</label>
                                <select class="form-control" name="rst_id">
                                    <option value="">All</option>
                                    <option value="051">SIPD / Otomatis</option>
                                    <option value="052">Bank</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table t-overbooking" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Partner Id</th>
                                <th>Callback Pertama</th>
                                <th>Callback Terakhir</th>
                                <th>Sevice Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $index => $value)
                                <tr>
                                    <td>{{ $value->lcb_partnerid }}</td>
                                    <td>{{ Helper::getFormatWib($value->lcb_created) }} </td>
                                    <td>{{ Helper::getFormatWib($value->lcb_last_updated) }} </td>
                                    <td>{{ $value->rst->rst_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $datas->links() }}
                </div>
            </div>
        </div>
    </div>


@stop
