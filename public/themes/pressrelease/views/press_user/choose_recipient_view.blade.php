
<input  type="hidden" id="view_value" name="view_value" value="{{session('user_membership')}}">

<div class="table table-bordered" style="overflow-y: scroll;position:relative;height: 500px;">
   <table  class="table table-bordered">
      <tr>
          <th class="hide_name" style="width: 15%;text-align: center;">Journalist Name</th>
          <th style="width: 15%;text-align: center;">Company Name</th>
          <th style="width: 15%;text-align: center;">Job Title</th>
          <th style="width: 15%;text-align: center;">Industry Type</th>
          <th style="width: 15%;text-align: center;">Media Type</th>
      </tr>
      @foreach($_recipients as $recipients)
      <tr>
          <td class="hide_name" style="width: 15%;text-align: center;">{{$recipients->name}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->company_name}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->position}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->industry_type}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->media_type}}</td>
      </tr>
       @endforeach
   </table>
</div>

<script type="text/javascript">
  
$(document).ready(function() 
{ 
  var hidden_number = $('#view_value').val();
  var number_one    = '1';
  var number_five   = '5';
  var number_three  = '3';

   if (hidden_number == number_one) 
   {
     $(".hide_name").hide();
   } 
   
   else if (hidden_number == number_five) 
   {
     $(".hide_name").hide();
   } 
   
   else if  (hidden_number == number_three) 
   {
     $(".hide_name").hide();
   } 
   else 
   {
      $(".hide_name").show();
   }  
});
</script>