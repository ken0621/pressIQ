@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <form method="POST">
            @include('mlm.report.global_repurchase')  

        </form> 
        <div>

    </div>
    </div>
</div>
@endsection