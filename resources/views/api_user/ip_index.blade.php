<div class="float-right mb-3">
    <button class="btn btn-primary btn-sm" onclick="modalIpShow('{{ $bank->bank_id }}', '{{ $bank->bank_name }}')">Tambah
        Ip</button>
</div>

<table class="table">
    <thead>
        <th>Name</th>
        <th>Ip</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($datas as $index => $value)
            <tr>
                <td>{{ $value->diw_address }}</td>
                <td>{{ $value->diw_address }}</td>
                <td>
                    <button class="btn btn-danger btn-sm"
                        onclick="deleteIp({{ $value->diw_index }}, '{{ $value->bank_id }}')">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
