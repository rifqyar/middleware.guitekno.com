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
    </script>
@stop
