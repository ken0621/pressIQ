@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Vendor &raquo; Check #<span id="check-no">0082411 </span></span>
                <small>
                <!--Add a product on your website-->
                </small>
            </h1>
            <button type="submit" class="panel-buttons btn btn-primary pull-right">Save and Send</button>
            <a href="/member/product/list" class="panel-buttons btn btn-default pull-right">Save</a>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray">
  
    <div class="tab-content">
        <div class="row">
            <div class="col-md-12" style="padding: 30px;">
                <!-- START CONTENT -->
                <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <select class="form-control chosen-select input-sm pull-left" data-placeholder="Select a Customer" style="width: calc(100% - 40px);">
                                <option value=""></option>
                                <option value="1">Guillermo Tabligan</option>
                                <option value="2">Edward Guevarra</option>
                                <option value="3">Luke Glenn Jordan</option>
                            </select>
                            <button class="pull-right btn btn-default btn-sm" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control pull-left chosen-select" style="width: calc(100% - 40px);">
                                <option value=""></option>
                                <option value="1">BDO - PHP</option>
                                <option value="2">DMSPH Bank Account - PHP</option>
                            </select>
                            <button class="pull-right btn btn-default btn-sm" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-sm-2">
                            <span>Balance PHP205,534.91</span>
                        </div>
                    </div>
                </div>
                
                <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Mailing Address</label>
                            <textarea class="form-control input-sm" name="" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-2">                        	
                        	<label>Payment Date</label>
                        	<input type="text" class="datepicker form-control input-sm" name="">
	                    </div>
                        <div class="col-sm-2 pull-right">
                            <div class="col-sm-12">
                                <label>Check no</label>
                                <input type="text" class="form-control input-sm" id="input-chck-no" name="">
                                <input type="checkbox" name="" id="print-later-check"> Print Later
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row clearfix">
	                <div class="title">
	                	<h3><a id="acct-a"> <i class="fa fa-caret-down"></i>  Account Details </a></h3>
	                </div>
                    <div class="table-responsive" id="account-tbl">
                        <div class="col-sm-12">
                            <table class="digima-table">
                                <thead >
                                    <tr>
                                        <th style="width: 15px;"></th>
                                        <th style="width: 15px;">#</th>
                                        <th style="width: 200px;">Account</th>
                                        <th>Description</th>
                                        <th style="width: 40px;">Amount(PHP)</th>
                                        <th style="width: 200px;">Customer</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr>
                                        <td class="text-center cursor-move move"><i class="fa fa-reorder"></i></td>
                                        <td>1</td>
                                        <td >                                        	
                                        	<select class="form-control chosen-select input-sm" >
				                                <option value=""></option>
				                                <option value="1">Advertising and Promotion <span class="pull-right"> - Expenses</span></option>
				                                <option value="2">Association Dues <span class="pull-right"> - Expenses</span></option>
				                                <option value="3">Automobile Expense <span class="pull-right"> - Expenses</span></option>
				                            </select>
                                        </td>
                                        <td><textarea></textarea></td>
                                        <td><input type="text" class="form-control input-sm" name=""></td>
                                        <td>
                                        	 <select class="form-control chosen-select input-sm" data-placeholder="Select a Customer" >
				                                <option value=""></option>
				                                <option value="1">Additions Phelps Trading - PHP</option>
				                                <option value="2">Global NWT - PHP </option>
				                                <option value="3">Homerun International - PHP</option>
				                            </select>
				                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center cursor-move move"><i class="fa fa-reorder"></i></td>
                                        <td>2</td>
                                        <td >                                        	
                                        	<select class="form-control chosen-select input-sm" >
				                                <option value=""></option>
				                                <option value="1">Advertising and Promotion <span class="pull-right"> - Expenses</span></option>
				                                <option value="2">Association Dues <span class="pull-right"> - Expenses</span></option>
				                                <option value="3">Automobile Expense <span class="pull-right"> - Expenses</span></option>
				                            </select>
                                        </td>
                                        <td><textarea></textarea></td>
                                        <td><input type="text" class="form-control input-sm" name=""></td>
                                        <td>
                                        	 <select class="form-control chosen-select input-sm" data-placeholder="Select a Customer" >
				                                <option value=""></option>
				                                <option value="1">Additions Phelps Trading - PHP</option>
				                                <option value="2">Global NWT - PHP </option>
				                                <option value="3">Homerun International - PHP</option>
				                            </select>
				                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 <div class="row clearfix">
	                <div class="title">
	                	<h3><a id="item-a"> <i class="fa fa-caret-down"></i>  Item Details </a></h3>
	                </div>
                    <div class="table-responsive" id="item-tbl">
                        <div class="col-sm-12">
                            <table class="digima-table">
                                <thead >
                                    <tr>
                                        <th style="width: 15px;"></th>
                                        <th style="width: 15px;">#</th>
                                        <th style="width: 200px;">Product/Service</th>
                                        <th>Description</th>
                                        <th style="width: 70px;">Qty</th>
                                        <th style="width: 120px;">Rate</th>
                                        <th style="width: 120px;">Amount</th>
                                        <th style="width: 200px;">Customer</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr>
                                        <td class="text-center cursor-move move"><i class="fa fa-reorder"></i></td>
                                        <td>1</td>
                                        <td>
                                        	<select class="form-control chosen-select input-sm" >
				                                <option value=""></option>				                                
				                            </select>
                                        </td>
                                        <td><textarea></textarea></td>
                                        <td><input class="text-right" type="text" name=""/></td>
                                        <td><input class="text-right" type="text" name=""/></td>
                                        <td><input class="text-right" type="text" name=""/></td>
                                        <td>
                                        	<select class="form-control chosen-select input-sm" >
				                                <option value=""></option>
				                                <option value="1">Additions Phelps Trading - PHP</option>
				                                <option value="2">Global NWT - PHP </option>
				                                <option value="3">Homerun International - PHP</option>
				                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center cursor-move move"><i class="fa fa-reorder"></i></td>
                                        <td>2</td>
                                        <td>
                                        	
                                        	<select class="form-control chosen-select input-sm">
				                                <option value=""></option>				                                
				                            </select>
                                        </td>
                                        <td><textarea></textarea></td>
                                        <td><input class="text-right" type="text" name=""/></td>
                                        <td><input class="text-right" type="text" name=""/></td>
                                        <td><input class="text-right" type="text" name=""/></td>
                                        <td>
                                        	 <select class="form-control chosen-select input-sm" data-placeholder="Select a Customer" >
				                                <option value=""></option>
				                                <option value="1">Additions Phelps Trading - PHP</option>
				                                <option value="2">Global NWT - PHP </option>
				                                <option value="3">Homerun International - PHP</option>
				                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <label>Memo</label>
                        <textarea class="form-control input-sm" name="" placeholder=""></textarea>
                    </div>
                    <div class="col-sm-6">                      
                        <div class="row">
                            <div class="col-md-7 text-right digima-table-label">
                                Total
                            </div>
                            <div class="col-md-5 text-right digima-table-value total">
                                PHP 148,400.00
                            </div>
                        </div> 
                    </div>
                </div>
                
                <!-- END CONTENT -->
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
var tmp = null;
    $(".chosen-select").chosen({no_results_text: "The customer doesn't exist."});
    $("#input-chck-no").val($("#check-no").html());
    $("#acct-a").click(function()
    {
    	$('#account-tbl').toggle();
    	$('i',this).toggleClass("fa-caret-right fa-caret-down")
    });
    $("#item-a").click(function()
    {
    	$('#item-tbl').toggle();
    	$('i',this).toggleClass("fa-caret-right fa-caret-down")
    });
    $("#print-later-check").click(function()
    {      
        if($("#print-later-check").is(':checked'))
        {
            tmp = $("#check-no").html();
            $("#input-chck-no").prop("disabled",true);
            $("#check-no").html("To Print");
            $("#input-chck-no").val("To Print")
            // checked
        }
        else
        {
            $("#input-chck-no").prop("disabled",false);
            $("#check-no").html(tmp);
            $("#input-chck-no").val(tmp)
         }
    });
</script>

@endsection