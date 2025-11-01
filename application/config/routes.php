<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE; 


$route['purchase-item-list'] = 'purchase/purchase_item_list'; 
$route['purchase-item-list/(:num)'] = 'purchase/purchase_item_list/$1'; 

$route['material-inward'] = 'purchase/material_inward_list'; 
$route['material-inward/(:num)'] = 'purchase/material_inward_list/$1'; 

$route['opening-stock-item-list'] = 'purchase/opening_stock_item_list'; 
$route['opening-stock-item-list/(:num)'] = 'purchase/opening_stock_item_list/$1'; 

$route['adj-stock-item-list'] = 'purchase/adj_stock_item_list'; 
$route['adj-stock-item-list/(:num)'] = 'purchase/adj_stock_item_list/$1'; 
 

$route['inward-register'] = 'purchase/inward_register';
$route['material-request-slip'] = 'purchase/material_request';
$route['material-issue-slip'] = 'purchase/material_issue';
$route['stock-report'] = 'purchase/stock_report';


$route['inward-testing-entry'] = 'purchase/inward_testing_entry';
$route['inward-testing'] = 'purchase/inward_testing_register';


$route['production-note'] = 'reports/production_report';

$route['headcode-wise-stock-report'] = 'reports/headcode_wise_stock_report';

$route['core-maker-reports'] = 'reports/core_maker_reports';
$route['core-stock-reports'] = 'reports/core_stock_reports';
//$route['core-maker-reports/(:num)'] = 'reports/core_maker_reports/$1';

$route['date-wise-production-report'] = 'reports/date_wise_production_report';
$route['date-wise-planning-report'] = 'reports/date_wise_planning_report';
$route['date-wise-rejection-report'] = 'reports/date_wise_rejection_report';
$route['customer-wise-planning-report'] = 'reports/customer_wise_planning_report';
$route['customer-wise-production-report'] = 'reports/customer_wise_production_report';
$route['heatcode-wise-production-report'] = 'reports/heat_code_wise_production_report'; 
$route['heatcode-wise-rejection-report'] = 'reports/headcode_wise_rejection_report';

$route['date-wise-melting-report'] = 'reports/date_wise_melting_report';
$route['customer-wise-melting-report'] = 'reports/customer_wise_melting_report';

$route['customer-wise-rejection-report'] = 'reports/customer_wise_rejection_report';
$route['customer-wise-rejection-report-v2'] = 'reports/customer_wise_rejection_report_v2';
$route['moulding-consumption-report'] = 'reports/moulding_consumption_report';
$route['melting-consumption-report'] = 'reports/melting_consumption_report';
$route['print-customer-list'] = 'reports/print_customer_list';

$route['print-order-register/(:num)'] = 'reports/print_order_info/$1';
$route['print-despatch-advice/(:num)'] = 'reports/print_despatch_advice/$1';

$route['city-wise-booking-summary'] = 'reports/city_wise_booking_summary';
$route['city-wise-booking-summary/(:num)'] = 'reports/city_wise_booking_summary/$1';

$route['manifest-report'] = 'reports/manifest_report';
$route['manifest-report/(:num)'] = 'reports/manifest_report/$1';

$route['production-summary-report'] = 'reports/production_summary_report'; 
$route['day-production-report'] = 'reports/day_production_report'; 
$route['mis-report'] = 'reports/mis_report';
$route['pattern-history-report'] = 'reports/pattern_history_report';

$route['customer-wise-despatch-report'] = 'reports/customer_wise_despatch_report'; 
$route['customer-wise-despatch-summary'] = 'reports/customer_wise_despatch_summary'; 
$route['work-order-wise-despatch-report'] = 'reports/work_order_wise_despatch_report'; 
$route['work-order-wise-despatch-summary'] = 'reports/work_order_wise_despatch_summary'; 
$route['grinding-report'] = 'reports/grinding_report'; 
$route['rejection-summary-report'] = 'reports/rejection_summary_report'; 

$route['customer-wise-pattern-report'] = 'reports/customer_wise_pattern_report'; 
$route['work-order-planning-statement'] = 'reports/work_order_planning_statement'; 

$route['melting-master-list'] = 'reports/customer_wise_melting_master_report'; 
$route['melting-master-list-v1'] = 'reports/customer_wise_melting_master_report_v1'; 
$route['customer-pattern-list'] = 'reports/customer_pattern_list'; 
$route['print-pattern/(:any)'] = 'reports/print_pattern_info/$1'; 
 
$route['print-melting-master/(:any)'] = 'reports/print_melting_master/$1'; 

$route['moulding-master-list'] = 'reports/customer_wise_moulding_master_report';
$route['print-moulding-master/(:any)'] = 'reports/print_moulding_master/$1'; 


$route['core-maker-master-rate'] = 'reports/core_maker_master_rate'; 
$route['grinding-master-rate-list'] = 'reports/grinding_master_rate_list'; 


$route['transporter-list'] = 'master/transporter_list'; 




