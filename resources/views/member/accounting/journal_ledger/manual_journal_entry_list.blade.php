@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Journal Entry &raquo; List </span>
                <small>
                    List of Journal Entry
                </small>
            </h1>
            <a class="panel-buttons btn btn-custom-primary pull-right" href="/member/accounting/journal" >Create Journal Entry</a>
        </div>
    </div>
</div>

<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="form-group tab-content panel-body sir_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Invoice No</th>
                            <th>Customer Name</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($_invoices)
                        @foreach($_invoices as $invoice)
                            <tr>
                                <td>{{$invoice->inv_id}}</td>
                                <td>{{$invoice->title_name." ".$invoice->first_name." ".$invoice->middle_name." ".$invoice->last_name." ".$invoice->suffix_name}}</td>
                                <td>{{currency("PHP",$invoice->inv_overall_price)}}</td>
                                <td>
                                    @if($invoice->inv_is_paid == 0)
                                    <a class="btn btn-warning form-control">Open</a>
                                    @else
                                    <a class="btn form-control" style="background-color: #78C500;color: #fff">Paid</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-custom">
                                          <li ><a class="popup" link="/member/customer/customer_invoice_view/{{$invoice->inv_id}}" size="lg">View Invoice</a></li>
                                          @if($invoice->manual_invoice_id == null)
                                          <li ><a href="/member/customer/invoice?id={{$invoice->inv_id}}">Edit Invoice</a></li>
                                          @endif
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
</div>
@endsection