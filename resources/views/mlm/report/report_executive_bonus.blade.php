@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <form method="POST">
            @include('mlm.report.global_wallet')
            @include('mlm.report.global_repurchase')
        </div>

        </form> 
        <div>

    </div>
    </div>
</div>
@endsection