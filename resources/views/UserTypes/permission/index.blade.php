@extends('layouts.app')

@section('page-title', __('User Types'))
@section('page-heading', __('User Types'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('User Types')
    </li>
    <li class="breadcrumb-item active">
        @lang('Permissions')
    </li>
@stop

@section('content')

    {{-- @include('partials.messages') --}}

    <div class="card">
        <div class="card-body">
            <div class="row mb-3 pb-3 border-bottom-light">
                <div class="col-lg-12">
                    <div class="float-right">
                        <a href="{{ route('types.create') }}" class="btn btn-primary btn-rounded">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Add Types')
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th class="min-width-100">@lang('Name')</th>
                            <th class="min-width-150">@lang('# of users with this types')</th>
                            <th class="text-center">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($types))
                            @foreach ($types as $type)
                                <tr>
                                    <td>{{ $type->ut_name }}</td>
                                    <td>{{ $type->users_count }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('types.edit', $type) }}" class="btn btn-icon"
                                            title="@lang('Edit Types')" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($type->removable)
                                            <a href="{{ route('roles.destroy', $type) }}" class="btn btn-icon"
                                                title="@lang('Delete Role')" data-toggle="tooltip" data-placement="top"
                                                data-method="DELETE" data-confirm-title="@lang('Please Confirm')"
                                                data-confirm-text="@lang('Are you sure that you want to delete this role?')"
                                                data-confirm-delete="@lang('Yes, delete it!')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"><em>@lang('No records found.')</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
