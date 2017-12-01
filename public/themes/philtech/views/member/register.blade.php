@extends("layout")
@section("content")

<form method="post">
    {{ csrf_field() }}
    <div class="content member-mob-margin">
        <div class="container">
            <input type="hidden" id="_token" value="{{csrf_token()}}">
            <div class="register">
                <table>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <div class="register-header clearfix">
                                    <div class="left">
                                        <div class="title">Create new customer account</div>
                                    </div>
                                    <div class="right">
                                        <div class="or">
                                            <img src="/themes/{{ $shop_theme }}/img/or-2.png">
                                        </div>
                                        <div class="text-right social-button">
                                            <a href="{{$fb_login_url or '#'}}" class="holder fb">
                                                <!--<div class="name"><i class="fa fa-facebook" aria-hidden="true"></i> Sign up with Facebook</div>-->
                                            </a>
                                            <a href="javascript:" class="holder gp" id="customBtn">
                                                <div class="name"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign up with Google+</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="c1">
                                <div class="register-form">
                                    <div class="form-group">
                                        <div class="register-label">GENDER</div>
                                        <div class="form-input gender-input">
                                            <label class="radio-inline"><input checked type="radio" name="gender" value="male">MALE</label>
                                            <label class="radio-inline"><input type="radio" name="gender" value="female">FEMALE</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="register-label">EMAIL</div>
                                        <div class="form-input">
                                            <input required class="form-control input-sm" type="email" name="email" placeholder="Type Your Email Here" value="{{ $dummy['email'] or old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="register-label">CUSTOMER NAME</div>
                                        <div class="form-input">
                                            <input required class="form-control input-sm" type="text" name="first_name" placeholder="First Name" value="{{ $dummy['first_name'] or old('first_name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-input">
                                            <input class="form-control input-sm" type="text" name="middle_name" placeholder="Middle Name" value="{{ $dummy['middle_name'] or old('middle_name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-input">
                                            <input requred class="form-control input-sm" type="text" name="last_name" placeholder="Last Name" value="{{ $dummy['last_name'] or old('last_name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="register-label">BIRTHDAY</div>
                                        <div class="form-input">
                                            <div class="date-holder">
                                                <select name="b_month" class="form-control">
                                                    @for($ctr = 1; $ctr <= 12; $ctr++)
                                                    <option {{ old('b_month') == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ date("F", strtotime($ctr . "/01/17")) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="date-holder">
                                                <select name="b_day" class="form-control">
                                                    @for($ctr = 1; $ctr <= 31; $ctr++)
                                                    <option {{ old('b_day') == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ $ctr }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="date-holder">
                                                <select name="b_year" class="form-control">
                                                    @for($ctr = date("Y"); $ctr >= (date("Y")-100); $ctr--)
                                                    <option {{ old('b_year') == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ $ctr }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="c2">
                                
                                <div class="register-form">
                                    @if(Session::has('error'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>{!! session('error') !!}</li>
                                        </ul>
                                    </div>
                                    @endif
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    
                                    <div class="form-group">
                                        <div class="register-label">CONTACT NUMBER</div>
                                        <div class="form-input">
                                            <input required class="form-control input-sm" type="text" name="contact" value="{{ $dummy['contact'] or old('contact') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="register-label">PASSWORD</div>
                                        <div class="form-input">
                                            <input required class="form-control input-sm" type="password" name="password" value="{{ $dummy['password'] or '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="register-label">REPEAT PASSWORD</div>
                                        <div class="form-input">
                                            <input required class="form-control input-sm" type="password" name="password_confirmation" value="{{ $dummy['password'] or '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix" style="margin-top: 15px;">
                                        <div class="checkbox agreement-checkbox">
                                            <label><input type="checkbox" value="" required> I agree to the <span>Terms of Use and Privacy Policy</span></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="choice">
                                            <div class="holder">
                                                <button class="btn btn-custom">Sign Up</button>
                                            </div>
                                            <div class="holder"><span class="or">OR</span></div>
                                            <div class="holder"><a class="login-href" href="/members/login">Login an Account</a></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>            
    </div>
</form>
<!-- Modal -->
<div class="modal fade modal-agreement" id="modal_agreement" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">Accept Philtech Terms and Conditions</div>
            <div class="modal-body">
                <div class="contract">
                    <div class="reviews">
                        <div class="title">REVIEWS, COMMENTS, EMAILS, AND OTHER CONTENT</div>
                            <div class="para-container">Visitors may post reviews, comments, and other content: and submit suggestions, ideas, comments, questions, or other information, so long as the content is not illegal, obscene, threatening, defamatory, invasive of privacy, infringing of intellectual property rights, or otherwise injurious to third parties or objectionable and does not consist of or contain software viruses, political campaigning, commercial solicitation, chain letters, mass mailings, or any form of "spam." You may not use a false e-mail address, impersonate any person or entity, or otherwise mislead as to the origin of a card or other content. PhilTECH reserves the right (but not the obligation) to remove or edit such content, but does not regularly review posted content. If you do post content or submit material, and unless we indicate otherwise, you grant PhilTECH and its associates a nonexclusive, perpetual, irrevocable, and fully sublicensable right to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, and display such content throughout the world in any media. You grant PhilTECH and its associates and sublicensees the right to use the name that you submit in connection with such content, if they choose. You represent and warrant that you own or otherwise control all of the rights to the content that you post: that the content is accurate: that use of the content you supply does not violate this policy and will not cause injury to any person or entity: and that you will indemnify PhilTECH or its associates for all claims resulting from content you supply. PhilTECH has the right but not the obligation to monitor and edit or remove any activity or content. PhilTECH takes no responsibility and assumes no liability for any content posted by you or any third party.
                        </div>
                    </div>
                    <div class="risk">
                        <div class="title">RISK OF LOSS</div>
                            <div class="para-container">All items purchased from PhilTECH are made pursuant to a shipment contract. This basically means that the risk of loss and title for such items pass to you upon our delivery to the carrier.
                        </div>
                    </div>
                    <div class="product-desc">
                        <div class="title">PRODUCT DESCRIPTIONS</div>
                        <div class="para-container">PhilTECH and its associates attempt to be as accurate as possible. However, PhilTECH does not warrant that product descriptions or other content of this site is accurate, complete, reliable, current, or error-free. If a product offered by PhilTECH itself is not as described, your sole remedy is to return it in unused condition.</div>
                    </div>
                    <div class="condition">
                        <div class="title">CONDITIONS OF USE</div>
                        <div class="para-container">Welcome to our online store! PhilTECH and its associates provide their services to you subject to the following conditions. If you visit or shop within our website, you are bound to accept our terms and conditions. Please read them carefully.</div>
                    </div>
                    <div class="privacy">
                        <div class="title">PRIVACY</div>
                        <div class="para-container">Please review our Privacy Notice, which also governs your visit to our website, to understand our practices.</div>
                    </div>
                    <div class="electonics">
                        <div class="title">ELECTRONIC COMMUNICATIONS</div>
                        <div class="para-container">When you visit PhilTECH or send e-mails to us, you are communicating with us electronically. You consent to receive communications from us electronically. We will communicate with you by e-mail or by posting notices on this site. You agree that all agreements, notices, disclosures and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.</div>
                    </div>
                    <div class="copyright">
                        <div class="title">COPYRIGHT</div>
                        <div class="para-container">All content included on this site, such as text, graphics, logos, button icons, images, audio clips, digital downloads, data compilations, and software, is the property of PhilTECH or its content suppliers and protected by international copyright laws. The compilation of all content on this site is the exclusive property of PhilTECH, with copyright authorship for this collection by PhilTECH, and protected by international copyright laws.</div>
                    </div>
                    <div class="trade">
                        <div class="title">TRADE MARKS</div>
                        <div class="para-container">PhilTECH's trademarks may not be used in connection with any product or service that is not PhilTECHs, in any manner that is likely to cause confusion among customers, or in any manner that disparages or discredits PhilTECH. All other trademarks not owned by PhilTECH or its subsidiaries that appear on this site are the property of their respective owners, who may or may not be affiliated with, connected to, or sponsored by PhilTECH or its subsidiaries.</div>
                    </div>
                    <div class="license">
                        <div class="title">LICENSE AND SITE ACCESS</div>
                        <div class="para-container">PhilTECH grants you a limited license to access and make personal use of this site and not to download (other than page caching) or modify it, or any portion of it, except with express written consent of PhilTECH. This license does not include any resale or commercial use of this site or its contents: any collection and use of any product listings, descriptions, or prices: any derivative use of this site or its contents: any downloading or copying of account information for the benefit of another merchant: or any use of data mining, robots, or similar data gathering and extraction tools. This site or any portion of this site may not be reproduced, duplicated, copied, sold, resold, visited, or otherwise exploited for any commercial purpose without express written consent of PhilTECH. You may not frame or utilize framing techniques to enclose any trademark, logo, or other proprietary information (including images, text, page layout, or form) of PhilTECH and our associates without express written consent. You may not use any meta tags or any other "hidden text" utilizing PhilTECHs name or trademarks without the express written consent of PhilTECH. Any unauthorized use terminates the permission or license granted by PhilTECH. You are granted a limited, revocable, and nonexclusive right to create a hyperlink to the home page of PhilTECH so long as the link does not portray PhilTECH, its associates, or their products or services in a false, misleading, derogatory, or otherwise offensive matter. You may not use any PhilTECH logo or other proprietary graphic or trademark as part of the link without express written permission.th, connected to, or sponsored by PhilTECH or its subsidiaries.</div>
                    </div>
                    <div class="membership">
                        <div class="title">YOUR MEMBERSHIP ACCOUNT</div>
                        <div class="para-container">If you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibility for all activities that occur under your account or password. If you are under 18, you may use our website only with involvement of a parent or guardian. PhilTECH and its associates reserve the right to refuse service, terminate accounts, remove or edit content, or cancel orders in their sole discretion.</div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-pure pull-right" data-dismiss="modal">Accept</button>
                <button type="submit" class="btn btn-semi pull-right" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section("js")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/member_register.js"></script>
<script type="text/javascript" src="/assets/member/js/google_script/google_script_auth.js"></script>
<script>startApp();</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_register.css">
@endsection