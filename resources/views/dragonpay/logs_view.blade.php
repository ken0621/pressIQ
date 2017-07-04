<title>Dragonpay Logs</title>
<!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
<style>
*
{
  font-family: "Arial", sans-serif;
}
table.GeneratedTable {
  width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 2px;
  border-color: #ffcc00;
  border-style: solid;
  color: #000000;
  table-layout: fixed;
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
    text-align: center;
}
</style>
<a style="color: #000; margin-bottom: 15px; text-decoration: none; display: block; font-weight: 700; font-size: 18px;" href="/payment/dragonpay/logs">&laquo; Back</a>
<!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
<table class="GeneratedTable">
  <thead>
    <tr>
      <th width="50px">Order ID</th>
      <th width="150px">Date</th>
      <th width="175px">IP</th>
      <th>Response</th>
    </tr>
  </thead>
  <tbody>
    @foreach($_dragonpay as $dragonpay)
    <tr>
      <td>{{ $dragonpay->order_id }}</td>
      <td>{{ date("F d, Y h:i:s A", strtotime($dragonpay->log_date)) }}</td>
      <td>{{ $dragonpay->ip_address }}</td>
      <td><pre style="overflow-x: auto; text-align: left;">{{ is_serialized($dragonpay->response) ? var_dump(unserialize($dragonpay->response)) : $dragonpay->response }}</pre></td>
    </tr>
    @endforeach
  </tbody>
</table>
<!-- Codes by Quackit.com -->

