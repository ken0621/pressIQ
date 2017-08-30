<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><i class="fa fa-calculator"></i> LANDING COST COMPUTATION</h4>
        <div>Compute the landing cost of your items</div>
    </div>
    <div class="modal-body clearfix">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
                <thead style="text-transform: uppercase">
                    <tr>
                        <th class="text-center" width="300px;">Description</th>
                        <th class="text-center" width="150px">Type</th>
                        <th class="text-center" width="150px">Value</th>
                        <th class="text-right" >Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">Purchase Cost</td>
                        <td class="text-center"></td>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value="1000"></td>
                        <td class="text-right">PHP 1,000.00</td>
                    </tr>
                    <tr>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value="Sample 01"></td>
                        <td class="text-center">
                            <select class="form-control">
                                <option selected>Percentage</option>
                                <option>Fixed</option>
                            </select>
                        </td>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value="5"></td>
                        <td class="text-right">PHP 50.00</td>
                    </tr>
                    <tr>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value="Sample 02"></td>
                        <td class="text-center">
                            <select class="form-control">
                                <option>Percentage</option>
                                <option selected>Fixed</option>
                            </select>
                        </td>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value="180"></td>
                        <td class="text-right">PHP 180.00</td>
                    </tr>
                    <tr>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value=""></td>
                        <td class="text-center">
                            <select class="form-control">
                                <option>Percentage</option>
                                <option selected>Fixed</option>
                            </select>
                        </td>
                        <td class="text-center"><input class="form-control text-center" type="text" name="" value=""></td>
                        <td class="text-right">PHP 0.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right text-bold" colspan="3">LANDING COST</td>
                        <td class="text-right text-bold">PHP 1,230.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary" type="button">Apply this Costing</button>
    </div>
</form>