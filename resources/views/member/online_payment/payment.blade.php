@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-credit-card"></i>
            <h1>
                <span class="page-title">Online Payment Method</span>
                <small>
                    Set your online payment settings
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="clearfix col-md-8">
    	<ul class="nav nav-tabs">
            <!-- <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#settings"><i class="fa fa-circle-o"></i> Settings</a></li> -->
            <li class="active cursor-pointer other-hide"><a class="cursor-pointer" data-toggle="tab" href="#method"><i class="fa fa-circle-o"></i> Payment Method</a></li>
            <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#gateway"><i class="fa fa-circle-o"></i> Payment Gateway</a></li>
        </ul>

        <div class="tab-content">
        	<div class="tab-pane fade in" id="settings">
		        <!-- FORM. GROUP -->
		        <div class="form-box-divider">
		            <div class="row clearfix">
		                <div class="form-group col-md-12">
		                    <label></label>
		                    <input type="text" name="text1" class="form-control input-sm" >
		                </div>
		                <div class="form-group col-md-12">
		                    <label></label>
		                    <select class="form-control select-category input-sm" name="" >

		                    </select>
		                </div>
		            </div>
		        </div>
		    </div>
		    <div class="tab-pane fade in active" id="method">
		        <!-- FORM. GROUP -->
		        <div class="form-box-divider method-load-data">
		            <div class="row clearfix method-data">
		            	<div class="row col-md-2">
			                <ul class="nav nav-tabs nav-stacked box-light">
			                	@foreach($_method as $key=>$method)
				                <li class="{{$key== 0 ? 'active' : ''}} cursor-pointer"><a class="border-right cursor-pointer" data-toggle="tab" href="#{{$method->method_code_name}}">{{$method->method_name}}</a></li>
				                @endforeach   
				            </ul>
			            </div>
			            <div class="col-md-10">
				            <div class="tab-content">
				            	@foreach($_method as $key=>$method)
						            <div class="tab-pane fade in {{$key== 0 ? 'active' : ''}}" id="{{$method->method_code_name}}">
						            	<form class="global-submit" action="/member/maintenance/online_payment/save-payment-setting" method="post">
						            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
						            		<input type="hidden" name="link_method_id" value="{{ $method->method_id }}">
						            		<div class="pull-right">
								            	<label class="switch">
													<input type="checkbox" name="link_is_enabled" {{$method->link_is_enabled == 1 ? 'checked' : ''}}>
													<div class="slider round"></div>
												</label>
											</div>
											<div class="col-md-4 text-center">	
					                            <input type="hidden" name="link_img_id" class="image-value" key="{{$key}}" value="{{$method->link_img_id or ''}}" required>
					                            <img class="img-responsive img-src" key="{{$key}}" style="width: 100%; height: 167px; object-fit: cover" src="{{$method->image_path or '/assets/front/img/default.jpg'}}">
					                            <button type="button" class="btn btn-primary image-gallery image-gallery-single" key="{{$key}}" style="margin-top: 15px;">Upload Image</button>
					                        </div>
					                        <div class="col-md-8 text-center select-container ">
					                        	<input type="hidden" class="link-reference-name" name="link_reference_name" value="{{$method->link_reference_name or ''}}" required/>
					                        	<div class="form-group">
						                        	<select name="link_reference_id" class="form-control select-gateway" required>							                        		
						                        		@include('member.load_ajax_data.load_payment_gateway', ['_gateway' => $method->gateway, 'reference_id' => $method->link_reference_id, 'reference_name' => $method->link_reference_name])
						                        	</select>
						                        </div>
						                        <div class="form-group ">
						                        	<button class="panel-buttons btn btn-custom-primary pull-right" type="btn">Save</button>
						                        </div>
					                        </div>
										</form>
						            </div>
				            	@endforeach
					        </div>
			            </div>
		            </div>
		        </div>
		    </div>
		    <div class="tab-pane fade in" id="gateway">
		         <!-- FORM. GROUP -->
		        <div class="form-box-divider">
		            <div class="row clearfix">
		            	<div class="row col-md-2">
			                <ul class="nav nav-tabs nav-stacked box-light">
			                	@foreach($_gateway as $key=>$gateway)
				                	<li class="{{$key== 0 ? 'active' : ''}} cursor-pointer other-hide"><a class="border-right cursor-pointer" data-toggle="tab" href="#{{$gateway->gateway_code_name}}">{{$gateway->gateway_name}}</a></li>
				                @endforeach
				            </ul>
			            </div>
			            <div class="col-md-10">
				            <div class="tab-content">

				            	@foreach($_gateway as $key=>$gateway)
					            	<div class="tab-pane fade in {{$key == 0 ? 'active' : ''}}" id="{{$gateway->gateway_code_name}}">
					            		<form class="global-submit" action="/member/maintenance/online_payment/save-gateway" method="post">
					            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
						            		<input type="hidden" name="gateway_code_name" class="form-control input-sm" value="{{$gateway->gateway_code_name}}">
						            		<input type="hidden" name="api_gateway_id" class="form-control input-sm" value="{{$gateway->gateway_id}}">
						            		@if($gateway->gateway_code_name != 'other')
						            			@if($gateway->gateway_code_name == "ipay88")
					            					<div class="form-group col-md-12">
									                    <label>Merchant Code</label>
									                    <input type="text" name="api_client_id" class="form-control input-sm" value="{{$gateway->client_id or ''}}">
									                </div>
									                <div class="form-group col-md-12">
									                    <label>Merchant Key</label>
									                    <input type="text" name="api_secret_id" class="form-control input-sm" value="{{$gateway->secret_id or ''}}">
									                </div>
								                @else
									                <div class="form-group col-md-12">
									                    <label>Client ID</label>
									                    <input type="text" name="api_client_id" class="form-control input-sm" value="{{$gateway->client_id or ''}}">
									                </div>
									                <div class="form-group col-md-12">
									                    <label>Secret ID</label>
									                    <input type="text" name="api_secret_id" class="form-control input-sm" value="{{$gateway->secret_id or ''}}">
									                </div>
								                @endif
								                <div class="col-md-12">
								            		<button type="submit" class="panel-buttons btn btn-custom-primary pull-right">save</button>
								            	</div>
							                @else
							                	<div class="other-load-data">
							                		<div class="other-load">
									               		<div class="col-md-12">
									                		<button type="button" class="panel-buttons btn btn-custom-primary pull-right add-other"><i class="fa fa-plus"></i> Add</button>
										                </div>
										                <div class="form-group col-md-12">
										                	@foreach($gateway->other as $other)
										                		<a class="btn btn-custom-white view-other" type="button" data-id="{{$other->other_id}}">{{$other->other_name}}</a>
										                	@endforeach
										                </div>
									                </div>
								                </div>
						                    @endif
						                    
						                </form>
					            	</div>
					            @endforeach
					        </div>
			            </div>
		            </div>
		        </div>
		    </div>
	    </div>
    </div>
    <div class="col-md-4">
        <!-- FORM.TITLE -->
        <div class="clearfix form-box-divider other-container" >
        	<!-- @include('member.online_payment.load_other_info') -->
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/product.css">
<style>
	.nav-tabs>li.active>a.border-right, .nav-tabs>li.active>a.border-right:hover, .nav-tabs>li.active>a.border-right:focus
	{
		/*box-shadow: none!important;
		border-right: 3px solid #76b6ec;*/
		-webkit-box-shadow: 6px 0 5px -2px #888!important;
        box-shadow: 6px 0 5px -2px #888!important;
	}
	.box-light
	{
		border-right: 1px solid #dddddd;
	}

	.other-container
	{
		display: none;
		min-height: 304px;
	}

	/* The switch - the box around the slider */
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 53px;
	  height: 18px;
	}

	/* Hide default HTML checkbox */
	.switch input {display:none;}

	/* The slider */
	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 14px;
	  width: 14px;
	  left: 2px;
	  bottom: 2px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input:checked + .slider {
	  background-color: #2196F3;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(35px);
	  -ms-transform: translateX(35px);
	  transform: translateX(35px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}

	.slider.round:before {
	  border-radius: 50%;
	}
</style>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/online_payment.js"></script>
@endsection