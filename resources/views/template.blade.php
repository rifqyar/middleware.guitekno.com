@extends('layouts.app')

@section('page-title', __('Name'))
@section('page-heading', __('Name'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Name')
    </li>
@stop

@section('content')

    <div class="container-fluid">

    </div>

@stop

@section('scripts')
    <!-- @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
    @if (method_exists($widget, 'scripts'))
    {!! app()->call([$widget, 'scripts']) !!}
    @endif
    @endforeach -->
@stop
