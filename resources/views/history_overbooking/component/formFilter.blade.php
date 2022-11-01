<div class="row align-items-center form-container">
    <div class="col-md-1 col-12 separator" style="display: none">
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

    <div class="col-md-1 col-12">
        <div class="form-group">
            <label for="operator">Operator</label>
            <select name="operator" id="" class="form-control required select-operator" onchange="changeOperator(this)">
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
                <option value="between" id="operator-tgl" style="display:none">Between</option>
            </select>
        </div>
    </div>

    <div class="col-md-3 col-12" id="value">
        <div class="form-group">
            <label for="value">Value</label>
            <select name="value" id="" class="form-control required select-value" style="width: 100%">
            </select>
        </div>
    </div>

    <div class="col-md-4 col-12" id="date-value" style="display: none">
        <div class="form-group">
            <label for="value">Tanggal Transaksi</label>
            <div class="row align-items-center">
                <div class="col-md-4 col-12 form-group">
                    <input type="date" name="tgl" class="form-control" style="display: none">
                </div>
                <div class="col-md-1 col-12 form-group date-end" style="display: none">
                    <strong>-</strong>
                </div>
                <div class="col-md-4 col-12 form-group date-end" style="display: none">
                    <input type="date" name="tgl2" class="form-control" readonly style="display: none">
                </div>
            </div> 
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
