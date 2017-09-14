
<div class="modal-body clearfix">
        <div class="filter-result table-responsive ">
            <table class="table table-bordered table-condensed" style=" background-color:0066CC;">
                <thead>
                    <tr>
                    <th class="text-center" colspan="4">TOTAL ee/loan Amount:</th>
                    <th class="text-center" colspan="5">{{ payroll_currency($contri_info["grand_total_pagibig_ee"]) }}</th>
                    </tr>
                     <tr>
                    <th class="text-center" colspan="4">TOTAL er Amount</th>
                    <th class="text-center" colspan="5">{{ payroll_currency($contri_info["grand_total_pagibig_er"]) }}</th>
                    </tr>
                    <tr>
                    <th class="text-center" colspan="4">RECORD Count</th>
                    <th class="text-center" colspan="5">TOTAL ee/loan Amount:</th>
                    </tr>
                    <tr style=" background-color:0066CC;">
                        <th class="text-center">#</th>
                        <th class="text-center">PAG-IBIG NO.</th>
                        <th class="text-center">TIN(Optional)</th>
                        <th class="text-center">LAST NAME</th>
                        <th class="text-center">FIRST NAME</th>
                        <th class="text-center">MIDDLE NAME</th>
                        <th class="text-center">PERIOD COVERED</th>
                        <th class="text-center">EE SHARE</th>
                        <th class="text-center">ER SHARE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contri_info["_employee_contribution"] as $key => $contribution)
                    <tr>
                        <td class="text-center">{{ $contribution->count }}</td>
                        <td class="text-center">{{ $contribution->payroll_employee_pagibig }}</td>
                        <td class="text-center">Not Available</td>
                        <td class="text-center">{{ $contribution->payroll_employee_last_name }}</td>
                        <td class="text-center">{{ $contribution->payroll_employee_first_name }}</td>
                        <td class="text-center">{{ $contribution->payroll_employee_middle_name }}</td>
                        <td class="text-center">{{ $contribution->period_covered }}</td>
                        <td class="text-center">{{ payroll_currency($contribution->total_pagibig_ee) }}</td>
                        <td class="text-center">{{ payroll_currency($contribution->total_pagibig_er) }}</td>
                     </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o" ></i> &nbsp;EXPORT TO EXCEL</button>
        <button class="btn btn-primary btn-custom-primary" type="submit">View PDF Form</button>
    </div>