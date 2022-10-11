<div class="container mt-3 mb-3">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-8">
            <h4>Edit Data Api Status</h4>
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
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="ras_id">Api Status ID</label>
                    <input type="text" class="form-control required" name="ras_id" readonly>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="ras_message">Api Status Message</label>
                    <input type="text" class="form-control required" name="ras_message">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="ras_description">Api Status Description</label>
                    <input type="text" class="form-control" name="ras_description">
                </div>
            </div>
            <div class="col-12 col-md-12">
                <button class="btn btn-primary btn-rounded float-right" id="btn-save"> 
                    <i class="fas fa-floppy-o mr-2"></i>
                    @lang('Update Data')
                </button>
            </div>
        </div>
    </form>

    <script>
        $('input[name="ras_id"]').inputmask("999")
    </script>
</div>