$route['dash'] = 'dashboard';
$route['get-data'] = 'general/get_data';
$route['update-data'] = 'general/update_data';
$route['insert-data'] = 'general/insert_data';
$route['delete-record'] = 'general/delete_record';
$route['get-content'] = 'general/get_content';
$route['get-charges'] = 'general/get_courier_charges';
$route['logout'] = 'general/logout';


/* Chart */

$route['chart-internal-rejection'] = 'chart/chart_internal_rejection'; 
$route['chart-internal-rejection-total'] = 'chart/chart_internal_rejection_total'; 
$route['chart-internal-rejection-dept'] = 'chart/chart_internal_rejection_dept'; 
$route['chart-internal-rejection-dept-wt'] = 'chart/chart_internal_rejection_dept_wt'; 

$route['chart-internal-rejection-dev-qty'] = 'chart/chart_internal_rejection_dev_qty'; 
$route['chart-internal-rejection-dev-wt'] = 'chart/chart_internal_rejection_dev_wt'; 

$route['chart-internal-rejection-based/(:any)'] = 'chart/chart_internal_rejection_based/$1'; 

$route['mrm-report'] = 'chart/mrm_report'; 
$route['mrm-report-v2'] = 'chart/mrm_report_v2'; 

/* Master */ 


$route['sub-contractor-list'] = 'master/sub_contractor_list';
$route['sub-contractor-list/(:num)'] = 'master/sub_contractor_list/$1';

$route['core-item-list'] = 'master/core_item_list';
$route['core-item-list/(:num)'] = 'master/core_item_list/$1';

$route['core-maker-list'] = 'master/core_maker_list';
$route['core-maker-list/(:num)'] = 'master/core_maker_list/$1';

$route['core-maker-rate-list'] = 'master/core_maker_rate_list';
$route['core-maker-rate-list/(:num)'] = 'master/core_maker_rate_list/$1';

$route['pattern-maker-list'] = 'master/pattern_maker_list';
$route['pattern-maker-list/(:num)'] = 'master/pattern_maker_list/$1';
 
$route['customer-list'] = 'master/customer_list'; 
$route['customer-list/(:num)'] = 'master/customer_list/$1';  

$route['uom-list'] = 'master/uom_list'; 
$route['uom-list/(:num)'] = 'master/uom_list/$1'; 

$route['iso-label-list'] = 'master/iso_label_list'; 
$route['iso-label-list/(:num)'] = 'master/iso_label_list/$1'; 

$route['MRM-target'] = 'master/MRM_target'; 
$route['MRM-target-v2'] = 'master/MRM_target_v2'; 

$route['grade-list'] = 'master/grade_list';
$route['grade-list/(:num)'] = 'master/grade_list/$1';

$route['rejection-type-list'] = 'master/rejection_type_list'; 
$route['rejection-type-list/(:num)'] = 'master/rejection_type_list/$1'; 

$route['moulding-spec-generate'] = 'master/moulding_spec_generate'; 

$route['employee-list'] = 'master/employee_list'; 
$route['employee-list/(:num)'] = 'master/employee_list/$1'; 

$route['user-list'] = 'master/user_list'; 
$route['user-list/(:num)'] = 'master/user_list/$1'; 


/* Pattern Shop */

$route['pattern-list'] = 'pattern/pattern_list'; 
$route['pattern-list/(:num)'] = 'pattern/pattern_list/$1'; 

$route['pattern-in-out-list'] = 'pattern/pattern_in_out_list'; 
$route['pattern-in-out-list/(:num)'] = 'pattern/pattern_in_out_list/$1';  

$route['pattern-in-out-list-v2'] = 'pattern/pattern_in_out_list_v2/'; 
$route['pattern-in-out-list-v2/(:num)'] = 'pattern/pattern_in_out_list_v2/$1'; 

$route['work-order-entry'] = 'pattern/work_order_entry'; 

$route['work-order-list'] = 'pattern/work_order_list'; 
$route['work-order-list/(:num)'] = 'pattern/work_order_list/$1'; 

$route['work-order-edit/(:num)'] = 'pattern/work_order_edit/$1'; 


$route['core-floor-stock'] = 'pattern/core_floor_stock'; 
$route['core-floor-stock/(:num)'] = 'pattern/core_floor_stock/$1'; 

$route['floor-stock'] = 'pattern/floor_stock'; 
$route['floor-stock/(:num)'] = 'pattern/floor_stock/$1'; 

$route['core-planning'] = 'pattern/core_planning'; 

$route['core-production'] = 'pattern/core_production'; 
$route['core-production/(:num)'] = 'pattern/core_production/$1'; 


/* Production */
 
$route['work-planning'] = 'production/work_planning'; 
$route['work-planning-list'] = 'production/work_planning_list'; 

$route['moulding-material'] = 'production/moulding_material'; 
$route['moulding-heatcode-log'] = 'production/moulding_heatcode_log'; 
$route['print-moulding-log-sheet/(:num)'] = 'production/print_moulding_log_sheet/$1'; 
$route['melting-log'] = 'production/melting_log'; 
$route['print-melting-log-sheet/(:num)'] = 'production/print_melting_log_sheet/$1'; 
$route['sand-test'] = 'production/sand_test'; 

