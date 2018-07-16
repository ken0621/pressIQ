
<!-- Change action and function-->
<form class="global-submit" role="form" action="/member/payroll/reports/save_payroll_register_selected_columns" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payroll Register Columns</h4>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" class="period_company_id" name="period_company_id" value="{{$period_company_id}}">
    </div>
    <div class="modal-body form-horizontal">
        <div class="form-group">
         @foreach($columnn as $column)
                 <div class="checkbox">
                  <label><input type="checkbox" name="name" value="1" {{$column->name == 1 ? 'checked' : 'unchecked'}}>Name</label>
                  <input type="hidden" name="columnname[]" value="name">
                </div>

                  <div class="checkbox">
                  <label><input type="checkbox" name="position" value="1" {{$column->position == 1 ? 'checked' : 'unchecked'}}>Position</label>
                  <input type="hidden" name="columnname[]" value="position">
                </div>

                  <div class="checkbox">
                  <label><input type="checkbox" name="taxstatus" value="1" {{$column->taxstatus == 1 ? 'checked' : 'unchecked'}}>Tax Status</label>
                  <input type="hidden" name="columnname[]" value="taxstatus">
                </div>

                  <div class="checkbox">
                  <label><input type="checkbox" name="dailyrate" value="1" {{$column->dailyrate == 1 ? 'checked' : 'unchecked'}}>Daily Rate</label>
                  <input type="hidden" name="columnname[]" value="dailyrate">
                </div>

                  <div class="checkbox">
                  <label><input type="checkbox" name="monthlybasic" value="1" {{$column->monthlybasic == 1 ? 'checked' : 'unchecked'}}>Monthly Basic</label>
                  <input type="hidden" name="columnname[]" value="monthlybasic">
                </div>

                  <div class="checkbox">
                  <label><input type="checkbox" name="semimonthlybasic" value="1" {{$column->semimonthlybasic == 1 ? 'checked' : 'unchecked'}}>Semi Monthly Basic</label>
                  <input type="hidden" name="columnname[]" value="semimonthlybasic">
                </div>

                <div class="checkbox">
                <label><input type="checkbox" name="gross_basic_pay" value="1" {{$column->gross_basic_pay == 1 ? 'checked' : 'unchecked'}}>Gross Basic Pay</label>
                <input type="hidden" name="columnname[]" value="gross_basic_pay">
                </div>

                <div class="checkbox">
                <label><input type="checkbox" name="absent" value="1" {{$column->absent == 1 ? 'checked' : 'unchecked'}}>Absent</label>
                <input type="hidden" name="columnname[]" value="absent">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="late" value="1" {{$column->late == 1 ? 'checked' : 'unchecked'}}>Late</label>
                    <input type="hidden" name="columnname[]" value="late">
                </div>
                <div class="checkbox">
                     <label><input type="checkbox" name="undertime" value="1" {{$column->undertime == 1 ? 'checked' : 'unchecked'}}>Undertime</label>
                     <input type="hidden" name="columnname[]" value="undertime">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="basic_pay" value="1" {{$column->basic_pay == 1 ? 'checked' : 'unchecked'}}>Basic Pay</label>
                    <input type="hidden" name="columnname[]" value="basic_pay">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="rendered_days" value="1" {{$column->rendered_days == 1 ? 'checked' : 'unchecked'}}>Rendered Days</label>
                    <input type="hidden" name="columnname[]" value="rendered_days">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="cola" value="1" {{$column->cola == 1 ? 'checked' : 'unchecked'}}>Cola</label>
                    <input type="hidden" name="columnname[]" value="cola">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="overtime_pay" value="1" {{$column->overtime_pay == 1 ? 'checked' : 'unchecked'}}>Overtime Pay</label>
                <input type="hidden" name="columnname[]" value="overtime_pay">
                </div>
                <div class="checkbox">
                   <label><input type="checkbox" name="night_differential_pay" value="1" {{$column->night_differential_pay == 1 ? 'checked' : 'unchecked'}}>Night Differential Pay</label>
                    <input type="hidden" name="columnname[]" value="night_differential_pay">
                </div>
                <div class="checkbox">
               <label><input type="checkbox" name="regular_holiday_pay" value="1" {{$column->regular_holiday_pay == 1 ? 'checked' : 'unchecked'}}>Regular Holiday Pay</label>
               <input type="hidden" name="columnname[]" value="regular_holiday_pay">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="special_holiday_pay" value="1" {{$column->special_holiday_pay == 1 ? 'checked' : 'unchecked'}}>Special Holiday Pay</label>
                <input type="hidden" name="columnname[]" value="special_holiday_pay">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="restday_pay" value="1" {{$column->restday_pay == 1 ? 'checked' : 'unchecked'}}>Rest Day Pay</label>
                <input type="hidden" name="columnname[]" value="restday_pay">
                </div>
                <div class="checkbox">
               <label><input type="checkbox" name="leave_pay" value="1" {{$column->leave_pay == 1 ? 'checked' : 'unchecked'}}>Leave Pay</label>
               <input type="hidden" name="columnname[]" value="leave_pay">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="allowance" value="1" {{$column->allowance == 1 ? 'checked' : 'unchecked'}}>Allowance</label>
                <input type="hidden" name="columnname[]" value="allowance">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="bonus" value="1" {{$column->bonus == 1 ? 'checked' : 'unchecked'}}>Bonus</label>
                <input type="hidden" name="columnname[]" value="bonus">
                </div>
                <div class="checkbox">
                 <label><input type="checkbox" name="commision" value="1" {{$column->commision == 1 ? 'checked' : 'unchecked'}}>Commision</label>
                   <input type="hidden" name="columnname[]" value="commision">
                </div>
                <div class="checkbox">
                       <label><input type="checkbox" name="incentives" value="1" {{$column->incentives == 1 ? 'checked' : 'unchecked'}}>Incentives</label>
                        <input type="hidden" name="columnname[]" value="incentives">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="additions" value="1" {{$column->additions == 1 ? 'checked' : 'unchecked'}}>Additions</label>
                    <input type="hidden" name="columnname[]" value="additions">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="month_13_and_other" value="1" {{$column->month_13_and_other == 1 ? 'checked' : 'unchecked'}}>13 Month and Others</label>
                    <input type="hidden" name="columnname[]" value="month_13_and_other">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="de_minimis_benefit" value="1" {{$column->de_minimis_benefit == 1 ? 'checked' : 'unchecked'}}>De Mimnimis Benefit</label>
                     <input type="hidden" name="columnname[]" value="de_minimis_benefit">
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" name="others" value="1" {{$column->others == 1 ? 'checked' : 'unchecked'}}>Others</label>
                  <input type="hidden" name="columnname[]" value="others">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="gross_pay" value="1" {{$column->gross_pay == 1 ? 'checked' : 'unchecked'}}>Gross Pay</label>
                <input type="hidden" name="columnname[]" value="gross_pay">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="deductions" value="1" {{$column->deductions == 1 ? 'checked' : 'unchecked'}}>Deductions</label>
                <input type="hidden" name="columnname[]" value="deductions">
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" name="cash_bond" value="1" {{$column->cash_bond == 1 ? 'checked' : 'unchecked'}}>Cash Bond</label>
                  <input type="hidden" name="columnname[]" value="cash_bond">
                </div>
                <div class="checkbox">
                <label><input type="checkbox" name="cash_advance" value="1" {{$column->cash_advance == 1 ? 'checked' : 'unchecked'}}>Cash Advance</label>
                 <input type="hidden" name="columnname[]" value="cash_advance">
                </div>
                <div class="checkbox">
                        <label><input type="checkbox" name="other_loan" value="1" {{$column->other_loan == 1 ? 'checked' : 'unchecked'}}>Other Loan</label>
                        <input type="hidden" name="columnname[]" value="other_loan">
                </div>
                <div class="checkbox">
                     <label><input type="checkbox" name="sss_loan" value="1" {{$column->sss_loan == 1 ? 'checked' : 'unchecked'}}>SSS Loan</label>     
                      <input type="hidden" name="columnname[]" value="sss_loan">          
                </div>
                <div class="checkbox">
                     <label><input type="checkbox" name="sss_ee" value="1" {{$column->sss_ee == 1 ? 'checked' : 'unchecked'}}>SSS EE</label> 
                        <input type="hidden" name="columnname[]" value="sss_ee">  
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="hdmf_loan" value="1" {{$column->hdmf_loan == 1 ? 'checked' : 'unchecked'}}>HDMF Loan</label> 
                    <input type="hidden" name="columnname[]" value="hdmf_loan"> 
                </div>
                <div class="checkbox">
                      <label><input type="checkbox" name="hdmf_ee" value="1" {{$column->hdmf_ee == 1 ? 'checked' : 'unchecked'}}>HDMF EE</label> 
                      <input type="hidden" name="columnname[]" value="hdmf_ee"> 
                </div>
                <div class="checkbox">
                        <label><input type="checkbox" name="phic_ee" value="1" {{$column->phic_ee == 1 ? 'checked' : 'unchecked'}}>PHIC EE</label> 
                          <input type="hidden" name="columnname[]" value="phic_ee">
                </div>
                <div class="checkbox">
                          <label><input type="checkbox" name="with_holding_tax" value="1" {{$column->with_holding_tax == 1 ? 'checked' : 'unchecked'}}>With Holding Tax</label> 
                                 <input type="hidden" name="columnname[]" value="with_holding_tax">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="total_deduction" value="1" {{$column->total_deduction == 1 ? 'checked' : 'unchecked'}}>Total Deduction</label> 
                      <input type="hidden" name="columnname[]" value="total_deduction">
                </div>
                <div class="checkbox">
                      <label><input type="checkbox" name="take_home_pay" value="1" {{$column->take_home_pay == 1 ? 'checked' : 'unchecked'}}>Take Home Pay</label> 
                      <input type="hidden" name="columnname[]" value="take_home_pay">
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" name="sss_er" value="1" {{$column->sss_er == 1 ? 'checked' : 'unchecked'}}>SSS ER</label>
                      <input type="hidden" name="columnname[]" value="sss_er"> 
                </div>
                <div class="checkbox">
                      <label><input type="checkbox" name="sss_ec" value="1" {{$column->sss_ec == 1 ? 'checked' : 'unchecked'}}>SSS EC</label>
                       <input type="hidden" name="columnname[]" value="sss_ec">  
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="hdmf_er" value="1" {{$column->hdmf_er == 1 ? 'checked' : 'unchecked'}}>HDMF ER</label> 
                    <input type="hidden" name="columnname[]" value="hdmf_er"> 
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="phic_er" value="1" {{$column->phic_er == 1 ? 'checked' : 'unchecked'}}>PHIC ER</label> 
                    <input type="hidden" name="columnname[]" value="phic_er"> 
                </div>
        @endforeach
        </div>
    </div>  

    <div class="modal-footer">
        <button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-custom-primary btn-submit" type="submit">Save</button>
    </div>
</form>
<script>
         function reload(data)
        {
            data.element.modal("hide");
            location.reload();
        }
</script>
{{-- <script type="text/javascript" src="/assets/js/ajax_offline.js"></script> --}}

