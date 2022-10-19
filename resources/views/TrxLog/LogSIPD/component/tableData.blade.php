<style>
    table {
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div id="filter" style="display: none">
        <div class="d-flex mb-3">
            <button class="btn btn-sm btn-outline-success btn-filter" {{--onclick="addFilter()"--}}> <i class="fas fa-filter"></i> Filter</button>
            <button class="btn btn-sm btn-success ml-4 btn-showAllData" {{--onclick="showData()"--}}> <i class="fas fa-database"></i> Show All Data</button>
        </div>

        <div class="container-fluid" id="form-filter" style="display: none">
        </div>

        <button class="btn btn-outline-primary btn-sm mb-2 float-right" id="setFilter" style="display: none" {{--onclick="setFilter()"--}}>
            Show Filtered Data
        </button>
    </div>

    <div class="table-responsive">
        <table class="table t-logSIPD" style="width: 100%">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Created</th>
                    <th>Created By</th>
                    <th>Last Update</th>
                    {{-- <th>Request Data</th> --}}
                    {{-- <th>Response Data</th> --}}
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
                    <td class="text-center align-middle tgl">{{$dt->lst_created}}</td>
                    <td class="text-center align-middle">{{$dt->lst_create_by}}</td>
                    <td class="text-center align-middle tgl">{{$dt->lst_last_updated}}</td>
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