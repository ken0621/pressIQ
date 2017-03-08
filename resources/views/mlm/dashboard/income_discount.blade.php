<ul class="list-group">  
    <li class="list-group-item form-horizontal">
        <h4>              
            Account Information
        </h4> 
        <div class="form-group">
            <label for="first-name" class="col-md-2 control-label">Account Username</label>
            <div class="col-md-10">
                <input id="first-name" class="form-control" value="{{$customer_info->mlm_username}}" disabled="disabled">
            </div>
        </div>
        <div class="form-group">
            <label for="first-name" class="col-md-2 control-label">Membership</label>
            <div class="col-md-10">
                <input id="first-name" class="form-control" value="@if($discount_card_log != null) Discount Card Holder @endif" disabled="disabled">
            
            </div>
        </div>
        <div class="form-group hide">
            <label for="first-name" class="col-md-2 control-label">Account Wallet</label>
            <div class="col-md-10">
                <input id="first-name" class="form-control" value="" disabled="disabled">
            </div>
        </div>  
    </li>
</ul>