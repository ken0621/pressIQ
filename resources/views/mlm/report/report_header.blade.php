
<?php 
$data['title'] = 'Report';
$data['sub'] = $plan->marketing_plan_name;
$data['plan_b'] = $plan->marketing_plan_code;
$data['icon'] = 'fa fa-archive';
?>
@include('mlm.header.index', $data)