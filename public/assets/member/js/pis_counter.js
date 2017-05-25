$.ajax({

	url : '/member/pis_counter',
	type : 'get',
	dataType : 'json',
	success : function(data)
	{
		$(".lof-count").html(data.lof_ctr);
		$(".sir-count").html(data.sir_ctr);
		$(".ilr-count").html(data.ilr_ctr);

		$(".col-count").html(data.col_ctr);
	}
});

