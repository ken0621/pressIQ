<form class="global-submit form-horizontal" role="form" action="/member/item/price_level/add" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">CREATE NEW PRICE LEVEL</h4>
	</div>
	<div class="modal-body clearfix">
		<div class="row">
			<div class="col-md-6">
		        <div class="form-group">
		            <label class="control-label col-sm-4 text-right" for="email">Price Level</label>
		            <div class="col-sm-8">
		                <input required="required" type="text" class="form-control input-sm price-level-select">
		            </div>
		        </div>
	        </div>
			<div class="col-md-6">
		        <div class="form-group">
		            <label class="control-label col-sm-4 text-right" for="email">Price Level Type</label>
		            <div class="col-sm-8">
		                <select class="form-control">
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
					        	<th width="50px"></th>
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
					            	<td width="50px" class="text-center price-level-check-event"><input type="checkbox" name=""></td>
					                <td width="250px" class="text-left">{{ $item->item_name }}</td>
					                <td width="180px" class="text-center">{{ $item->item_cost }}</td>
					                <td width="180px" class="text-center">{{ $item->item_price }}</td>
					                <td class="text-center"><input type="text" class="custom-price-textbox text-right" name=""></td>
					            </tr>
					            @endforeach
					        </tbody>
						</table>
					</div>

					<div class="">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button">Submit</button>
	</div>
</form>

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
</style>

