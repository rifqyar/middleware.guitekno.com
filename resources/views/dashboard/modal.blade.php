<div class="modal fade" id="detail-connected">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daerah terkoneksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($data['prop'] as $h)
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between align-items-center" style="cursor: pointer" onclick="showDaerah({{$h->prop_id}})">
                            <h6 class="d-flex align-items-center">
                                {{ $h->prop_nama }}
                            </h6>

                            <h6><i class="fa fa-chevron-down" id="icon-header-{{$h->prop_id}}"></i></h6>
                        </div>
                        <div class="card-body" id="daerah-{{$h->prop_id}}" style="display: none">
                            <ul>
                                @foreach ($data['dati2'] as $ch)
                                    @if ($h->prop_id == $ch->prop_id)
                                        <li>
                                            <b> {{$ch->dati2_nama}} </b>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>