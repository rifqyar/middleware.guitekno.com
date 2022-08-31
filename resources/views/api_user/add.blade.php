@extends('layouts.app')

@section('page-title', __('Name'))
@section('page-heading', __('Name'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Name')
    </li>
@stop

@section('styles')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div style="display: flex;justify-content:space-between">
                        <div>
                            <h6 class="card-header">Form User Service</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/user-service/add/save">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Bpd</label>
                                <select class="form-control js-example-basic-single" name="bank_id">
                                    @foreach ($banks as $index => $value)
                                        <option class="{{ $index }}" value="{{ $value->bank_id }}">
                                            {{ $value->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#exampleFormControlSelect1').select2();
            $('select').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
    <!-- @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
    @if (method_exists($widget, 'scripts'))
    {!! app()->call([$widget, 'scripts']) !!}
    @endif
    @endforeach -->
@stop
