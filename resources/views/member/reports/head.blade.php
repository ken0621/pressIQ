<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <div>
            <i class="{{$head_icon}}"></i>
            <h1>
                <span class="page-title">{{$head_title}}</span>
                <small>
                {{$head_discription}}
                </small>
            </h1>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/mlm/jquery.aCollapTable.min.js"></script>  
<script type="text/javascript">
    function action_collaptible()
        {
            $('.collaptable').aCollapTable(
            { 
                startCollapsed: true,
                addColumn: false, 
                plusButton: '<span class="fa fa-caret-right fa-1x"> </span> ', 
                minusButton: '<span class="fa fa-caret-down fa-1x"> </span> ' 
            });
        }
</script>