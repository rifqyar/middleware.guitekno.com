<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('Role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->role->id : '', [
                'class' => 'form-control input-solid',
                'id' => 'role_id',
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
            <label for="type">@lang('User Type')</label>
            {!! Form::select('usertype_id', $type, $edit ? $user->usertype_id : '', [
                'class' => 'form-control input-solid',
                'id' => 'tipe',
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
        <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', [
                'class' => 'form-control input-solid',
            ]) !!}
        </div>
        <div class="form-group">
            <label for="address">@lang('Province')</label>
            <select class="form-control input-solid" name="province_id" id="province">
                <option>Select a Province</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">@lang('Regency')</label>
            <select class="form-control input-solid" name="dati2_id" id="regency">
                <option>Select a Regency</option>
            </select>
        </div>
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
        $('#tipe').on('change', function() {
            // $('#province').empty();
            let tipeID = $(this).val();
            console.log(tipeID)

            if (tipeID) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('users.province') }}?tipeID=" + tipeID,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data)
                        $.each(data, function(key, value) {
                            console.log(value)

                            $('#province').append('<option value="' + value
                                .prop_id +
                                '">' +
                                value.prop_nama + '</option>').prop(
                                'selectedIndex', 0);
                        })
                    }
                })
            }
        });



        $('#province').on('change', function() {
            let provID = $(this).val();
            console.log(provID)

            if (provID) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('users.regency') }}?provID=" + provID,
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            console.log(value)

                            $('#regency').append('<option value="' + value
                                .dati2_id +
                                '">' +
                                value.dati2_nama + '</option>');
                        })
                    }
                })
            } else {
                $('#regency').empty();
            }
        })


    })
</script>
