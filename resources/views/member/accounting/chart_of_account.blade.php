@extends('member.layout')
@section('css')
<style>

    .hiddenRow {
        padding: 0 !important;
    }
    .just-padding {
        padding: 15px;
    }

    .list-group.list-group-roots {
        padding: 0;
        overflow: hidden;
    }

    .list-group.list-group-roots .list-group {
        margin-bottom: 0;
    }

    .list-group.list-group-roots .list-group-item {
        border-radius: 0;
        border-width: 1px 0 0 0;
    }

    .list-group-item:first-child {
        /*border-top-width: 0;*/
        border-top: 1px !important;
    }

    .list-group.list-group-rootS > .list-group > .list-group-item {
        padding-left: 30px;
    }

    .list-group.list-group-roots > .list-group > .list-group > .list-group-item {
        padding-left: 45px;
    }

    .list-group-item .glyphicon {
        margin-right: 5px;
    }
</style>
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Chart of Accounts</span>
                <small>
                    Categorize money your business earns or spends. Or, track the value of your assets and liabilities.
                </small>
            </h1>
            <a href="javascript:" class="panel-buttons btn btn-primary pull-right popup" link="/member/accounting/chart_of_account/popup/add" >Add Accounts</a>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab"><i class="fa fa-star"></i> Active Accounts</a></li>
        <!-- <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"><i class="fa fa-trash"></i> Inactive Accounts</a></li> -->
    </ul>
    <div class="search-filter-box">
            <div class="col-md-4 col-md-offset-8" style="padding: 10px">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control global-search" url="/member/accounting/chart_of_account" data-value="1" placeholder="Search" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
<!--     <div class="">
        <div class="just-padding">

<div class="list-group list-group-roots well">
  
  <a href="#item-1" class="list-group-item" data-toggle="collapse">
    <i class="glyphicon glyphicon-chevron-right"></i>Item 1
  </a>
  <div class="list-group collapse" id="item-1">
    
    <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 1.1
    </a>
    <div class="list-group collapse" id="item-1-1">
      <a href="#" class="list-group-item">Item 1.1.1</a>
      <a href="#" class="list-group-item">Item 1.1.2</a>
      <a href="#" class="list-group-item">Item 1.1.3</a>
    </div>
    
    <a href="#item-1-2" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 1.2
    </a>
    <div class="list-group collapse" id="item-1-2">
      <a href="#" class="list-group-item">Item 1.2.1</a>
      <a href="#" class="list-group-item">Item 1.2.2</a>
      <a href="#" class="list-group-item">Item 1.2.3</a>
    </div>
    
    <a href="#item-1-3" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 1.3
    </a>
    <div class="list-group collapse" id="item-1-3">
      <a href="#" class="list-group-item">Item 1.3.1</a>
      <a href="#" class="list-group-item">Item 1.3.2</a>
      <a href="#" class="list-group-item">Item 1.3.3</a>
    </div>
    
  </div>
  
  <a href="#item-2" class="list-group-item" data-toggle="collapse">
    <i class="glyphicon glyphicon-chevron-right"></i>Item 2
  </a>
  <div class="list-group collapse" id="item-2">
    
    <a href="#item-2-1" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 2.1
    </a>
    <div class="list-group collapse" id="item-2-1">
      <a href="#" class="list-group-item">Item 2.1.1</a>
      <a href="#" class="list-group-item">Item 2.1.2</a>
      <a href="#" class="list-group-item">Item 2.1.3</a>
    </div>
    
    <a href="#item-2-2" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 2.2
    </a>
    <div class="list-group collapse" id="item-2-2">
      <a href="#" class="list-group-item">Item 2.2.1</a>
      <a href="#" class="list-group-item">Item 2.2.2</a>
      <a href="#" class="list-group-item">Item 2.2.3</a>
    </div>
    
    <a href="#item-2-3" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 2.3
    </a>
    <div class="list-group collapse" id="item-2-3">
      <a href="#" class="list-group-item">Item 2.3.1</a>
      <a href="#" class="list-group-item">Item 2.3.2</a>
      <a href="#" class="list-group-item">Item 2.3.3</a>
    </div>
    
  </div>
  
  
  <a href="#item-3" class="list-group-item" data-toggle="collapse">
    <i class="glyphicon glyphicon-chevron-right"></i>Item 3
  </a>
  <div class="list-group collapse" id="item-3">
    
    <a href="#item-3-1" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 3.1
    </a>
    <div class="list-group collapse" id="item-3-1">
      <a href="#" class="list-group-item">Item 3.1.1</a>
      <a href="#" class="list-group-item">Item 3.1.2</a>
      <a href="#" class="list-group-item">Item 3.1.3</a>
    </div>
    
    <a href="#item-3-2" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 3.2
    </a>
    <div class="list-group collapse" id="item-3-2">
      <a href="#" class="list-group-item">Item 3.2.1</a>
      <a href="#" class="list-group-item">Item 3.2.2</a>
      <a href="#" class="list-group-item">Item 3.2.3</a>
    </div>
    
    <a href="#item-3-3" class="list-group-item" data-toggle="collapse">
      <i class="glyphicon glyphicon-chevron-right"></i>Item 3.3
    </a>
    <div class="list-group collapse" id="item-3-3">
      <a href="#" class="list-group-item">Item 3.3.1</a>
      <a href="#" class="list-group-item">Item 3.3.2</a>
      <a href="#" class="list-group-item">Item 3.3.3</a>
    </div>
    
  </div>
  
