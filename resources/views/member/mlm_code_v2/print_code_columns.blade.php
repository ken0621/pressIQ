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
                                        <input type="checkbox" {{$col['status'] == true ? 'checked' : ''}} name="{{$col['code']}}">
                                        {{$col['name']}} 
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <select name="status" class="form-control">
                                <option value="">Unused</option>
                                <option value="reserved">Reserved</option>
                                <option value="block">Block</option>
                                <option value="used">Used</option>
                            </select>
                        </div>
                    </div>
                    @if($type == 'membership_code')
                    <div class="form-group">
                        <div class="col-md-6">
                            <select name="membership" class="form-control">
                                <option value="">All Membership</option>
                            @foreach($_membership as $membership)
                                <option value="{{ $membership->membership_id }}">{{ $membership->membership_name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="membership_kit" class="form-control">
                                <option value="">All Membership Kit</option>
                            @foreach($_item_kit as $kit)
                                <option value="{{ $kit->item_id }}">{{ $kit->item_name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary assemble-code-submit" type="submit">Print</button>
    </div>
</form>