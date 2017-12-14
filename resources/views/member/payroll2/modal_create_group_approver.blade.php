<form class='global-submit' action="#" method="post">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Create Approver Group</h4>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>

    <div class="modal-body">
      <div class="form-group">
        <label for="approver_group_name">Approver Group Name:</label>
        <input type="text" class="form-control" id="approver_group_name" placeholder="Enter Group Name" name="approver_group_name">
      </div>

      <div class="form-group">
        <label for="approver_level_count">Select Up to Level:</label>
        <select id="approver_level_count" class="form-control" name="approver_level_count" style="width: 50%" required>
            <option value=""> Select Level </option>
            <option value="1"> 1 </option>
            <option value="2"> 2 </option>
            <option value="3"> 3 </option>
            <option value="4"> 4 </option>
            <option value="5"> 5 </option>
        </select>
      </div>

      <div class="form-group">
        <label for="approver_level_count">Select Up to Level:</label>
        <select id="approver_level_count" class="form-control" name="approver_level_count" style="width: 50%" required>
            <option value=""> Select Level </option>
            <option value="1"> 1 </option>
            <option value="2"> 2 </option>
            <option value="3"> 3 </option>
            <option value="4"> 4 </option>
            <option value="5"> 5 </option>
        </select>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</form>
<script type="text/javascript" src="/assets/js/payroll_group_approver.js"></script>
