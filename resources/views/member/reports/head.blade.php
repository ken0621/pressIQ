<style type="text/css">
    .table
    {
        width: inherit;
        min-width: 650px;
        margin: auto;
    }
    
    .report-container
    {
        text-align: -webkit-center;
    }

    .panel-report
    {
        display: inline-block;
        width: 100%;
        overflow-x: scroll;

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
            plusButton: '&#9658; ', 
            minusButton: '&#9660; '
        });

        if(collapse)    $(".act-more").closest("tr").find(".total-report").removeClass("hide");
        else            $(".act-more").closest("tr").find(".total-report").addClass("hide");
    }

    $(document).on("click", ".act-more", function()
    {
        $parent_tr = $(this).closest("tr");

        if($parent_tr.hasClass("act-tr-expanded"))
        {
            $parent_tr.find(".total-report").addClass("hide");
        }
        else
        {
            $parent_tr.find(".total-report").removeClass("hide");
        }
    })
</script>