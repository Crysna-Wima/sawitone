<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master BPB</title>
</head>
<body>
    {{-- table --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. BPB</th>
                <th>Tanggal</th>
                <th>Operator</th>
                <th>Customer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- @php $i = 1; @endphp
            @foreach($masterBpb as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $data->fc_bpbno }}</td>
                <td>{{ $data->fd_bpbdatesysinput }}</td>
                <td>{{ $data->fc_userid }}</td>
                <td>{{ $data->customer->fc_membername1 }}</td>
                <td>Rp. {{ number_format($data->fm_total,0,',','.')}}</td>
            </tr>
            @php $itemCount = count($data->bpbdtl); @endphp
            <tr>
                <td>&nbsp;</td>
                <td style="font-weight: bold;">Item:{{ $itemCount }} </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endforeach --}}
            @dd($masterBpb)
        </tbody>
</body>
</html>