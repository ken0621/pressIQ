@extends('member.payroll2.employee_dashboard.layout')
@section('content')
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/employee">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">{{ $page }}</li>
  </ol>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $company->payroll_company_logo }}" class="rounded float-right" alt="{{ $company->payroll_company_name }}" height="200" width="200">
            <h3 class="text-center">{{ $company->payroll_company_name }}</h3>
            <hr>
            <ul class="list-unstyled text-center">
                <li><p><i class="fa fa-map-marker" style="font-size:18px;color:#ff1a1a"></i> {{ $company->payroll_company_address }}</p></li>
                <li><p><i class="fa fa-phone-square" style="font-size:18px"></i> {{ $company->payroll_company_contact}} </p></li>
                <li><p><i class="fa fa-envelope m-r-xs" style="color:#4db8ff"></i><a href="#"> {{ $company->payroll_company_email }} </a></p></li>
            </ul>
        </div>
        <div class="col-md-9 m-t-lg">
            <div class="row">
                <h4>Business Information</h4>
                <div class="panel panel-default">
                	<div class="form-group row">
                		<div class="col-md-12">
                            <br><p style="text-indent: 40px" align="justify">Our goal is to provide and build professional websites, mobile applications with a specific design that best suit to your company specifications, a uniform graphic set with eye catchy details. We are good at building brands and improving your global presence so that we develop meaningful and long term relationships with you. Our core services focuses in Web Design and Development, E-commerce Web Development, Sleek-Modern & Mobile Responsive Web Design, SEO and Apps for Android & iOS, maintain and update website content to both existing and new clients. We also accept any Graphic Design services, Produce 2D animated Videos, and Social Media Marketing. Our services are not limited to what a techinal I.T Professional can do but also professional business advice on how are you going to innovate your business process.</p>
                		</div>
                        <div class="col-md-12">
                            <br><p style="text-indent: 40px" align="justify">Our goal is to provide and build professional websites, mobile applications with a specific design that best suit to your company specifications, a uniform graphic set with eye catchy details. We are good at building brands and improving your global presence so that we develop meaningful and long term relationships with you. Our core services focuses in Web Design and Development, E-commerce Web Development, Sleek-Modern & Mobile Responsive Web Design, SEO and Apps for Android & iOS, maintain and update website content to both existing and new clients. We also accept any Graphic Design services, Produce 2D animated Videos, and Social Media Marketing. Our services are not limited to what a techinal I.T Professional can do but also professional business advice on how are you going to innovate your business process.</p>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit"  class="btn btn-primary btn-md">Edit</button>
</div>


@endsection
