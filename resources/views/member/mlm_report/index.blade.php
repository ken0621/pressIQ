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
                  <option value="{{$key}}" from="{{$report_list_d[$key]['from']}}" to="{{$report_list_d[$key]['to']}}" count="{{$report_list_d[$key]['count']}}" >{{$value}}</option>
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
            </div>
            <div class="col-md-12">
                <hr>
                <small><span style="color: gray">Data Count</span></small>
            </div>
            <div class="col-md-12">
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
    // alert($(ito).find('option:selected').attr('from'));
    var from = $(ito).find('option:selected').attr('from');
    var to = $(ito).find('option:selected').attr('to');
    var count = $(ito).find('option:selected').attr('count');
    // var from = $('.report_choose').options[$('.report_choose').selectedIndex].getAttribute('from');
    // console.log(from);
    $('.from_in').val(from);
    $('.to_in').val(to);
    $('.count_in').val(count);
    $('.take_in').val(count);
  }
  function print_excel()
  {
    var choose = $('.report_choose').val();
    var from = $('.from_in').val();
    var to = $('.to_in').val();
    var skip = $('.skip_in').val();
    var take = $('.take_in').val();

    window.open('/member/mlm/report/get?report_choose=' + choose + '&pdf=excel&from=' + from +'&to=' + to + '&skip=' +skip +'&take=' + take, '_blank');
  }
  function print_pdf()
  {
    var choose = $('.report_choose').val();

    var from = $('.from_in').val();
    var to = $('.to_in').val();
    var skip = $('.skip_in').val();
    var take = $('.take_in').val();


    window.open('/member/mlm/report/get?report_choose=' + choose + '&pdf=true&from=' + from +'&to=' + to + '&skip=' +skip +'&take=' + take, '_blank');
  }
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection
