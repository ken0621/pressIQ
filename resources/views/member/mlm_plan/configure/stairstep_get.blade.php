@if($rank)
    @foreach($rank as $key => $value)
    <tr>
        <td colspan="6">
        <form class="global-submit" method="post" id="edit_form{{$key}}" action="/member/mlm/plan/stairstep/edit/save" id="edit_stairstep{{$key}}">
            {!! csrf_field() !!}
            <input type="hidden" name="stairstep_id" value="{{$value->stairstep_id}}" />
            <div class="col-md-4">
                <label for="stairstep_name">Rank Name</label>
                <input type="text" class="form-control" name="stairstep_name" value="{{$value->stairstep_name}}" placeholder="Enter Rank Name">
            </div>
            <div class="col-md-1">
                <label for="stairstep_level">Rank Level</label>
                <select name="stairstep_level" class="form-control">
                @for($i = 1; $i < $rank_count; $i++)
                    <option value="{{$i}}" {{$value->stairstep_level == $i ? 'selected' : "" }}>{{$i}}</option>
                @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label for="stairstep_required_pv">Required Personal Sales</label>
                <input type="number" class="form-control" name="stairstep_required_pv" value="{{$value->stairstep_required_pv}}">
            </div>
            <div class="col-md-2">
                <label for="stairstep_required_gv">Required Group Sales</label>
                <input type="number" class="form-control" name="stairstep_required_gv" value="{{$value->stairstep_required_gv}}">
            </div>
            <div class="col-md-2">
                <label for="stairstep_bonus">Bonus</label>
                <input type="number" class="form-control" name="stairstep_bonus" value="{{$value->stairstep_bonus}}">
            </div>
            <div class="col-md-1">
                <br>
                <a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="edit_stairstep({{$key}})">Save</a>
            </div>
        </form>
        </td>
    </tr>
    @endforeach
@endif

<tr>
    <td colspan="6">
    <form class="global-submit" method="post" action="/member/mlm/plan/stairstep/save" id="save_stairstep">
        {!! csrf_field() !!}
        <div class="col-md-4">
            <label for="stairstep_name">Rank Name</label>
            <input type="text" class="form-control" name="stairstep_name" value="" placeholder="Enter Rank Name">
        </div>
        <div class="col-md-1">
            <label for="stairstep_level">Rank Level</label>
            <select name="stairstep_level" class="form-control">
            @for($i = 1; $i < $rank_count_new; $i++)
                <option value="{{$i}}" <?php if($i == ($rank_count_new - 1)) echo "selected"; ?> >{{$i}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-2">
            <label for="stairstep_required_pv">Required Personal Sales</label>
            <input type="number" class="form-control" name="stairstep_required_pv" value="0">
        </div>
        <div class="col-md-2">
            <label for="stairstep_required_gv">Required Group Sales</label>
            <input type="number" class="form-control" name="stairstep_required_gv" value="0">
        </div>
        <div class="col-md-2">
            <label for="stairstep_bonus">Bonus</label>
            <input type="number" class="form-control" name="stairstep_bonus" value="0">
        </div>
        <div class="col-md-1">
            <br>
            <a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="save_stairstep()">Save</a>
        </div>
    </form>
    </td>
</tr>
