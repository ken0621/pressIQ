@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
    <div class="main-wrapper">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">About Press IQ</div>
                    <div class="about-container">
                        <span class="desc-black"></span><span class="desc-black">An intelligent results-driven platform for</span><span class="desc-black"> PR Professionals</span><span class="desc-black"> and</span><span class="desc-black"> Marketers</span><span class="desc-black"> for targeted distribution of your press release. We provide you with access to the most updated and extensive database of media journalist</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/about-image.jpg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper-1">
        <div class="container">
            <div class="title-container">Create great Press Releases</div>
            <div class="subtitle-container">Distribute your content to the right people in the right place.</div>
            <div class="border-container"></div>
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="image-holder"><img src="/themes/{{ $shop_theme }}/img/wrapper1-image.png"></div>
                </div>
                <div class="col-md-6">
                    <div class="caption-container">
                        <span class="caption-black">Distribute your News using</span><span class="caption-red"> Our Intelligent</span><span class="caption-black"> and most updated media database</span>
                    </div>
                    <div class="details-container">
                        <span class="details-blue">Contacts of media journalist and editors</span><span class="details-black"> across all regions including Asia, North America, Europe and the Middle East</span>
                    </div>
                    <div class="details-container">
                        <span class="details-blue">Easy to use</span><span class="details-black"> media release builder with ability to add rich media images or videos to your press release</span>
                    </div>
                    <div class="details-container">
                        <span class="details-blue">Media monitoring</span><span class="details-black"> receive a full report of coverage after your distribution campaign</span>
                    </div>
                    <div class="details-container">
                        <span class="details-blue">Real-time</span><span class="details-black"> reporting and measurable data</span>
                    </div>
                    <div class="details-container">
                        <span class="details-blue">Advanced segmentation</span><span class="details-black"> by Audience, media, demographic, and Category</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="requestdemo" class="wrapper-2" style="background-image: url('/themes/{{ $shop_theme }}/img/wrapper2-image.jpg')">
        <div class="container">
                @if (session('Demo_message'))
                    <div class="alert alert-success">
                        {{ session('Demo_message') }}
                    </div>
                 @endif
            <div class="title-container">
                <span class="title">Request a free demo of Press IQ!</span><span class="icon"><img src="/themes/{{ $shop_theme }}/img/wrapper-2-icon.png"></span>
            </div>
            <form action="Post"> 
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Name: *</div>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Company: *</div>
                        <input type="text" class="form-control" id="company" name="company" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Email: *</div>
                        <input type="Email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="title">Phone Number: *</div>
                        <input type="text" class="form-control" id="number" name="number" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="title">Message: *</div>
                        <textarea type="text" class="form-control text-message" id="message" name="message"></textarea>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" formaction="/demo/send">SEND</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113245030-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113245030-1');
</script>

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/about.css">
@endsection
