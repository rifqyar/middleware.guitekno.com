@extends('layouts.app')

@section('page-title', __('User Types'))
{{-- @section('page-heading', __('Create New Types')) --}}
@section('page-heading', $edit ? $type->ut_name : __('Create New Types'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('types.index') }}">@lang('User Types')</a>
    </li>
    <li class="breadcrumb-item">
        @lang('Permissions')
        {{-- {{ __($edit ? 'Edit' : 'Create') }} --}}
    </li>
    <li class="breadcrumb-item active">
        {{-- @lang('Create') --}}
        {{ __($edit ? 'Edit' : 'Create') }}

    </li>
@stop

@section('content')

    {{-- {{ var_dump($type) }} --}}

    @include('partials.messages')

    {!! Form::open(['route' => 'types.post', 'id' => 'role-form']) !!}

    {{-- @if ($edit)
        {!! Form::open(['route' => ['types.update', $types], 'method' => 'PUT', 'id' => 'role-form']) !!}
    @else
        {!! Form::open(['route' => 'types.post', 'id' => 'role-form']) !!}
    @endif --}}

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
                        <label for="ut_name">@lang('Name')</label>
                        <input type="text" class="form-control input-solid" id="ut_name" name="ut_name"
                            placeholder="@lang('Type Name')" value="{{ $edit ? $type->ut_name : '' }}">
                        {{-- <input type="text" class="form-control input-solid" id="name" name="name"
                            placeholder="@lang('Type Name')" value="{{ $edit ? $role->name : old('name') }}"> --}}
                    </div>
                    <div class="form-group">
                        <label for="ut_displayname">@lang('Display Name')</label>
                        <input type="text" class="form-control input-solid" id="ut_displayname" name="ut_displayname"
                            placeholder="@lang('Display Name')">
                        {{-- <input type="text" class="form-control input-solid" id="display_name" name="display_name"
                            placeholder="@lang('Display Name')" value="{{ $edit ? $role->display_name : old('display_name') }}"> --}}
                    </div>
                    <div class="form-group">
                        <label for="ut_desc">@lang('Description')</label>
                        <textarea name="ut_desc" id="ut_desc" class="form-control input-solid"></textarea>
                        {{-- <textarea name="description" id="description" class="form-control input-solid">{{ $edit ? $role->description : old('description') }}</textarea> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ __('Create Type') }}
        {{-- {{ __($edit ? 'Update Role' : 'Create Role') }} --}}
    </button>

@stop

@section('scripts')
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Role\CreateRoleRequest', '#role-form') !!}

    {{-- @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Role\UpdateRoleRequest', '#role-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Role\CreateRoleRequest', '#role-form') !!}
    @endif --}}
@stop
