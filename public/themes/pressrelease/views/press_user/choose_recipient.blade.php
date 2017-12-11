<div class="popup-choose">
   <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <div class="title-container">RECIPIENT</div>
      </div>
      <div class="modal-body">
         <div class="row clearfix">
            <div class="col-md-3">
               <div class="title-container">Choose Country</div>
               <form method="post" >
                  <select type="text" class="col-md-12 " id="choose_country" name="choose_country">
                     <option value="">--Select Country--</option>
                     @foreach($country as $country_name)
                     <option value="{{$country_name->country}}">{{$country_name->country}}</option>
                     @endforeach
                  </select>
                  <br>
               </form>
            </div>
            <div class="col-md-9">
               <div class="left-container" id="country_table" name="country_table">
                  <table  class="display table table-bordered" style="background-color: #FFFFFF;width: 100%; cellspacing: 0;">
                     <thead>
                        <tr>
                           <th style="text-align: center;">RECIPIENT</th>
                           <th style="text-align: center;">ACTION</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($add_recipient as $addrecipients)
                        <tr>
                           <td style="text-align: center;">{{$addrecipients->name}}</td>
                           <td style="text-align: center;">  
                              <button  type="button" id="choose_recipient" class="btn btn-success" data-name="{{$addrecipients->name}}" data-name1="{{$addrecipients->research_email_address}}">Choose</button>
                              <a href="/pressadmin/pressreleases_deleterecipient/{{$addrecipients->recipient_id}}" style="background-color: transparent; color: transparent;" ><button type="button" class="btn btn-danger center" id="delete_recipients" name="delete_recipients"> Delete</button>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {!! $add_recipient->render() !!}    
               </div>
            </div>
         </div>
      </div>
   </div>
</div>