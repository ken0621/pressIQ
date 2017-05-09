<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <style type="text/css">
            .box-scroll { border:2px solid #ccc; height: 100px; overflow-y: scroll; }
        </style>
        <form class="global-submit" action="/member/report/accounting/sale/edit/filter" method="post">
        <div class="col-md-6">
            <div class="box-scroll">
                <center>Fields to show</center>
                {!! csrf_field() !!}
                @foreach($report_field_default as $key => $value)
                <input type="checkbox" value="{{$key}}" {{isset($report_field[$key]) == true ? 'checked' : ''}} name="report_field_module[{{$key}}]" /> {{$value}} <br />
                @endforeach
            </div>
            <button class="btn btn-primary col-md-12">Submit</button>
            </form>
        </div>
    </div>
</div>