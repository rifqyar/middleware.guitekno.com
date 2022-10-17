@extends('layouts.app')

@section('page-title', __('Tambah Integrasi Bank'))
@section('page-heading', __('Tambah Integrasi Bank'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Integrasi Bank')
    </li>
    <li class="breadcrumb-item active">
        @lang('Tambah')
    </li>
@stop

@section('content')
<style>
    .progress-with-circle {
        position: relative;
        top: 40px;
        z-index: 50;
        height: 4px;
    }
    .progress-with-circle .progress-bar {
        box-shadow: none;
        -webkit-transition: width .3s ease;
        -o-transition: width .3s ease;
        transition: width .3s ease;
    }
    .icon-circle {
        font-size: 20px;
        border: 3px solid #F3F2EE;
        text-align: center;
        border-radius: 50%;
        color: rgba(0, 0, 0, 0.53);
        font-weight: 600;
        width: 70px;
        height: 70px;
        background-color: #FFFFFF;
        margin: 0 auto;
        position: relative;
        top: -2px;
        z-index: 100
    }
    .nav-pills > li.active > a > .icon-circle {
        background-color: #179970;
    }
    .nav-pills > li.active > a {
        color: #179970;
    }
    .icon-circle.checked {
        border-color: #179970;
    }
    .icon-circle [class*="fas "] {
        position: absolute;
        z-index: 1;
        left: 1px;
        right: 0px;
        top: 23px;
    }
    .icon-circle [class*="fa "] {
        position: absolute;
        z-index: 1;
        left: 1px;
        right: 0px;
        top: 23px;
    }

    .nav-pills > li > a {
        text-decoration: none !important;
    }
</style>
<div class="container-fluid">
    <div id="bank_res_data"></div>
    <div id="bEndpoint_res_data"></div>
    <div id="endpointData"></div>

    <div class="wizard-container">
        <div class="card px-0 mt-3 mb-2 wizard-card">
            <div class="wizard-header mt-4">
                <div class="row justify-content-center">
                    <p>
                        <h4>Tambah Integrasi Bank</h4>
                    </p>
                </div>
            </div>

            <div class="wizard-navigation">
                <div class="progress progress-with-circle" style="height: 2px">
                    <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                </div>

                <ul class="nav nav-pills" style="text-align: center !important">
                    <li class="active" id="step-1">
                        <a href="#data-bank" data-toggle="tab" aria-expanded="true" >
                            <div class="icon-circle">
                                <i class="fas fa-lock"></i>
                            </div>
                            Data Bank
                        </a>
                    </li>
                    <li id="step-2">
                        <a href="#endpoint-bank" data-toggle="tab" >
                            <div class="icon-circle">
                                <i class="fas fa-link"></i>
                            </div>
                            Endpoint Bank
                        </a>
                    </li>
                    <li id="step-3" >
                        <a href="#konfirm" data-toggle="tab">
                            <div class="icon-circle">
                                <i class="fa fa-check-circle-o"></i>
                            </div>
                            Konfirmasi Data
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="data-bank">
                    <div class="container">
                        <div class="card p-4 mt-3">
                            <div class="row justify-content-center">
                                @include('integrasI_bank/component/addBankSecret')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="endpoint-bank">
                    <div class="container">
                        <div class="card p-4 mt-3">
                            <div class="row justify-content-center">
                                @include('integrasI_bank/component/addBankEndpoint')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="konfirm">
                    <div class="container">
                        <div class="card p-4 mt-3">
                            <div class="row justify-content-center">
                                @include('integrasI_bank/component/preview')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="wizard-footer p-4">
                <div class="pull-right">
                    <button class="btn btn-primary btn-rounded float-right ml-3 btn-next">
                        @lang('Next')
                        <i class="fas fa-chevron-right mr-2"></i>
                    </button>

                    <button class="btn btn-primary btn-rounded float-right ml-3 btn-finish">
                        @lang('Finish')
                        <i class="fas fa-checklist mr-2"></i>
                    </button>
                </div>

                <div class="pull-left">
                    <button class="btn btn-warning btn-rounded float-right btn-previous">
                        <i class="fas fa-chevron-left mr-2"></i>
                        @lang('Back')
                    </button>
                </div>
                <div class="clearfix"></div>
            </div> --}}
        </div>
    </div>
</div>

    {{-- <script src="{{ url('assets/js/masterAPI.min.js') }}"></script> --}}
    <script src="{{ url('assets/dev/masterAPI.js') }}"></script>
    <script src="{{url('assets/dev/integrasi_bank/js/main.js')}}"></script>
@stop
