
<tr>
  <th style="width: 20%;">Contact Name</th>
  <th style="width: 20%;">Company</th>
  <th style="width: 20%;">Country</th>
  <th style="width: 20%;">Action</th>
</tr>
@foreach($_media_contacts as $_media)
  <tr>
    <td>{{$_media->name}}</td>
    <td>{{$_media->company_name}}</td>
    <td>{{$_media->country}}</td>
    <td>
      <button type="button"  class="btn btn-warning center pop_chosen_recipient_btn" data-id="{{$_media->recipient_id}}">
      <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>

      <button type="button"  class="btn btn-danger center pop_delete_media_btn" data-id="{{$_media->recipient_id}}">
      <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i> Delete</button></a>

      {{-- <a href="/pressadmin/pressreleases_edit_recipient/{{$_media->recipient_id}}"><button type="button"  class="btn btn-warning center">
      <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button> --}}

      {{-- <a onclick="return confirm('Are you sure you want to Delete?');" href="/pressadmin/pressreleases_deleterecipient/{{$_media->recipient_id}}"><button type="button"  class="btn btn-danger center"> --}}
      {{-- <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>Delete</button> --}}
    </td>
  </tr>
@endforeach

<div class="popup-view">
  <div class="modal" id="viewPopup" name="viewPopup" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post" action="/pressadmin/pressreleases_addrecipient" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Media Contacts</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="submit" id="submit_button" class="btn btn-primary pull-right" name="submit_button">Update Contacts</button>
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupMediaDelete" name="viewPopupMediaDelete" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/pressreleases_deleterecipient/media" enctype="multipart/form-data">
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

<script>
  $('.pop_delete_media_btn').click(function()
  {
      var recipient_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/pressreleases_deleterecipient/'+recipient_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupMediaDelete').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

<script>
    $('.pop_chosen_recipient_btn').click(function()
  {
      var recipient_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/pressreleases_edit_recipient/'+recipient_id,
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