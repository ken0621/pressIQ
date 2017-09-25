<table class="table table-condensed shop_table">
  <thead class="thead thead-inverse">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Contact Number</th>
      <th>User Level</th>
      <th>Shop Name</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($partnerResult as $user_accounts)
    <tr>
      <td>{{$user_accounts->user_first_name }}</td>
      <td>{{$user_accounts->user_last_name }}</td>
      <td>{{$user_accounts->user_email }}</td>
      <td>{{$user_accounts->user_contact_number }}</td>
      <td>{{$user_accounts->user_level }}</td>
      <td>{{$user_accounts->shop_key }}</td>
      <td class="text-center">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
          <span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-custom-update">
            <li>
              <a href="/admin/shop_user_accounts_update/{{$user_accounts->user_id }}">&nbsp;Edit</a>
            </li>
          </ul>
        </div>
        </td>
      </tr>
    @endforeach
  </tbody>
  </table>
  