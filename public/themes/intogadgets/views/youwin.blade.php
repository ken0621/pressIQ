@section('content')
@extends('layout')
<div class="youwin">
   <div class="youwin-job" style="background-image: url(resources/assets/frontend/img/youwin-header.jpg);">
      <div class="container">
         <div class="containers">
            <div class="text">
               <div class="description">YOUWIN DEVICES AUTHORIZED SERVICE </div>
               <div class="description1">CLICK BELOW TO SEE HOW WE CAN BEST SERVE YOU.</div>
            </div>
         </div>
      </div>
   </div>
   <div class="service">
      <div class="holder">
         <a href="/contact" target="_blank">
         <img src="resources/assets/frontend/img/location.jpg">
         </a>
      </div>
      <div class="holder">
         <a href="https://docs.google.com/forms/d/e/1FAIpQLSd7G9SWq8BxmCIZIrI5h04ctPtBFt6AVfyUl2AG-rP-S6FysA/viewform" target="_blank">
         <img src="resources/assets/frontend/img/message.jpg">
         </a>
      </div>
      <div class="holder">
         <img src="resources/assets/frontend/img/contact.jpg">
      </div>
   </div>
   <div class="manual">
      <div class="header-manual">
         <div class="line"></div>
         <div class="text">MANUALS</div>
      </div>
      <!-- Place somewhere in the <body> of your page -->
      <div class="manualdownload">
         <div class="text1">DOWNLOAD PDF MANUAL ACCORDING TO DEVICE        
            MODEL
         </div>
         <div class="manual-box">
            <input class="download-box" type="button" value="DOWNLOAD M022 MODEL" onclick="window.location.href='https://drive.google.com/open?id=0B1CyP3NtcWQKRTlkcElvTFg0VDQ'" />
         </div>
         <div class="manual-box">
            <input class="download-box" type="button" value="DOWNLOAD M022T MODEL" onclick="window.location.href='https://drive.google.com/file/d/0B1CyP3NtcWQKd2NzN0d5d2lLb2M/view?usp=sharing'" />
         </div>
         <div class="manual-box">
            <input class="download-box" type="button" value="DOWNLOAD R01 MODEL" onclick="window.location.href='https://drive.google.com/open?id=0B1CyP3NtcWQKU0lIdk9NdldmQzg'" />
         </div>
      </div>
   </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/youwin.css">
@endsection