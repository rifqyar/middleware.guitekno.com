@extends('layouts.app')

@section('page-title', __('Master Data - Ref Bank'))
@section('page-heading', __('Master Data - Ref Bank'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Master Data')
    </li>
    <li class="breadcrumb-item active">
        @lang('Bank')
    </li>
@stop

@section('content')
    <style>
        table.dataTable {
            font-size: 12px;
        }
    </style>
    <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <div id="bank-component">
        <div id="bank_res_data">

        </div>
        <div class="card" id="list-data" style="display: none">
            <div class="col-md-12 col-12 mv-4 mt-2">
                <button class="btn btn-primary btn-rounded float-right" id="btn-add">
                    <i class="fas fa-plus mr-2"></i>
                    @lang('Add Bank')
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table t-refBank" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Bank ID</th>
                                <th>Bank Name</th>
                                <th>Status</th>
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
            @include('MasterData.bank.component.add')
        </div>

        <div class="card" id="edit" style="display: none">
            @include('MasterData.bank.component.edit')
        </div>
    </div>

    <script src="{{ url('assets/js/masterAPI.min.js') }}"></script>
    <script src="{{url("assets/dev/MasterData/bank/js/main.js")}}"></script>
    {{-- <script src="{{ url("vendor/plugins/master-data/bank/js/main.min.js") }}"></script> --}}
    
@stop