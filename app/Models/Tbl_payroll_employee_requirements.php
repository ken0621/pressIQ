<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_employee_requirements extends Model
{
    protected $table = 'tbl_payroll_employee_requirements';
	protected $primaryKey = "payroll_employee_requirements_id";
    public $timestamps = false;

    /* COLUMN REFERENCES */
    // PRIMARY 		payroll_employee_requirements_id 
    // INTEGER 		payroll_employee_id
    // TINYINTEGER 	has_resume
	// INTEGER 		resume_requirements_id
	// TINYINTEGER 	has_police_clearance
	// INTEGER 		police_clearance_requirements_id
	// TINYINTEGER 	has_nbi
	// INTEGER 		nbi_payroll_requirements_id
	// TINYINTEGER 	has_health_certificate
	// INTEGER 		health_certificate_requirements_id
	// TINYINTEGER 	has_school_credentials
	// INTEGER 		school_credentials_requirements_id
	// TINYINTEGER 	has_valid_id
	// INTEGER 		valid_id_requirements_id
}
