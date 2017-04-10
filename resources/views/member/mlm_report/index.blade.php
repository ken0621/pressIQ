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
                <select name="report_choose" class="form-control report_choose">
                  @foreach($report_list as $key => $value)
                  <option value="{{$key}}">{{$value}}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-2">
              <button class="btn btn-primary col-md-12">Generate</button>
              </div>
              <div class="col-md-7 pull-right">
                  <button class="btn btn-custom-red-white margin-right-10 btn-pdf pull-right" onClick="print_pdf()"><i class="fa fa-file-pdf-o"></i>&nbsp;Export to PDF</button>
                   <button class="btn btn-custom-green-white margin-right-10 btn-pdf pull-right" onClick="print_pdf()"><i class="fa fa-file-excel-o"></i>&nbsp;Export to Excel</button>
              </div>

            </div>
            <div class="col-md-12">
                <hr>
                <small><span style="color: gray">Filter by date range</span></small>
            </div>
            <div class="col-md-12">      
                

                <div class="col-md-3">
                    <label><small>From:</small></label>
                    <input type="date" class="form-control">
                </div>   
                <div class="col-md-3">
                    <label><small>To:</small></label>
                    <input type="date" class="form-control">
                </div>  
            </div>
            <div class="col-md-12">
                <hr>
                <small><span style="color: gray">Filter by date period</span></small>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <label><small>Date Period</small></label>
                    <select class="form-control">
                        <option value="day">Day</option>
                        <option value="month">Month</option>
                        <option value="Year">Year</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
                <small><span style="color: gray">Data Count</span></small>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <label><small>Skip</small></label>
                    <input type="number" class="form-control" value="0">
                </div>
                <div class="col-md-3">
                    <label><small>Take</small></label>
                    <input type="number" class="form-control" value="0">
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
  function print_pdf()
  {
    var choose = $('.report_choose').val();
    window.open('/member/mlm/report/get?report_choose=' + choose + '&pdf=true', '_blank');
  }
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection
