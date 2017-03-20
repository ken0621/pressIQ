@extends('member.layout')

@section('css')
@endsection

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-sitemap"></i>
            <h1>
                <span class="page-title">Manage Categories</span>
                <small>
                Manage your item categories
                </small>
            </h1>
            
            <a href="javascript:" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/item/category/modal_create_category" >Add Category</a>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
	<div class="panel-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Active Category</a></li>
				  <li><a data-toggle="tab" href="#"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Archived Category</a></li>
				</ul>
			</div>
			<div class="col-md-4 pull-right">
				<div class="input-group">
					<span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
					<input type="search" name="" class="form-control" placeholder="Start typing category">
				</div>
			</div>
		</div>
		<div class="form-group panel-body">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Category Name</th>
						<th class="text-center">Category Type</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="table-category">
					{!!$category!!}
				</tbody>
			</table>
		</div>
		
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/manage_category_list.js"></script>
<script type="text/javascript">
  function submit_done(data)
  {    
    if(data.status == "success-category")
    {         
        toastr.success("Success");        
        data.element.modal("hide");
    }
    else if(data.status == "error")
    {
        toastr.warning(data.status_message);
        $(data.target).html(data.view);
    }
  }
</script>
@endsection