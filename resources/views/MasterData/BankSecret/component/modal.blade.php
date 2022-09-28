<div class="modal" id="detail-bs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <caption id="info"></caption>
                                <thead>
                                    <tr>
                                        <th>
                                            Token
                                        </th>
                                        <th>
                                            Expired In
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="token" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis"></td>
                                        <td id="exp" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" id="footer-modal">
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
