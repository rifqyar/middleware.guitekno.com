@extends('layouts.app')

@section('page-title', __('Log - Callback'))
@section('page-heading', __('Log Callback'))

@section('content')
    <div id="log_callback-component">
        <div class="card" id="list-data">
            <div class="card-body">
                <div>
                    <h6>Filter</h6>
                    <form class="form-group" method="GET" action="javascript:void(0)">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Service Type</p>
                                <select class="form-control filter" name="rst_id">
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
                                <input type="text" class="form-control filter" name="partner_id"
                                    @isset($param['partner_id']) value="{{ $param['partner_id'] }}" @endisset>
                            </div>
                            {{-- {{ var_dump($param['partner_id']) }} --}}
                            <div class="col-md-4">
                                <p>Callback Terakhir</p>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control filter" name="parameter">
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
                                        <input type="date" class="form-control filter" name="last_updated"
                                            @isset($param['last_updated']) value={{ $param['last_updated'] }} @endisset>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="submit" class="btn btn-primary mb-2" onclick="test()">Filter</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table t-log_callback" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Partner Id</th>
                                <th>Callback Pertama</th>
                                <th>Callback Terakhir</th>
                                <th>Sevice Type</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function (){
            renderTable()
        })

        function test(){
            // '?rst_id=&partner_id=&parameter=&last_updated='
            let param = '?'
            $('.filter').each((k, v) => {
                if($(v).val() != ''){
                    param += $(v).attr('name')+'='+$(v).val()+'&'
                }
            })
            param = param.slice(0, -1)
            renderTable(param) 
        }

        function renderTable(param = ''){
            $('.t-log_callback').DataTable().destroy();
            $('.t-log_callback').DataTable({
                processing: true,
                serverSide: true,
                ajax: `${$('meta[name="baseurl"]').attr('content')}log-callback${param}`,
                columns: [
                    { data: 'lcb_partnerid', name: 'lcb_partnerid' },
                    { data: 'created', name: 'created' },
                    { data: 'last_update', name: 'last_update' },
                    { data: 'service', name: 'service' },
                ],
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                columnDefs: [
                    { orderable: false, targets: 0 }
                ],
            });
        }
    </script>
@stop
