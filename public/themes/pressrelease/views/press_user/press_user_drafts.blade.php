@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
         @if (Session::has('delete'))
              <div class="alert alert-danger">
                 <center>{{ Session::get('delete') }}</center>
              </div>
          @endif 
        <div class="drafts-holder-container">
          <div class="table-container">
            <table>
                <tr>    
                    <th>Press Release Title</th>
                    <th>Status</th>
                    <th colspan="2">Action</th>
                </tr>
                @foreach($drafts as $draft)
                <tr>
                    <td style="width: 50%;">{{$draft->pr_headline}}</td>
                    <td style="width: 20%;">Draft</td>
                    <td style="width: 15%;">
                        <a href="/pressuser/pressrelease/edit_draft/{{$draft->pr_id}}">
                        <button type="button" class="btn btn-success center">
                        <i class="fa fa-wrench" name="recipient_id" aria-hidden="true">&nbsp;</i>Edit</button>
                        </a>
                    </td>
                    <td style="width: 15%;">
                        <button type="button" class="btn btn-danger center pop_up_draft" data-id="{{$draft->pr_id}}">
                        <i class="fa fa-trash" name="recipient_id" aria-hidden="true">&nbsp;</i>Delete</button>
                      
                    </td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
    </div>
</div>

<div class="popup-view">
  <div class="modal" id="viewPopupDraft" name="viewPopupDraft" role="dialog">
    <div class="modal-dialog modal-sm" >
      <form method="post" action="/pressuser/pressrelease/delete_draft_release" enctype="multipart/form-data">
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_drafts.css">
@endsection

@section("script")
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:780031,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>


<script>
  $('.pop_up_draft').click(function()
  {
      var draft_id = $(this).data('id');

      $.ajax({
        url: '/pressuser/pressrelease/delete_draft/'+draft_id,
        type: 'GET',
        success: function (data)
        {
            setTimeout(function()
            {  
                $('#viewPopupDraft').modal('show');
                $('div.modal-body').html(data); 
            }, 100);
        }
      });
  });
</script>

@endsection