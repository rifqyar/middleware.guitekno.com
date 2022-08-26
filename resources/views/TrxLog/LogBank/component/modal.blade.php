<div class="modal" id="detail-log-bank">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="list-detail" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="request-tab" href="#request" role="tab"
                                    aria-controls="request" aria-selected="true">Request Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="response-tab" href="#response" role="tab"
                                    aria-controls="response" aria-selected="false">Response Data</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mt-3">
                            <div class="tab-pane" id="request" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table" id="table-request">

                                    </table>
                                </div>

                                <div class="table-responsive mt-4">
                                    <h6 class="title-detail"></h6>
                                    <table class="table detail-data" id="table-detail-request">

                                    </table>
                                </div>

                                <button class="btn btn-icon btn-sm float-right close-detail"
                                    onclick="closeDetailData(this)" style="display: none">
                                    <span>Close Detail</span>
                                    <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div class="tab-pane" id="response" role="tabpanel" aria-labelledby="response-tab">
                                <div class="table-responsive">
                                    <table class="table" id="table-response">

                                    </table>
                                </div>

                                <div class="table-responsive mt-4">
                                    <h6 class="title-detail"></h6>
                                    <table class="table detail-data" id="table-detail-response">

                                    </table>
                                </div>

                                <button class="btn btn-icon btn-sm float-right close-detail"
                                    onclick="closeDetailData(this)" style="display: none">
                                    <span>Close Detail</span>
                                    <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> --}}
        </div>
    </div>
</div>

<script>
    $('#list-detail a').on('click', function(e) {
        e.preventDefault()
        let id = $(this).attr('href')
        console.log(id)
        $(`.tab-pane:not(${id})`).slideUp()
        $(`.nav-link:not(${id}-tab)`).removeClass('active')

        if ($(`.tab-pane${id}`).css('display') != 'none') {
            $(this).removeClass('active')
            $(`.tab-pane${id}`).slideUp()
        } else {
            $(this).addClass('active')
            $(`.tab-pane${id}`).slideDown()
        }
        // console.log($(this))
    })
</script>
