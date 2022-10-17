<div class="container mt-3 mb-3">
    <form action="javascript:void(0)" class="bEndpoint_res_data" method="POST">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="status">Status Endpoint</label>
                    <select class="status-select form-control required" name="status" style="width: 100%; height: 100%">
                        <option value="00">Stagging</option>
                        <option value="01">Production</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="bank_secret">Bank</label>
                    <input type="text" class="form-control" name="bank_secret_show" readonly>
                    {{-- <select class="bank_secret-select form-control required" name="bank_secret" style="width: 100%; height: 100%">
                    </select> --}}
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="col-2 col md-2">
                <h1>1</h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong>Get Token</strong>
                        <input name="endpoint_type" class="form-control required" readonly value="RKeWQlXpJxSIYD9" style="display: none"/>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control required" name="endpoint">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 col md-2">
                <h1>2</h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong>Inquiry</strong>
                        <input name="endpoint_type" class="form-control required" readonly value="Ge4qtr0j7IU0EqJ" style="display: none"/>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control required" name="endpoint">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 col md-2">
                <h1>3</h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong>Over Booking</strong>
                        <input name="endpoint_type" class="form-control required" readonly value="LiQtCAz66uAmROO" style="display: none"/>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control required" name="endpoint">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 col md-2">
                <h1>4</h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong>Check Status</strong>
                        <input name="endpoint_type" class="form-control required" readonly value="oYOJnbuLbSgt3Mv" style="display: none"/>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control required" name="endpoint">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 col md-2">
                <h1>5</h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong>Get History</strong>
                        <input name="endpoint_type" class="form-control required" readonly value="yp1n7R0GCbpI6oH" style="display: none"/>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control required" name="endpoint">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2 col md-2">
                <h1>6</h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong>Callback SIPD</strong>
                        <input name="endpoint_type" class="form-control required" readonly value="uoUGmzzoDHjL4V1" style="display: none"/>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control required" name="endpoint">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <button class="btn btn-primary btn-rounded float-right ml-3 btn-next">
                    @lang('Next')
                    <i class="fas fa-chevron-right mr-2"></i>
                </button>
                <button class="btn btn-warning btn-rounded float-right btn-previous">
                    <i class="fas fa-chevron-left mr-2"></i>
                    @lang('Back')
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
