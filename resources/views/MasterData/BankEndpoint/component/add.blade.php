<div class="container mt-3 mb-3">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-8">
            <h4>Add Data Bank Endpoint</h4>
        </div>
        <div class="col-md-4 col-4">
            <button class="btn btn-warning btn-rounded float-right btn-back" onclick="back('add', 'list-data')">
                <i class="fas fa-chevron-left mr-2"></i>
                @lang('Back')
            </button>
        </div>
    </div>
    <hr>
    <form action="javascript:void(0)" id="form-add">
        <div class="row">
            <div class="col-12 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="bank_secret">Bank Secret</label>
                    <select class="bank_secret-select form-control required" name="bank_secret" style="width: 100%; height: 100%">
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="endpoint">Endpoint</label>
                    <input type="text" class="form-control required" name="endpoint">
                </div>
            </div>
            <div class="col-12 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="endpoint_type">Endpoint Type</label>
                    <select class="endpoint_type-select form-control required" name="endpoint_type" style="width: 100%; height: 100%">
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="status">Status Endpoint</label>
                    <select class="status-select form-control required" name="status" style="width: 100%; height: 100%">
                        <option value="00">Stagging</option>
                        <option value="01">Production</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <button class="btn btn-primary btn-rounded float-right" id="btn-save"> 
                    <i class="fas fa-floppy-o mr-2"></i>
                    @lang('Save Data')
                </button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('.bank_secret-select').select2({
                theme: 'bootstrap',
                placeholder: 'Select Bank Secret',
                allowClear: true
            });

            $('.endpoint_type-select').select2({
                theme: 'bootstrap',
                placeholder: 'Select Endpoint Type',
                allowClear: true
            });
        });
    </script>
</div>