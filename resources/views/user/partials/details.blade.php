<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('Role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->role->id : '', [
                'class' => 'form-control input-solid',
                'id' => 'role',
                $profile ? 'disabled' : '',
            ]) !!}
        </div>
        <div class="form-group">
            <label for="status">@lang('Status')</label>
            {!! Form::select('status', $statuses, $edit ? $user->status : '', [
                'class' => 'form-control input-solid',
                'id' => 'status',
                $profile ? 'disabled' : '',
            ]) !!}
        </div>
        <div class="form-group">
            <label for="first_name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid" id="first_name" name="first_name"
                placeholder="@lang('First Name')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid" id="last_name" name="last_name"
                placeholder="@lang('Last Name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', [
                'class' => 'form-control input-solid',
            ]) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="birthday">@lang('Date of Birth')</label>
            <div class="form-group">
                <input type="text" name="birthday" id='birthday'
                    value="{{ $edit && $user->birthday ? $user->present()->birthday : '' }}"
                    class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone" name="phone"
                placeholder="@lang('Phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address" name="address"
                placeholder="@lang('Address')" value="{{ $edit ? $user->address : '' }}">
        </div>

        {{-- id="province" --}}
        @if ($edit)
            <div class="form-group" id="province_div">
                <label for="address">@lang('Province')</label>
                {!! Form::select('province_id', $province, $edit ? $user->province_id : '', [
                    'class' => 'form-control input-solid',
                    'id' => 'province',
                    $profile ? 'disabled' : '',
                ]) !!}
            </div>
            <div class="form-group" id="regency_div">
                <label for="address">@lang('Regency')</label>
                {!! Form::select('dati2_id', $regency, $edit ? $user->dati2_id : '', [
                    'class' => 'form-control input-solid',
                    'id' => 'regency',
                    $profile ? 'disabled' : '',
                ]) !!}
            </div>
        @else
            <div class="form-group" id="province_div" style="display:none;">
                <label for="address">@lang('Province')</label>
                {!! Form::select('province_id', $province, $edit ? $user->province_id : '', [
                    'class' => 'form-control input-solid',
                    'id' => 'province',
                ]) !!}
            </div>
            <div class="form-group" id="regency_div" style="display:none;">
                <label for="address">@lang('Regency')</label>
                {!! Form::select('dati2_id', $regency, $edit ? $user->dati2_id : '', [
                    'class' => 'form-control input-solid',
                    'id' => 'regency',
                ]) !!}
            </div>
        @endif
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('Update Details')
            </button>
        </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('#role').on('change', function() {
            // $('#province').empty();
            var tipeID = $(this).val();
            // console.log(tipeID)

            if (tipeID === '4' || tipeID === '5') {
                $.get("{{ route('users.province') }}?tipeID=" + tipeID, function(data) {
                    $('#province_div').removeAttr("style");
                    $('#province').html(data);
                    // console.log(data)
                })
            } else {
                $('#province').val("0").change()
                $('#province_div').hide()
            }
        });



        $('#province').on('change', function() {
            var provID = $(this).val();

            if (provID === '0') {
                $('#regency_div').hide();
            } else {
                $.get("{{ route('users.regency') }}?provID=" + provID, function(data) {
                    console.log(data)
                    $('#regency_div').removeAttr("style");
                    $('#regency').html(data)
                })
            }
        })


    })
</script>
