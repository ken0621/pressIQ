<a href="{{$link}}?column_name={{$column_name}}&in_order={{Request::input('column_name') == $column_name && $in_order != 'asc' ? 'asc' : 'desc' }}">{{$title_column_name}}
	@if(Request::input('column_name') == $column_name && $in_order == 'asc')
	<i class="fa fa-fw fa-sort-desc"></i>
	@elseif(Request::input('column_name') == $column_name && $in_order == 'desc')
	<i class="fa fa-fw fa-sort-asc"></i>
	@else
	<i class="fa fa-fw fa-sort"></i>
	@endif
</a>