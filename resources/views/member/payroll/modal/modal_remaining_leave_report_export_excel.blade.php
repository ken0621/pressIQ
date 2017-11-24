	    <h4 class="modal-title"><b>Remaining - Leave Records</b> <i><br> Remaining - Leave Records</i></h4>

    <div class="modal-body clearfix">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Leave Name</th>
                                <th class="text-center wa">Employee Code</th>
                                <th class="text-center empname">Employee Name</th>
                                <th class="text-center wa">Leave Credits</th>
                                <th class="text-center wa">Used Leave</th>
                                <th class="text-center wa">Remaining Leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($leave_report))
                            @foreach($leave_report as $leave_data)
                                @foreach($leave_data as $leave)
                            <tr>
                                <td class="text-center">{{ $leave->payroll_leave_temp_name }}</td>
                                <td class="text-center">{{ $leave->payroll_employee_id }}</td>
                                <td class="text-center">{{ $leave->payroll_employee_display_name }}</td>
                                <td class="text-center">{{ $leave->payroll_leave_temp_hours }}</td>
                                <td class="text-center">{{ $leave->total_leave_consume }}</td>
                                <td class="text-center">{{ $leave->remaining_leave }}</td>
                            </tr>
                                 @endforeach
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
	</div>
<style>
.wa{
    background-color: #ffff99 !important;
     border: 5px solid #2C2C2C;
}
.empname{
    background-color: #ccffff !important;
        border: 5px solid #2C2C2C;
}

</style>