Webcam.set
({
	width: 600,
	height: 460,
	image_format: 'jpeg',
	jpeg_quality: 90
});	
Webcam.attach( '#my_camera' );

function take_snapshot() 
{
// take snapshot and get image data
Webcam.snap( function(data_uri) 
{
	// display results in page		
Webcam.upload( data_uri, '/admin/web_cam', function(code, text) {
document.getElementById('results').innerHTML = 
		'<h2>Here is your image:</h2>' + 
		'<img src="'+text+'"/>';
		} );	
	} );
}