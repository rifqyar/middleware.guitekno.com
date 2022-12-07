<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baseurl" content="{{ asset('') }}">

    <title>Tambah Integrasi Bank - {{ setting('app_name') }}</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"
        integrity="sha256-6XMVI0zB8cRzfZjqKcD01PBsAy3FlDASrlC8SxCpInY=" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('assets/img/icons/kemendagri.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('assets/img/icons/kemendagri.png') }}" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/kemendagri.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/kemendagri.png') }}" sizes="16x16" />
    <meta name="application-name" content="{{ setting('app_name') }}" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ url('assets/img/icons/kemendagri.png') }}" />

    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/vendor.css')) }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/app.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .hai {
            -webkit-box-shadow: 0px 0px 16px -8px rgba(0, 0, 0, 0.68);
            box-shadow: 0px 0px 16px -8px rgba(0, 0, 0, 0.68);
        }
    </style>
</head>

<body>
    <!-- Page Style -->
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
    <!-- Page Style -->

    <!-- Content -->
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
                                    @include('integrasi_eksternal/component/addBankSecret')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="endpoint-bank">
                        <div class="container">
                            <div class="card p-4 mt-3">
                                <div class="row justify-content-center">
                                    @include('integrasi_eksternal/component/addBankEndpoint')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="konfirm">
                        <div class="container">
                            <div class="card p-4 mt-3">
                                <div class="row justify-content-center">
                                    @include('integrasi_eksternal/component/preview')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Content -->

    <script src="{{ url(mix('assets/js/vendor.js')) }}"></script>
    <script src="{{ url('assets/js/as/app.js') }}"></script>

    <link rel="stylesheet" href="{{ url('vendor/jquery-toast/src/jquery.toast.css') }}">
    <script src="{{ url('vendor/jquery-toast/src/jquery.toast.js') }}"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-bootstrap-wizard@1.4.2/jquery.bootstrap.wizard.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ url('assets/js/masterAPI.min.js') }}"></script>
    <script src="{{ url('vendor/plugins/integrasi_eksternal/main.min.js')}}"></script>