$route['quality-check-v1'] = 'production/quality_check'; 
$route['quality-check'] = 'production/quality_check_v2'; 

$route['customer-despatch-v2'] = 'production/customer_despatch_v2'; 


$route['customer-despatch-restore'] = 'production/customer_despatch_restore'; 
$route['customer-despatch-restore/(:num)'] = 'production/customer_despatch_restore/$1'; 

$route['customer-despatch'] = 'production/customer_despatch'; 
$route['customer-despatch/(:num)'] = 'production/customer_despatch/$1'; 

$route['customer-despatch-edit/(:num)'] = 'production/customer_despatch_edit/$1'; 

$route['sub-contractor-despatch'] = 'production/sub_contractor_despatch'; 
$route['sub-contractor-despatch/(:num)'] = 'production/sub_contractor_despatch/$1'; 
$route['sub-contractor-despatch-edit/(:num)'] = 'production/sub_contractor_despatch_edit/$1'; 

$route['print-dc/(:any)'] = 'production/print_dc/$1/$2'; 
$route['print-sdc/(:any)'] = 'production/print_sdc/$1/$2'; 
$route['print-pattern-out-dc/(:any)'] = 'pattern/print_pattern_out_dc/$1/$2'; 
$route['print-mtc/(:any)'] = 'production/print_MTC/$1/$2'; 

$route['print-str/(:any)'] = 'production/print_STR/$1'; 

$route['customer-rejection-list'] = 'machineshop/customer_rejection_list'; 
$route['customer-rejection-list/(:any)'] = 'machineshop/customer_rejection_list/$1'; 
$route['customer-rejection-edit/(:num)'] = 'machineshop/customer_rejection_edit/$1'; 

$route['rework-inward-list'] = 'machineshop/rework_inward_list'; 
$route['rework-inward-list/(:any)'] = 'machineshop/rework_inward_list/$1'; 
$route['rework-in-out-edit/(:num)'] = 'machineshop/rework_in_out_edit/$1'; 

$route['rework-outward-list'] = 'machineshop/rework_outward_list'; 
$route['rework-outward-list/(:any)'] = 'machineshop/rework_outward_list/$1'; 



$route['ms-despatch-list'] = 'machineshop/ms_despatch_list'; 
$route['ms-despatch-list/(:any)'] = 'machineshop/ms_despatch_list/$1'; 

$route['ms-despatch-edit/(:num)'] = 'machineshop/ms_despatch_edit/$1'; 

$route['print-ms-dc/(:any)'] = 'machineshop/print_ms_dc/$1'; 

$route['ms-floor-stock'] = 'machineshop/ms_floor_stock'; 
$route['ms-floor-stock/(:any)'] = 'machineshop/ms_floor_stock/$1'; 

$route['ms-stock-report'] = 'machineshop/ms_stock_report'; 
$route['customer-rejection-report'] = 'machineshop/customer_rejection_report'; 



 

$route['state-list'] = 'master/state_list'; 
$route['state-list/(:num)'] = 'master/state_list/$1'; 

$route['city-list'] = 'master/city_list'; 
$route['city-list/(:num)'] = 'master/city_list/$1'; 

$route['franchise-type-list'] = 'master/franchise_type_list'; 
$route['franchise-type-list/(:num)'] = 'master/franchise_type_list/$1'; 

$route['franchise-list'] = 'master/franchise_list'; 
$route['franchise-list/(:num)'] = 'master/franchise_list/$1'; 

$route['franchise-domestic-rate'] = 'master/franchise_domestic_rate'; 
$route['franchise-domestic-rate/(:num)'] = 'master/franchise_domestic_rate/$1';   

$route['agent-list'] = 'master/agent_list'; 
$route['agent-list/(:num)'] = 'master/agent_list/$1';  


$route['customer-domestic-rate/(:num)'] = 'master/customer_domestic_rate/$1'; 


$route['carrier-list'] = 'master/carrier_list'; 
$route['carrier-list/(:num)'] = 'master/carrier_list/$1'; 



$route['service-list'] = 'master/service_list'; 
$route['service-list/(:num)'] = 'master/service_list/$1'; 

$route['package-type-list'] = 'master/package_type_list'; 
$route['package-type-list/(:num)'] = 'master/package_type_list/$1';

$route['product-type-list'] = 'master/product_type_list'; 
$route['product-type-list/(:num)'] = 'master/product_type_list/$1';

$route['customer-type-list'] = 'master/customer_type_list';
$route['customer-type-list/(:num)'] = 'master/customer_type_list/$1';

$route['commodity-type-list'] = 'master/commodity_type_list';
$route['commodity-type-list/(:num)'] = 'master/commodity_type_list/$1';

$route['domestic-rate'] = 'master/domestic_rate';
$route['get-supplier'] = 'general/get_supplier';
