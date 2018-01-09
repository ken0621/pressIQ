<div>
 <div>
  @if(session::has('edit_user'))
   @foreach($_user_edit as $_user_edits)
    <label>UPDATE USER ACCOUNT</label>
      <form method="post" action="">
        {{csrf_field()}}
        <div class="title">First Name:</div>
      <input type="text" id="first_name" name="first_name" class="form-control" value="{{$_user_edits->user_first_name}}">

        <div class="title">Last Name:</div>
        <input type="text"  id="last_name" name="last_name" class="form-control" value="{{$_user_edits->user_last_name}}">

        <div class="title">Email:</div>
        <input type="text" id="email" name="email" class="form-control" value="{{$_user_edits->user_email}}">


        <div class="title">Company Name:</div>
        <input type="text" id="company_name" name="company_name" class="form-control" value="{{$_user_edits->user_company_name}}">


        <div class="button-container">
            <button type="submit" id="submit_button" name="submit_button" formaction="/pressadmin/manage_user_edit">Submit</button>
        </div>
    </form>
   @endforeach
  @endif
 </div>
</div>