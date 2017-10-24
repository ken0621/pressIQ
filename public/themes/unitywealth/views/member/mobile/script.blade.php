{{-- Modal Sample --}}
<div class="picker-modal picker-modal-demo">
    <div class="toolbar">
        <div class="toolbar-inner">
            <div class="left"></div>
            <div class="right"><a href="#" class="link close-picker">Done</a></div>
        </div>
    </div>
    <div class="picker-modal-inner">
        <div class="content-block">Integer mollis nulla id nibh elementum finibus. Maecenas eget fermentum ipsum. Sed sagittis condimentum nisl at tempus. Duis lacus libero, laoreet vitae ligula a, aliquet eleifend sapien. Nullam sodales viverra sodales.</div>
    </div>
</div>

<!-- Profile Popover -->
<div class="popover popover-profile">
    <div class="popover-angle"></div>
    <div class="popover-inner">
        <div class="profile-ul">
            <ul>
                <li><a href="#" data-popup=".popup-basic-info" class="open-popup">Basic Information</a></li>
                <li><a href="#" data-popup=".popup-reward-config" class="open-popup">Rewards Config</a></li>
                <li><a href="#" data-popup=".popup-profile-picture" class="open-popup">Profile Picture</a></li>
                <li><a href="#" data-popup=".popup-password" class="open-popup">Password</a></li>
            </ul>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/mobile/framework7/dist/js/framework7.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/mobile/framework7/kitchen-sink-material/js/kitchen-sink.js"></script>
<!-- GLOBAL JS -->
<script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/mobile/js/global.js"></script>
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/non_member.js?version=2.1"></script>