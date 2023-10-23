<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tabel Rekap Stock</title>
<style>
  table {
    height: 108px;
    width: 1699px;
    border-collapse: collapse;
    border: 1px solid black;
  }
  th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
  }
  th[style], td[style] {
    border: 2px solid black !important;
  }
</style>
</head>
<body>
<table>
  <tbody>
    <tr>
      <td colspan="10" style="text-align: center; font-size: 18px; font-weight: bold; border: 2px solid black;">Nama Gudang</td>
    </tr>
    <tr>
        <th width="10" style="font-weight: bold;">Katalog</th>
        <th width="30" style="font-weight: bold;">Internal Barcode</th>
        <th width="30" style="font-weight: bold;">Nama Stock</th>
        <th width="30" style="font-weight: bold;">Brand</th>
        <th width="30" style="font-weight: bold;">Sub Group</th>
        <th width="30" style="font-weight: bold;">Tipe Stock</th>
        <th width="30" style="font-weight: bold;">Expired</th>
        <th width="30" style="font-weight: bold;">Batch/Lot</th>
        <th width="30" style="font-weight: bold;">Qty</th>
        <th width="30" style="font-weight: bold;">Satuan</th>
    </tr>
    <tr>
      <td style="border: 1px solid black;">data katalog</td>
      <td style="border: 1px solid black;">data barcode</td>
      <td style="border: 1px solid black;">data nama stok</td>
      <td style="border: 1px solid black;">data brand</td>
      <td style="border: 1px solid black;">data sub group</td>
      <td style="border: 1px solid black;">data tipe stok</td>
      <td style="border: 1px solid black;">data expired</td>
      <td style="border: 1px solid black;">data batch</td>
      <td style="border: 1px solid black;">data qty</td>
      <td style="border: 1px solid black;">data satuan</td>
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>



