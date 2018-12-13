<form class="global-submit form-horizontal" id="form_submit" role="form" action="/member/cashier/settings/submit" method="post">
    <div class="modal-header">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><i class="fa fa-cart-plus"></i> {{$page or ''}}</h4>
        <div>Create Payment Method</div>
    </div>
    
    <div class="form-horizontal">
        <div class="col-md-12">
            <div class="sale-module">
                <h4 class="section-title" >PAYMENT METHOD</h4>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="basic-input">Payment Method Name</label>
                        <input type="hidden" class="form-control text-right" value="{{$method->payment_method_id}}" name="payment_method_id">
                        <input type="text" class="form-control text-right" placeholder="Method Name" value="{{$method->payment_name}}" name="payment_name">
                    </div>
                </div>
                <h4 class="section-title" >Payment Type</h4>
                <div class="form-group cashier-settings">
                    <div class="col-md-12" style="padding-bottom: 10px;">
                        <button type="button" id="add_payment" class="btn btn-def-white btn-custom-white pull-right"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                              <tr>
                                <th style="width:20px;"><input type="checkbox"></th>
                                <th>Payment Type Name</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($_type as $type)
                                  <tr class="append">
                                    <td>
                                        <input type="checkbox" {{$type->is_check}} value="{{$type->payment_type_id}}" name="payment_type_id[]">
                                        <input type="hidden" class="form-control text-right" placeholder="Method Name" value="" name="payment_type_name[]">
                                    </td>
                                    <td>{{$type->payment_type_name}}</td>
                                  </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                   
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button class="btn btn-primary btn-custom-primary add-submit-button" type="button"><i class="fa fa-save"></i> Save Item</button>
    </div>
</form>
<script type="text/javascript" src="/assets/member/js/cashier/cashier_settings.js"></script>
