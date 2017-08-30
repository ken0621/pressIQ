
<table class="table table-bordered">
  <thead>
    <tr >
      <th bgcolor="#262874"><font color="white">Company Logo</font></th>
      <th bgcolor="#262874"><font color="white">Company Name</font></th>
      <th bgcolor="#262874"><font color="white">Company Owner</font></th>
      <th bgcolor="#262874"><font color="white">Company Contact Number</font></th>
      <th bgcolor="#262874"><font color="white">Company Address</font></th>
      <th bgcolor="#262874"><font color="white">Company Location</font></th>
      <th bgcolor="#262874"><font color="white">Action</font></th>
    </tr>
  </thead>
  <tbody>
 @foreach($partnerResult as $partnerResultItem)
  <tr>
      <td bgcolor="#EFF5F9" style="line-height: 115px; height: 115px;">
        <img src="{{ $partnerResultItem->company_logo }}" class="img-thumbnail" alt="Logo" width="100" height="70">
        </div>
      </td>
      <td bgcolor="#EFF5F9" style="text-align:center;vertical-align:middle;">{{ $partnerResultItem->company_name }}</td>
      <td bgcolor="#EFF5F9" style="text-align:center;vertical-align:middle;">{{ $partnerResultItem->company_owner }}</td>
      <td bgcolor="#EFF5F9" style="text-align:center;vertical-align:middle;">{{ $partnerResultItem->company_contactnumber }}</td>
      <td bgcolor="#EFF5F9" style="text-align:center;vertical-align:middle;">{{ $partnerResultItem->company_address }}</td>
      <td bgcolor="#EFF5F9" style="text-align:center;vertical-align:middle;">{{ $partnerResultItem->company_location }}</td>
      <td bgcolor="#EFF5F9" style="text-align:center;vertical-align:middle;">{{ $partnerResultItem->company_name }}</td>
  </tr>
@endforeach
  </tbody>
</table>