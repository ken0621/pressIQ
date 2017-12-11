<div class="popup-choose">
   <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <div class="title-container">Found Result</div>
      </div>
      <div class="modal-body">
            <div class="row pull-right" style="padding:10px 10px 10px 10px;">
               <button  type="button" id="choose_recipient" class="btn btn-success" >Select All Found</button>
               <button  type="button" id="choose_recipient" class="btn btn-success" >Unselect All Found</button>
            </div>
         <div class="row clearfix">
            <!-- <div class="col-md-3">
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
            </div> -->
            <div class="" style="padding:10px 10px 10px 10px;">
               <input type="text" name=""></input>
               <button  type="button" id="choose_recipient" class="btn btn-success" >Search</button>
            </div>
            <div class="col-md-12">

               <div class="left-container" id="country_table" name="country_table">
                  <table  class="display table table-bordered" style="background-color: #FFFFFF;width: 100%; cellspacing: 0;">
                     <thead>
                        <tr>
                           <th style="text-align: center;">ACTION</th>
                           <th style="text-align: center;">COMPANY</th>
                           <th style="text-align: center;">RECIPIENT</th>
                           <th style="text-align: center;">POSITION</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($add_recipient as $addrecipients)
                        <tr>
                           <td style="text-align: center;">  
                              <button  type="checkbox" id="choose_recipient" class="btn btn-success" data-name="{{$addrecipients->name}}" data-name1="{{$addrecipients->research_email_address}}">Choose</button>
                           </td>
                           <td style="text-align: center;">{{$addrecipients->name}}</td>
                           <td style="text-align: center;">{{$addrecipients->company_name}}</td>
                           <td style="text-align: center;">{{$addrecipients->position}}</td>
                           
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