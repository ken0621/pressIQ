
     <tr>
         <th style="width: 20%;">Contact Name</th>
         <th style="width: 20%;">Company</th>
         <th style="width: 20%;">Country</th>
         <th style="width: 20%;">Action</th>
     </tr>
      @foreach($_media_contacts as $_media)
        <tr>
           <td>{{$_media->name}}</td>
           <td>{{$_media->company_name}}</td>
           <td>{{$_media->country}}</td>
           <td>
             <a href="/pressadmin/pressreleases_edit_recipient/{{$_media->recipient_id}}"><button type="button"  class="btn btn-warning center">
             <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>
             
             <a href="/pressadmin/pressreleases_deleterecipient/{{$_media->recipient_id}}"><button type="button"  class="btn btn-danger center">
             <i class="fa fa-trash" name="recipient_id" aria-hidden="true"></i>Delete</button>
           </td>
        </tr>
        @endforeach

 