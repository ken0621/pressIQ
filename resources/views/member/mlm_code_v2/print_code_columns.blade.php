<form action="/member/mlm/print_codes/submit" method="get">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h4 class="modal-title">Columns</h4>
    </div>
    <div class="modal-body clearfix">
    	<div class="row">
            <input type="hidden" name="type" value="{{$type}}">
            <div class="clearfix modal-body"> 
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-12">
                            @foreach($columns as $col)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="{{$col['code']}}">
                                        {{$col['name']}} 
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary assemble-code-submit" type="submit">Print</button>
    </div>
</form>