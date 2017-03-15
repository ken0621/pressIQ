<!-- @products $product -->
<!-- @variant $variant -->
<!-- @item $item -->
<!-- @column $column -->

<!-- FORM.VARIANTS.DETAILS -->
<div class="variant-information">
    <input value="{{$variant->evariant_id or ''}}" type="text" class="hidden" name="variant_id" id="variant_id">
    <div class="title">Information</div>
    <div class="dividers half"></div>
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="{{$default == 1 ? 'active' : ''}} cursor-pointer tab" data-id="1"><a class="cursor-pointer" data-toggle="tab" href="#description"><i class="fa fa-tag"></i> Name & Description</a></li>
            @if($product->eprod_is_single == 0)
                <li class="{{$default == 2 ? 'active' : ''}} cursor-pointer tab" data-id="2"><a class="cursor-pointer" data-toggle="tab" href="#options"><i class="fa fa-certificate"></i> Options</a></li>
            @endif
            <li class="{{$default == 3 ? 'active' : ''}} cursor-pointer tab" data-id="3"><a class="cursor-pointer" data-toggle="tab" href="#info"><i class="fa fa-info"></i> Other Info</a></li>
            <li class="{{$default == 4 ? 'active' : ''}} cursor-pointer tab" data-id="4"><a class="cursor-pointer" data-toggle="tab" href="#image"><i class="fa fa-picture-o"></i> Images</a></li>
        </ul> 
    </div>

    <div class="dividers" style="margin-top: 0"></div>

    <div class="tab-content">
        <div class="tab-pane fade in {{$default == 1 ? 'active' : ''}}" id="description">
            <div class="clearfix">
                <!-- FORM.TITLE -->
                <div class="">
                    <div class="fieldset">
                        <label>Product Item</label>
                        <div class="row">
                            <div class="col-md-6">
                            <select class="select-item droplist-item" name="evariant_item_id">
                                @include("member.load_ajax_data.load_item", ['add_search' => "", 'item_id' => isset($variant) ? $variant->evariant_item_id : ''])
                            </select>
                            </div>
                            <div class="col-md-6">
                            <a class="btn btn-custom-white btn-sm popup edit-item" link=""> Edit Item</a>
                            </div>
                        </div>
                    </div>
                    <div class="fieldset">
                        <label>Product Label</label>
                        <div>
                            <input class="form-control input-sm" name="evariant_item_label" placeholder="Product Label" value="{{$variant->evariant_item_label or ''}}">
                        </div>
                    </div>

                    <div class="fieldset">
                        <!-- description -->
                        <label>Description</label>
                        <div class="product-desc-content">
                            <textarea name="evariant_description" class="form-control input-sm tinymce" >{{ $variant->evariant_description or '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($product->eprod_is_single == 0)
            <div class="tab-pane fade in {{$default == 2 ? 'active' : ''}}" id="options">
                <div class="clearfix">
                    <!-- FORM.TITLE -->
                    @if(isset($_column))
                        @foreach($_column as $key=>$column)
                            <div class="">
                                <label>{{$column}}</label>
                                <input name="option_name[]" value="{{$column}}" type="hidden" class="option-name">
                                <input name="option_value[]" value="{{ $variant->variation[$key] or ''}}" placeholder="" type="text" class="form-control option-value" data-id="">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        <div class="tab-pane fade in {{$default == 3 ? 'active' : ''}}" id="info">
            <div class="clearfix">
                <!-- FORM.TITLE -->
                <div class="">
                    <div class="fieldset">
                        <label>Product Price</label>
                        <div>
                            <input class="form-control input-sm" name="evariant_price" placeholder="Product Price" value="{{$variant->evariant_price or ''}}">
                        </div>
                    </div>

                    <div class="fieldset">
                        <!-- description -->
                        <!-- label>Promo Price</label>
                        <div >
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in {{$default == 4 ? 'active' : ''}}" id="image">
            <div class="clearfix">
                <!-- FORM.IMAGES -->
                <div class="form-box-divider">
                    <div class="clearfix">
                        <div class="title pull-left">Images</div>
                        <a class="image-button pull-right image-gallery" href="javascript:"><i class="fa fa-hand-o-up"></i> Select Image</a>
                        <input id="product-main-image" type="hidden" name="product_main_image" value="">
                    </div>
                    <div class="dividers half"></div>
                    <div class="image-upload-container">
                        <!-- FORM.IMAGES.EMPTY -->
                        @if(isset($variant->image))
                            @if($variant->image->count() <= 0)
                                <div class="upload-empty ">
                                    <div class="icon"><i class="fa fa-image"></i></div>
                                    <div class="word"></div>
                                </div>  
                            @endif
                        @endif
                        <!-- FORM.IMAGES.NOT-EMPTY -->
                       <div class="image-container text-left">
                            <span class="old-image-container">
                            </span>
                            <span class="new-image-container">
                            @if(isset($variant->image))
                                @if($variant->image->count() > 0)
                                    @foreach($variant->image as $key=>$image)
                                        <div class="image">
                                            <input type="hidden" class="image-id" name="image_id[]" value="{{$image->image_id}}">
                                            <input type="hidden" class="image-value" name="product_image[]" value="{{$image->image_path}}">
                                            <div class="loader">
                                                <div class="progress" style="width: 0"></div>
                                            </div>
                                            <div class="black-loader"></div>
                                            <div class="black-hover">
                                                <div class="button-icons-container">
                                                    <div class="icon delete-image">
                                                        <i class="fa fa-trash"></i>
                                                        <div class="label">Delete</div>
                                                    </div>
                                                    <div class="icon set-default-image"><i class="fa fa-circle-o"></i>
                                                        <div class="label">Set Default</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="{{$image->image_path}}">
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                            </span>
                       </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="script-hidden-storage hidden">
    <div class="script-image-container">
       <div class="image loading newly-added">
            <input type="hidden" class="image-id" name="image_id[]" disabled>
            <input type="hidden" class="image-value" name="product_image[]" disabled>
            <div class="loader">
                <div class="progress" style="width: 0"></div>
            </div>
            <div class="black-loader"></div>
            <div class="black-hover">
                <div class="button-icons-container">
                    <div class="icon delete-image">
                        <i class="fa fa-trash"></i>
                        <div class="label">Delete</div>
                    </div>
                    <div class="icon set-default-image"><i class="fa fa-circle-o"></i>
                        <div class="label">Set Default</div>
                    </div>
                </div>
            </div>
            <img src="">
       </div>
    </div>
</div>

<script src="/assets/external/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/assets/member/js/evariant_info.js"></script>