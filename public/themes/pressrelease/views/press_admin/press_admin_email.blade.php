@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="press-container">
              @if (Session::has('delete_email'))
              <div class="alert alert-danger">
                 <center>{{ Session::get('delete_email') }}</center>
              </div>
              @endif 
            <div class="title-container">Emails Press Release</div>
            <table>
                <tr>
                    <th style="width: 30%;">Email From</th>
                    <th style="width: 60%;">Header</th>
                    <th style="width: 60%;">Edit</th>
                    <th style="width: 60%;">Delete</th>
                    @foreach($_email as $email)
                    <tr>
                        <td style="width: 30%;">{{$email->pr_from}}</td>
                        <td style="width: 60%;">{{$email->pr_headline}}</td>
                        <td style="width: 60%;">
                            <a href="/pressadmin/email_edit/{{$email->pr_id}}"><button type="submit"  class="btn btn-warning center">
                            <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>
                        </td>
                        <td style="width: 60%;">
                            <button type="button"  class="btn btn-danger center pop_email_delete" data-id="{{$email->pr_id}}">
                            <i class="fa fa-trash" name="" aria-hidden="true"></i>Delete</button>
                        </td>
                    </tr>
                    @endforeach

            </table>
               {!! $_email->render() !!}
        </div>
    </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupDeleteEmail" name="viewPopupDeleteEmail" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressadmin/email_delete_admin" enctype="multipart/form-data">
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


@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_pressrelease.css">
@endsection

@section("script")

<script>
  $('.pop_email_delete').click(function()
  {
      var email_id = $(this).data('id');

      $.ajax({
        url: '/pressadmin/email_delete/'+email_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupDeleteEmail').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

@endsection