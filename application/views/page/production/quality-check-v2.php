<?php  include_once(VIEWPATH . '/inc/header.php');  
// echo "<pre>"; 
// print_r($record_list); 
// //print_r($rejection_type_opt); 
// echo "</pre>";
?>
<section class="content-header">
    <h1>Internal Inspection</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> QC - Inspection</a></li>
        <li class="active">QC-Rejection</li>
    </ol>
</section>

<section class="content">
    <!-- Default box -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
        </div>
        <div class="box-body">
            <form action="" method="post" id="frm">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Planning Date</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker" id="srch_date"
                                name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="srch_customer">Shift</label>
                        <?php echo form_dropdown('srch_shift',array('' => 'Select Shift') + $shift_opt ,set_value('srch_shift',$srch_shift) ,' id="srch_shift" class="form-control"');?>
                    </div>
                    <!-- <div class="form-group col-md-3"> 
                    <label for="srch_customer">Customer</label>
                    <?php echo form_dropdown('srch_customer',array('' => 'Select Customer') + $customer_opt ,set_value('srch_customer',$srch_customer) ,' id="srch_customer" class="form-control"');?>  
                </div> -->
                    <div class="form-group col-md-6">
                        <label for="srch_pattern_id">Pattern Item</label>
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'Select Item') + $pattern_itm_opt ,set_value('srch_pattern_id',$srch_pattern_id) ,' id="srch_pattern_id" class="form-control"');?>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="srch_rejection_group">Rejection Group</label>
                        <?php echo form_dropdown('srch_rejection_group',array('' => 'Select Group') + $rejection_group_opt ,set_value('srch_rejection_group',$srch_rejection_group) ,' id="srch_rejection_group" class="form-control"');?>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="srch_qc_date">QC Date</label>
                        <input type="date" class="form-control" name="srch_qc_date" id="srch_qc_date"
                            value="<?php echo set_value('srch_qc_date',$srch_qc_date);?>" placeholder="QC Date" />
                    </div>
                    <div class="col-sm-3 col-md-4" style="margin-top:5px;">
                        <br />
                        <button class="btn btn-info" type="submit">Show Records</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if(!empty($record_list)){ ?>

    <form action="" method="post" id="frm_inspection">
        <input type="hidden" name="srch_date" value="<?php echo $srch_date; ?>" />
        <input type="hidden" name="srch_shift" value="<?php echo $srch_shift; ?>" />
        <input type="hidden" name="srch_pattern_id" value="<?php echo $srch_pattern_id; ?>" />
        <input type="hidden" name="srch_rejection_group" value="<?php echo $srch_rejection_group; ?>" />
        <input type="hidden" name="srch_qc_date" value="<?php echo $srch_qc_date; ?>" />
        <input type="hidden" name="work_planning_id" value="<?php echo $record_list[0]['work_planning_id']; ?>" />
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list"></i> Inspection List</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped inspection-table">
                    <thead>
                        <tr>
                            <th colspan="<?php echo 3 + count($rejection_type_opt); ?>" class="text-center bg-primary">
                                Inspection Details</th>
                        </tr>
                        <tr>
                            <th colspan="<?php echo round((3 + count($rejection_type_opt)) / 2); ?>"
                                class="text-left bg-warning">
                                <span>Planning Date :</span><?php echo date('d-m-Y',strtotime($srch_date)); ?>
                                <br> Shift :
                                <?php echo (isset($shift_opt[$srch_shift]) && $srch_shift != '') ? $shift_opt[$srch_shift] : 'All'; ?>


                            </th>
                            <th colspan="<?php echo round((3 + count($rejection_type_opt)) / 2); ?>"
                                class="text-left bg-warning">
                                Pattern Item :
                                <?php echo (isset($pattern_itm_opt[$srch_pattern_id]) && $srch_pattern_id != '') ? $pattern_itm_opt[$srch_pattern_id] : 'All'; ?>
                                <br> QC Date : <?php echo date('d-m-Y',strtotime($srch_qc_date)); ?>
                            </th>
                        </tr>
                        <tr>
                            <th rowspan="2">S.No</th>
                            <th rowspan="2">Heat Code</th>
                            <th rowspan="2" class="bg-success">Prod.Qty</th>
                            <th colspan="<?php echo count($rejection_type_opt); ?>" class="bg-danger text-center">
                                <?php echo (isset($rejection_group_opt[$srch_rejection_group]) && $srch_rejection_group != '') ? $rejection_group_opt[$srch_rejection_group] : 'All'; ?>
                            </th>
                        </tr>
                        <tr>

                            <?php foreach($rejection_type_opt as $rej_typ){ ?>
                            <th class="bg-info text-left"><?php echo $rej_typ['rej_code'];?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(count($record_list) > 0 ) { 
                            $sno = 1; 
                            $shift_supervisor = '';
                            $tumblast_machine_operator = '';
                            $shot_blastng_machine_operator = '';    
                            $ag4_machine_operator = '';
                            $contractor_grinding_machine_operator = '';
                            $company_grinding_machine_operator = '';
                            $painting_person = '';
                            $factory_manager = '';
                        foreach($record_list as $row) {  
                         $rty_arry = (isset($row['rejection_type_id']) && $row['rejection_type_id'] != '') ? explode(',',$row['rejection_type_id']) : array();
                         $rqty_arry = (isset($row['rejection_qty']) && $row['rejection_qty'] != '') ? explode(',',$row['rejection_qty']) : array();   
                         $qc_id_arry = (isset($row['qc_inspection_id']) && $row['qc_inspection_id'] != '') ? explode(',',$row['qc_inspection_id']) : array();   
                            
                         if(isset($row['shift_supervisor']) && $row['shift_supervisor'] != '') $shift_supervisor = $row['shift_supervisor'] ;
                         if(isset($row['tumblast_machine_operator']) && $row['tumblast_machine_operator'] != '') $tumblast_machine_operator = $row['tumblast_machine_operator'] ;
                         if(isset($row['shot_blastng_machine_operator']) && $row['shot_blastng_machine_operator'] != '') $shot_blastng_machine_operator = $row['shot_blastng_machine_operator'] ;
                         if(isset($row['ag4_machine_operator']) && $row['ag4_machine_operator'] != '') $ag4_machine_operator = $row['ag4_machine_operator'] ;
                         if(isset($row['contractor_grinding_machine_operator']) && $row['contractor_grinding_machine_operator'] != '') $contractor_grinding_machine_operator = $row['contractor_grinding_machine_operator'] ;
                         if(isset($row['company_grinding_machine_operator']) && $row['company_grinding_machine_operator'] != '') $company_grinding_machine_operator = $row['company_grinding_machine_operator'] ;
                         if(isset($row['painting_person']) && $row['painting_person'] != '') $painting_person = $row['painting_person'] ;
                         if(isset($row['factory_manager']) && $row['factory_manager'] != '') $factory_manager = $row['factory_manager'] ;
                    ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td>

                                <?php echo $row['heat_code']; ?>
                            </td>
                            <td class="text-center bg-success"><?php echo number_format($row['prod_qty'],0); ?></td>
                            <?php foreach($rejection_type_opt as $rej_typ){ 
                            $rej_qty = '';
                            $qc_id = '0';
                            if(in_array($rej_typ['rejection_type_id'],$rty_arry)){
                                $key = array_search($rej_typ['rejection_type_id'],$rty_arry);
                                $rej_qty = isset($rqty_arry[$key]) ? $rqty_arry[$key] : '-';
                                $qc_id = isset($qc_id_arry[$key]) ? $qc_id_arry[$key] : '0';
                            } 
                        ?>
                            <td class="text-center">
                                <input type="hidden"
                                    name="qc_inspection_id[<?php echo $row['melting_heat_log_id']?>][<?php echo $rej_typ['rejection_type_id']?>]"
                                    id="qc_inspection_id[<?php echo $row['melting_heat_log_id']?>][<?php echo $rej_typ['rejection_type_id']?>]"
                                    value="<?php echo $qc_id; ?>" />
                                <input type="text" step="any" class="form-control"
                                    name="rejection_qty[<?php echo $row['melting_heat_log_id']?>][<?php echo $rej_typ['rejection_type_id']?>]"
                                    id="rejection_qty[<?php echo $row['melting_heat_log_id']?>][<?php echo $rej_typ['rejection_type_id']?>]"
                                    value="<?php echo $rej_qty; ?>" style="width:70px;" />
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="<?php echo 3 + count($rejection_type_opt); ?>" class="text-center">No Records
                                Found
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="box box-info" style="margin-top:20px;">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-user"></i> Supervisor & Operators Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Shift Supervisor</label>
                                <?php echo form_dropdown('shift_supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('shift_supervisor',$shift_supervisor) ,' id="shift_supervisor" class="form-control"');?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tumblast Machine Operator</label>
                                <?php echo form_dropdown('tumblast_machine_operator',array('' => 'Select Tumblast Machine Operator') + $employee_opt ,set_value('tumblast_machine_operator',$tumblast_machine_operator) ,' id="tumblast_machine_operator" class="form-control"');?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Shot Blastng Machine Operator</label>
                                <?php echo form_dropdown('shot_blastng_machine_operator',array('' => 'Select Shot Blastng Machine Operator') + $employee_opt ,set_value('shot_blastng_machine_operator',$shot_blastng_machine_operator) ,' id="shot_blastng_machine_operator" class="form-control"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>AG4 Machine Operator</label>
                                <?php echo form_dropdown('ag4_machine_operator',array('' => 'Select AG4 Machine Operator') + $employee_opt ,set_value('ag4_machine_operator',$ag4_machine_operator) ,' id="ag4_machine_operator" class="form-control"');?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Contractor Grinding Machine Operator</label>
                                <?php echo form_dropdown('contractor_grinding_machine_operator',array('' => 'Contractor Grinding Machine Operator') + $employee_opt ,set_value('contractor_grinding_machine_operator',$contractor_grinding_machine_operator) ,' id="contractor_grinding_machine_operator" class="form-control"');?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Company Grinding Machine Operator</label>
                                <?php echo form_dropdown('company_grinding_machine_operator',array('' => 'Company Grinding Machine Operator') + $employee_opt ,set_value('company_grinding_machine_operator',$company_grinding_machine_operator) ,' id="company_grinding_machine_operator" class="form-control"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Painting Person</label>
                                <?php echo form_dropdown('painting_person',array('' => 'Select Painting Person') + $employee_opt ,set_value('painting_person',$painting_person) ,' id="painting_person" class="form-control"');?>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Factory Manager</label>
                                <?php echo form_dropdown('factory_manager',array('' => 'Select Factory Manager') + $employee_opt ,set_value('factory_manager',$factory_manager) ,' id="factory_manager" class="form-control"');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-success btn-save" name="btn-save" value="Save"><i
                        class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </form>
    <?php } ?>



</section>
 

<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>