<div class="container mt-3 mb-3">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-8">
            <h4>Add Data Bank</h4>
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
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="bank_id">Bank ID</label>
                    <input type="text" class="form-control required" name="bank_id" onkeyup="getRefBank(this)" onchange="getRefBank(this)">
                    <small id="maxCharBank" class="form-text text-muted">Max. 3 Character</small>
                    <small id="bankIDUsed" class="form-text text-danger" style="display: none">This Bank ID Already in Use</small>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control required" name="bank_name">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="statusBank">Status Bank</label>
                    <select name="bank_status" id="statusBank" class="form-control required">
                        <option value="00">Stagging</option>
                        <option value="01">Production</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <button class="btn btn-primary btn-rounded float-right disabled" disabled id="btn-save" style="cursor: not-allowed"> 
                    <i class="fas fa-floppy-o mr-2"></i>
                    @lang('Save Data')
                </button>
            </div>
        </div>
    </form>

    <script>
        $('input[name="bank_id"]').inputmask("999")
    </script>
</div>