<style type="text/css">
    .table
    {
        width: inherit;
        margin: auto;
    }
    
    .report-container
    {
        text-align: -webkit-center;
    }

    .panel-report
    {
        display: inline-block;
    }
</style>

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
    function action_collaptible(collapse = false)
    {
        $('.collaptable').aCollapTable(
        { 
            startCollapsed: collapse,
            addColumn: false, 
            plusButton: '<span class="collapse-report fa fa-caret-right fa-1x"> </span> ', 
            minusButton: '<span class="collapse-report fa fa-caret-down fa-1x"> </span> ' 
        });
    }

    $(document).on("click", ".collapse-report", function()
    {
        $parent_tr = $(this).parents("tr");
        console.log($(this));
        console.log($parent_tr.find(".total-report").html());

        if($parent_tr.find(".act-more").hasClass("act-expanded"))
        {
            $parent_tr.find(".total-report").hide();
        }
        else
        {
            $parent_tr.find(".total-report").show();
        }
    })
</script>