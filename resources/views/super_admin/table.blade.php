<style type="text/css">
</style>
<table id="example2" class=" table table_bordered shop_table">
  <thead>
    <tr>
      <th class="table_head">First Name</th>
      <th class="table_head">Last Name</th>
      <th class="table_head">Email</th>
      <th class="table_head">Contact Number</th>
      <th class="table_head">User Level</th>
      <th class="table_head">Shop Name</th>
      <th class="table_head">Action</th>
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
<span class="pagination-container1">
 {!! $partnerResult->appends(Input::except('page'))->render() !!}
</span>
