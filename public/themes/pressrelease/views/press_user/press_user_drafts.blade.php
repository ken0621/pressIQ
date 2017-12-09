@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
         <!-- Drafts -->
        <div class="drafts-holder-container">
            <table>
                <tr>    
                    <th>Press Release Title</th>
                    <th>Recipient</th>
                    <th>Status</th>
                    <th>Send</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <tr>
                    <td>Sample 1</td>
                    <td>Contact 1</td>
                    <td>Draft</td>
                    <td><a href="#">Send</a></td>
                    <td><a href="#">Edit</a></td>
                    <td><a href="#">Delete</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_drafts.css">
@endsection

@section("script")

@endsection