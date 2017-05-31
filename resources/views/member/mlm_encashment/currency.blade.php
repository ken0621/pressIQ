@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-money"></i>
            <h1>
                <span class="page-title">Encashment - Currency</span>
                <small>
                    You can set your encashment convertion here
                </small>
            </h1>
        </div>
    </div>
</div> 
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <table class="table table-condensed table-bordered">
                    <tr>
                        <th>ISO</th>
                        <th>Country</th>
                        <th>Enable</th>
                        <th>Convertion</th>
                        <th></th>
                    </tr>
                @foreach($country as $key => $value)
                    <tr>
                        <td>{{$value->iso}}</td>
                        <td>{{$value->name}}</td>
                        <th><input type="checkbox"></th>
                        <th><input type="number" class="form-control"></th>
                        <th>
                            <button class="btn btn-primary">Save</button>
                        </th>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>        
@endsection
@section('script')
<script type="text/javascript">

</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection
