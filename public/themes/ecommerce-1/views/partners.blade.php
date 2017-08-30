@extends("layout")
@section("content")
<div class="container-white-1">
  <div class="container">
    <div id="selection">
        <label>Select By Location</label><br>
        <select class="selecting" id="locationDropdown" >
          <option value="ALL">ALL LOCATION</option>
          @foreach($locationList as $locationListItem)
          <option value="{{ $locationListItem->company_location }}">{{ $locationListItem->company_location }}</option>
          @endforeach
        </select>
      </div>
  </div>

  <div class="container">

    <div class="partner-result row-no-padding">

      @foreach($_company_information as $company_information)

        <div class="col-md-3" style="padding: 4px;">

        <div class="partners-div">

          <div class="partner-header">
            <img src="{{ $company_information->company_logo }}" width="100%">
          </div>

          <div class="partner-body">
            <div style="text-align: center; padding: 30px 0px 30px 0px;">{{ $company_information->company_name }}
          </div>
          
          <div id="company-address">
            <div class="col-md-2"><i class="fa fa-map-marker" aria-hidden="true" id="element"></i></div>
            <div class="col-md-10" ><p"> {{ $company_information ->company_address }} asdasdasdasdsadasdas</p></div>
          </div>

          <div>
            <div class="col-md-2"><i class="fa fa-phone" aria-hidden="true" id="element2"></i></div>
            <div class="col-md-10"><p> {{ $company_information ->company_contactnumber }}</p></div>
          </div>

        </div>

      </div>

      </div>

      @endforeach

    </div>

  </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/assets/js/partner-filtering-location.js"></script>
@endsection
@section("css")

<style type="text/css">
#company-address{
  min-height: 75px;
}
  .container-white-1
  {
    background:#ededed;
    width:100%;
  }

  #element
  {
    color: #FF0010;
    text-shadow: 1px 1px 1px #ccc;
    font-size: 2.0em;
  }

  #element2
  {
    color: #4CAF50;
    text-shadow: 1px 1px 1px #ccc;
    font-size: 2.0em;
  }

  .partners-div
  {
    height:420px;
    background:#FFFFFF;
    margin-top: 2px;
  }

  .partner-header
  {
    border: 1px solid #dedede;
  }

  .partner-result
  {
    padding: 50px 0px 500px 0px;
  }

  .selecting
  {
    width:300px;
    height:40px;
    border-radius:5px;
    display:inline-block;
    overflow:hidden;
    border:1px solid #cccccc;
  }

  #selection
  {
    padding: 50px 0px 0px 15px;
  }

</style>
@endsection