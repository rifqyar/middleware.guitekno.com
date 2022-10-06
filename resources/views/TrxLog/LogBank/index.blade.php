@extends('layouts.app')

@section('page-title', __('Log Transaction - Bank'))
@section('page-heading', __('Log Transaction - Bank'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Log Transaction')
    </li>
    <li class="breadcrumb-item active">
        @lang('Bank')
    </li>
@stop

@section('content')
    {{-- <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script> --}}
    <div id="logBank-component">
        <div class="container-fluid" id="list-data">
            <div class="d-flex align-items-center mb-3">
                <div class="col-lg-10 col-12">
                    <div class="row align-items-center">
                        <span>Showing</span>
                        <select name="perPage" class="form-control mx-2" style="width: 10vh; height: 5vh">
                            <option value="5" selected="true">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>Entries</span>
                    </div>
                </div>
                <div class="col-lg-2 col-12">
                    <div class="d-flex flex-end">
                        <b>Total Data : {{$data['totalAllData'][0]->total}}</b>
                    </div>
                </div>
            </div>
            @if(count($data['header']) > 0)
                @foreach ($data['header'] as $h)
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between align-items-center" data-name="{{$h->rst_name}}" id="{{$h->rst_id}}">
                            <h6 class="d-flex align-items-center" onclick="collapse('{{$h->rst_id}}')" style="cursor: pointer"> 
                                {{$h->rst_name}} 
                                <button class="btn btn-icon btn-sm btn-warning ml-3" onclick="getData(`{{$h->rst_id}}`)" style="display: none"><i class="fas fa-refresh text-white"></i></button>
                            </h6>
                            <span class="badge badge-info mr-2">
                                {{$h->total}}
                            </span>
                        </div>
                        <div class="card-body data-log-bank" id="data-{{$h->rst_id}}" style="display: none">
                        </div>
                    </div>
                @endforeach
            @else
                <center>
                    <h3>
                        <font color="red">There's nothing to show</font>
                    </h3>
                </center>
            @endif
        </div>

    </div>

    @include('TrxLog.LogBank.component.modal')

    <script src="{{ url('assets/js/masterAPI.min.js') }}"></script>
    {{-- <script src="{{url('assets/dev/trxlog/bank/main.js')}}"></script> --}}
    <script src="{{ url("vendor/plugins/trxlog/bank/main.min.js") }}"></script>
    
@stop