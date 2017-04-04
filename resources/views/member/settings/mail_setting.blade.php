@extends('member.layout')
@section('content')
<form method="post">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Page <i class="fa fa-angle-double-right"></i> Content</span>
                    <small>
                    You can edit content of your website in this page.
                    </small>
                </h1>
                <button type="submit" class="panel-buttons btn btn-custom-primary pull-right">Submit</button>
            </div>
        </div>
    </div>
    <!-- NO PRODUCT YET -->
    <div class="panel panel-default panel-block panel-title-block panel-gray">
        
    </div>
</form>
@endsection