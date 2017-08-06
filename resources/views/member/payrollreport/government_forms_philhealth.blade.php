<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">PHILHEALTH CONTRIBUTION FOR THE MONTH OF {{ strtoupper($month_name) }} {{ $year }} </h4>
	</div>
	<div class="modal-body clearfix">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                            	<th class="text-center">#</th>
                                <th class="text-center">PHILHEALTH NO.</th>
                                <th class="text-center">LAST NAME</th>
                                <th class="text-center">FIRST NAME</th>
                                <th class="text-center">NAME EXT</th>
                                <th class="text-center">MIDDLE NAME</th>
                                <th class="text-center">PERIOD COVERED</th>
                                <th class="text-center">EE SHARE</th>
                                <th class="text-center">ER SHARE</th>
                                <th class="text-center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                 			@foreach($contri_info["_employee_contribution"] as $key => $contribution)
                        	<tr>
                        		<td class="text-center">{{ $contribution->count }}</td>
                        		<td class="text-center">{{ $contribution->payroll_employee_philhealth }}</td>
                        		<td class="text-center">{{ $contribution->payroll_employee_last_name }}</td>
                        		<td class="text-center">{{ $contribution->payroll_employee_first_name }}</td>
                        		<td class="text-center">{{ $contribution->payroll_employee_suffix_name }}</td>
                        		<td class="text-center">{{ $contribution->payroll_employee_middle_name }}</td>
                        		<td class="text-center">{{ $contribution->period_covered }}</td>
                        		<td class="text-center">{{ payroll_currency($contribution->total_philhealth_ee) }}</td>
                        		<td class="text-center">{{ payroll_currency($contribution->total_philhealth_er) }}</td>
                        		<td class="text-center" style="color: #76B6EC; font-weight: bold;">{{ payroll_currency($contribution->total_philhealth_ee_er) }}</td>
                        	</tr>
                        	@endforeach
                        </tbody>
                          <tfoot>
                            <tr>
                                <td colspan="7" class="text-right" style="font-weight: bold;">GRAND TOTAL</td>
                                <td class="text-center" style="font-weight: bold;">{{ payroll_currency($contri_info["grand_total_philhealth_ee"]) }}</td>
                                <td class="text-center" style="font-weight: bold;">{{ payroll_currency($contri_info["grand_total_philhealth_er"]) }}</td>
                                <td class="text-center" style="color: #76B6EC; font-weight: bold;">{{ payroll_currency($contri_info["grand_total_philhealth_ee_er"]) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
	</div>
</form>

<style type="text/css">
    #global_modal .modal-dialog
    {
        width: 85% !important;
    }
</style>