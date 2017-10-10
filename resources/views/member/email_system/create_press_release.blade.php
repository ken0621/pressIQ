@extends('member.layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<div class="box-body">
 <button class="image-gallery" key="1234"> Image Gallery </button>
<input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
                                          <form  method ="post" action ="/member/page/press_release_email/save_email_press_release" role="form" class="form-horizontal" id="get_data_tinymce">
                                            {{csrf_field()}}
                                              	<div class="subject">
                                                  <div class="col-lg-6">
                                                      <input type="text" placeholder="subject" id="input_subject" class="form-control subject_email" name="subject">
                                                  </div> 
                                              </div>
                                              <br>
                                              <br>
                                              <div class="tiny">
                                                <textarea class="mce tiny" id="texteditor">                
                                                </textarea>
                                                <input type="submit" value="Save">
                                            </div>
                                          </form>  
                                          <button class="btn-primary preview"> preview </button>
                                           <button class="btn-primary continue"><a href="/member/page/press_release_email/choose_recipient_press_release" class ="con"> continue </a></button>
</div>

<script src="/email_assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/email_assets/tinymce/js/tinymce/tinymce.js"></script>
<script src="/email_assets/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
  selector: '.mce',  // change this value according to your HTML
  theme:'modern',
  /*toolbar: "insertfile undo redo bold italic  alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link image",
  plugins: "advlist anchor autolink autoresize autosave bbcode charmap code codesample colorpicker compat3x contextmenu directionality emoticons fullpage fullscreen help hr image imagetools importcss insertdatetime legacyoutput link media nonbreaking hr image imagetools importcss insertdatetime legacyoutput link media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker tabfocus table template textcolor textpattern toc visualblocks visualchars wordcount",*/
  plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor filemanager autoresize preview",
  toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent preview",
  toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor | print preview code | caption",
  /*image_caption: true,
  image_advtab: true,

  external_filemanager_path: "/email_assets/filemanager",
  filemanager_title: "photos",
  external_plugins:{"filemanager": "/email_assets/filemanager/plugin.min.js"},

  visualblocks_default_state: true,

  style_formats_autohide: true,
  style_formats_merge: true,*/
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
@endsection