<form action="{{ url('/overbooking-pdf-test') }}" method="GET" id="data-filter">
    <div class="row align-items-center form-container">
        <div class="col-md-2 col-12 separator" style="display: none">
            <div class="form-group">
                <label for="separator">&nbsp;</label>
                <select name="separator" id="separator" class="form-control required separator" style="display: none">
                    <option value="AND">AND</option>
                    <option value="OR">OR</option>
                </select>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label for="field">Filter by</label>
                <select name="field_name" id="" class="form-control required select-field"
                    onchange="getValueColumn(this)" style="width: 100%">
                    <option></option>
                    @foreach ($column as $c)
                        <option value="{{ $c->column_name }}">
                            @php
                                $name = '';
                                $name = strtolower($name);
                                $name = str_replace('tbk_', '', $c->column_name);
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
                <select name="operator" id="" class="form-control required select-operator">
                    <option value="=">= (Equal)</option>
                    <option value="<>">
                        <> (Not Equal)
                    </option>
                    <option value=">">> (Greater Than)</option>
                    <option value="<">
                        < (Less Than)</option>
                    <option value=">=">>= (Greater or Equal Than)</option>
                    <option value="<=">
                        <= (Less or Equal Than)</option>
                </select>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label for="value">Value</label>
                <select name="value" id="" class="form-control required select-value" style="width: 100%">
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
</form>

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
