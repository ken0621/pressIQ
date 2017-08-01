<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title"><b>MAKE ADJUSTMENT</b> &raquo; {{ $employee_info->payroll_employee_first_name }} {{ $employee_info->payroll_employee_last_name }} (Employee No. {{ $employee_info->payroll_employee_number == "" ? "00" : $employee_info->payroll_employee_number }})</h4>
    <div>{{ $show_period_start }} to {{ $show_period_end }}</div>
</div>
<form method="post" class="submit-adjustment global-submit" action="/member/payroll/company_timesheet2/make_adjustment/{{ $period_id }}/{{ $employee_id }}">
    <div class="modal-body clearfix make-adjustment-modal form-horizontal">
        {{ csrf_field() }}
        <input type="hidden" class="period-id" value="{{ $period_id }}" />
        <input type="hidden" class="x-employee-id" value="{{ $employee_id }}" />
        <div class="form-group">
            <div class="col-md-12">
                <small>Description</small>
                <input type="text" class="form-control" name="adjustment_name" required placeholder="Bonus, Comission, Retro, etc...">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <small>Adjustment Type</small>
                <select class="form-control adjustment-type" required name="adjustment_type">
                    <option value="addition">Addition</option>
                    <option value="deduction">Deduction</option>
                </select>
            </div>
            <div class="col-md-6">
                <small>Amount</small>
                <input type="text" class="form-control" required name="adjustment_amount" placeholder="0.00">
            </div>
        </div>
        
        <div class="form-group addition-setting">
            <div class="col-md-12">
                <small>Addition Settings</small>
                <select name="adjustment_setting" class="form-control adjustment_setting">
                    <option value="non-taxable">Non-Taxable</option>
                    <option value="taxable">Taxable</option>
                    <option value="hidden">Hidden</option>
                </select>
            </div>
        </div>
        
    </div>

    <div class="modal-footer text-right">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">CLOSE</button>
        <button type="submit" class="btn btn-primary load-summary">APPLY ADJUSTMENT</button>
    </div>
</form>

<script type="text/javascript" src="/assets/member/payroll/js/apply_adjustment.js"></script>