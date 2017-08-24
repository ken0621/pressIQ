<form class="global-submit form-horizontal" role="form" action="/member/item/price_level/add" method="post">
	{{ csrf_field() }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title"><i class="fa fa-table"></i> CREATE NEW PRICE LEVEL</h4>
		<div>This module allows you to create custom price for products.</div>
	</div>
	<div class="modal-body clearfix">
		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		            <label class="control-label col-sm-4 text-right" for="email">Price Level</label>
		            <div class="col-sm-8">
		                <input name="price_level_name" required="required" type="text" class="form-control input-sm price-level-select">
		            </div>
		        </div>
	        </div>
			<div class="col-md-6">
		        <div class="form-group">
		            <label class="control-label col-sm-4 text-right" for="email">Price Level Type</label>
		            <div class="col-sm-8">
		                <select name="price_level_type" class="form-control select-type-of-price-level">
		                	<option value="per-item">Per Item</option>
		                	<option value="fixed-percentage">Fixed Percentage</option>
		                </select>
		            </div>
		        </div>
	        </div>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="price-level-container" leveltype="per-item">
				<div class="col-md-12">
					<table class="table table-bordered table-condensed">
					    <thead style="background-color: #eee">
					        <tr>
					        	<th class="text-center check-all-item" width="50px"><input type="checkbox" class="checkbox-all"></th>
					            <th class="text-left" width="250px">ITEM NAME</th>
					            <th class="text-center" width="180px">COST</th>
					            <th class="text-center" width="180px">STANDARD</th>
					            <th class="text-center">CUSTOM PRICE</th>
					        </tr>
					    </thead>
					</table>
					<div class="table-holder">
						<table class="table table-condensed price-level-table">
					        <tbody>
					        	@foreach($_item as $item)
					            <tr>
					            	<td width="50px" class="text-center price-level-check-event">
					            		<input class="checkboxs" type="checkbox" name="">
					            	</td>
					                <td width="250px" class="text-left price-level-check-event">{{ $item->item_name }}</td>
					                <td width="180px" class="text-center item-cost" item-value="{{$item->item_cost}}">{{ $item->item_cost }}</td>
					                <td width="180px" class="text-center item-price" item-value="{{$item->item_price}}">{{ $item->item_price }}</td>
					                <td class="text-center"><input name="_item[{{ $item->item_id }}]" type="text" class="custom-price-textbox text-right" name=""></td>
					            </tr>
					            @endforeach
					        </tbody>
						</table>
					</div>

					<div class="adjust-panel">
						<div>
							<span>Adjust price of marked items to be</span>
							<span>
								<input class="text-right adjust-price-percent" width="20px" type="text" name="" value="0.00%">
							</span>
							<span>
								<select name="fixed-percentage-mode"  class="adjust-price-range">

									<option>lower</option>
									<option>upper</option>
								</select>
							</span>
							<span> than its </span>
							<span>
								<select name="fixed-percentage-source" class="adjust-price-type">
									<option>standard price</option>
									<option>cost price</option>
								</select>
							</span>
							<button type="button" class="adjust-marked-btn">Adjust</button>
						</div>
						<div style="margin-top: 5px;">
							<span name="fixed-percentage-round-off">Round up to the nearest </span>
							<span> 
								<select class="adjust-price-roundup">
									<option>no rounding</option>
								</select>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="price-level-container" leveltype="fixed-percentage">
				<hr>
				<div class="col-md-12 text-center">
					<div class="adjust-panel">
						<div>
							<span>The price will</span>
							<span>
								<select>
									<option name="decrease">decrease</option>
								</select>
							</span>
							<span> by </span>
							<span>
								<input class="text-right" width="20px" type="text" name="" value="0.00%">
							</span>
						</div>
						<div style="margin-top: 5px;">
							<span>Round up to the nearest </span>
							<span> 
								<select>
									<option name="no_rounding">no rounding</option>
								</select>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit"><i class="fa fa-save"></i> &nbsp; Save Price Level</button>
	</div>
</form>

<script type="text/javascript" src="/assets/member/js/price_level/add.js"></script>

<style type="text/css">
.table-holder
{
	height: 237px;
	overflow-y: scroll;
	border: 1px solid #ddd;
	margin-top: -10px;
}
.custom-price-textbox
{
	border: 1px solid #ddd;
	border-radius: 2px;
	padding: 2px 5px;
}
.price-level-check-event
{
	cursor: pointer;
}
.price-level-check-event input[type=checkbox]
{
	cursor: pointer;
}
.adjust-panel
{
	padding: 10px 20px;

}
.adjust-panel input[type=text], select
{
	border: 1px solid #ccc;
	padding: 3px;
	border-radius: 3px;
	width: 150px;
}
.adjust-panel button
{
	background-color: #ddd;
	border: 1px solid #bbb;
	width: 60px;
	margin-left: 5px;
}
</style>

