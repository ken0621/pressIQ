
<tr>
  <th style="width: 15%;">First Name</th>
  <th style="width: 15%;">Last Name</th>
  <th style="width: 15%;">Email</th>
  <th style="width: 15%;">Company Name</th>
  <th style="width: 15%;">Date Started</th>
  <th style="width: 20%;">Action</th>
</tr>
@foreach($_user as $_user_account)
  <tr>
    <td>{{$_user_account->user_first_name}}</td>
    <td>{{$_user_account->user_last_name}}</td>
    <td>{{$_user_account->user_email}}</td>
    <td>{{$_user_account->user_company_name}}</td>
    <td>{{date("F d, Y - H:i:s", strtotime($_user_account->user_date_created))}}</td>
    <td>
      <button type="button"  class="btn btn-warning center pop_user_btn" data-id="{{$_user_account->user_id}}">
      <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>

      <button type="button" class="btn btn-danger center pop_user_delete" data-id="{{$_user_account->user_id}}">
      <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>  Delete</button></a>

      <button type="button" class="btn btn-success center pop_force_login" data-id="{{$_user_account->user_id}}">
      <i class="fa fa-vcard-o" name="recipient_id" aria-hidden="true"></i>  Force Login</button></a>
    
    </td>
  </tr>
@endforeach

<div class="popup-view">
  <div class="modal" id="viewPopup" name="viewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressadmin/manage_user_edit" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Update User</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <button type="submit" id="submit_button" class="btn btn-primary pull-right" name="submit_button">Update User</button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupDeleteUser" name="viewPopupDeleteUser" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/delete_user_account" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Are you sure you want to Delete?</h4>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupForceLogin" name="viewPopupForceLogin" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/force_login" >
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Force to Login?</h4>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('.pop_user_btn').click(function()
  {
      var user_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/edit_user/'+user_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopup').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>          

<script>
  $('.pop_user_delete').click(function()
  {
      var user_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/delete_user/'+user_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupDeleteUser').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
  $('.pop_force_login').click(function()
  {
      var user_id_force = $(this).data('id');

      $.ajax({
        url: '/pressadmin/manage_force_login/'+user_id_force,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupForceLogin').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>


