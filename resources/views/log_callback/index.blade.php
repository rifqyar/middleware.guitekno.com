@extends('layouts.app')

@section('page-title', __('Log - Callback'))
@section('page-heading', __('Log Callback'))

@section('content')
    <div id="overbooking-component">
        <div class="card" id="list-data">
            <div class="card-body">
                <div>
                    <h6>Filter</h6>
                    <form class="form-group" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Service Type</p>
                                <select class="form-control" name="rst_id">
                                    <option value="">All</option>

                                    <option value="051"
                                        {{ isset($param['rst_id']) && $param['rst_id'] == '051' ? 'selected' : '' }}>SIPD /
                                        Otomatis
                                    </option>
                                    <option value="052"
                                        {{ isset($param['rst_id']) && $param['rst_id'] == '052' ? 'selected' : '' }}>Bank
                                    </option>

                                </select>
                                {{-- {{ var_dump($param['rst_id']) }} --}}
                            </div>
                            <div class="col-md-4">
                                <p>Partner Id</p>
                                <input type="text" class="form-control" name="partner_id"
                                    value="{{ isset($param['partner_id']) && $param['partner_id'] }}">
                            </div>
                            {{-- {{ var_dump($param['partner_id']) }} --}}
                            <div class="col-md-4">
                                <p>Callback Terakhir</p>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control" name="parameter">
                                            <option value="">All</option>
                                            <option value="<"
                                                {{ isset($param['parameter']) && $param['parameter'] == '<' ? 'selected' : '' }}>
                                                < </option>
                                            <option value=">"
                                                {{ isset($param['parameter']) && $param['parameter'] == '>' ? 'selected' : '' }}>
                                                >
                                            </option>
                                            <option value="="
                                                {{ isset($param['parameter']) && $param['parameter'] == '=' ? 'selected' : '' }}>
                                                =
                                            </option>
                                            <option value=">="
                                                {{ isset($param['parameter']) && $param['parameter'] == '>=' ? 'selected' : '' }}>
                                                >=
                                            </option>
                                            <option value="<="
                                                {{ isset($param['parameter']) && $param['parameter'] == '<=' ? 'selected' : '' }}>
                                                <= </option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" name="last_updated"
                                            value={{ isset($param['last_updated']) && $param['last_updated'] }}>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="table-responsive mt-4">
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
