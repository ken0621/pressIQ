<!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
<style>
table.GeneratedTable {
  width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 2px;
  border-color: #ffcc00;
  border-style: solid;
  color: #000000;
}

table.GeneratedTable td, table.GeneratedTable th {
  border-width: 2px;
  border-color: #ffcc00;
  border-style: solid;
  padding: 3px;
}

table.GeneratedTable thead {
  background-color: #ffcc00;
}

th, td
{
    vertical-align: top;
}
</style>

<!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
<table class="GeneratedTable">
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Response</th>
    </tr>
  </thead>
  <tbody>
    @foreach($_dragonpay as $dragonpay)
    <tr>
      <td>{{ $dragonpay->order_id }}</td>
      <td>{{ is_serialized($dragonpay->response) ? var_dump(unserialize($dragonpay->response)) : $dragonpay->response }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<!-- Codes by Quackit.com -->

