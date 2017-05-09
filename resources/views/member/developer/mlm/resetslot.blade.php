@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Reset All Slots</span>
                <small>
                    This where developer reset all avible mlm slot
                </small>
            </h1>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <form method="post" action="/member/developer/reset_slot/submit">
            <div class="col-md-4">
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
            {!! csrf_field() !!}
            <button class="btn btn-primary">Reset All Slot</button>
            </form>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <form method="post" action="/member/developer/reset_slot/submit/give">
            <div class="col-md-4">
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="id" placeholder="Ec order id">
            </div>
            {!! csrf_field() !!}
            <button class="btn btn-primary">Give Product Points Ec order</button>
            </form>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <form method="post" action="/member/developer/reset_slot/submit/retro_product_sales">
            <div class="col-md-4">
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
            {!! csrf_field() !!}
            <button class="btn btn-primary">Retro Product Code Sales Chart of Accounts</button>
            </form>
        </div>
    </div>
</div>
@endsection
