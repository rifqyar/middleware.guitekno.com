<div class="container mt-3 mb-3">
    <form action="javascript:void(0)" class="bank_res_data" method="POST">
        <div class="row">
            <div class="col-6 col-md-6 col-sm-12" style="display: none">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" name="id" readonly style="display: none">
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="bank_id">Bank ID</label>
                    <div id="select_bank">
                        <select class="bank_id-select form-control required" name="bank_id" style="width: 100%; height: 100%;">
                        </select>
                    </div>

                    <input type="text" class="form-control" name="bank_id" readonly style="display: none">
                    
                    <small id="refBankUnavailable" class="form-text text-muted">
                        Data bank tidak ada? silahkan tambah <a href="{{url('master-data/bank')}}">Di sini</a>
                    </small>
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
                <button class="btn btn-primary btn-rounded float-right btn-next"> 
                    @lang('Next')
                    <i class="fas fa-chevron-right mr-2"></i>
                </button>
            </div>
        </div>
    </form>

    <small id="notice" class="form-text text-danger">
        <strong>*Jika Bank tidak ada dalam list, besar kemungkinan sudah ada integrasi dengan bank yang dimaksud. Silahkan cek <a href="{{url('master-data/bank-secret')}}">Di sini</a></strong> 
    </small>

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