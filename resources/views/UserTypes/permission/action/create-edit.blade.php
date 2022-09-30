@extends('layouts.app')

@section('page-title', __('User Types'))
@section('page-heading', $edit ? $type->ut_name : __('Create New Types'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('types.index') }}">@lang('User Types')</a>
    </li>
    <li class="breadcrumb-item">
        @lang('Permissions')
    </li>
    <li class="breadcrumb-item active">
        {{-- @lang('Create') --}}
        {{ __($edit ? 'Edit' : 'Create') }}

    </li>
@stop

@section('content')

    @include('partials.messages')

    @if ($edit)
        {!! Form::open(['route' => ['types.update', $type], 'method' => 'PUT', 'id' => 'role-form']) !!}
    @else
        {!! Form::open(['route' => 'types.post', 'id' => 'role-form']) !!}
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('Type Details')
                    </h5>
                    <p class="text-muted">
                        @lang('A general type information.')
                    </p>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        {{-- {{ var_dump($type->ut_id) }} --}}
                        <label for="ut_name">@lang('Name')</label>
                        <input type="text" class="form-control input-solid" id="ut_name" name="ut_name"
                            placeholder="@lang('Type Name')" value="{{ $edit ? $type->ut_name : old('ut_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="ut_displayname">@lang('Display Name')</label>
                        <input type="text" class="form-control input-solid" id="display_name" name="display_name"
                            placeholder="@lang('Display Name')"
                            value="{{ $edit ? $type->ut_displayname : old('display_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="ut_desc">@lang('Description')</label>
                        <textarea name="description" id="description" class="form-control input-solid">{{ $edit ? $type->ut_desc : old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ __($edit ? 'Update Role' : 'Create Role') }}
    </button>

@stop
