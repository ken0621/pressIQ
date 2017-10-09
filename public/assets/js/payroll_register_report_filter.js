$(document).ready(function(){
	$('#filter_report').on('change', function(e){
		var parent_company_id = $(this).val();
		var payroll_parent_company_id = $(this).data("id")
		
		$.ajax({
			type: 'GET',
			url: '/member/payroll/reports/payroll_register_report_period_filtering',
			dataType: 'text',
			data: {parent_company_id: parent_company_id,payroll_parent_company_id:payroll_parent_company_id},
			success: function(data)
				{
					$(".filterResult").html(data);
				}
			});
		
	});
});