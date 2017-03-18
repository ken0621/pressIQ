
@extends('member.layout')
@section('content')

<form method="post" action="/member/mlm/product_code/sell/process" class="global-submit">
	<div class="panel panel-default panel-block panel-title-block" id="top">
	    <div class="panel-heading">
	        <div>
	            <i class="fa fa-tags"></i>
	            <h1>
	                <span class="page-title">Sell Product/s</span>
	                <small>
	                    
	                </small>
	            </h1>
	            <button type="submit" class="panel-buttons btn btn-primary pull-right save_item">Process Purchase</button>
	            <a href="/member/mlm/product_code" class="panel-buttons btn btn-default pull-right">&laquo; Back</a>
	        </div>
	    </div>
	</div>
	<div class="col-md-12 col-lg-12">
		@if (Session::has('code_error'))
		   <div class='alert alert-danger'>
		   		@foreach(Session::get('code_error') as $code_error)
		   			<b>{{$code_error}}</b>
		   			</br>
		   		@endforeach
		   </div>
		@endif
		<div class="panel panel-default panel-block">
			<div class="list-group">
				<div class="list-group-item clearfix" id="input-fields-horizontal">
					<h4 class="section-title">Customer Information</h4>
					<div class="row">
						<div class="col-md-12 customer_data">
							
						</div>
							<div class="col-md-3">
								<label>Slot</label>
								<input type="text" class="form-control membership_code" name="membership_code" onChange="bar_code_membership_code(this)">
							</div>
					</div>
				</div>
				<div class="list-group-item clearfix" id="input-fields-horizontal">
					<div class="row">
			            <div class="table-responsive item_container">
			                <table class="table table-condensed">
			                    <thead style="text-transform: uppercase">
			                        <tr>
			                            <th>Item</th>
			                            <th>Quantity</th>
			                            <th class="text-right">Price</th>
			                            <th class="text-right">Membership Discount(/Piece)</th>
			                            <th class="text-right">Total</th>
			                            <th style="width: 40px;"></th>
			                        </tr>
			                    </thead>
			                    <tbody class="item_body">
			                    	{!! $table_body !!}
			                    </tbody>
			                    <tbody>
								    <tr>
								    	<td colspan="3">
								    		<a href="javascript:" class="btn btn-default popup add_line_link" link="/member/mlm/product_code/sell/add_line">Add Lines</a>
								    		<a href="javascript:" class="btn btn-default clear_all_lines" onClick="clear_all_lines()">Clear All Lines</a>
								    	</td>
								    	<td class="text-right" style="font-weight: bold;">Total</td>
								    	<td class="text-right" style="font-weight: bold; font-size: 20px; color: green;"><span class="total_bot">PHP 00.00</span></td>
								    </tr>
			                    </tbody>
			                </table>
			            </div>
					</div>
				</div>
				<!-- OTHER SETTINGS -->
				<div class="list-group-item clearfix" id="input-fields-horizontal">
					<div class="row">
						<form role="form" action="/member/mlm/item/add/save" id="save_item_form" method="post">
							{!! csrf_field() !!}
							<div class="form-group col-md-3">
								<label for="basic-input">Message displayed on invoice</label>
								<textarea class="form-control" name="item_code_message_on_invoice"></textarea>
							</div>
							<div class="form-group col-md-3">
								<label for="basic-input">Statement memo</label>
								<textarea class="form-control" name="item_code_statement_memo"></textarea>
							</div>
							<div class="form-group col-md-6">
								<label for="basic-input">Customer Paid</label>
								<select class="form-control" name="item_code_paid">
									<option value="1">YES</option>
									<option value="0">NO</option>
								</select>
								<label for="basic-input">Product Issued</label>
								<select class="form-control" name="item_code_product_issued">
									<option value="1">YES</option>
									<option value="0">NO</option>
								</select>
								<label for="basic-input">Use Item Code</label>
								<select class="form-control" name="use_item_code_auto">	
									<option value="1">YES</option>
									<option value="0">NO</option>
								</select>
								<label for="basic-input">Warehouse (Inventory)</label>
								<select class="form-control" name="warehouse_id">
									@foreach($warehouse as $key => $value)
									<option value="{{$value->warehouse_id}}">{{$value->warehouse_name}}</option>
									@endforeach
								</select>

								<div class="row">
									<br>
								  <div class="col-lg-12">
								    <div class="input-group">
								      <span class="input-group-addon">
								        <input type="checkbox" name="use_gc" aria-label="Checkbox for following text input">
								      </span>
								      <span class="input-group-addon" >USE GC</span>
								      <input type="text" class="form-control" aria-label="Text input with checkbox" name="gc_code">
								    </div>
								  </div>
								</div>
								<div class="row">
									<br>
								  <div class="col-lg-12">
								  <label>USE WALLET</label>
								   <input type="checkbox"  name="use_wallet">
								  </div>
								</div>

							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</form>
