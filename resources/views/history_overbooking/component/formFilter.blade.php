<div class="d-flex align-items-center form-container">
    <div class="col-md-2 col-12 separator" style="display: none">
        <div class="form-group">
            <label for="separator">&nbsp;</label>
            <select name="separator" id="" class="form-control required separator" style="display: none">
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label for="field">Filter by</label>
            <select name="field_name" id="" class="form-control required select-field" onchange="getValueColumn(this)">
                <option></option>
                @foreach ($column as $c)
                    <option value="{{$c->column_name}}">
                        @php
                            $name = '';
                            $name = str_replace('TBK_', ' ', $c->column_name);
                            $name = str_replace('_', ' ', $name);
                            echo ucwords(strtolower($name));
                        @endphp
                    </option>    
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2 col-12">
        <div class="form-group">
            <label for="operator">Operator</label>
            <select name="operator" id="" class="form-control required">
                <option value="=">= (Equal)</option>
                <option value="<>"><> (Not Equal)</option>
                <option value=">">> (Greater Than)</option>
                <option value="<">< (Less Than)</option>
                <option value=">=">>= (Greater or Equal Than)</option>
                <option value="<="><= (Less or Equal Than)</option>
            </select>
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label for="value">Value</label>
            <select name="value" id="" class="form-control required select-value">
            </select>
        </div>
    </div>

    <div class="col-md-2 col-12 remove-filter" style="display: none">
        <button class="btn btn-warning mt-2" onclick="removeFilter(this)">
            <i class="fas fa-trash"></i>
            Remove
        </button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select-field').select2({
            theme: 'bootstrap',
            placeholder: 'Select Filter Field',
            allowClear: true
        });

        $('.select-value').select2({
            theme: 'bootstrap',
            placeholder: 'Select Value',
            allowClear: true
        });
    });
</script>