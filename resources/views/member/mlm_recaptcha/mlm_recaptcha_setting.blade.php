<form class="global-submit form-horizontal" role="form" action="/member/mlm/recaptcha/recaptcha_setting" method="post">
    {{csrf_field()}}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">{{$page}}</h4>
    </div>
    <div class="modal-body clearfix">
        <div class="form-group">
            <div class="col-md-12">
                {{-- <label for="basic-input">Acquired points per submit</label> --}}
                <input autocomplete="off" id="basic-input" type="text" value="{{$point}}" class="form-control" name="point" placeholder="Acquired points per submit">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary" type="submit">Set</button>
    </div>
</form>
<script type="text/javascript">
    function success(data)
    {
        toastr.success('success');
        data.element.modal('hide');
    }
    function error(data)
    {
        toastr.error('Error updating setting');
    }
</script>