<div class="clear"></div>
<div class="col-md-12 load_fix_session hide">
	@include('sessionPrinter')
</div>
@endsection

@section('script')
<link rel="stylesheet" href="/assets/external/loading/jquery.loading.css" />
<script type="text/javascript" src="/assets/external/loading/jquery.loading.js"></script>
<script type="text/javascript">

// compute();
load_no_discount();
chosen_select_on_change();
chosen_select_on_change_event();
on_change_quantity();
$(".membership_code").focus();
var past_value = null;
var slot_chosen = 0;
function compute()
{
	// /member/mlm/code/sell/compute
	$('.total_top').html('Computing...');
	
	$('.total_bot').html('Computing...')
	$( ".total_bot" ).load( "/member/mlm/product_code/sell/compute", function(data) 
	{
		$('.total_top').html(data);	
	  	check_item_container();
	});
}
function load_session() 
{
    $('.item_body').html('<tr><td colspan="6"><center><div style="margin: 100px auto;" class="loader-16-gray"></div></center></td></tr>');
    var slot_id = $('.slot_id').val();
    var discount_card_log_id = $('.discount_card_log_id').val();
    if(slot_id == undefined || slot_id == null)
	{
		slot_id = 0;
	}
	if(discount_card_log_id == undefined || discount_card_log_id == null)
	{
		discount_card_log_id = 0;
	}
	var link = '/member/mlm/product_code/sell/add_line/view?slot_id=' + slot_id + '&discount_card_log_id=' + discount_card_log_id;
    $('.item_body').load(link, function() 
	{
		compute();
		item_options();
	});
}
function clear_all_lines()
{
	$('.clear').load('/member/mlm/product_code/sell/clear_line_all', function() 
	{
		load_session();
		toastr.success('All lines cleared.');
	});
}
function remove_line(id) {
	// body...
	$('.clear').load('/member/mlm/product_code/sell/clear_line/' + id, function() 
	{
		load_session();
		toastr.success('Line Removed');
	});
}
function submit_done(data) 
{
    if(data.response_status == "warning")
    {
        var htmls 		  = "<div class='alert alert-danger'>";
        var warning_vali  = data.warning_validator;
        if (warning_vali != undefined) {
             // do something 
            var item_id   = warning_vali.item_id;
            var quantity  = warning_vali.quantity;
            
            
            $(item_id).each(function(a, b){
               htmls += b + "<br/>";
            });

            $(quantity).each(function(a, b){
               htmls += b + "<br/>";
            });
        }
        else
        {
            var other = data.other_warning;
            htmls    += other + "<br/>"; 
        }
        
        htmls += "</div>";
        $('#add-new-line-warning').html(htmls);
    }
    else if(data.response_status == "success")
    {
        $('#add-new-line-warning').html(" ");
        toastr.success('Line Successfully Added!');
        load_session();
        $('#global_modal').modal('toggle');
    }
}

/* ERWIN */
function on_change_quantity()
{
	$(".item_container").on("input",".quantity_container",function()
	{
		update_container($(this));
	});


	$(".item_container").on("change",".item_id",function()
	{
		update_container($(this),"item_changed");
	});	
}

