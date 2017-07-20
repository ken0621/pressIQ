<form id="bank-form" class="global-submit" method="POST" action="/member/mlm/slot/transfer_post">
    {!! csrf_field() !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title layout-modallarge-title">Login History</h4>
    </div>
    <div class="modal-body max-450 modallarge-body-layout background-white">
        @if(isset($history_login))
            @if($history_login)
                <table class="table table-bordered">
                    
                    <thead>
                        <th>Login</th>
                        <th>Logout</th>
                        <th>Last Activity</th>
                        <th>Ip Address</th>
                        <th>Browser</th>
                        <th>Platform</th>
                        <th>Message</th>
                    </thead>
                    
                    @foreach($history_login as $key => $value)
                    <tr>
                        <td>{{$value->customer_login_history_login}}</td>
                        <td>{{$value->customer_login_history_logout}}</td>
                        <td>{{$value->customer_login_history_last_activity}}</td>
                        <td>{{$value->ip_address}}</td>
                        <td>{{$value->ip_browser}}</td>
                        <td>{{$value->ip_device}}</td>
                        <td>{{$value->status_message}}</td>
                    </tr>
                    
                    @endforeach
                </table>
            @else
            
            @endif
        @else
        
        @endif
        
        
        @if(isset($failed_history_username))
            @if($failed_history_username)
                <center>Failed Login Attempt</center>
                <table class="table table-bordered">
                    
                    <thead>
                        <th>Login</th>
                        <th>Username Used</th>
                        <th>Ip Address</th>
                        <th>Browser</th>
                        <th>Platform</th>
                        <th>Message</th>
                    </thead>
                    
                    @foreach($failed_history_username as $key => $value)
                    <tr>
                        <td>{{$value->customer_login_history_login}}</td>
                        <td>{{$value->customer_username}}</td>
                        <td>{{$value->ip_address}}</td>
                        <td>{{$value->ip_browser}}</td>
                        <td>{{$value->ip_device}}</td>
                        <td>{{$value->status_message}}</td>
                    </tr>
                    
                    @endforeach
                    @foreach($failed_history_email as $key => $value)
                    <tr>
                        <td>{{$value->customer_login_history_login}}</td>
                        <td>{{$value->customer_username}}</td>
                        <td>{{$value->ip_address}}</td>
                        <td>{{$value->ip_browser}}</td>
                        <td>{{$value->ip_device}}</td>
                        <td>{{$value->status_message}}</td>
                    </tr>
                    
                    @endforeach
                </table>
            @else
            
            @endif
        @else
        
        @endif
    </div>
    <div class="modal-footer">
        <div class="error-modal text-center"></div>
        <button type="button" class="btn btn-custom-white " data-dismiss="modal">Cancel</button>
    </div>
</form>