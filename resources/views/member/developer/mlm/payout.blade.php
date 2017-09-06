@extends('member.layout')
@section('content')

<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">MLM Payout Import Excel</span>
            </h1>
            <a class="btn btn-success pull-right" target="_blank" href="public/assets/mlm/payout_format.xlsx">Download Format (xlsx)</a>
        </div>
    </div>
</div>
<div class="all_user_body_get">
<div class="col-md-4">
    <div class="panel panel-default panel-block panel-title-block clearfix col-md-12" id="top">
        <div class="panel-body" style="overflow-x:auto;">
            <form method="post" action="/member/developer/payout/submit" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <label for=""><small><span style="color: gray">Import</span></small></label>
                <input type="file" name="payout_file" class="form-control" accept=".xlsx" onchange="checkfile(this);" />
                <hr>
                <button class="btn btn-primary pull-right">Submit</button>
            </form>
        </div>
    </div> 
</div>
@if(isset($slots))
    <div class="col-md-8 div_get_details">
        <div class="panel panel-default panel-block panel-title-block clearfix col-md-12" id="top">
            <div class="panel-body">
                <div class="div_get_details_body" style="overflow-x:auto;">
                    <table class="table table-bordered">
                        <tr>
                            <th>Slot</th>
                            <th>From - To</th>
                            <th>Amount</th>
                            <th>Tax</th>
                            <th>Total</th>
                        </tr>
                        
                        @foreach($slots as $key => $value)
                            @if($value && isset($value['error']) && isset($value['subtotal']) && isset($value['tax_value']) && isset($value['tax']) && isset($value['total']))
                            <tr @if($value['error'] == 1) style="background-color: red" @endif >
                                <td>{{$key}}</td>
                                <td>{{$value['from']}} - {{$value['to']}}</td>
                                <td>{{currency('PHP', $value['subtotal'])}}</td>
                                <td>{{currency('PHP', $value['tax_value'])}} ({{currency('PHP', $value['tax'])}}%)</td>
                                <td>{{currency('PHP', $value['total'])}}</td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                    @if(count($slots) >= 1)
                    <form method="post" action="/member/developer/payout/submit/verify">
                        {!! csrf_field() !!}
                        <input type="hidden" name="file" value="{{$file}}">
                        @if($error == 0)
                            <button class="btn btn-primary pull-right">Verify and update wallet.</button>
                        @else
                        <center><h2>There slots with no income withhin the timerange, please remove them on the excel and import again</h2></center>
                        @endif
                    </form>
                    @else
                    <tr>
                        <td> No Data Found</td>
                    </tr>
                    @endif
                </div>
            </div>
        </div> 
    </div>
@endif    
</div>
@endsection

@section('script')
<script type="text/javascript">
    function checkfile(sender) {
        var validExts = new Array(".xlsx");
        var fileExt = sender.value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if (validExts.indexOf(fileExt) < 0) {
          alert("Invalid file selected, valid files are of " +
                   validExts.toString() + " types.");
          return false;
        }
        else return true;
    }
    function submit_done()
    {
        
    }
</script>
@endsection