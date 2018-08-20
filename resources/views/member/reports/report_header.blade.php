<h2 class="text-center">{{$shop_name}}</h2>
<h4 class="text-center"><b>{{$head_title}}</b></h4>
<h4 class="text-center">{{isset($from) && $from != '1000-01-01' ? dateFormat($from)." - ".dateFormat($to) : 'All Dates'}}</h4>
<h4 class="text-center">{{$warehouse_name}}</h4>
