@extends('layouts.app')

@section('page-title', __('Network Log'))
@section('page-heading', __('Network Log'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Network Log')
    </li>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body" style="height: 100%">
            <div class="embed-responsive embed-responsive-21by9">
                <iframe src="{{env('NETWORK_LOG_URL')}}" frameborder="0" height="100%"></iframe>
            </div>
        </div>
    </div>
</div>
@stop
