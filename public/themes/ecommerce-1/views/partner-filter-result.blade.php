


  @foreach($partnerResult as $partnerResultItem)

        <div class="col-md-3" style="padding: 4px;">

        <div class="partners-div">

          <div class="partner-header">
            <img src="{{ $partnerResultItem->company_logo }}" width="100%">
          </div>

          <div class="partner-body">
            <div style="text-align: center; padding: 30px 0px 30px 0px;">{{ $partnerResultItem->company_name }}
          </div>
          
          <div id="company-address">
            <div class="col-md-2"><i class="fa fa-map-marker" aria-hidden="true" id="element"></i></div>
            <div class="col-md-10" ><p"> {{ $partnerResultItem ->company_address }} </p></div>
          </div>

          <div>
            <div class="col-md-2"><i class="fa fa-phone" aria-hidden="true" id="element2"></i></div>
            <div class="col-md-10"><p> {{ $partnerResultItem ->company_contactnumber }}</p></div>
          </div>

        </div>

      </div>

      </div>

      @endforeach