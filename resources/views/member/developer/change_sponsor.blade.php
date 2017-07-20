@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Change Sponsor</span>
                <small>
                    For slot with no sponsor.
                </small>
            </h1>
        </div>
    </div> 
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form class="global-submit" method="post" action="/member/developer/change_sponsor/submit">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-6">
                <label for="">Slot</label>
                <input type="text" class="form-control" name="slot">
            </div>
            <div class="col-md-6">
                <label for="">Sponsor</label>
                <input type="text" class="form-control" name="slot_sponsor">
            </div>
            <div class="col-md-12"><br></div>
            <div class="col-md-6">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
<style type="text/css">

</style>
@section('script')
<script type="text/javascript">
    
    function submit_done(data)
    {
        toastr.success(data.message);
    }
</script>
@endsection