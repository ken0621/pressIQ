@extends('member.layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" type="text/css" href="/email_assets/email_css/create_email.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
    <div>
      <i class="fa fa-envelope"></i>
      <h1>
      <span class="page-title">Press Release Email System</span>
      </h1>
    </div>
  </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
  <header class="header_email">
    <div class="panel-body form-horizontal">
      <div class="form-group">
        <div class="container">
          <ul class="list-inline inline">
            <li class=""><a href="#"><big>Create</big><small> New Release</small></a></li>
            <li class="choose"><a href="#"><big>Choose</big><small> recipients</small></a></li>
            <li><a href="#"><big>Send</big><small> Release </small></a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</head>
<div class="box-body">
  <button class="input_chose_email"> Email List </button>
  <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
  <form  method ="post" action ="/member/page/press_release_email/save_email_press_release" role="form" class="form-horizontal" id="get_data_tinymce">
    {{csrf_field()}}
    <div class="subject">
      <div class="col-lg-6">
        <input type="text" placeholder="subject" id="input_subject" class="form-control subject_email email-subject-container" name="subject">
      </div>
    </div>
    <br>
    <br>
    <div class="tiny">
      <textarea class="mce tiny email-content-container" id="texteditor">
      </textarea>
    </div>
  </form>
  <button class="btn-primary preview"> preview </button>
  <button class="btn-primary continue"><a href="/member/page/press_release_email/send_press_release" class ="con"> send </a></button>
</div>
<div class="modal fade" id="email_databaseModal" tabindex="-1" role="dialog" aria-labelledby="email_database_ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal_body">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <table class="table table-inbox table-hover table_email_list" id="table_email_list">
            <tbody>
              @foreach($_email_list as $email_list)
              <tr class="unread">
                <td class="view-message dont-show" onClick="pass_data({{$email_list->email_id}})" value="{{$email_list->email_id}}" email-id="{{$email_list->email_id}}">
                  {{$email_list->email_title}}
                  <!-- EXTRA LALAGYANAN PARA MAPASA MO YUNG DATA -->
                  <input type="hidden" class="email-subject-{{$email_list->email_id}}" value="{{$email_list->email_title}}">
                  <input type="hidden" class="email-content-{{$email_list->email_id}}" value="{!! $email_list->email_content !!}">
                </td>
                <td class="view-message ">{!!$email_list->email_content!!}</td>
                <td class="view-message  text-right">{{$email_list->email_time}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
$(".input_chose_email").click(function() {
$('#email_databaseModal').modal('show');

});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/email_assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/email_assets/tinymce/js/tinymce/tinymce.js"></script>
<script src="/email_assets/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
selector: '.mce',  // change this value according to your HTML
theme:'modern',
plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor filemanager autoresize preview",
toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent preview",
toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor | print preview code | caption",
});
function submit_selected_image_done(data) {
var image_path = data.image_data[0].image_path;
tinyMCE.execCommand('mceInsertContent',false,'<img src="'+image_path+'"/>');
}
</script>
<script type="text/javascript">
  $('.preview').click(function(){
    tinyMCE.activeEditor.execCommand('mcePreview');
  });
</script>
<script type="text/javascript" src="/email_assets/js/create_press_release.js"></script>
<script type="text/javascript" src ="http://malsup.github.com/jquery.form.js"></script>
<script>
// function addRowHandlers() {
// var rows = document.getElementById("table_email_list").rows;
// for (i = 0; i < rows.length; i++) {
// rows[i].onclick = function(){ return function(){
// var title = this.cells[0].innerHTML;
// var content = this.cells[1].innerHTML;
// var time = this.cells[2].innerHTML;
// tinymce.get('texteditor').setContent(content);
// $('#email_databaseModal').modal('hide');
// };}(rows[i]);

// }
// }
// window.onload = addRowHandlers();
// eto Yung Onclick na nasa TD pag-kinclick yun dto pupunta
function pass_data(email_id)
{
  $('.email-subject-container').val($('.email-subject-'+email_id).val());
  $('.email-content-container').val($('.email-content-'+email_id).val());
$('#email_databaseModal').modal('hide');
}
</script>
</script>
@endsection