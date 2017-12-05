@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
            <!-- Dashboard -->
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">RECENT RELEASES</div>
                </div>
                <div class="col-md-6">
                    <div class="button-container">
                        <span class="create-button pull-right" ><a href="/pressuser/pressrelease">Create a Press Release</a>
                      
                    </div>
                </div>
            </div>
            <table>
                <tr>
                    <th>Press Release Title</th>
                    <th>Publish Date</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Sample 1</td>
                    <td>15/11/2017</td>
                    <td>Draft</td>
                </tr>
                <tr>
                    <td>Sample 2</td>
                    <td>15/11/2017</td>
                    <td>Draft</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_dashboard.css">
@endsection

@section("script")

@endsection