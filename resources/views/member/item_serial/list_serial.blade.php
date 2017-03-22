
<style type="text/css">
    .chosen-container
    {
        width: 100% !important;
    }
</style>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title item_title">ITEM SERIAL NUMBER</h4>
</div>
<div class="modal-body modallarge-body-layout background-white form-horizontal menu_container" >
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-12">
                {{$item_name->item_name}}
            </div>
        </div>
        <div class="row clearfix draggable-container">
            <div class="table-responsive">
             <div class="col-md-12">
                    <div class="row clearfix draggable-container ilr-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 30px;"> # </th>
                                            <th style="width: 15px;" class="text-center">Serial Number</th>
                                            <th style="width: 15px;" class="text-center">Sold</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($_item_serial as $serial)
                                        <tr>
                                            <td>{{$serial->serial_id}}</td>
                                            <td class="text-center">{{$serial->serial_number}}</td>
                                            <td class="text-center"><input type="checkbox" name="sold_serial"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>                                   
                                </table>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>    
    </div>
</div>

<div class="modal-footer" >
    <button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
</div>