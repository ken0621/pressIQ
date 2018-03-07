
<div class="table table-bordered" style="overflow-y: scroll;position:relative;height: 500px;">
   <table  class="table table-bordered">
      <tr>
          <th style="width: 15%;text-align: center;">Journalist Name</th>
          <th style="width: 15%;text-align: center;">Company Name</th>
          <th style="width: 15%;text-align: center;">Job Title</th>
          <th style="width: 15%;text-align: center;">Industry Type</th>
          <th style="width: 15%;text-align: center;">Media Type</th>
      </tr>
      @foreach($_recipients as $recipients)
      <tr>
          <td style="width: 15%;text-align: center;">{{$recipients->name}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->company_name}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->title_of_journalist}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->industry_type}}</td>
          <td style="width: 15%;text-align: center;">{{$recipients->media_type}}</td>
      </tr>
       @endforeach
   </table>
</div>
