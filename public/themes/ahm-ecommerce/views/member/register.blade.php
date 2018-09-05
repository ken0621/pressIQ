@extends("layout")
@section("content")

<div id="home" class="register-wrapper" style="background-color: $base-color-dark;">
    <div style="padding: 50px 0;">

        @include("member2.include_register")

        <!-- Modal -->
        <div class="modal fade modal-agreement" id="modal_agreement" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">Accept AHM Ecommerce Contract</div>
                    <div class="modal-body">
                        <div class="contract">
                            <p class="cnt-txt-b">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo, quia animi explicabo nihil neque facilis dicta eum sint labore alias, aperiam ipsum! Ipsam molestias, minima. Blanditiis repellendus reiciendis nemo, dignissimos!
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-pure pull-right" data-dismiss="modal">Accept</button>
                        <button type="submit" class="btn btn-semi pull-right" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section("script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/member_register.js"></script>
{{-- <script type="text/javascript" src="/assets/member/js/google_script/google_script_auth.js"></script> --}}

<script>startApp();</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_register.css">
@endsection
