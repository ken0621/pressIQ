
@extends('member.layout')
@section('content')
<form class="global-submit form-to-submit-transfer" role="form" action="/member/pis/sir/edit_submit" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" name="sir_id" value="{{$sir->sir_id}}">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Load Out Form &raquo; EDIT L.O.F No {{sprintf("%'.05d\n", $sir->sir_id)}}</span>
                    <small>
                    	Update Load Out Form
                    </small>
                </h1>
                
            <div class="text-right">
            <a class="btn btn-custom-white panel-buttons" href="/member/pis/sir">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-block panel-title-block panel-gray">
        <div class="panel-body form-horizontal">
            <div class="form-group">
                <div class="col-md-1">                                
                    <label>DATE :</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="datepicker form-control" value="{{dateFormat($sir->created_at)}}" name="sir_date">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1">                                
                    <label>Plate No:</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control select-truck" name="truck_id">
                        @if($_truck)
                            @foreach($_truck as $truck)
                                <option value="{{$truck->truck_id}}" {{$sir->truck_id == $truck->truck_id ? 'selected' : ''}}>{{$truck->plate_number}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1">
                    <label>Salesman:</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control select-employee" name="sales_agent_id">
                        @if($_employees)
                            @foreach($_employees as $employee)
                                <option value="{{$employee->employee_id}}" {{$sir->sales_agent_id == $employee->employee_id ? 'selected' : ''}}>{{$employee->first_name}} {{$employee->middle_name}} {{$employee->last_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>            
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 30px;"></th>
                                            <th style="width: 15px;" class="text-right">#</th>
                                            <th style="width: 200px;">Product Code</th>
                                            <th style="width: 200px;">Unit</th>
                                            <th>Description</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 120px;">Unit Price</th>
                                            <th style="width: 120px;">Amount</th>
                                            <th width="30"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="draggable">
                                    @if($_sir_item)
                                        @foreach($_sir_item as $key => $sir_item)                              
                                        <tr class="tr-draggable tr-draggable-html">
                                            <td class="text-center cursor-move move"><i class="fa fa-th-large colo-mid-dark-gray"></i></td>

                                            <td class="invoice-number-td text-right">{{$key + 1}}</td>
                                            <td>
                                                <select class="form-control select-item droplist-item input-sm pull-left" name="item[]">
                                                    @foreach($_item as $item)
                                                        <option value="{{$item->item_id}}" {{$sir_item->item_id == $item->item_id ? 'selected' : ''}} unit="{{$item->item_measurement_id}}" sales-info="{{$item->item_sales_information}}" purchase-info="{{$item->item_purchasing_information}}" price="{{$item->item_price}}" cost="{{$item->item_cost}}">{{$item->item_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>                                            
                                            <td>
                                                <select class="um-list form-control select-item droplist-unit input-sm pull-left {{$ctr = 0}}" price="{{$sir_item->item_price}}" name="related_um_type[]">
                                                    @if(is_numeric($sir_item->related_um_type))
                                                        @foreach($sir_item->um_list as $um)
                                                            <option value="{{$um->multi_id}}" {{$um->multi_id == $sir_item->related_um_type ? 'selected' : ''}} unit-qty="{{$um->unit_qty}}">{{$um->multi_name}} ({{$um->multi_abbrev}})</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($sir_item->um_list as $um)
                                                            <option value="{{$um->multi_id}}" unit-qty="{{$um->unit_qty}}">{{$um->multi_name}} ({{$um->multi_abbrev}})</option>
                                                        @endforeach                                                        
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" readonly="true" class="txt-desc" name="invline_description[]">{{$sir_item->item_sales_information}}</textarea>
                                                <input type="hidden" name="um_qty[]" class="um-qty" >
                                            </td>
                                            <td><input class="text-center number-input txt-qty" type="text" value="{{$sir_item->item_qty}}" name="item_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate" type="text" value="{{number_format($sir_item->um_qty * $sir_item->item_price,2)}}" readonly="true" name="item_rate[]"/></td>
                                            <td><input class="text-right number-input txt-amount" type="text" value="{{number_format($sir_item->item_price * ($sir_item->item_qty * $sir_item->um_qty),2)}}" readonly="true" name="item_amount[]"/></td>
                                            <td class="text-center cursor-pointer"><i class="fa fa-trash-o remove-tr" aria-hidden="true"></i></td>
                                        </tr>
                                        @endforeach
                                    @endif                                       
                                        <tr class="tr-draggable">
                                            <td class="text-center cursor-move move" ><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
                                            <td class="invoice-number-td text-right">2</td>
                                            <td>
                                                <select class="form-control select-item droplist-item input-sm pull-left" name="item[]" data-placeholder="Select a Customer" style=";">
                                                   @include('member.load_ajax_data.load_item');
                                                </select>
                                            </td>                                          
                                            <td>
                                                <select class="um-list form-control select-item droplist-unit input-sm pull-left" name="related_um_type[]" data-placeholder="Select a Customer" style=";">
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc"  class="txt-desc" name="invline_description[]"></textarea>
                                                <input type="hidden" name="um_qty[]" class="um-qty" >
                                            </td>
                                            <td><input class="text-center number-input txt-qty" type="text" name="item_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate" type="text" readonly="true" name="item_rate[]"/></td>
                                            <td><input class="text-right number-input txt-amount" type="text" readonly="true" name="item_amount[]"/></td>
                                            <td class="text-center cursor-pointer"><i class="fa fa-trash-o remove-tr" aria-hidden="true"></i></td>
                                        </tr>

                                    </tbody>
                                   
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</form>
<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="text-center cursor-move move" ><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
            <td class="invoice-number-td text-right">2</td>
            <td>
                <select class="form-control select-item item-class input-sm pull-left" name="item[]" data-placeholder="Select a Customer" style=";">
                    @include('member.load_ajax_data.load_item');
                </select>
            </td>
            <td>
                <select class="um-list form-control select-item unit-class input-sm pull-left" name="related_um_type[]" data-placeholder="Select a Customer" style=";">
                </select>
            </td>
            <td>
                <textarea class="textarea-expand txt-desc"  class="txt-desc" name="invline_description[]"></textarea>
                <input type="hidden" name="um_qty[]" class="um-qty" >
            </td>
            <td><input class="text-center number-input txt-qty" type="text" name="item_qty[]"/></td>
            <td><input class="text-right number-input txt-rate" type="text" readonly="true" name="item_rate[]"/></td>
            <td><input class="text-right number-input txt-amount" type="text" readonly="true" name="item_amount[]"/></td>
            <td class="text-center cursor-pointer"><i class="fa fa-trash-o remove-tr" aria-hidden="true"></i></td>
        </tr>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
    $(".select-truck").globalDropList(
    {
      hasPopup                : "true",      
      link                    : "/member/pis/truck_list/add",
      link_size               : "md",
      width                   : "100%",
      placeholder             : "Search truck...",
      no_result_message       : "No result found!"
    });
    $(".select-truck").globalDropList("disabled");
    $(".select-employee").globalDropList(
    { 
      hasPopup                : "false",
      width                   : "100%",
      placeholder             : "Search Salesman...",
      no_result_message       : "No result found!"
    });    
    $(".select-employee").globalDropList("disabled");
</script>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript" src="/assets/member/js/draggable_row.js"></script>
<script type="text/javascript" src="/assets/member/js/sir.js"></script>
@endsection