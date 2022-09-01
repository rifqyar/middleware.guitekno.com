@extends('layouts.app')

@section('page-title', __('User Service'))
@section('page-heading', __('User Service'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('User Service')
    </li>
@stop



@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div style="display: flex;justify-content:space-between">
                        <div>
                            <h6 class="card-header">User Service Bpd & Sipd</h6>
                        </div>
                        <div class="card-header">
                            <a href="/user-service/form">
                                <button class="btn btn-primary">
                                    Tambah
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="list-user">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modal-listIp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List Ip yang terdaftar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="location-list">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-ip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Ip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">BPD</label>
                            <input type="text" class="form-control" id="name_bank_form" readonly>
                            <input type="text" class="form-control" id="id_bank_form" hidden>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">IP Address</label>
                            <input type="text" class="form-control" id="ip_form">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveIpAdd()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <!-- @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
    @if (method_exists($widget, 'scripts'))
    {!! app()->call([$widget, 'scripts']) !!}
    @endif
    @endforeach -->
    <script>
        $(function() {
            var table = $('#list-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user-service-post') }}",
                    method: "post"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'bank_id',
                        name: 'bank_id'
                    },
                    {
                        data: 'dau_username',
                        name: 'dau_username'
                    },
                    {
                        data: 'dau_password',
                        name: 'dau_password'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        function getIp(bank_code) {
            $('#modal-listIp').modal('show')
            $.ajax({
                    method: "get",
                    url: `/user-service/ip/view/${bank_code}`,
                })
                .done(function(res) {
                    console.log(res)
                    $('#location-list').html(res)
                })
        }

        function deleteIp(id, bank_code) {
            $('#modal-listIp').modal('hide')
            $.ajax({
                    method: "delete",
                    url: `user-service/ip/delete/${id}`,
                })
                .done(function(res) {
                    getIp(bank_code)
                })
        }

        function modalIpShow(id, name) {
            $('#name_bank_form').val(name)
            $('#id_bank_form').val(id)
            $('#modal-listIp').modal('hide')
            $('#modal-add-ip').modal('show')
        }

        function saveIpAdd() {
            $('#modal-add-ip').modal('hide')
            $.ajax({
                    method: "post",
                    url: `user-service/ip/save`,
                    data: {
                        bank_id: $('#id_bank_form').val(),
                        ip_address: $('#ip_form').val(),
                    }
                })
                .done(function(res) {
                    getIp($('#id_bank_form').val())
                })
        }
    </script>
@stop
