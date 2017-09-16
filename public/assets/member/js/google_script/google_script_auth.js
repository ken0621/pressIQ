function onSignIn(googleUser)
{
	// console.log(googleUser);
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    // console.log(profile);
    // console.log("ID: " + profile.getId()); // Don't send this directly to your server!
    // console.log('Full Name: ' + profile.getName());
    // console.log('Given Name: ' + profile.getGivenName());
    // console.log('Family Name: ' + profile.getFamilyName());
    // console.log("Image URL: " + profile.getImageUrl());
    // console.log("Email: " + profile.getEmail());

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    // console.log("ID Token: " + id_token);
	// location.href = '/members/login-google-submit';

	var data = [];
	data['id'] = profile.getId();
	data['first_name'] = profile.getGivenName();
	data['last_name'] = profile.getFamilyName();
	data['email'] = profile.getEmail();

	push_data = JSON.stringify(data);
	$.ajax({
		url : '/members/login-google-submit',
		type : 'POST',
		dataType : 'json',
		data : { id : data['id'],first_name : data['first_name'],last_name : data['last_name'],email : data['email'], _token : $('#_token').val()},
		success : function(res)
		{
			if(res == 'success')
			{
				location.href = "/members";
			}
		}
	});
}