</div>
  
</div>
        <div class="just-padding">

            <div class="list-group list-group-root well">
              
              <a href="#item-1" class="list-group-item" data-toggle="collapse">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <i class="fa fa-caret-down fa-1x"></i>Item 1
                    </div>
                    <div class="col-md-6">
                        Accounts Types
                    </div>
                </div>
              </a>
              <div class="list-group collapse in" id="item-1">
                
                <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
                  <i class="fa fa-caret-down fa-1x"></i>Item 1.1
                </a>
                <div class="list-group collapse in" id="item-1-1">
                  <a href="#" class="list-group-item">Item 1.1.1</a>
                  <a href="#" class="list-group-item">Item 1.1.2</a>
                  <a href="#" class="list-group-item">Item 1.1.3</a>
                </div>
                
                <a href="#item-1-2" class="list-group-item" data-toggle="collapse">
                  <i class="fa fa-caret-down fa-1x"></i>Item 1.2
                </a>
                <div class="list-group collapse in" id="item-1-2">
                  <a href="#" class="list-group-item">Item 1.2.1</a>
                  <a href="#" class="list-group-item">Item 1.2.2</a>
                  <a href="#" class="list-group-item">Item 1.2.3</a>
                </div>
                
                <a href="#item-1-3" class="list-group-item" data-toggle="collapse">
                  <i class="fa fa-caret-down fa-1x"></i>Item 1.3
                </a>
                <div class="list-group collapse in" id="item-1-3">
                  <a href="#" class="list-group-item">Item 1.3.1</a>
                  <a href="#" class="list-group-item">Item 1.3.2</a>
                  <a href="#" class="list-group-item">Item 1.3.3</a>
                </div>
                
              </div>
              
            </div>
    </div> -->
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive load-data" target="coa_data">
                <div id="coa_data">
                    <table class="table table-hover table-condensed">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Balance Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @include('member.accounting.load_chart_account')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}');
    @endif
    function submit_done(data)
    {
        if(data.response_status == 'success')
        {
            if(data.redirect_to)
            {
                window.location.href = data.redirect_to;
            }
        }
    }

    var coa_list = new coa_list();

    function coa_list()
    {
        init();

        function init()
        {
            document_ready();
        }

        function document_ready() 
        {     
            event_toggle_caret(); 

            $('.list-group-item').on('click', function() {
                $('.fa', this)
                  .toggleClass('fa-caret-down fa-caret-right')
              });
        }

        function event_toggle_caret()
        {
            $(document).on("click", ".toggle-caret", function()
            {
                // $('#display_advance').toggle('1000');
                $(this).toggleClass("fa-caret-right fa-caret-down");
            })
        }
    }
</script>
@endsection