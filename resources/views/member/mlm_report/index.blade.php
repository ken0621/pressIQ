@extends('member.layout')
@section('content')

<style type="text/css">
    .info-box{
            display: block;
            min-height: 90px;
            background: #fff;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            border-radius: 2px;
            margin-bottom: 15px;
    }
    .info-box-number
    {
            display: block;
            font-weight: bold;
            font-size: 18px;
    }
    .info-box-icon
    {
            border-top-left-radius: 2px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 2px;
            display: block;
            float: left;
            height: 90px;
            width: 90px;
            text-align: center;
            font-size: 45px;
            line-height: 90px;
            background: rgba(0,0,0,0.2);
    }
    .bg-primary
    {
        background-color: #76b6ec !important;
    }
    .info-box-text
    {
        display: block;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .info-box-content
    {
            padding: 5px 10px;
            margin-left: 90px;
    }
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
    <div class="panel-heading">
        <div>
        <form class="global-submit" method="post" action="/member/mlm/report/get">
        {!! csrf_field() !!}
              <div class="col-md-3">
                <select name="report_choose" class="form-control report_choose">
                  @foreach($report_list as $key => $value)
                  <option value="{{$key}}">{{$value}}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-3">
              <button class="btn btn-primary col-md-12">Generate</button>
              </div>
              <div class="col-md-3">
                  <button class="btn btn-custom-red-white margin-right-10 btn-pdf" onClick="print_pdf()"><i class="fa fa-file-pdf-o"></i>&nbsp;Export to PDF</button>
              </div>
            </div>
        </form>    
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
