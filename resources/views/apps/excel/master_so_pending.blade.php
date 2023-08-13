


<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold; 
        }
    </style>
</head>

<body>

<table width="900">
    <tbody>
       
    <tr>
        <th width="10">No</th>
        <th width="30">No. SO</th>
        <th width="30">Tanggal</th>
        <th width="30">Expired</th>
        <th width="30">Tipe</th>
        <th width="30">Operator</th>
        <th width="30">Customer</th>
        <th width="30">Total</th>
    </tr>
    @php $i = 1; @endphp
    @foreach($masterSoPending as $data)
  
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $data->fc_sono }}</td>
        <td>{{ $data->fd_sodatesysinput }}</td>
        <td>{{ $data->fd_soexpired }}</td>
        <td>{{ $data->fc_sotype }}</td>
        <td>{{ $data->fc_userid }}</td>
        <td>{{ $data->customer->fc_membername1 }}</td>
        <td>{{ $data->fn_sodetail }}</td>
        <td>Rp. {{ number_format($data->fm_brutto,0,',','.')}}</td>
    </tr>
   
    @php $itemCount = count($data->sodtl); @endphp
    <tr>
        <td>&nbsp;</td>
        <td>Item:{{ $itemCount }} </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Katalog</td>
        <td>Nama Barang</td>
        <td>Satuan</td>
        <td>Qty</td>
        <td>Terkirim</td>
        <td>Catatan</td>
        <td>Status</td>
    </tr>
    @foreach($data->sodtl as $item)
    <tr>
        <td>&nbsp;</td>
        <td>{{ $item->stock->fc_stockcode }}</td>
        <td>{{ $item->stock->fc_namelong }}</td>
        <td>{{ $item->stock->fc_namepack }}</td>
        <td>{{ $item->fn_so_qty }}</td>
        <td>{{ $item->fn_do_qty }}</td>
        <td>{{ $item->fv_description }}</td>
        <td>
            @if ($item->fn_so_qty !== $item->fn_do_qty)
                Pending
            @else
                Tuntas
            @endif
        </td>
    </tr>
    @endforeach
    @endforeach
    </tbody>
</table>

</body>

</html>
