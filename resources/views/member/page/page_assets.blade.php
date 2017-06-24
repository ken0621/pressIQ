<script type="text/javascript" src="/assets/member/js/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({ 
	selector:'.mce',
	plugins: 'lists advlist',
	toolbar: 'bold italic underline | bullist numlist outdent indent',
 });

function submit_selected_image_done(data) 
{ 
	$('.maintenance-image-holder[key="'+data.akey+'"]').html('<img src="'+data.image_data[0].image_path+'">');
	$('.maintenance-image-input[key="'+data.akey+'"]').val(data.image_data[0].image_path);
}
</script>
<style type="text/css">
.maintenance-image-holder
{
	position: relative;
	padding-bottom: 50%;
	height: 0;
	background-color: #ddd;
	margin-bottom: 10px;
}
.maintenance-image-holder img
{
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	height: 100%;
	object-fit: cover;
}
</style>