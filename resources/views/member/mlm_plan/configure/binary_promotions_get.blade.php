<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
           <div class="table-responsive">
           <table class="table table-condensed">
                <tr><th colspan="6"><center>Binary Promotions</center></th></tr>
               
               @foreach($binary_promotions as $key => $value)
               <tr>
                  <td colspan="6">
                    <form class="global-submit" action="/member/mlm/plan/binary_promotions/save" method="post"> 
                    {!! csrf_field() !!}
                      <div class="col-md-2">
                          <label>Membership</label>
                          <select class="form-control" name="binary_promotions_membership_id">
                              @foreach($membership as $key => $value)
                                <option value="{{$value->membership_id}}" @if($value->binary_promotions_membership_id == $key) selected @endif >{{$value->membership_name}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-3">
                            <label>Item</label>
                            <select class="drop-down-item" name="item_id" name="binary_promotions_item_id">
                                @include("member.load_ajax_data.load_item_category", ['add_search' => $value->binary_promotions_item_id])
                            </select>
                      </div>
                      <div class="col-md-2">
                          <label>Required Left</label>
                          <input type="number" class="form-control" value="{{$value->binary_promotions_required_left}}" name="binary_promotions_required_left">
                      </div>
                      <div class="col-md-2">
                          <label>Required Right</label>
                          <input type="number" class="form-control" value="{{$value->binary_promotions_required_right}}" name="binary_promotions_required_right">
                      </div>
                      <div class="col-md-2">
                          <label>No. Of Units</label>
                          <input type="number" class="form-control" value="{{$value->binary_promotions_no_of_units}}" name="binary_promotions_no_of_units">
                      </div>
                      <div class="col-md-1">
                        <label>Submit</label><br>
                        <button class="btn btn-primary">Save</button>
                      </div>
                      <div class="col-md-12">
                          
                      </div>
                      </form>
                  </td> 
               </tr>
               @endforeach
               <tr>
                  <td colspan="6">
                    <form class="global-submit" action="/member/mlm/plan/binary_promotions/save" method="post"> 
                    {!! csrf_field() !!}
                      <div class="col-md-2">
                          <label>Membership</label>
                          <select class="form-control" name="binary_promotions_membership_id">
                              @foreach($membership as $key => $value)
                                <option value="{{$value->membership_id}}">{{$value->membership_name}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-3">
                            <label>Item</label>
                            <select class="drop-down-item" name="item_id" name="binary_promotions_item_id">
                                @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                            </select>
                      </div>
                      <div class="col-md-2">
                          <label>Required Left</label>
                          <input type="number" class="form-control" value="0" name="binary_promotions_required_left">
                      </div>
                      <div class="col-md-2">
                          <label>Required Right</label>
                          <input type="number" class="form-control" value="0" name="binary_promotions_required_right">
                      </div>
                      <div class="col-md-2">
                          <label>No. Of Units</label>
                          <input type="number" class="form-control" value="0" name="binary_promotions_no_of_units">
                      </div>
                      <div class="col-md-1">
                        <label>Submit</label><br>
                        <button class="btn btn-primary">Save</button>
                      </div>
                      <div class="col-md-12">
                          
                      </div>
                      </form>
                  </td> 
               </tr>
           </table>
           </div>
        </div>
    </div>
</div>