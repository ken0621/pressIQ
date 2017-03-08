/* INITITALIZE ARRAY */
$entry_data = [];

/* BATCH DATA */
$entry_data[]["account_id"]        = "1";
$entry_data[]["account_id"]        = "2";
$entry_data[]["account_id"]        = "7";
$entry_data[]["entry_type"]        = "debit";
$entry_data[]["entry_amount"]      = "1000";
$entry_data[]["entry_description"] = "this is first description";

/* BATCH DATA */
$entry_data[]["account_id"]        = "2";
$entry_data[]["account_id"]        = "1";
$entry_data[]["account_id"]        = "7";
$entry_data[]["entry_type"]        = "credit";
$entry_data[]["entry_amount"]      = "1000";
$entry_data[]["entry_description"] = "this is second description";

/* INITIALIZE VARIABLES */
$reference_module = "invoice";
$reference_id = 1;
$entry_date = "2000-01-01";
$remarks = "This is a remark";

/* CALL METHOD TO PROCESS */
Accounting::postJournalEntry("invoice","2","2000-01-01","This is a remark", $entry_data)