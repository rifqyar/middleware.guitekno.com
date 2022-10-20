@extends('layouts.app')

@section('page-title', __('Stream Log'))
@section('page-heading', __('Stream Log'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Stream Log')
    </li>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body" style="height: 100%">
            <div class="embed-responsive embed-responsive-21by9">
                <iframe src="{{env('STREAM_LOG_URL')}}" frameborder="0" height="100%"></iframe>
            </div>
        </div>
    </div>
</div>
@stop
