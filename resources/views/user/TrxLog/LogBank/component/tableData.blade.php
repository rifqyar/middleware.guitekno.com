<div class="container">
    {{-- <div class="row mb-1">
        <div class="col-lg-2">
            <div class="row">
                <span class="badge badge-success px-2 mr-3">&nbsp;</span>
                <b>Transaction Success</b>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="row">
                <span class="badge badge-danger px-2 mr-3">&nbsp;</span>
                <b>Transaction Failed</b>
            </div>
        </div>
    </div> --}}
    <div class="table-responsive">
        <table class="table t-logBank" style="width: 100%">
            <thead>
                <tr>
                    <th>LBT ID</th>
                    <th>Created</th>
                    <th>Created By</th>
                    <th>Last Update</th>
                    <th>Last Update By</th>
                    {{-- <th>Request Data</th> --}}
                    {{-- <th>Response Data</th> --}}
                    <th>User ID</th>
                    <th>Account Number</th>
                    <th>Service Type ID</th>
                    <th>Service Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $successCode = ['000', '900', 'true'];   
                    $badge = '';
                    $requestData = '';
                    $responseData = '';
                @endphp
                @foreach ($data as $dt)
                    @php
                        $statusCode = json_decode($dt->lbt_response);
                        if(isset($statusCode->response->status)){
                            $statusCode = $statusCode->response->status->code;
                        } else if (isset($statusCode->status) && !isset($statusCode->response)){
                            $statusCode = $statusCode->status->code;
                        } else {
                            $statusCode = is_array($statusCode) ? $statusCode[0]->success : $statusCode->success;
                        }

                        if (isset($dt->lbt_request)){
                            $requestData = base64_encode(json_encode($dt->lbt_request));
                        } 
                        if(isset($dt->lbt_response)){
                            $responseData = base64_encode(json_encode($dt->lbt_response));
                        }
                    @endphp
                    @if (stripos(json_encode($successCode), $statusCode) == false)
                        @php
                            $badge = '<span class="badge badge-pill badge-danger mr-2">failed</span>';
                        @endphp
                    @else
                        @php
                            $badge = '<span class="badge badge-pill badge-success mr-2">success</span>';
                        @endphp
                    @endif
                <tr>
                    <td class="text-center align-middle">{{$dt->lbt_id}}</td>
                    <td class="text-center align-middle">{{$dt->lbt_created}}</td>
                    <td class="text-center align-middle">{{$dt->lbt_create_by}}</td>
                    <td class="text-center align-middle">{{$dt->lbt_last_updated}}</td>
                    <td class="text-center align-middle">{{$dt->lbt_last_update_by}}</td>
                    {{-- <td>{{$dt->lbt_request}}</td> --}}
                    {{-- <td>{{$dt->lbt_response}}</td> --}}
                    <td class="text-center align-middle">{{$dt->lbt_acc_number}}</td>
                    <td class="text-center align-middle">{{$dt->lbt_userid}}</td>
                    <td class="text-center align-middle">{{$dt->rst_id}}</td>
                    <td class="text-center align-middle">{{$dt->rst_name}}</td>
                    <td class="text-center align-middle">{!! $badge !!} </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-icon" onclick="showDetail(`{!! $responseData !!}`,`{!! $requestData !!}`, `{!!$statusCode!!}`)" data-toggle="tooltip" data-placement="top" title="View Detail Data">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
 
	{{ $data->links() }}
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('.pagination a').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var rst_id = url.split('/')[6]
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'JSON',
            beforeSend: () => {
                $(`#data-${rst_id}`).html(`
                    <div class="row justify-content-center">   
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `)
            },
            success: (res) => {
                $(`#data-${rst_id}`).html(res.blade)
                $(`#data-${rst_id}`).find('th').css('white-space', 'nowrap')
                $(`#data-${rst_id}`).find('td').css('white-space', 'nowrap')
            }
        })
    });
</script>