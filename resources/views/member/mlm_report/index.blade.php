@extends('member.layout')
@section('content')

<style type="text/css">
    
</style>
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-folder-open-o"></i>
            <h1>
                <span class="page-title">Multilevel Marketing Report</span>
                <small>
                    Reports from multilevel marketing
                </small>
            </h1>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading clearfix">
        <div>
        <form class="global-submit" method="post" action="/member/mlm/report/get">
        {!! csrf_field() !!}
            <div class="col-md-12">
              <div class="col-md-3">
                <select name="report_choose" class="form-control report_choose" onChange="filter_update(this)">
                  @foreach($report_list as $key => $value)
                  <option value="{{$key}}" from="{{$report_list_d[$key]['from']}}" to="{{$report_list_d[$key]['to']}}" count="{{$report_list_d[$key]['count']}}" cashier="{{$report_list_d[$key]['cashiers']}}" warehouse="{{$report_list_d[$key]['warehouse']}}" >{{$value}}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-2">
              <button class="btn btn-primary col-md-12">Generate</button>
              </div>
              <div class="col-md-7 pull-right">
                  <button class="btn btn-custom-red-white margin-right-10 btn-pdf pull-right" onClick="print_pdf()"><i class="fa fa-file-pdf-o"></i>&nbsp;Export to PDF</button>
                   <button class="btn btn-custom-green-white margin-right-10 btn-pdf pull-right" onClick="print_excel()"><i class="fa fa-file-excel-o"></i>&nbsp;Export to Excel</button>
              </div>

            </div>
            <div class="col-md-12">
                <hr>
                <small><span style="color: gray">Filter by date range</span></small>
            </div>
            <div class="col-md-12">      
                

                <div class="col-md-3">
                    <label><small>From:</small></label>
                    <input type="date" class="form-control from_in" name="from">
                </div>   
                <div class="col-md-3">
                    <label><small>To:</small></label>
                    <input type="date" class="form-control to_in" name="to">
                </div>  

                <div class="col-md-3 status_c hide">
                    <label><small>Status:</small></label>
                    <select class="form-control inv_status" name="inv_status">
                      <option value="0" selected>All</option>
                      <option value="Pending"   >Pending</option>
                      <option value="Failed"    >Failed</option>
                      <option value="Processing">Processing</option>
                      <option value="Shipped"   >Shipped</option>
                      <option value="Completed" >Completed</option>
                      <option value="On-Hold"   >On-Hold</option>
                      <option value="Cancelled" >Cancelled</option>
                  </select>
                </div> 

                <div class="col-md-3 cashiers_c hide">
                  <label><small>Cashiers</small></label>
                  <select class="form-control user_id" name="user_id">
                    <option value="0">All</option>
                    @foreach($users as $key => $value)
                      <option value={{$value->user_id}}>{{$value->user_first_name}} {{$value->user_last_name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 warehouse_c hide">
                  <label><small>Warehouse</small></label>
                    <select class="form-control warehouse_id" name="warehouse_id">
                    <option value="0">All</option>
                    @foreach($warehouse as $key => $value)
                      <option value="{{$value->warehouse_id}}">{{$value->warehouse_name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 hide">
                <hr>
                <small><span style="color: gray">Data Count</span></small>
            </div>
            <div class="col-md-12 hide">
                <div class="col-md-3">
                    <label><small>Data Count</small></label>
                    <input type="number" class="form-control count_in" value="0">
                </div>
                <div class="col-md-3">
                    <label><small>Skip</small></label>
                    <input type="number" class="form-control skip_in" value="0" name="skip">
                </div>
                <div class="col-md-3">
                    <label><small>Take</small></label>
                    <input type="number" class="form-control take_in" value="50" name="take">
                </div>

            </div>
        </form>  
        </div>  
    </div>
</div>
<div class="append_report"></div>
@endsection

@section('script')
<script type="text/javascript">
  function submit_done (data) {
    // body...
    if(data.status =='success')
    {
      toastr.success('Fetched Report');
      $('.append_report').html(data.view);
    }
  }
  function filter_update(ito)
  {
    var from = $(ito).find('option:selected').attr('from');
    var to = $(ito).find('option:selected').attr('to');
    var count = $(ito).find('option:selected').attr('count');
    var cashier = $(ito).find('option:selected').attr('cashier');
    var warehouse = $(ito).find('option:selected').attr('warehouse');
    var value = $(ito).find('option:selected').attr('value');

    $('.from_in').val(from);
    $('.to_in').val(to);
    $('.count_in').val(count);
    $('.take_in').val(count);

    if(warehouse == 'show')
    {
      $('.cashiers_c').removeClass('hide');
      $('.warehouse_c').removeClass('hide');
    }
    else
    {
      $('.cashiers_c').addClass('hide');
      $('.warehouse_c').addClass('hide');
    }

    $('.status_c').addClass('hide');

    if(value=='e_commerce_sales_report')
    {
      $('.status_c').removeClass('hide');
    }
    
  }
  function print_excel()
  {
    var choose = $('.report_choose').val();
    var from = $('.from_in').val();
    var to = $('.to_in').val();
    var skip = $('.skip_in').val();
    var take = $('.take_in').val();
    var user_id = $('.user_id').val();
    var warehouse_id = $('.warehouse_id').val();

    var inv_status = $('.inv_status').val(); 

    window.open('/member/mlm/report/get?report_choose=' + choose + '&pdf=excel&from=' + from +'&to=' + to + '&skip=' +skip +'&take=' + take + '&user_id=' + user_id + '&warehouse_id=' + warehouse_id + '&inv_status=' + inv_status, '_blank');
  }
  function print_pdf()
  {
    var choose = $('.report_choose').val();

    var from = $('.from_in').val();
    var to = $('.to_in').val();
    var skip = $('.skip_in').val();
    var take = $('.take_in').val();
    var user_id = $('.user_id').val();
    var warehouse_id = $('.warehouse_id').val();

    var inv_status = $('.inv_status').val();  

    window.open('/member/mlm/report/get?report_choose=' + choose + '&pdf=true&from=' + from +'&to=' + to + '&skip=' +skip +'&take=' + take + '&user_id=' + user_id + '&warehouse_id=' + warehouse_id + '&inv_status=' + inv_status, '_blank');
  }
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection
