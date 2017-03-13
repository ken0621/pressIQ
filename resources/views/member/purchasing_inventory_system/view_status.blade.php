
<style type="text/css">
    .chosen-container
    {
        width: 100% !important;
    }
</style>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title item_title">STATUS</h4>
</div>
<div class="modal-body modallarge-body-layout background-white form-horizontal menu_container" >
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">            
                <h3>SIR NO : {{sprintf("%'.05d\n", $sir->sir_id)}}</h3>
            </div>
            <div class="col-md-6">
                <h3>Plate Number: {{$sir->plate_number}}</h3>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                1. New Load Out Form 
            </div>
            <div class="col-md-12">
                2. Confirmation of Load Out form by Sales Agent 
            </div>
            <div class="col-md-12">
                3. Convert LoadOutForm to SIR (Click here to convert to SIR)
            </div>
            <div class="col-md-12">
                4. Currently Synced (Waiting for Truck and Agent to Return)
            </div>
            <div class="col-md-12">
                5. Sales Agent Submit all transaction (Open I.L.R will be generated)
            </div>
            <div class="col-md-12">
                6. Warehose Supervisor Update Inventory and Closed the I.L.R (Click here to close the I.L.R)
            </div>
            <div class="col-md-12">
                7. Accounting Department Confirmed Payment Remit by Agent
            </div>
       <!--  <div class="col-md-12"><h3>Select Item</h3></div>        
            <div class="col-md-3" >
                <select class="form-control">
                    <option>All Items</option>
                </select>
            </div>
            <div class="col-md-9" > 
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="search" name="" class="form-control" placeholder="Start typing item">
                </div>
            </div>
        </div> -->    
    </div>
</div>

<div class="modal-footer" >
    <button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
</div>