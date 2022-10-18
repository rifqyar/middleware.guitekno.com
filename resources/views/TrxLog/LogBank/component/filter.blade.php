<div class="row align-items-center form-container">
    <div class="col-md-6 col-12" id="form_bpd">
        <div class="form-group">
            <label for="bpd">BPD</label>
            <select name="bpd" class="form-control required select-field" style="width: 100%">
                <option></option>
                @foreach ($bpd as $d)
                    <option value="{{$d->code_bank}}">{{$d->bank_name}}</option>    
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6 col-12">
        {{-- <div class="form-group"> --}}
            <label>Tanggal Transaksi</label>
            <div class="row">
                <div class="col-md-4 col-12 form-group">
                    <select name="operator_tanggal" class="form-control required" onchange="changeOperatorTgl(this)">
                        <option value="0">All</option>
                        <option value="=">=</option>
                        <option value=">">></option>
                        <option value="<"><</option>
                        <option value=">=">>=</option>
                        <option value="<="><=</option>
                    </select>
                </div>
                <div class="col-md-8 col-12">
                    <input type="date" name="tgl" class="form-control" readonly>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select-field').select2({
            theme: 'bootstrap',
            placeholder: 'Pilih BPD',
            allowClear: true
        });
    });
</script>