@extends('layouts.app')

@section('page-title', __('Master Data - Api Status'))
@section('page-heading', __('Master Data - Api Status'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Master Data')
    </li>
    <li class="breadcrumb-item active">
        @lang('Api Status')
    </li>
@stop

@section('content')
    <style>
        table.dataTable {
            font-size: 12px;
        }
    </style>
    <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <div id="apiStatus-component">
        <div id="apiStatus_res_data">

        </div>
        <div class="card" id="list-data" style="display: none">
            <div class="col-md-12 col-12 mv-4 mt-2">
                <button class="btn btn-primary btn-rounded float-right" id="btn-add">
                    <i class="fas fa-plus mr-2"></i>
                    @lang('Add Api Status')
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table t-refapiStatus" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Message</th>
                                <th>Description</th>
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
            @include('MasterData.ApiStatus.component.add')
        </div>

        <div class="card" id="edit" style="display: none">
            @include('MasterData.ApiStatus.component.edit')
        </div>
    </div>

    <script src="{{ url('assets/js/masterAPI.min.js') }}"></script>
    {{-- <script src="{{ url('assets/dev/MasterData/ApiStatus/js/main.js') }}"></script> --}}
    <script src="{{ url("vendor/plugins/master-data/ApiStatus/js/main.min.js") }}"></script>
@stop