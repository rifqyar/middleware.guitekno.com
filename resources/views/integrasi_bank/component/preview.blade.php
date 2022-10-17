<div class="container mt-3 mb-3">
    <h4 class="text-center">Apakah data di bawah ini sudah benar?</h4>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <h5>Data Bank</h5>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Bank Terpilih
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="bank_id">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Client ID
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="client_id">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Client Secret
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="client_secret">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Username
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="username">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Password
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="password">

                    </div>
                </div>

            </div>
            <div class="col-12 col-md-12 mt-5">
                <h5>Data Endpoint</h5>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Status
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="status">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Get Token
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="endpoint_getToken">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Inquiry 
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="endpoint_inquiry">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Overbooking 
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="endpoint_overbooking">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Check Status 
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="endpoint_checkstatus">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Get History 
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="endpoint_getHistory">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-12">
                        Endpoint Callback SIPD 
                    </div>
                    <div class="col-md-1 col-12">
                        :
                    </div>
                    <div class="col-12 col-md-7" id="endpoint_callbackSIPD">

                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <button class="btn btn-primary btn-rounded float-right ml-3 btn-finish" onclick="saveData()"> 
                    @lang('Finish')
                    <i class="fas fa-chevron-right mr-2"></i>
                </button>
                <button class="btn btn-warning btn-rounded float-right btn-previous"> 
                    <i class="fas fa-chevron-left mr-2"></i>
                    @lang('Back')
                </button>
            </div>
        </div>
    </div>

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