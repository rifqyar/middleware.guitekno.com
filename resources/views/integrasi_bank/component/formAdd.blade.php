@foreach ($data as $i => $dt)
    @if ($dt->name != 'callbackSipd')
        <div class="row mt-4 mb-4">
            <div class="col-2 col md-2">
                <h1> {{$i}} </h1>
            </div>
            <div class="col-10 col-md-10">
                <div class="col-12 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="endpoint_type">Endpoint Type</label>
                        <strong> {{$dt->name}} </strong>
                        <input name="endpoint_type" class="form-control required" readonly value="{{$dt->id}}" style="display: none"/>
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
    @endif
@endforeach