function update_container($container,$type = null)
{
	$(".item_container").on("focus",".item_id",function()
	{
		past_value = $(this).val();
    });

	var box_container      = $container;
	var quantity           = box_container.parent().parent().find(".quantity_container");
	var item_id 		   = box_container.parent().parent().find(".item_id");
	var price              = box_container.parent().parent().find(".price_container");
	var subtotal           = box_container.parent().parent().find(".subtotal_container");
	var total_top          = $(".total_top");
	var total_bot          = $(".total_bot");
	
	var item_value 				 = item_id.val();
	var quantiy_value			 = quantity.val();
	var price_value	             = $(':selected', item_id).attr("item_price");
	var total_value            	 = price_value * quantiy_value;

	var slot_id = $('.slot_id').val();
    var discount_card_log_id = $('.discount_card_log_id').val();
    if(slot_id == undefined || slot_id == null)
	{
		slot_id = 0;
	}
	if(discount_card_log_id == undefined || discount_card_log_id == null)
	{
		discount_card_log_id = 0;
	}

	if(quantity.val() > 0)
	{
       $.ajax({
       type: "POST",
       url: "/member/mlm/product_code/sell/add_line/submit?" + slot_id + "&discount_card_log_id=" + discount_card_log_id,
       data: {removed:past_value,_token:$("input[name='_token']").val(),item_edit:"1",item_id:item_value,quantity:quantiy_value}, // serializes the form's elements.
       success: function(returned_data)
       {
       		load_session();
       		returned_data = jQuery.parseJSON(returned_data);
    		subtotal.text(returned_data["subtotal"]);
    		total_bot.text(returned_data["total"]);
    		total_top.text(returned_data["total"]);
    		if($type == "item_changed")
    		{
				load_session();
				change_slot_class();
    		}
       }});
	}
}

function item_options()
{
	$('select[name=item_id\\[\\]]').each(function(i,obj) 
	{
		var item_id = $(this).val();
		$(".item_id option[value='"+item_id+"']").not(":eq("+i+")").wrap( "<span>" );	
	});
}
function chosen_select_on_change()
{
	$(".chosen-select").chosen().change(function()
	{
		chosen_select_on_change_event();
	});	
}
function chosen_select_on_change_event()
{
	$(".chosen-select").chosen().val();
	var e_mail = get_chosen_attr("e_mail");
	$(".email").val(e_mail);
}
function get_chosen_attr($attribute)
{
	var options = $( ".chosen-select option:selected" );
	
	for (var i = 0; i < options.length; i++)
	{
	    var property = $(options[i]).attr($attribute);
	    return property;
	}
}
function check_item_container()
{
	if ($(".item_id")[0])
	{
    	$(".save_item").prop("disabled",false);
	} 
	else 
	{
	    $(".save_item").prop("disabled",true);
	}
}
function get_slot(ito)
{
    $('#slot_div').html('<center><div class="loader-16-gray"></div></center>');
    var customer_id = ito.value;
    $('#slot_div').load('/member/customer/product_repurchase/get_slot/' + customer_id, function() {
        $(".chosen-slot_id").chosen({no_results_text: "The slot does not exist."});
    });
}
function bar_code_membership_code(ito)
{
	var membership_code = ito.value;
	$('.customer_data').html('<center><div class="loader-16-gray"></div></center>');
	$('.customer_data').load('/member/customer/product_repurchase/get_slot_v_membership_code/' + membership_code, function(){
		change_slot_class();
	});
	$(ito).val('');
	
}
$(".membership_code").on("paste",function(e){
    $(".membership_code").focus();
});
function change_slot_class()
{
	var slot_id = $('.slot_id').val();
	if(slot_id == undefined || slot_id == null)
	{
		slot_id = 0;
	}
	$('.load_fix_session').load('/member/mlm/product/discount/fix/session/' + slot_id, function(data){
		load_session();
	});
}
function change_slot(ito)
{
	var link = '/member/mlm/product_code/sell/add_line';
	link += '?slot_id=' + ito.value;
	$('.add_line_link').attr('link', link);
	$('.load_fix_session').load('/member/mlm/product/discount/fix/session/' + ito.value, function(data){
		load_session();
	});
}
function load_no_discount()
{

	$('.load_fix_session').load('/member/mlm/product/discount/fix/session/0', function(data){
		load_session();
	});
}
$(".chosen-select").chosen({no_results_text: "The customer doesn't exist."});
function submit_done(data)
{
	if(data.response_status == 'warning')
	{
		var validtor = data.warning_validator;
		validtor.forEach(function (item) {
		  toastr.warning(item);
		})
	}
	else if(data.response_status == 'success')
	{
		toastr.success('Success');
		load_session();
	}

	else if(data.response_status == 'success_process')
	{
		toastr.success('Success');
		window.location = "/member/mlm/product_code/receipt?invoice_id=" + data.invoice_id;
	}
}

$(document).on("keydown", ".membership_code", function(e)
{
	
	if(e.which == 13)
	{
		e.preventDefault();
		bar_code_membership_code(this);
	}
})
</script>
@endsection