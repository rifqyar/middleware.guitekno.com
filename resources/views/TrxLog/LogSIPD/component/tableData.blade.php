<style>
    table {
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table t-logSIPD" style="width: 100%">
            <thead>
                <tr>
                    <th>Action</th>
                    {{-- <th>LST ID</th> --}}
                    <th>SIPD Transactionn ID</th>
                    <th>BPD Transactionn ID</th>
                    <th>Created</th>
                    <th>Created By</th>
                    <th>Last Update</th>
                    <th>Last Update By</th>
                    {{-- <th>Request Data</th> --}}
                    {{-- <th>Response Data</th> --}}
                    <th>USer ID</th>
                    <th>IP</th>
                    <th>Account Number</th>
                    <th>Service Type ID</th>
                    <th>Service Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $requestData = '';
                    $responseData = '';
                    $bgColor = '';
                    $successCode = ['000', '900', 'true'];   
                @endphp
                @foreach ($data as $dt)
                    @php
                        if (isset($dt->lst_request)){
                            $requestData = base64_encode(json_encode($dt->lst_request));
                        } 
                        if(isset($dt->lst_response)){
                            $responseData = base64_encode(json_encode($dt->lst_response));
                        }

                        if(stripos(json_encode($successCode), $dt->ras_id)){
                            $bgColor = 'bg-success text-light';
                        } else {
                            $bgColor = 'bg-danger text-light';
                        }
                    @endphp
                <tr>
                    <td class="text-center align-middle">
                        <button class="btn btn-icon" onclick="showDetail(`{!! $responseData !!}`,`{!! $requestData !!}`)" data-toggle="tooltip" data-placement="top" title="View Detail Data">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    {{-- <td class="text-center align-middle">{{$dt->lst_id}}</td> --}}
                    <td class="text-center align-middle">{{$dt->lst_sipd_tx_id}}</td>
                    <td class="text-center align-middle">{{$dt->lst_bpd_tx_id}}</td>
                    <td class="text-center align-middle tgl">{{$dt->lst_created}}</td>
                    <td class="text-center align-middle">{{$dt->lst_create_by}}</td>
                    <td class="text-center align-middle tgl">{{$dt->lst_last_updated}}</td>
                    <td class="text-center align-middle">{{$dt->lst_last_update_by}}</td>
                    <td class="text-center align-middle">{{$dt->lst_userid}}</td>
                    <td class="text-center align-middle">{{$dt->lst_id}}</td>
                    <td class="text-center align-middle">{{$dt->lst_acc_number}}</td>
                    <td class="text-center align-middle">{{$dt->rst_id}}</td>
                    <td class="text-center align-middle">{{$dt->rst_name}}</td>
                    <td class="text-center align-middle">
                        <span class="badge badge-pill {{$bgColor}} mr-2">{{$dt->ras_message}}</span>
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
        // convertDate()
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

    function convertDate(){
        $('.tgl').each((k, v) => {
            var visitortime = new Date();
            var visitortimezone = -visitortime.getTimezoneOffset();
            var menit = visitortimezone / 60

            var currDate = new Date($(v).html())
            currDate.setHours(currDate.getHours()+menit)

            var date = currDate.toLocaleDateString('id-ID', { year: 'numeric', month: '2-digit', day: '2-digit' })
            date = date.split('/').join('-')
            var time = currDate.toLocaleTimeString('id-ID').split('.').join(':')

            $(v).html(`${date} ${time}`)
        })
    }
</script>