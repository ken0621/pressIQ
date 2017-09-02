@extends("layout")
@section("content")
<div class="content">
	<div class="contact-container">
	    <div class="container">
	        <div class="row clearfix">
	            <div class="col-md-6">
	                <div class="title">Get In Touch <font class="intouch-label">With Us</font></div>
	                <div class="form-group-container">
	                    <div class="row clearfix">
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label>First Name *</label>
	                                <input type="text" class="form-control">
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label>Last Name *</label>
	                                <input type="text" class="form-control">
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row clearfix">
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label>Phone Number *</label>
	                                <input type="text" class="form-control">
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label>Email Address *</label>
	                                <input type="text" class="form-control">
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row clearfix">
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label>Subject *</label>
	                                <input type="text" class="form-control">
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row clearfix">
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <label>Message *</label>
	                                <textarea class="form-control"></textarea>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="text-right">
	                        <button class="btn btn-primary">Send</button>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6">
	                <div class="title">Location</div>
	                <div class="info">
	                    <table>
	                        <tbody>
	                            <tr>
	                                <td class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></td>
	                                <td class="text"></td>
	                                <!--UG3 Alfaro Place Condominium 146 L.P. Leviste St., Salcedo Village, Makati City-->
	                            </tr>
	                           
	                            {{-- @foreach($contactInfo->_contact as $contact)
	                            <tr>
	                                <td class="icon"><i class="fa fa-{{$contact->category == 'number'?'mobile':'envelope'}}" aria-hidden="true"></i></td>
	                                <td class="text">{{$contact->contact}}</td>
	                            </tr>
	                            @endforeach --}}
	                           
	                        </tbody>
	                    </table>
	                </div>
	                <div class="title">Business <font class="business-label">Hours</font></div>
	                <div class="info">
	                    <table>
	                        <tbody>
	                            <tr>
	                                <td class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></td>
	                                <td class="text">Monday - Friday at 9:00am - 6:00pm</td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="map-title">FIND US <font class="map-title-pink">ON MAP</font></div>
	<div class="map-container">
		<div class="container">
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3861.007280409033!2d120.97894086009421!3d14.598660949454503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sph!4v1468556209677" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/front/css/contact.css">
@endsection
@section("script")

@endsection