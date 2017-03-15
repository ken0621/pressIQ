@extends('member.layout')
@section('content')
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div class="col-md-8">
            <i class="fa fa-tablet"></i>
            <h1>
                <span class="page-title">Tablet</span>
                <small>
                    Login as Sales Agent
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

<div class="panel panel-default panel-block panel-title-block panel-gray">
  <div class="tab-content panel-body form-horizontal tablet-container">
    <div class="form-group text-center">
        <div class="col-md-6 col-xs-6">
          <h3>SIR No: <strong>{{sprintf("%'.05d\n", $open_sir->sir_id)}}</strong></h3>
        </div>
        <div class="col-md-6 col-xs-6">
            <h3>
           <a link="/tablet/sir_inventory/{{Session::get('selected_sir')}}" size="lg" class="form-control btn btn-primary popup">VIew Inventory</a>
           </h3>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-xs-6">
          <a class="btn btn-primary form-control" href="/tablet/invoice"><i class="fa fa-list-alt"></i> Invoice ({{$total_invoice_amount}})</a>
        </div>
        <div class="col-md-6 col-xs-6">
            <a class="btn btn-primary form-control"><i class="fa fa-users"></i> Customer ({{$total_customer}})</a>          
        </div>        
    </div>
    <div class="form-group">
        <div class="col-md-6 col-xs-6">
            <a class="btn btn-primary form-control" href="/tablet/receive_payment"><i class="fa fa-money"></i> Receive Payment ({{$total_receive_payment}})</a>
        </div>
        <div class="col-md-6 col-xs-6">
            <a class="popup btn btn-primary form-control" link="/member/pis/agent/edit/{{$employee_id}}" ><i class="fa fa-gears"></i> Account Setting </button></a>
        </div>
    </div>
  </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray">
    <ul class="nav nav-tabs">
        <li class="cursor-pointer sir-class active"><a class="cursor-pointer" data-toggle="tab" href="#invoice"><i class="fa fa-reorder"></i> Invoice List</a></li>
        <li class="cursor-pointer sir-class"><a class="cursor-pointer" data-toggle="tab" href="#customer"><i class="fa fa-users"></i> Customer List</a></li>
        <li class="cursor-pointer sir-class"><a class="popup" link="/member/pis/agent/edit/{{$employee_id}}" size="md"><i class="fa fa-user"></i> Account Settings</a></li>
        <li class="cursor-pointer sir-class"><a class="popup" link="/tablet/submit_all_transaction" ><i class="fa fa-upload"></i> Submit</a></li>
    </ul>

    <div class="tab-content panel-body form-horizontal tablet-container">
            <div id="invoice" class="tab-pane fade in active">
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-primary" href="/tablet/create_invoices/add?sir_id={{Session::get('selected_sir')}}">Create Invoice</a>
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
            <div id="customer" class="tab-pane fade in"> 
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <a link="/member/customer/modalcreatecustomer?stat=not-approved" class="btn btn-primary popup" size="lg">Add Customer</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                      <table class="table table-bordered table-condensed">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Customer</th>
                                  <th>Balance</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($_customer as $customer)
                              <tr style="color: {{$customer->approved == 1? '#000' : '#ff3333' }};">
                                <td>{{$customer->customer_id}}</td>
                                <td>
                                  @if($customer->company != null)
                                  {{$customer->company}}
                                  @else
                                  {{$customer->title_name}} {{$customer->first_name}} {{$customer->middle_name}} {{$customer->last_name}} 
                                  {{$customer->suffix_name}}
                                  @endif
                                </td>
                                <td>{{currency("PHP",$customer->customer_opening_balance)}}</td>
                                  <td class="text-center">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action <span class="caret"></span>
                                      </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                            <li><a href="/tablet/create_invoices/add?sir_id={{Session::get('selected_sir')}}&customer_id={{$customer->customer_id}}">Create Invoice</a></li>
                                            <li><a href="/tablet/receive_payment/add?customer_id={{$customer->customer_id}}" >Receive Payment</a></li>
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
            <div id="account" class="tab-pane fade in">
            
            </div>
            <div id="submit" class="tab-pane fade in">
            
            </div>
        </div>
    </div>
</div>


@endsection
@section("script")
<script type="text/javascript">
    function submit_done_customer(data)
    {
        if(data.message == "success")
        {
            toastr.success("Success");
            $(".tablet-container").load("/tablet/dashboard .tablet-container")
        }
        else if(data.message == "error")
        {
            toastr.warning(data.error);
        }
    }
    function submit_done(data)
    {
        if(data.status == "success")
        {
            toastr.success("Success");
            location.href = "/tablet/dashboard";
        }
        else if(data.status == "error")
        {
            toastr.warning(data.status_message);
            $(data.target).html(data.view);
        }
    }
    $(".select-sir-no").globalDropList(
    { 
      hasPopup                : "false",
      width                   : "100%",
      placeholder             : "Search SIR...",
      no_result_message       : "No result found!",
      onChangeValue : function()
        {
           set_as_selected_sir($(this).val());
        }
    });
    function set_as_selected_sir($sir_id)
    {
        $(".modal_header").removeClass("hidden");
        $.ajax({
            url  : '/tablet/selected_sir',
            data : {sir_id : $sir_id},
            type : 'get',
            success : function()
            {
                toastr.success("Success");
                location.href = "/tablet/dashboard";
            }
        })
    }
</script>
@endsection