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
    .nav-pills > li.active > a:after {
        background-color: #179970;
    }
    .nav-pills > li.active > a {
        color: #179970;
    }
    .icon-circle.checked {
        border-color: #179970;
        background-color: #179970
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
    <div class="card px-0 mt-3 mb-4">
        <div class="container px-0 py-0 pt-3 mb-4">
            <div class="row justify-content-center">
                <p>
                    <h4>Tambah Integrasi Bank</h4>
                </p>
                <span>input data bank</span>
            </div>

            <div class="container mt-5">
                <div class="progress progress-with-circle" style="height: 2px">
                    <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 16.6667%;"></div>
                </div>

                <ul class="nav nav-pills" style="text-align: center !important">
                    <li class="active" style="width: 33.3333%;">
                        <a href="#about" data-toggle="tab" aria-expanded="true">
                            <div class="icon-circle checked">
                                <i class="fas fa-lock"></i>
                            </div>
                            Data Bank
                        </a>
                    </li>
                    <li style="width: 33.3333%;">
                        <a href="#account" data-toggle="tab">
                            <div class="icon-circle">
                                <i class="fas fa-link"></i>
                            </div>
                            Endpoint Bank
                        </a>
                    </li>
                    <li style="width: 33.3333%;">
                        <a href="#address" data-toggle="tab">
                            <div class="icon-circle">
                                <i class="fa fa-check-circle-o"></i>
                            </div>
                            Konfirmasi Data
                        </a>
                    </li>
                </ul>

                
            </div>
        </div>
    </div>
</div>

<script src="{{url('assets/dev/integrasi_bank/js/main.js')}}"></script>
@stop
