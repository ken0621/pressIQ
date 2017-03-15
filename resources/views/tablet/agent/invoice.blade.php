@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div class="col-md-8">
            <i class="fa fa-tablet"></i>
            <h1>
                <span class="page-title">Tablet &raquo; Invoice</span>
                <small>
                </small>
            </h1>
        </div>
        <div class="col-md-4 text-right">
            <div class="col-md-12 text-left">
                <label>{{$employee_name}}</label><br>
                <label>{{$employee_position}}</label><br>
                <a href="/tablet/logout">Logout</a>
            </div>  
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block" id="top">
   <div class="tab-content panel-body form-horizontal tablet-container">
        <div id="invoice" class="tab-pane fade in active">
            <div class="form-group">
                <div class="col-md-4">
                    <a class="btn btn-primary form-control" href="/tablet/create_invoices/add?sir_id={{Session::get('selected_sir')}}">Create Invoice</a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                  <table class="table table-bordered table-condensed">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Customer</th>
                              <th>Total Price</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($_invoices as $inv)
                          <tr>
                            <td>{{$inv->inv_id}}</td>
                            <td>
                              @if($inv->company != null)
                              {{$inv->company}}
                              @else
                              {{$inv->title_name}} {{$inv->first_name}} {{$inv->middle_name}} {{$inv->last_name}} 
                              {{$inv->suffix_name}}
                              @endif
                            </td>
                            <td>{{currency("PHP",$inv->inv_overall_price)}}</td>
                              <td class="text-center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action <span class="caret"></span>
                                  </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li><a size="lg" link="/tablet/view_invoice_view/{{$inv->inv_id}}" class="popup">View Invoice</a></li>
                                        <li><a href="/tablet/create_invoices/add?id={{$inv->inv_id}}&sir_id={{Session::get('selected_sir')}}">Edit Invoice</a></li>
                                        <li><a >View Receipt</a></li>                                            
                                    </ul>
                                </div>
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection