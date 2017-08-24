@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-cart-plus"></i>
            <h1>
            <span class="page-title">Item List</span>
            <small>
                 List of Products / Services you are selling
            </small>
            </h1>

            <div class="dropdown pull-right">
                <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-gear"></i> Columns</button>
                <button onclick="location.href=''" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</button>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-check"></i> Active</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-trash"></i> Archived</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            <select class="form-control">
                <option value="0">All Item Type</option>
                <option value="1">Inventory</option>
                <option value="2">Non-Inventory</option>
                <option value="3">Bundle</option>
            </select>
        </div>
        <div class="col-md-3" style="padding: 10px">
            <select class="form-control">
                <option value="0">All Category</option>
            </select>
        </div>
        <div class="col-md-2" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-employee-name" placeholder="Search Item" aria-describedby="basic-addon1">
            </div>
        </div>  
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
                <div class="clearfix">
                    <div class="col-md-12">
                        <div class="table-responsive">
						    <table class="table table-bordered table-striped table-condensed">
						        <thead style="text-transform: uppercase">
						            <tr>
						            	<th class="text-center" width="50px;">ITEM ID</th>
						                <th class="text-center" width="220px;">SKU</th>
						                <th class="text-center" width="120px">Inventory</th>
						                <th class="text-center" width="60px">U/M</th>
						                <th class="text-center" width="180px">Price</th>
						                <th class="text-center" width="180px">Cost</th>
						                <th class="text-left" width="170px"></th>
						            </tr>
						        </thead>
						        <tbody>
						        	<tr>
						        		<td class="text-center">500001</td>
						        		<td class="text-center">XUNODBCMAGICWALTZJ7PRIME</td>
						        		<td class="text-center">125</td>
						        		<td class="text-center"><a href="javascript:">ea</a></td>
						        		<td class="text-center">PHP 1,500.00</td>
						        		<td class="text-center">PHP 1,500.00</td>
						        		<td class="text-center">
											<div class="btn-group">
												<button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Action <span class="caret"></span>
												</button>
												<ul class="dropdown-menu dropdown-menu-custom">
													<li>
														<a href="javascript:">
															<div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-edit"></i> &nbsp;</div>
															Modify
														</a>
													</li>
													<li>
														<a href="javascript:">
															<div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-trash"></i> &nbsp;</div>
															Archive
														</a>
													</li>
													<li>
														<a href="javascript:">
															<div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-info"></i> &nbsp;</div>
															Item Information
														</a>
													</li>
												</ul>
											</div>
						        		</td>
						        	</tr>
						        </tbody>
						    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection