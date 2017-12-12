<style >
.table 
{
   width: 100%;
   display:block;
   height: 400px;
   overflow-y: scroll;
}

</style>

<div class="popup-choose">
   <!-- Modal content-->
   <div class="modal-content" id="recipient-modal" name="recipient-modal">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <div class="title-container">Found Result</div>
      </div>
      <div class="modal-body">
            <div class="row pull-right" style="padding:10px 10px 10px 10px;">
               <button  type="button" id="select_all" name="select_all" class="btn btn-success" >Select All Found</button>
               <button  type="button" id="unselect_all" name="unselect_all" class="btn btn-success" >Unselect All Found</button>
            </div>
         <div class="row clearfix">
            <div class="" style="padding:10px 10px 10px 10px;">
               <input type="text"  name="search_key" id="search_key">
               <button  type="button" name="search_button" id="search_button" class="btn btn-success" >Search</button>
            </div>
            <div class="col-md-12">

               <form class="" action="/pressuser/pressrelease/recipient/done" method="POST" style="">
               <div class="left-container" id="recipient_table" name="recipient_table">
                  <table  class="display table table-bordered" style="background-color: #FFFFFF;" id="showHere_table">
                     <thead>
                        <tr>
                           <th style="text-align: center;width: 5%;">ACTION</th>
                           <th style="text-align: center;width: 25%;">COMPANY</th>
                           <th style="text-align: center;width: 25%;">RECIPIENT</th>
                           <th style="text-align: center;width: 25%;">POSITION</th>   
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($_recipient as $recipients)
                        <tr>
                           <input type="hidden" id="recipient_id" name="recipient_id" value="{{$recipients->recipient_id}}">
                           <td style="text-align: center;"><input type="checkbox" name="checkbox" value="{{$recipients->recipient_id}}" ></td>
                           <td style="text-align: center;">{{$recipients->company_name}}</td>
                           <td style="text-align: center;">{{$recipients->name}}</td>
                           <td style="text-align: center;">{{$recipients->position}}</td>
                           
                        </tr>
                        @endforeach
                     </tbody>
                     
                  </table>
               </div>
               <div class="row pull-right" style="padding:10px 10px 10px 10px;">
                  <button type="button" id="recipient_submit" name="recipient_submit" class="btn btn-success">Done</button>
               </div> 
               </form>  
            </div>
         </div>
      </div>
   </div>
</div>
<script  src="/assets/js/choose_recipient_release.js"></script>
