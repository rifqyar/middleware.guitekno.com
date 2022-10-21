@extends('layouts.app')

@section('page-title', __('History Overbooking'))
@section('page-heading', __('History Overbooking'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('History Overbooking')
    </li>
@stop

@section('content')
    <style>
        table.dataTable {
            font-size: 12px;
        }
    </style>
    <script type='text/javascript'
        src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <div id="overbooking-component">
        <div class="card">
            <div id="filter">
                <div class="d-flex m-5">
                    <button class="btn btn-outline-success" onclick="addFilter('show')"> <i class="fas fa-filter"></i>
                        Filter</button>
                    <button class="btn btn-success ml-4" onclick="showData()"> <i class="fas fa-database"></i> Show All
                        Data</button>
                    <button class="btn btn-danger ml-4" onclick="pdfByFilter()"> <i class="fas fa-download"></i> Export to
                        PDF</button>
                    {{-- <button class="btn btn-danger ml-4" id="test"> <i class="fas fa-download"></i>
                        Export to
                        PDF(test)</button> --}}
                </div>
                <div class="container-fluid ml-3" id="form-filter" style="display: none">
                    <button class="btn btn-info ml-3 mb-3" onclick="addFilter('add')">
                        <i class="fas fa-plus-circle"></i>
                        Add Filter
                    </button>
                    {{-- @include('history_overbooking.component.formFilter') --}}
                </div>

                <button class="btn btn-outline-primary btn-sm m-5 float-right" id="setFilter" style="display: none"
                    onclick="setFilter()">
                    Show Filtered Data
                </button>
            </div>
            <div id="list-data" style="display: none">
                @include('history_overbooking.component.tableData')
            </div>
        </div>
    </div>

    <script src="{{ url('assets/js/masterAPI.min.js') }}"></script>
    <script src="{{ url('vendor/plugins/history_overbooking/main.min.js') }}"></script>
    {{-- <script src="{{url('assets/dev/history_overbooking/main.js')}}"></script> --}}

@stop

@section('scripts')

    <script>
        function pdfByFilter() {

            // // var filter = btoa(`${field} ${parameter} '${value}' `);

            // if (typeof field === 'undefined' || typeof parameter === 'undefined' || typeof value === 'undefined') {
            //     var filter = 'all';
            // } else {
            //     var filter = btoa(`${field} ${parameter} '${value}' `);
            // }
            // // var filter = btoa(`${field} ${parameter} '${value}' `);

            // console.log(filter)
            // window.location = '/overbooking-pdf/' + filter

            const mainComponent = $("#overbooking-component");
            var e = mainComponent.find("#form-filter").find(".form-container");
            var n = mainComponent.find(e).find(".required");
            var filter_data = "";

            e.find(".form-control").each((e, n) => {
                "none" != $(n).css("display") &&
                    (filter_data +=
                        "value" != $(n).attr("name") ?
                        `${$(n).val()} ` :
                        `'${$(n).val()}' `);
            })
            if (filter_data == "" || filter_data == " = 'null' ") {
                var filter = 'all'
                window.location = '/overbooking-pdf/' + filter

            }
            // else if (filter_data == " <> 'null' " || filter_data == " > 'null' " || filter_data == " < 'null' " ||
            //     filter_data == " >= 'null' " || filter_data == " <= 'null' ") {
            //     swal({
            //         title: "Failed",
            //         text: "Please insert the filter",
            //         icon: "error",
            //     });
            // }
            else {
                var filter = btoa(`${filter_data}`)
                window.location = '/overbooking-pdf/' + filter
            }
        }
    </script>
@stop
