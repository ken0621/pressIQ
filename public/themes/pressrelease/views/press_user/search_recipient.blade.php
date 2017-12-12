
      <table  class="display table table-bordered" style="background-color: #FFFFFF;width: 100%; cellspacing: 0;">
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
               <input type="hidden" name="recipient_id" value="{{$recipients->recipient_id}}">
               <td style="text-align: center;"><input type="checkbox" name="checkbox" value="{{$recipients->name}}" ></td>
               <td style="text-align: center;">{{$recipients->company_name}}</td>
               <td style="text-align: center;">{{$recipients->name}}</td>
               <td style="text-align: center;">{{$recipients->position}}</td>
               
            </tr>
            @endforeach
         </tbody>   
      </table>
     
