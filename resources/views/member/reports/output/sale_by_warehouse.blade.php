<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report">
      <div class="panel-heading">
        @include('member.reports.report_header');
          <div class="table-repsonsive">
        <table class="table table-condensed collaptable">
          <thead>
            
            <tr>
            @foreach($report_field as $key => $value)
              <th>{{$value->report_field_label}}</th>
            @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($warehouse_all as $w_key => $w_value)
              <tr data-id="{{$w_key}}" data-parent=""  style="background-color: #dedede;" >
                <td colspan="20">{{$w_value->warehouse_name}}</td>
              </tr>
              <?php $balance = 0; ?>
              @if(isset($filter[$w_key]))
                @foreach($filter[$w_key] as $f_key => $f_value)
                    @if(isset($sales[$f_key]))
                      <?php 
                      $balance += $sales[$f_key]->jline_amount;
                      $sales[$f_key]->balance = currency('PHP', $balance);
                      $sales[$f_key]->jline_amount = currency('PHP', $sales[$f_key]->jline_amount);
                      ?>
                      <tr data-id="a_{{$f_key}}" data-parent="{{$w_key}}">
                        @foreach($report_field as $r_f_key => $r_f_value)
                          <th>{{$sales[$f_key]->$r_f_key}}</th>
                        @endforeach
                      </tr>
                    @endif
                @endforeach
              @else
                <tr>
                  <td colspan="20"><center>No Record on this warehouse</center></td>
                </tr>  
              @endif
            @endforeach
                </tbody>
        </table>
          </div>
          <h5 class="text-center">---- {{$now or ''}} ----</h5>
      </div>
  </div>
</div>