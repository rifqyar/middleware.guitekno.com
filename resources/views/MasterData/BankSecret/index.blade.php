@extends('layouts.app')

@section('page-title', __('Master Data - Bank Secret'))
@section('page-heading', __('Master Data - Bank Secret'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Master Data')
    </li>
    <li class="breadcrumb-item active">
        @lang('Bank Secret')
    </li>
@stop

@section('content')
    <style>
        table.dataTable {
            font-size: 12px;
        }
    </style>
    <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <div id="bSecret-component">
        <div id="bSecret_res_data">

        </div>
        <div class="card" id="list-data" style="display: none">
            <div class="col-md-12 col-12 mv-4 mt-2">
                <button class="btn btn-primary btn-rounded float-right" id="btn-add">
                    <i class="fas fa-plus mr-2"></i>
                    @lang('Add Bank Secret')
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table t-bankSecret" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code Bank</th>
                                <th>Bank Name</th>
                                <th>Client ID</th>
                                <th>Client Secret</th>
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
        
        <div class="card" id="add" style="display: none">
            @include('MasterData.BankSecret.component.add')
        </div>

        <div class="card" id="edit" style="display: none">
            @include('MasterData.BankSecret.component.edit')
        </div>
    </div>

    @include('MasterData/BankSecret/component/modal')

    <script src="{{ url('assets/js/masterAPI.min.js') }}"></script>
    {{-- <script src="{{ url("assets/dev/MasterData/BankSecret/js/main.js") }}"></script> --}}
    <script src="{{ url("vendor/plugins/master-data/BankSecret/js/main.min.js") }}"></script>
    <script>
        $(function(){
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop