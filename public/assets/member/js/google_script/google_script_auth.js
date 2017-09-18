function onSignIn(googleUser)
{
	// console.log(googleUser);
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    // console.log("ID Token: " + id_token);
	// location.href = '/members/login-google-submit';

	var data = [];
	data['access_token'] = id_token;
	data['id'] = profile.getId();
	data['first_name'] = profile.getGivenName();
	data['last_name'] = profile.getFamilyName();
	data['email'] = profile.getEmail();

	push_data = JSON.stringify(data);
	$.ajax({
		url : '/members/login-google-submit',
		type : 'POST',
		dataType : 'json',
		data : { id : data['id'],first_name : data['first_name'],access_token : data['access_token'],last_name : data['last_name'],email : data['email'], _token : $('#_token').val()},
		success : function(res)
		{
			if(res == 'success')
			{
				location.href = "/members";
			}
		}
	});
}
