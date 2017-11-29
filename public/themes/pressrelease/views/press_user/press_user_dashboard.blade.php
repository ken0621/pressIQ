@extends("press_user.member")
@section("pressview")
    
        <!-- Dashboard -->
       <div id="dashboard" class="tab-pane fade">
            <div class="dashboard-container">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="title-container">RECENT RELEASES</div>
                    </div>
                    <div class="col-md-6">
                        <div class="button-container">
                            <span class="create-button"><a href="#">Create a Press Release</a></span><span class="drafts">Drafts: 2</span><span class="releases">Releases: 3</span>
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

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/pressrelease_view.css">
@endsection

@section("script")

@endsection