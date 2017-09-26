@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-cubes"></i>
            <h1>
                <span class="page-title">Receiving Inventory</span>
            </h1>
            <div class="text-right">
                <a class="btn btn-custom-white panel-buttons">Cancel</a>
                <a class="btn btn-primary panel-buttons">Save</a>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body warehouse-container">
            <div class="col-md-12">
                <label>Remarks</label>
                <textarea class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group tab-content panel-body warehouse-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                     <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th class="text-center">ITEM SKU</th>
                                <th class="text-center">ISSUED QTY</th>
                                <th class="text-center">RECEIVED QTY</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>GSATHDDECODER300</td>
                                <td>3</td>
                                <td><input type="text" class="form-control text-right" name="" value="3"></td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>GSATHDDECODER500</td>
                                <td>10</td>
                                <td><input type="text" class="form-control text-right" name="" value="3"></td>
                                <td>7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection