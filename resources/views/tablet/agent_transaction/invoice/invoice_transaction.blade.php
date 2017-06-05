@extends('tablet.layout')
@section('content')
<div class="form-group">
	<div class="col-md-12">
		<form class="global-submit" action="{{$action}}">
			<div class="panel panel-default panel-block panel-title-block" id="top">
				<div class="panel-heading">
					<div class="col-md-8 col-xs-6">
						<i class="fa fa-tablet"></i>
						<h1>
						<span class="page-title">Tablet &raquo; Credit Sales</span>
						<small>
						</small>
						</h1>
					</div>
					<div class="col-md-4 col-xs-6 text-right">
						<button data-action="save-and-new" class="btn btn-custom-white">Save and New</button>
						<button data-action="save-and-edit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>
			<div class="panel panel-default panel-block panel-title-block" id="top">
			   <div class="tab-content panel-body form-horizontal tablet-container">
			        <div id="invoice" class="tab-pane fade in active">
			           <div class="form-group">
			           		<div class="col-xs-3">
			           			<label >Invoice No.</label>
		           			</div>
			           		<div class="col-xs-4">
			           			<input type="text" class="form-control input-sm" name="new_invoice_id" value="{{$inv->new_inv_id or $new_inv_id}}">
			           		</div>
			           </div>

			           <div class="form-group">
			           		<div class="col-md-12">
			           			<select class="form-control droplist-customer input-sm pull-left" name="inv_customer_id" data-placeholder="Select a Customer" required>
                                	@include('member.load_ajax_data.load_customer', ['customer_id' => isset($inv) ? $inv->inv_customer_id : (isset($c_id) ? $c_id : '') ]);
                                </select>
		           			</div>
			           </div>

			           <div class="form-group">
			           		<div class="col-md-12">
				           		<label>Terms</label>
				           	</div>
			           		<div class="col-md-12">
			           			<select class="form-control input-sm droplist-terms" name="inv_terms_id">
                                    @include("member.load_ajax_data.load_terms", ['terms_id' => isset($inv) ? $inv->inv_terms_id : ''])
                                </select>
			           		</div>
			           	</div>
			            <div class="form-group">
			           		<div class="col-xs-6">
			           			<label>Invoice Date</label>
                                <input type="text" class="datepicker form-control input-sm" name="inv_date" value="{{isset($inv) ? dateFormat($inv->inv_date) : date('m/d/y')}}"/>
			           		</div>
			           		<div class="col-xs-6">
			           			<label>Due Date</label>
			           			<input type="text" class="datepicker form-control input-sm" name="inv_due_date" value="{{isset($inv) ? dateFormat($inv->inv_due_date) : date('m/d/y')}}" />
			           		</div>
			           	</div>
			           	
		           		@include('tablet.load_ajax_tablet.tablet_item')

			           	<div class="form-group">
			           		<div class="col-md-12">
			           		 <h3>Add Item</h3>
			           		</div>
			           	</div>
			           	<div class="form-group">
			           		<div class="col-md-12">
			           		<!-- select-item droplist-item -->
				           		<select class="form-control tablet-droplist-item input-sm pull-left" name="invline_item_id[]" required>
	                                @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
	                            </select>
                            </div>
			           	</div>
			           	<div class="form-group">
			           		<div class="col-md-12">
                                <div class="col-xs-6 digima-table-label">
                                    Sub Total
                                </div>
                                <div class="col-xs-5 text-right digima-table-value">
                                    <input type="hidden" name="subtotal_price" class="subtotal-amount-input" />
                                    PHP&nbsp;<span class="sub-total">0.00</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-xs-6 text-right digima-table-label">
                                    <div class="row">
                                        <div class="col-xs-6 col-xs-offset-3  padding-lr-1">
                                            <label>EWT</label>
                                        </div>
                                        <div class="col-xs-3  padding-lr-1">
                                            <!-- <input class="form-control input-sm text-right ewt_value number-input" type="text" name="ewt"> -->
                                            <select class="form-control input-sm ewt-value compute" name="ewt">  
                                                <option value="0" {{isset($inv) ? $inv->ewt == 0 ? 'selected' : '' : ''}}></option>
                                                <option value="0.01" {{isset($inv) ? $inv->ewt == 0.01 ? 'selected' : '' : ''}}>1%</option>
                                                <option value="0.02" {{isset($inv) ? $inv->ewt == 0.02 ? 'selected' : '' : ''}}>2%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="ewt-total">0.00</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-xs-6 text-right digima-table-label">
                                    <div class="row">
                                        <div class="col-xs-6 col-xs-offset-3  padding-lr-1">
                                            <select class="form-control input-sm compute discount_selection" name="inv_discount_type">  
                                                <option value="percent" {{isset($inv) ? $inv->inv_discount_type == 'percent' ? 'selected' : '' : ''}}>Disc. %</option>
                                                <option value="value" {{isset($inv) ? $inv->inv_discount_type == 'value' ? 'selected' : '' : ''}}>Disc. value</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3  padding-lr-1">
                                            <input class="form-control input-sm text-right number-input discount_txt compute" type="text" name="inv_discount_value" value="{{$inv->inv_discount_value or ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="discount-total">0.00</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="col-xs-6 text-right digima-table-label">
                                    <div class="row">
                                        <div class="col-xs-4 col-xs-offset-8  padding-lr-1">
                                            <select class="form-control input-sm tax_selection compute" name="taxable">  
                                                <option value="0" {{isset($inv) ? $inv->taxable == 0 ? 'selected' : '' : ''}}>No Tax</option>
                                                <option value="1" {{isset($inv) ? $inv->taxable == 1 ? 'selected' : '' : ''}}>Vat (12%)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="tax-total">0.00</span>
                                </div>
                            </div> 
			           		</div>
			           	</div>

			           	<div class="form-group">
                            <div class="col-md-12">
                                <div class="col-xs-6 digima-table-label">
                                 @if(isset($pis) && $pis != 0)
                                 Invoice
                                 @endif
                                  Total
                                </div>
                                <div class="col-xs-5 text-right digima-table-value total">
                                    <input type="hidden" name="overall_price" class="total-amount-input" />
                                    PHP&nbsp;<span class="total-amount">0.00</span>
                                </div>
                            </div>
                            @if(isset($inv))
                                <div class="col-md-12">
                                    <div class="col-xs-7 text-right digima-table-label">
                                        Payment Appplied
                                    </div>
                                    <div class="col-xs-5 text-right digima-table-value">
                                        <input type="hidden" name="payment-receive" class="payment-receive-input" />
                                        PHP&nbsp;<span class="payment-applied">{{$inv->inv_payment_applied}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7 text-right digima-table-label total">
                                        Balance Due
                                    </div>
                                    <div class="col-xs-5 text-right digima-table-value total">
                                        <input type="hidden" name="balance-due" class="balance-due-input" />
                                        PHP&nbsp;<span class="balance-due">0.00</span>
                                    </div>
                                </div>
                            @endif
			           	</div>
			        </div>
			   </div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}');
    @endif
</script>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript" src="/assets/member/js/draggable_row.js"></script>
<script type="text/javascript" src="/assets/member/bootstrap_drawer/cooker.drawer.js"></script>
<script type="text/javascript" src="/assets/member/js/customer_invoice.js"></script>
@endsection