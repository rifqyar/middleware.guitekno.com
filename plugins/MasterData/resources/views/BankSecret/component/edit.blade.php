<div class="container mt-3 mb-3">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-8">
            <h4>Edit  Data Bank Secret</h4>
        </div>
        <div class="col-md-4 col-4">
            <button class="btn btn-warning btn-rounded float-right btn-back" onclick="back('edit', 'list-data')">
                <i class="fas fa-chevron-left mr-2"></i>
                @lang('Back')
            </button>
        </div>
    </div>
    <hr>
    <form action="javascript:void(0)" id="form-edit">
        <div class="row">
            <div class="col-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control required" name="id" readonly>
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                <div class="row align-items-center justify-content-between edit" style="display: none">
                    <div class="col-10 col-md-10">
                        <div class="form-group">
                            <label for="bank_id">Bank ID</label>
                            <select class="bank_id-select form-control required" name="bank_id" style="width: 100%; height: 100%; display: none">
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-md-2 mt-3">
                        <button
                            class="btn btn-icon btn-lg"
                            onclick="editBankID(this, 'default')"
                            title="Cancel Edit">
                            <i class="fas fa-times-circle text-danger"></i>
                        </button>
                    </div>
                </div>
                
                <div class="row align-items-center justify-content-between default">
                    <div class="col-10 col-md-10">
                        <div class="form-group">
                            <label for="bank_id">Bank ID</label>
                            <input type="text" class="form-control bank_id-default required" name="bank_id" readonly>
                        </div>
                    </div>
                    <div class="col-2 col-md-2 mt-2">
                        <button
                            class="btn btn-icon btn-lg"
                            onclick="editBankID(this, 'edit')"
                            title="Edit Bank Code">
                            <i class="fas fa-edit text-warning"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="client_id">Client ID</label>
                    <input type="text" class="form-control required" name="client_id">
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="client_secret">Client Secret</label>
                    <input type="text" class="form-control required" name="client_secret">
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control required" name="username">
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control required" name="password">
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
            $('.bank_id-select').select2({
                theme: 'bootstrap',
                placeholder: 'Select Code Bank',
                allowClear: true
            });
        });
    </script>
</div>