@extends('member.layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-envelope-open-o"></i>
            <h1>
                <span class="page-title">Email Header & Footer</span>
            </h1><!-- 
            <div class="text-right">
            <a class="btn btn-primary panel-buttons popup" link="/member/maintenance/email_content/add" size="md" data-toggle="modal" data-target="#global_modal">Add Email Content</a>
            </div> -->
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                  <li id="all-list" class="active"><a data-toggle="tab" href="#all"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Email Header Footer</a></li>
                </ul>
            </div>
            <div class="col-md-4 pull-right">
            </div>
        </div>

        <div class="form-group tab-content panel-body template-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="tab-content">
                    <div class="form-group">
                        <div class="col-md-12">
                            <button link="/member/maintenance/email_header_footer/update/header" size="lg" class="btn btn-primary popup">Edit Email Header</button>
                        </div>
                    </div>
                    <div class="form-group row clearfix">
                        @if(isset($template))
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group clearfix">
                                    <table style="width: 100%;background-color: {{$template->header_background_color}}">
                                        <tbody>
                                            <tr>
                                                <td style="width: 180px">
                                                    <img style="width: 100%;" src="{{$template->header_image}}">
                                                </td>
                                                <td>
                                                    <div style="color: {{$template->header_text_color}}">{!! $template->header_txt !!}</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        @endif
                    </div>
                </div>

                <div class="tab-content">
                    <div class="form-group">
                        <div class="col-md-12">
                            <button link="/member/maintenance/email_header_footer/update/footer" size="lg" class="btn btn-primary popup">Edit Email Footer</button>
                        </div>
                    </div>
                    <div class="form-group row clearfix">
                        @if(isset($template))
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group clearfix">
                                    <table style="width: 100%;background-color: {{$template->footer_background_color}}">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div style="color: {{$template->footer_text_color}}">{!! $template->footer_txt !!}</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
@section("script")
<!-- <script type="text/javascript" src="/assets/member/js/warehouse.js"></script> -->
<script type="text/javascript">
    function submit_done(data)
    {
        if(data.status == "success")
        {
            toastr.success("Success");
            $(".template-container").load("/member/maintenance/email_header_footer .template-container"); 
            data.element.modal("hide");
        }
    }
</script>
@endsection