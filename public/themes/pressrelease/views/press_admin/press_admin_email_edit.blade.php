@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="press-container">
              
            <div class="title-container">Email's Press Release</div>
            @foreach($edit as $edits)
            <form method="post">
              {{csrf_field()}}
            <input type="text" name="pr_headline" value="{{$edits->pr_headline}}"><br>
            <textarea name="pr_content">{!!$edits->pr_content!!}</textarea><br>
            <textarea name="pr_boiler_content">{!!$edits->pr_boiler_content!!}</textarea>
            <button type="submit" name="save" value="save" formaction="/pressadmin/email_save"><a>Save as draft</a></button>
            </form>
            @endforeach

            
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_pressrelease.css">
@endsection

@section("script")

@endsection