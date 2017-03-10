<form class="global-submit" role="form" action="" method="POST">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title">Create new employee</h4>
  </div>
  <div class="modal-body modallarge-body-layout background-white">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    <div class="form-horizontal">
      <div class="form-group">
        <div class="col-md-6">
          <div class="col-md-2 padding-lr-1">
            <small>Title</small>
            <input type="text" name="title" class="form-control auto-name title margin-l-0"/>
          </div>
          <div class="col-md-3 padding-lr-1">
            <small>First name</small>
            <input type="text" name="first_name" class="form-control auto-name first_name" value="{{$value or ''}}" required/>
          </div>
          <div class="col-md-3 padding-lr-1">
            <small>Middle name</small>
            <input type="text" name="middle_name" class="form-control auto-name middle_name"/>
          </div>
          <div class="col-md-3 padding-lr-1">
            <small>Last name</small>
            <input type="text" name="last_name" class="form-control auto-name last_name"/>
          </div>
          <div class="col-md-1 padding-lr-1">
            <small>Suffix</small>
            <input type="text" name="suffix" class="form-control auto-name suffix"/>
          </div>
        </div>
        <div class="col-md-6">
          <div class="col-md-6 padding-lr-1">
            <small>Employee number</small>
            <input type="text" name="employee_number" class="form-control"/>
          </div>
          <div class="col-md-6 padding-lr-1">
            <small>ATM No.</small>
            <input type="text" name="atm_number" class="form-control"/>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <small>Company</small>
          <select class="form-control" required>
            <option value="">Select Company</option>
            @foreach($_company as $company)
            <option value="{{$company->payroll_company_id}}">{{$company->payroll_company_name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <div class="col-md-6 padding-lr-1">
            <small>Contact</small>
            <input type="text" name="phone" class="form-control"/>
          </div>
          <div class="col-md-6 padding-lr-1">
            <small>Email</small>
            <input type="text" name="mobile" class="form-control"/>
          </div>
          
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <small><b>Print on as check as</b></small>&nbsp;
          <div class="checkbox display-inline-block"><small for=""><input type="checkbox" name="chck_print_on_as" class="checkbox-toggle-rev check-print-name-as" data-target=".display-name-check" checked="true"/>Use display name</small></div>
          <input type="text" name="print_on_as_check_as" class="form-control display-name-check"/>
        </div>
        <div class="col-md-6">
          <small>Birthdate</small>
          <input type="text" name="" class="form-control indent-13 datepicker">
          <i class="fa fa-calendar pos-absolute top-30 margin-left-6 color-dark-gray" aria-hidden="true"></i>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <ul class="nav nav-tabs nav-tabs-custom">
            <li class="active"><a data-toggle="tab" href="#address">Address</a></li>
            <li><a data-toggle="tab" href="#company-details">Company Details</a></li>
            <li><a data-toggle="tab" href="#government-contribution">Government Contribution</a></li>
            <li><a data-toggle="tab" href="#salary-details">Salary Details</a></li>
            <li><a data-toggle="tab" href="#requirements">Requirements</a></li>
            <li><a data-toggle="tab" href="#remarks">Remarks</a></li>
          </ul>
          
          <div class="tab-content tab-content-custom">
            <div id="address" class="tab-pane fade in active">
             
              <div class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Street</small>
                        <textarea name="" rows="2" class="form-control textarea-expand" placeholder="Street"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-6">
                        <small>City/Town</small>
                        <input type="text" name="" class="form-control" placeholder="City/Town">
                      </div>
                      <div class="col-md-6">
                        <small>State</small>
                        <input type="text" name="" class="form-control" placeholder="State">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-6">
                        <small>Zip Code</small>
                        <input type="text" name="" class="form-control" placeholder="Zip code">
                      </div>
                      <div class="col-md-6">
                        <small>Country</small>
                        <select class="form-control" name="">
                          @foreach($_country as $country)
                          <option value="{{$country->country_id}}">{{$country->country_name}}</option>
                          @endforeach
                        </select>
                       
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
            <div id="company-details" class="tab-pane fade ">
              <div class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Department</small>
                        <select class="form-control" required>
                          <option value="">Select Department</option>
                          @foreach($_department as $department)
                          <option value="{{$department->payroll_department_id}}">{{$department->payroll_department_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Job Title</small>
                        <select class="form-control" required>
                          <option value="">Select Job Title</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-6">
                        <small>Date Hired</small>
                        <input type="text" name="" class="form-control indent-13 datepicker">
                        <i class="fa fa-calendar pos-absolute top-30 margin-left-6 color-dark-gray" aria-hidden="true"></i>
                      </div>
                      <div class="col-md-6">
                        <small>Employment Status</small>
                        <select class="form-control">
                          <option value="">Select Status</option>
                          @foreach($employement_status as $employment)
                          <option value="{{$employment->payroll_employment_status_id}}">{{$employment->employment_status}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Payroll Group</small>
                        <select class="form-control">
                          <option value="">Select Group</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="government-contribution" class="tab-pane fade ">
              <div class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-6">
                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="checkbox">
                            <label><input type="checkbox" name="" value="1">Minimum wage earner</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <small>Tax Status</small>
                          <select class="form-control">
                            @foreach($tax_status as $tax)
                            <option value="{{$tax->payroll_tax_status_name}}">{{$tax->payroll_tax_status_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <small>Tax Identification Number</small>
                          <input type="text" name="" class="form-control">
                        </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>SSS Number</small>
                        <input type="text" name="" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Philhealth Number</small>
                        <input type="text" name="" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Pagibig/HDMF Number</small>
                        <input type="text" name="" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div id="salary-details" class="tab-pane fade">
              
              <div class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Monthly Rate</small>
                        <input type="number" name="" class="form-control text-right">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Daily Rate</small>
                        <input type="number" name="" class="form-control text-right">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>Taxable Salary</small>
                        <input type="number" name="" class="form-control text-right">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>SSS Salary</small>
                        <input type="number" name="" class="form-control text-right">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>PAGIBIG/HDMF Salary</small>
                        <input type="number" name="" class="form-control text-right">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <small>PHILHEALTH Salary</small>
                        <input type="number" name="" class="form-control text-right">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="requirements" class="tab-pane fade">
              <div class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-12">
                    <table class="table table-condensed">
                      <tr>
                        <td>Resume/CV/Bio-Data</td>
                        <td class="text-center">
                          <input type="checkbox" name="requirement_resume_checkbox" value="1">
                        </td>
                        <td width="35%" class="text-center">
                          <a href="#" class="a-file-name display-none">file name here</a><br>
                          <div class="custom-progress-container-100 display-none">
                            <div class="custom-progress"></div>
                          </div>
                          <label class="lbl-a-href"><input type="file" name="" class="hide file-requirements"><i class="fa fa-cloud-upload lbl-a-href" aria-hidden="true"></i>&nbsp;Upload requirement</label>
                          <input type="hidden" class="requirement-input" name="requirement_resume_input">
                        </td>
                        <td class="text-center" width="10">
                          <a href="#" class="display-none remove-requirements" data-requirement=""><i class="fa fa-times"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Police Clearance</td>
                        <td class="text-center">
                          <input type="checkbox" name="requirement_police_checkbox" value="1">
                        </td>
                        <td width="35%" class="text-center">
                          <a href="#" class="a-file-name display-none">file name here</a><br>
                          <div class="custom-progress-container-100 display-none">
                            <div class="custom-progress"></div>
                          </div>
                          <label class="lbl-a-href"><input type="file" name="" class="hide file-requirements"><i class="fa fa-cloud-upload lbl-a-href" aria-hidden="true"></i>&nbsp;Upload requirement</label>
                          <input type="hidden" class="requirement-input" name="requirement_police_input">
                        </td>
                        <td class="text-center" width="10">
                          <a href="#" class="display-none remove-requirements" data-requirement=""><i class="fa fa-times"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>NBI</td>
                        <td class="text-center">
                          <input type="checkbox" name="requirement_nbi_checkbox" value="1">
                        </td>
                        <td width="35%" class="text-center">
                          <a href="#" class="a-file-name display-none">file name here</a><br>
                          <div class="custom-progress-container-100 display-none">
                            <div class="custom-progress"></div>
                          </div>
                          <label class="lbl-a-href"><input type="file" name="" class="hide file-requirements"><i class="fa fa-cloud-upload lbl-a-href" aria-hidden="true"></i>&nbsp;Upload requirement</label>
                          <input type="hidden" class="requirement-input" name="requirement_nbi_input">
                        </td>
                        <td class="text-center" width="10">
                          <a href="#" class="display-none remove-requirements" data-requirement=""><i class="fa fa-times"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Health Certificate</td>
                        <td class="text-center">
                          <input type="checkbox" name="requirement_health_checkbox" value="1">
                        </td>
                        <td width="35%" class="text-center">
                          <a href="#" class="a-file-name display-none">file name here</a><br>
                          <div class="custom-progress-container-100 display-none">
                            <div class="custom-progress"></div>
                          </div>
                          <label class="lbl-a-href"><input type="file" name="" class="hide file-requirements"><i class="fa fa-cloud-upload lbl-a-href" aria-hidden="true"></i>&nbsp;Upload requirement</label>
                          <input type="hidden" class="requirement-input" name="requirement_health_input">
                        </td>
                        <td class="text-center" width="10">
                          <a href="#" class="display-none remove-requirements" data-requirement=""><i class="fa fa-times"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>School Credentials</td>
                        <td class="text-center">
                          <input type="checkbox" name="requirement_school_checkbox" value="1">
                        </td>
                        <td width="35%" class="text-center">
                          <a href="#" class="a-file-name display-none">file name here</a><br>
                          <div class="custom-progress-container-100 display-none">
                            <div class="custom-progress"></div>
                          </div>
                          <label class="lbl-a-href"><input type="file" name="" class="hide file-requirements"><i class="fa fa-cloud-upload lbl-a-href" aria-hidden="true"></i>&nbsp;Upload requirement</label>
                          <input type="hidden" class="requirement-input" name="requirement_school_input">
                        </td>
                        <td class="text-center" width="10">
                          <a href="#" class="display-none remove-requirements" data-content=""><i class="fa fa-times"></i></a>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div id="remarks" class="tab-pane fade">
              <br>
              <div class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-12">
                    <label for=""><b>Notes</b></label>
                    <textarea class="form-control textarea-expand"  name=""></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="error-modal text-center">
      Error
    </div>
    
    <button type="button" class="btn btn-custom-white " data-dismiss="modal">Cancel</button>
    <!--<button type="button" class="btn btn-custom-red-white btn-del-modallarge" data-url="" data-value="">Delete</button>-->
    <button class="btn btn-custom-primary btn-save-modallarge" type="submit" data-url="">Save customer</button>
  </div>
</form>
<script type="text/javascript" src="/assets/member/js/customer.js"></script>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_employee.js"></script>