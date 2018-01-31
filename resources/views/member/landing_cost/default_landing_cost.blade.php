@extends('member.layout')
@section('content')
<form class="global-submit" action="{{$action or ''}}" method="post">
    <div class="panel panel-default panel-block panel-title-block">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
        <div class="panel-heading">
            <div>
                <i class="fa fa-calendar"></i>
                <h1>
                <span class="page-title">Landing Cost</span>
                <small>
                Insert Description Here
                </small>
                </h1>
                <div class="dropdown pull-right">
                    <div>
                    	<button type="submit" class="btn btn-primary"><i class="fa fa-icon fa-star"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
        <div class="data-container">
            <div class="tab-content">
                <div class="row">      
                    <div class="col-md-12" style="padding: 30px;">
		            	<div class="row clearfix draggable-container">
		                    <div class="table-responsive">
		                        <div class="col-sm-12">
		                            <table class="digima-table">
		                                <thead>
		                                	<tr>
		                                		<th class="text-center">#</th>
		                                		<th class="text-center">Name</th>
		                                		<th class="text-center">Description</th>
		                                		<th class="text-center">Type</th>
		                                	</tr>
		                                </thead>
                                        <tbody class="draggable tbody-item">
                                        	<tr>
                                        		<td class="text-center"><label>1</label></td>
                                        		<td><input type="text" class="form-control" name=""/></td>
                                        		<td><textarea class="form-control textarea-expand"></textarea></td>
                                        		<td>
                                        			<select class="form-control">
                                        				<option value="">Fixed</option>
                                        				<option value="">Percentage</option>
                                        			</select>
                                        		</td>
                                        	</tr>
                                        	<tr>
                                        		<td class="text-center"><label>2</label></td>
                                        		<td><input type="text" class="form-control" name=""/></td>
                                        		<td><textarea class="form-control textarea-expand"></textarea></td>
                                        		<td>
                                        			<select class="form-control">
                                        				<option value="">Fixed</option>
                                        				<option value="">Percentage</option>
                                        			</select>
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
    </div>
</form>


<div class="div-script">
    <table class="div-item-row-script hide">
    </table>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/landing_cost/default_landing_cost.js"></script>
@endsection