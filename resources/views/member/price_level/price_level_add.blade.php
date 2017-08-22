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
					<table class="table table-bordered table-condensed price-level-table">
					    <thead>
					        <tr>
					            <th class="text-left" width="250px">ITEM NAME</th>
					            <th class="text-center" width="180px">PRICE</th>
					            <th class="text-center">QTY</th>
					            <th class="text-center">DISCNT</th>
					            <th class="text-right" width="180px">AMOUNT</th>
					            <th width="50px"></th>
					        </tr>
					    </thead>
				        <tbody>
				            <tr>
				                <td class="text-center"></td>
				                <td class="text-center"></td>
				                <td class="text-center"></td>
				                <td class="text-right"></td>
				            </tr>
				        </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button">Submit</button>
	</div>
</form>