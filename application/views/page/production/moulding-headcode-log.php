<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
<section class="content-header">
    <h1>Moulding Log Sheet</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> Moulding Log</a></li>
        <li class="active">HeatCode Log</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
        </div>
        <div class="box-body">
            <form action="" method="post" id="frm">
                <div class="row">

                    <div class="col-sm-3 col-md-3">
                        <label>Planning Date</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker" id="srch_date"
                                name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="srch_customer">Shift</label>
                        <?php echo form_dropdown('srch_shift',array('' => 'Select Shift') + $shift_opt ,set_value('srch_shift',$srch_shift) ,' id="srch_shift" class="form-control"');?>
                    </div>

                    <div class="col-sm-3 col-md-2">
                        <br />
                        <button class="btn btn-info" type="submit">Show</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box box-success">
        <?php if(isset($work_planning_id)) { ?>
        <div class="box-header with-border">
            Moulding Log
        </div>
        <div class="box-body table-responsive"> <b>Shift Planning Info</b>
            <table class="table table-hover table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Planning Date</th>
                        <th>Shift</th>
                        <th>Customer</th>
                        <th>Customer PO No</th>
                        <th>Item Desc</th>
                        <th>Plan Box</th>
                        <th class="text-center">Add Log</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                   foreach($record_list as $wo_itm_id => $info){
                ?>
                    <tr class="bg-yellow-active">
                        <td><?php echo date('d-m-Y', strtotime($info[0]['planning_date'])) ?></td>
                        <td><?php echo $info[0]['shift']?></td>
                        <td><?php echo $info[0]['customer']?></td>
                        <td><?php echo $info[0]['customer_PO_No']?></td>
                        <td><?php echo $info[0]['match_plate_no']?>-<?php echo $info[0]['pattern_item']?></td>
                        <td><?php echo $info[0]['planned_box']?></td>
                        <td class="text-center">
                            <button data-toggle="modal" data-target="#add_modal"
                                value="<?php echo $info[0]['work_planning_id']?>"
                                class="add_record btn btn-primary btn-xs" title="Add Heat Code"><i
                                    class="fa fa-plus-circle"></i></button>
                        </td>
                    </tr>
                    <tr class="bg-gray-active">
                        <td colspan="7">
                            <b>Moulding Log Info</b>
                            <table class="table table-hover table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Production Hrs</th>
                                        <!-- <th>Prod.to Time</th> -->
                                        <!-- <th>Prod.from Time</th> -->
                                        <!-- <th>Brk.to Time</th>
                                        <th>Brk.from Time</th> -->
                                        <th>Breakdown Hrs</th>
                                        <th>Produced Box</th>
                                        <th>Man Hour</th>
                                        <th>Efficiency</th>
                                        <!--<th>Pouring Box	</th>  
                                <th>Planning Leftout Box</th>  
                                <th>Planning Leftout Remarks</th>  
                                <th>KnockOut Time</th>  -->
                                        <th>Remarks</th>
                                        <th colspan="3" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               if(!empty($info[0]['pattern_prod_to_time'])) {
                               foreach($info as $j=> $ls){
                            ?>
                                    <tr>
                                        <td class="text-center"><?php echo ($j + 1);?></td>
                                        <!-- <td><?php echo $ls['pattern_prod_to_time']?></td>
                                        <td><?php echo $ls['pattern_prod_from_time']?></td> -->
                                        <!-- <td><?php echo $ls['breakdown_to_time']?></td>
                                        <td><?php echo $ls['breakdown_from_time'] ?></td> -->
                                        <td><?php echo $ls['prod_hrs']?></td>
                                        <td><?php echo $ls['breakdown_hrs']?></td>
                                        <td><?php echo $ls['produced_box']?></td>
                                        <td><?php echo $ls['man_hr']?></td>
                                        <td><?php echo number_format($ls['eff'],2)?></td>
                                        <!--<td><?php echo $ls['pouring_box']?></td>   
                                <td class="text-center"><?php if($ls['leftout_box'] > 0) echo "<span class='label label-danger'>" . $ls['leftout_box']."</span>"; else echo $ls['leftout_box']?></td>  
                                <td><?php echo $ls['leftout_remarks']?></td>  
                                <td><?php echo $ls['knock_out_time']?></td>  -->
                                        <td><?php echo $ls['remarks']?></td>
                                        <?php if(($this->session->userdata('cr_is_admin') == 1 )|| (($this->session->userdata('cr_is_admin') != 1 ) && ($ls['days'] <= 3))) {  ?>
                                        <td class="text-center">
                                            <a href="<?php echo site_url('print-moulding-log-sheet/'. $ls['moulding_log_item_id']);?>"
                                                target="_blank" class="btn btn-xs btn-info"><i
                                                    class="fa fa-print"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <button data-toggle="modal" data-target="#edit_modal"
                                                value="<?php echo $ls['moulding_log_item_id']?>"
                                                class="edit_record btn btn-primary btn-xs" title="Edit"><i
                                                    class="fa fa-edit"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button value="<?php echo $ls['moulding_log_item_id']?>"
                                                class="del_record btn btn-danger btn-xs" title="Delete"><i
                                                    class="fa fa-remove"></i></button>
                                        </td>
                                        <?php } else { echo "<td colspan='2'></td>"; } ?>
                                    </tr>
                                    <?php
                                }
                                }
                            ?>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                    <?php
                    }
                ?>
                </tbody>
            </table>


            <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form method="post" action="" id="frmadd">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Add Moulding Log Sheet Info</h4>
                                <input type="hidden" name="mode" value="Add" />
                                <input type="hidden" name="work_planning_id" id="work_planning_id" value="" />
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="core_plan_date">Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right " id="moulding_date"
                                                name="moulding_date" value="<?php echo $srch_date;?>" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Shift</label>
                                        <input class="form-control" type="text" name="shift" id="shift"
                                            value="<?php echo $srch_shift; ?>" disabled="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Machine On Time</label>
                                        <input class="form-control" type="time" name="machine_on_time"
                                            id="machine_on_time" value="<?php echo $machine_on_time; ?>"
                                            required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Machine Off Time</label>
                                        <input class="form-control" type="time" name="machine_off_time"
                                            id="machine_off_time" value="<?php echo $machine_off_time; ?>">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Item Desc</label>
                                        <input class="form-control" type="text" name="pattern" id="pattern" value=""
                                            disabled="true">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Heat Code</label>
                                        <input class="form-control" type="text" name="heat_no" id="heat_no" value=""
                                            placeholder="Heat Code">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Production Date From</label>
                                        <input class="form-control" type="date" name="pattern_prod_from_datetime"
                                            id="pattern_prod_from_datetime" value="<?php echo $srch_date;?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Production Time From [<i class="text-red">24 Hrs</i>]</label>
                                        <div class="input-group">
                                            <input class="form-control timepicker" type="text"
                                                name="pattern_prod_from_time" id="pattern_prod_from_time" value="">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Production Date To</label>
                                        <input class="form-control" type="date" name="pattern_prod_to_datetime"
                                            id="pattern_prod_to_datetime" value="<?php echo $srch_date;?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Production Time To [<i class="text-red">24 Hrs</i>]</label>
                                        <div class="input-group">
                                            <input class="form-control timepicker" type="text"
                                                name="pattern_prod_to_time" id="pattern_prod_to_time" value="">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Breakdown Time From [<i class="text-red">24 Hrs</i>]</label>
                                        <input class="form-control" type="text" name="breakdown_from_time"
                                            id="breakdown_from_time" value="00:00:00" required="true" data-mask>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Breakdown Time To [<i class="text-red">24 Hrs</i>]</label>
                                        <input class="form-control" type="text" name="breakdown_to_time"
                                            id="breakdown_to_time" value="00:00:00" data-mask>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Breakdown Hour</label>
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="breakdown_hrs"
                                                id="breakdown_hrs" value="" readonly>
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Breakdown Remarks</label>
                                        <textarea class="form-control" name="breakdown_remarks" id="breakdown_remarks" placeholder="Breakdown Reason"></textarea>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>HRDS Top</label>
                                        <input class="form-control" type="text" name="moulding_hrd_top"
                                            id="moulding_hrd_top" value="" required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>HRDS Bottom</label>
                                        <input class="form-control" type="text" name="moulding_hrd_bottom"
                                            id="moulding_hrd_bottom" value="" required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Produced Box</label>
                                        <input class="form-control" type="text" name="produced_box" id="produced_box"
                                            value="" required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Closed Mould Qty</label>
                                        <input class="form-control" type="text" name="closed_mould_qty"
                                            id="closed_mould_qty" value="0" required="true">
                                    </div>
                                </div>
                                <h4>Moulding Check List</h4>
                                <div class="row p-2">
                                    <div class="form-group col-md-6">
                                        <label for="chk_pattern_condition">Pattern Condition( Loose mounting / Bush
                                            )</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_pattern_condition" value="1"
                                                    checked="true" /> Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_pattern_condition" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="chk_logo_identify">Logo & Idenfication Marks</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_logo_identify" value="1" checked="true" />
                                                Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_logo_identify" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="form-group col-md-6">
                                        <label for="chk_gating_sys_identify">Gating System Idenfication</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_gating_sys_identify" value="1"
                                                    checked="true" /> Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_gating_sys_identify" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="chk_mold_closing_status">Mold Closing Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_mold_closing_status" value="1"
                                                    checked="true" /> Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_mold_closing_status" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="form-group col-md-4">
                                        <label for="bottom_moulding_machine_operator">Bottom Moulding Machine
                                            Operator</label>
                                        <?php echo form_dropdown('bottom_moulding_machine_operator',array('' => 'Select Operator') + $employee_opt ,set_value('bottom_moulding_machine_operator',$bottom_moulding_machine_operator) ,' id="bottom_moulding_machine_operator" class="form-control" required');?>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="top_moulding_machine_operator">Top Moulding Machine Operator</label>
                                        <?php echo form_dropdown('top_moulding_machine_operator',array('' => 'Select Operator') + $employee_opt ,set_value('top_moulding_machine_operator',$top_moulding_machine_operator) ,' id="top_moulding_machine_operator" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="core_setter_name">Core Setter Name</label>
                                        <?php echo form_dropdown('core_setter_name',array('' => 'Select Operator') + $employee_opt ,set_value('core_setter_name',$core_setter_name) ,' id="core_setter_name" class="form-control" required');?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="mould_closer_name">Mould Closer Name</label>
                                        <?php echo form_dropdown('mould_closer_name',array('' => 'Select Operator') + $employee_opt ,set_value('mould_closer_name',$mould_closer_name) ,' id="mould_closer_name" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="mullar_operator_name">Mullar Operator Name</label>
                                        <?php echo form_dropdown('mullar_operator_name',array('' => 'Select Operator') + $employee_opt ,set_value('mullar_operator_name',$mullar_operator_name) ,' id="mullar_operator_name" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="supervisor">Supervisor</label>
                                        <?php echo form_dropdown('supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('supervisor',$supervisor) ,' id="supervisor" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="addt_other_operators">Additional Operators </label>
                                        <input class="form-control" type="number" name="addt_other_operators"
                                            id="addt_other_operators" value="<?php echo $addt_other_operators; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Modification Details in Pattern</label>
                                        <textarea class="form-control" name="modification_details"
                                            id="modification_details"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <input type="submit" name="Save" value="Save" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form method="post" action="" id="frmedit">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Edit Moulding - Head Code Info</h4>
                                <input type="hidden" name="mode" value="Edit" />
                                <input type="hidden" name="moulding_log_item_id" id="moulding_log_item_id" />
                                <input type="hidden" name="work_planning_id" id="work_planning_id" value="" />
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="core_plan_date">Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right " id="moulding_date"
                                                name="moulding_date" value="<?php echo $srch_date;?>" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Shift</label>
                                        <input class="form-control" type="text" name="shift" id="shift"
                                            value="<?php echo $srch_shift; ?>" disabled="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Machine On Time</label>
                                        <input class="form-control" type="time" name="machine_on_time"
                                            id="machine_on_time" value="<?php echo $machine_on_time; ?>"
                                            required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Machine Off Time</label>
                                        <input class="form-control" type="time" name="machine_off_time"
                                            id="machine_off_time" value="">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Item Desc</label>
                                        <input class="form-control" type="text" name="pattern" id="pattern" value=""
                                            disabled="true">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Heat Code</label>
                                        <input class="form-control" type="text" name="heat_no" id="heat_no" value=""
                                            placeholder="Heat Code">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Production Date From</label>
                                        <input class="form-control" type="date" name="pattern_prod_from_datetime"
                                            id="pattern_prod_from_datetime" value="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Production From Time [<i class="text-red">24 Hrs</i>]</label>
                                        <div class="input-group">
                                            <input class="form-control timepicker" type="text"
                                                name="pattern_prod_from_time" id="pattern_prod_from_time" value="">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Production Date To</label>
                                        <input class="form-control" type="date" name="pattern_prod_to_datetime"
                                            id="pattern_prod_to_datetime" value="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Production Time To [<i class="text-red">24 Hrs</i>]</label>
                                        <div class="input-group">
                                            <input class="form-control timepicker" type="text"
                                                name="pattern_prod_to_time" id="pattern_prod_to_time" value="">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Breakdown Time From [<i class="text-red">24 Hrs</i>]</label>
                                        <input class="form-control" type="text" name="breakdown_from_time"
                                            id="breakdown_from_time" value="00:00:00" required="true" data-mask>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Breakdown Time To [<i class="text-red">24 Hrs</i>]</label>
                                        <input class="form-control" type="text" name="breakdown_to_time"
                                            id="breakdown_to_time" value="00:00:00" data-mask>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Breakdown Hour</label>
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="breakdown_hrs"
                                                id="breakdown_hrs" value="" readonly>
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Breakdown Remarks</label>
                                        <textarea class="form-control" name="breakdown_remarks" id="breakdown_remarks" placeholder="Breakdown Reason"></textarea>
                                    </div> 
                                </div>
                                <div class="row">
                                     
                                    <div class="form-group col-md-3">
                                        <label>HRDS Top</label>
                                        <input class="form-control" type="text" name="moulding_hrd_top"
                                            id="moulding_hrd_top" value="" required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>HRDS Bottom</label>
                                        <input class="form-control" type="text" name="moulding_hrd_bottom"
                                            id="moulding_hrd_bottom" value="" required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Produced Box</label>
                                        <input class="form-control" type="text" name="produced_box" id="produced_box"
                                            value="" required="true">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Closed Mould Qty</label>
                                        <input class="form-control" type="text" name="closed_mould_qty"
                                            id="closed_mould_qty" value="0" required="true">
                                    </div>
                                </div>
                                <h4>Moulding Check List</h4>
                                <div class="row p-2">
                                    <div class="form-group col-md-6">
                                        <label for="chk_pattern_condition">Pattern Condition( Loose mounting / Bush
                                            )</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_pattern_condition" value="1"
                                                    checked="true" /> Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_pattern_condition" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="chk_logo_identify">Logo & Idenfication Marks</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_logo_identify" value="1" checked="true" />
                                                Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_logo_identify" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="form-group col-md-6">
                                        <label for="chk_gating_sys_identify">Gating System Idenfication</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_gating_sys_identify" value="1"
                                                    checked="true" /> Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_gating_sys_identify" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="chk_mold_closing_status">Mold Closing Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_mold_closing_status" value="1"
                                                    checked="true" /> Ok
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="chk_mold_closing_status" value="0" /> Not Ok
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="bottom_moulding_machine_operator">Bottom Moulding Machine
                                            Operator</label>
                                        <?php echo form_dropdown('bottom_moulding_machine_operator',array('' => 'Select Operator') + $employee_opt ,set_value('bottom_moulding_machine_operator',$bottom_moulding_machine_operator) ,' id="bottom_moulding_machine_operator" class="form-control" required');?>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="top_moulding_machine_operator">Top Moulding Machine Operator</label>
                                        <?php echo form_dropdown('top_moulding_machine_operator',array('' => 'Select Operator') + $employee_opt ,set_value('top_moulding_machine_operator',$top_moulding_machine_operator) ,' id="top_moulding_machine_operator" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="core_setter_name">Core Setter Name</label>
                                        <?php echo form_dropdown('core_setter_name',array('' => 'Select Operator') + $employee_opt ,set_value('core_setter_name',$core_setter_name) ,' id="core_setter_name" class="form-control" required');?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="mould_closer_name">Mould Closer Name</label>
                                        <?php echo form_dropdown('mould_closer_name',array('' => 'Select Operator') + $employee_opt ,set_value('mould_closer_name',$mould_closer_name) ,' id="mould_closer_name" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="mullar_operator_name">Mullar Operator Name</label>
                                        <?php echo form_dropdown('mullar_operator_name',array('' => 'Select Operator') + $employee_opt ,set_value('mullar_operator_name',$mullar_operator_name) ,' id="mullar_operator_name" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="supervisor">Supervisor</label>
                                        <?php echo form_dropdown('supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('supervisor',$supervisor) ,' id="supervisor" class="form-control" required');?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="addt_other_operators">Additional Operators </label>
                                        <input class="form-control" type="number" name="addt_other_operators"
                                            id="addt_other_operators" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Modification Details in Pattern</label>
                                        <textarea class="form-control" name="modification_details"
                                            id="modification_details"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <input type="submit" name="Save" value="Update" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="view_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body table-responsive">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="form-group col-sm-6">
                <label>Total Records : <?php echo count($record_list);?></label>
            </div>

        </div>
        <!-- /.box-footer-->
        <?php } else { echo "<div class='box-body'> <h3 class='alert alert-danger text-center'>No Planning Found<h3></div>"; } ?>


    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>