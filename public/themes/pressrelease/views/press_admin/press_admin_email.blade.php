@extends("press_admin.admin")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="press-container">
            <div class="title-container">Email's Press Release</div>

            <table>
                <tr>
                    <th>Email From</th>
                    <th>Header</th>
                    <th>Content</th>
                    <th>Boilerplate</th>
                    <th>Action</th>
                    @foreach($_email as $email)
                    <tr>
                        <td style="text-align: center;">{{$email->pr_from}}</td>
                        <td style="text-align: center;">{{$email->pr_headline}}</td>
                        <td style="text-align: center;">{!!$email->pr_content!!}</td>
                         <td style="text-align: center;">{!!$email->pr_boiler_content!!}</td>
                        <td  style="text-align: center;align-items: row">
                            <a href=""><button type="button"  class="btn btn-warning center">
                            <i class="fa fa-wrench" name="" aria-hidden="true"></i>Edit</button>
                            <a href=""><button type="button"  class="btn btn-danger center">
                            <i class="fa fa-trash" name="" aria-hidden="true"></i>Delete</button>
                        </td>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_pressrelease.css">
@endsection

@section("script")

@endsection