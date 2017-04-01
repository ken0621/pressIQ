@extends('member.layout')
@section('content')
<form method="post">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Page <i class="fa fa-angle-double-right"></i> Content</span>
                    <small>
                    You can edit content of your website in this page.
                    </small>
                </h1>
                <button type="submit" class="panel-buttons btn btn-custom-primary pull-right">Submit</button>
            </div>
        </div>
    </div>
    <!-- NO PRODUCT YET -->
    <div class="panel panel-default panel-block panel-title-block panel-gray ">
        <ul class="nav nav-tabs">
            @foreach($page_info as $key => $_info)
            <li class="{{ $key == 'home' ? 'active' : '' }}"><a href="#{{ $key }}">{{ underscore2Camelcase($key) }}</a></li>
            @endforeach
            <li><a href="#others">Others</a></li>
        </ul>
        <div class="panel panel-default panel-block panel-title-block panel-gray">
            <div class="tab-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($page_info as $key => $_info)
                    <div id="{{ $key }}" class="tab-pane fade {{ $key == 'home' ? 'in active' : '' }}">
                        <div class="clearfix" style="padding: 30px">
                            @foreach($_info as $keys => $info)
                            <div class="col-md-{{ $info->size }}" style="margin-bottom: 5px;">
                                <label>{{ $info->label }}</label>
                                <div>
                                    @if($info->type == "textbox")
                                    <div class="match-height">
                                        <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}">
                                        <input type="text" name="info[{{ $keys }}][value]" class="form-control" value="{{ $info->default }}">
                                    </div>
                                    @elseif($info->type == "gallery")
                                    <div class="match-height">
                                        <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}">
                                        <input class="image-value" key="{{ $keys }}" type="hidden" name="info[{{ $keys }}][value]" value="{{ $info->default }}">
                                        <button type="button" class="btn btn-primary remove-image" key="{{ $keys }}">Remove Images</button>
                                        <div class="gallery-list image-gallery" key="{{ $keys }}">
                                            @if(is_serialized($info->default))
                                                @foreach(unserialize($info->default) as $value)
                                                <div>
                                                    <div class="img-holder">
                                                        <img style="object-fit: contain; object-position: center;" class="img-responsive" src="{{ $value }}">
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                            <div class="empty-notify"><i class="fa fa-image"></i> No Image Yet</div>
                                            @endif
                                        </div>
                                        <div class="slider-thumb" key="{{ $keys }}">
                                            @if(is_serialized($info->default))
                                                @foreach(unserialize($info->default) as $value)
                                                <div>
                                                    <div class="img-holder">
                                                        <img style="object-fit: contain; object-position: center;" class="img-responsive" src="{{ $value }}">
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                    @elseif($info->type == "image")
                                    <div class="match-height">
                                        <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}">
                                        <input class="image-value" key="{{ $keys }}" type="hidden" name="info[{{ $keys }}][value]" value="{{ $info->default }}">
                                        <div class="gallery-list image-gallery image-gallery-single" key="{{ $keys }}">
                                            @if($info->default)
                                            <div>
                                                <div class="img-holder">
                                                    <img style="object-fit: contain; object-position: center;" class="img-responsive" src="{{ $info->default }}">
                                                </div>
                                            </div>
                                            @else
                                            <div class="empty-notify"><i class="fa fa-image"></i> No Image Yet</div>
                                            @endif
                                        </div>
                                    </div>
                                    @elseif($info->type == "post")
                                    <div class="match-height">
                                        <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}">
                                        <input class="post-value" key="{{ $keys }}" type="hidden" name="info[{{ $keys }}][value]" value="{{ $info->default }}">
                                        <button class="btn btn-primary popup" type="button" link="/member/page/content/post/{{ isset($info->limit) ? $info->limit : 'all' }}?key={{ $keys }}" size="lg">Manage Post</button>
                                    </div>
                                    @elseif($info->type == "collection")
                                    <div class="match-height">
                                        <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}">
                                        <select class="form-control select-collection" name="info[{{ $keys }}][value]">
                                            @foreach($_collection as $collection)
                                            <option value="{{ $collection->collection_id }}" {{ $collection->collection_id == $info->default ? "selected" : "" }}>{{ $collection->collection_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @elseif($info->type == "maintenance")
                                    <div class="match-height">
                                        <!-- <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}"> -->
                                        <!-- <input type="hidden" class="form-control maintenance-holder" key="{{ $keys }}" name="info[{{ $keys }}][value]"> -->
                                        <button class="btn btn-primary popup" type="button" link="/member/page/content/maintenance?field={{ serialize($info->field) }}&key={{ $keys }}">Manage {{ $info->label }}</button>
                                        <div style="display: inline-block; margin-left: 5px;">This maintenance currently has <span class="maintenance-count" key="{{ $keys }}">{{ is_serialized($info->default) ? count(unserialize($info->default)) : 0 }}</span> data.</div>
                                    </div>
                                    @else
                                    <div class="match-height">
                                        <input type="hidden" name="info[{{ $keys }}][type]" value="{{ $info->type }}">
                                        <textarea class="form-control" name="info[{{ $keys }}][value]">{{ $info->default }}</textarea>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div id="others" class="tab-pane fade">
                    <div class="clearfix" style="padding: 30px">
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Name</label>
                            <div>
                                <div class="match-height">
                                    <input type="hidden" name="info[company_name][type]" value="{{ isset($company_info['company_name']) ? $company_info['company_name']->type : 'textbox' }}">
                                    <input type="text" name="info[company_name][value]" class="form-control" value="{{ isset($company_info['company_name']) ? $company_info['company_name']->value : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Acronym</label>
                            <div>
                                <div class="match-height">
                                    <input type="hidden" name="info[company_acronym][type]" value="{{ isset($company_info['company_acronym']) ? $company_info['company_acronym']->type : 'textbox' }}">
                                    <input type="text" name="info[company_acronym][value]" maxlength="4" class="form-control" value="{{ isset($company_info['company_acronym']) ? $company_info['company_acronym']->value : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Logo</label>
                            <div class="match-height">
                                <input type="hidden" name="info[company_logo][type]" value="{{ isset($company_info['company_logo']) ? $company_info['company_logo']->type : 'image' }}">
                                <input class="image-value" key="company_logo" type="hidden" name="info[company_logo][value]" value="{{ isset($company_info['company_logo']) ? $company_info['company_logo']->value : '' }}">
                                <div class="gallery-list image-gallery image-gallery-single" key="company_logo">
                                    @if(isset($company_info['company_logo']))
                                    <div>
                                        <div class="img-holder">
                                            <img class="img-responsive" src="{{ $company_info['company_logo']->value }}">
                                        </div>
                                    </div>
                                    @else
                                    <div class="empty-notify"><i class="fa fa-image"></i> No Image Yet</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Receipt Logo</label>
                            <div class="match-height">
                                <input type="hidden" name="info[receipt_logo][type]" value="{{ isset($company_info['receipt_logo']) ? $company_info['receipt_logo']->type : 'image' }}">
                                <input class="image-value" key="receipt_logo" type="hidden" name="info[receipt_logo][value]" value="{{ isset($company_info['receipt_logo']) ? $company_info['receipt_logo']->value : '' }}">
                                <div class="gallery-list image-gallery image-gallery-single" key="receipt_logo">
                                    @if(isset($company_info['receipt_logo']))
                                    <div>
                                        <div class="img-holder">
                                            <img class="img-responsive" src="{{ $company_info['receipt_logo']->value }}">
                                        </div>
                                    </div>
                                    @else
                                    <div class="empty-notify"><i class="fa fa-image"></i> No Image Yet</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Address</label>
                            <div>
                                <div class="match-height">
                                    <input type="hidden" name="info[company_address][type]" value="{{ isset($company_info['company_address']) ? $company_info['company_address']->type : 'textbox' }}">
                                    <input type="text" name="info[company_address][value]" class="form-control" value="{{ isset($company_info['company_address']) ? $company_info['company_address']->value : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Email</label>
                            <div>
                                <div class="match-height">
                                    <input type="hidden" name="info[company_email][type]" value="{{ isset($company_info['company_email']) ? $company_info['company_email']->type : 'textbox' }}">
                                    <input type="text" name="info[company_email][value]" class="form-control" value="{{ isset($company_info['company_email']) ? $company_info['company_email']->value : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Mobile</label>
                            <div>
                                <div class="match-height">
                                    <input type="hidden" name="info[company_mobile][type]" value="{{ isset($company_info['company_mobile']) ? $company_info['company_mobile']->type : 'textbox' }}">
                                    <input type="text" name="info[company_mobile][value]" class="form-control" value="{{ isset($company_info['company_mobile']) ? $company_info['company_mobile']->value : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 5px;">
                            <label>Company Business Hours</label>
                            <div>
                                <div class="match-height">
                                    <input type="hidden" name="info[company_hour][type]" value="{{ isset($company_info['company_hour']) ? $company_info['company_hour']->type : 'textbox' }}">
                                    <input type="text" name="info[company_hour][value]" class="form-control" value="{{ isset($company_info['company_hour']) ? $company_info['company_hour']->value : '  Monday - Friday at 9:00am - 6:00pm' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/page_content.css">
<link rel="stylesheet" type="text/css" href="/assets/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="/assets/slick/slick-theme.css">
<style type="text/css">
.slick-no-slide .slick-track {
    width: 100% !important;
    text-align: center;
    transform: translate3d(0px, 0px, 0px) !important;
}

.slick-no-slide .slick-slide {
    float: none;
    display: inline-block;
}

.slick-no-slide .slick-list {
    padding: 0;
}
</style>
@endsection

@section('script')
<script type="text/javascript" src="/assets/slick/slick.js"></script>
<script type="text/javascript" src="/assets/member/js/page_content.js"></script>
@endsection