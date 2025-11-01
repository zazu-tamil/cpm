<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Melting Log Sheet</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Melting Log Sheet</a></li> 
    <li class="active">Melting Log</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
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
        Melting Log Sheet
     </div>
    <div class="box-body table-responsive">  
        <?php if(!empty($leftout_list)) { ?>    
        <h4 class="text-fuchsia"><strong>Previous Shift Planning Leftout Info</strong></h4>
       <table class="table table-hover table-bordered table-responsive">
        <thead> 
            <tr>  
                <th>Planning Date</th>  
                <th>Shift</th>  
                <th>Customer</th>  
                <th>Customer PO No</th>  
                <th>Pattern</th>  
                <th>Plan Box</th> 
                <th>LeftOut Box</th> 
                <th class="text-center">Add Melting Log </th>  
            </tr> 
        </thead> 
        <tbody>
             <?php 
                   foreach($leftout_list as $wo_itm_id => $info){
                ?> 
                <tr class="bg-olive-active"> 
                    <td><?php echo date('d-m-Y', strtotime($info[0]['planning_date'])) ?></td>
                    <td><?php echo $info[0]['shift']?></td>  
                    <td><?php echo $info[0]['customer']?></td>  
                    <td><?php echo $info[0]['customer_PO_No']?></td>  
                    <td><?php echo $info[0]['match_plate_no']?>-<?php echo $info[0]['pattern_item']?></td>  
                    <td><?php echo $info[0]['planned_box']?></td> 
                    <td><?php echo $info[0]['leftout_box']?></td> 
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#add_modal" value="<?php echo $info[0]['work_planning_id']?>" class="add_record btn btn-warning btn-xs" title="Add Heat Code"><i class="fa fa-plus-circle"></i></button>
                    </td>                                  
                </tr>
                <tr class="bg-gray-active">
                    <td colspan="8">
                        <b>Melting Log Info</b>
                        <table class="table table-hover table-bordered table-striped table-responsive">
                        <thead> 
                            <tr>
                                <th>#</th> 
                                <th>Furnace On/Off Time</th>  
                                <th>Lining /Days Heat No</th>  
                                <th>Pouring Box	</th>  
                                <th>Tapp/Pour Temp</th>  
                                <th>First/Last Temp</th>  
                                <th>Start/End Units</th>  
                                <th>Ideal Hrs From/To </th>     
                                <th>Total Hrs</th>   
                                <th>Remarks</th>  
                                <th colspan="3" class="text-center">Action</th>  
                            </tr> 
                        </thead>
                        <tbody>
                           <?php
                               if(!empty($info[0]['melting_log_id'])) {
                                $tot['pouring_box'] = 0 ;
                               foreach($info as $j=> $ls){ 
                                $tot['pouring_box'] += $ls['pouring_box'];  ;
                            ?> 
                            <tr> 
                                <td class="text-center"><?php echo ($j + 1);?></td>  
                                <td><?php echo $ls['furnace_on_time']?><br /><?php echo $ls['furnace_off_time']?></td>  
                                <td><?php echo $ls['lining_heat_no']?><br /><span class="badge"><?php echo $ls['heat_code']. str_pad($ls['days_heat_no'],2,'0',STR_PAD_LEFT)?></span></td>  
                                <td class="text-right"><?php echo $ls['pouring_box']?></td>   
                                <td><?php echo $ls['tapp_temp']?><br /><?php echo $ls['pour_temp']?></td>  
                                <td><?php echo $ls['temp_first_box']?><br /><?php echo $ls['temp_last_box']?></td>  
                                <td><?php echo $ls['start_units']?><br /><?php echo $ls['end_units']?></td>  
                                <td><?php echo $ls['ideal_hrs_from']?><br /><?php echo $ls['ideal_hrs_to']?></td>  
                                <td><?php echo $ls['total_hrs']?></td> 
                                <td><?php echo $ls['remarks']?></td>  
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['melting_log_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                                </td>
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['melting_log_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                                </td> 
                                <td class="text-center"> 
                                    <button value="<?php echo $ls['melting_log_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                                </td>                                      
                            </tr>
                            <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><?php echo number_format($tot['pouring_box'],2);?></td>
                                    <td colspan="9"></td>
                                </tr>
                              <?php  }  ?>                                 
                        </tbody>
                        </table>
                        
                    </td>
                </tr>
                <?php
                    }
                ?>    
        </tbody>    
        </table>
       <hr />
       <?php } ?>
       <b>Shift Planning Info</b>
       <table class="table table-hover table-bordered table-responsive">
        <thead> 
            <tr>  
                <th>Planning Date</th>  
                <th>Shift</th>  
                <th>Customer</th>  
                <th>Customer PO No</th>  
                <th>Pattern</th>  
                <th>Plan Box</th> 
                <th class="text-center">Add Melting Log </th>  
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
                        <button data-toggle="modal" data-target="#add_modal" value="<?php echo $info[0]['work_planning_id']?>" class="add_record btn btn-primary btn-xs" title="Add Heat Code"><i class="fa fa-plus-circle"></i></button>
                    </td>                                  
                </tr>
                <tr class="bg-gray-active">
                    <td colspan="7">
                        <b>Melting Log Info</b>
                        <table class="table table-hover table-bordered table-striped table-responsive">
                        <thead> 
                            <tr>
                                <th>#</th> 
                                <th>Furnace On/Off Time</th>  
                                <th>Lining /Days Heat No</th>  
                                <th>Pouring Box	</th>  
                                <th>Tapp/Pour Temp</th>  
                                <th>First/Last Temp</th>  
                                <th>Start/End Units</th>  
                                <th>Ideal Hrs From/To </th>     
                                <th>Total Hrs</th>   
                                <th>Remarks</th>  
                                <th colspan="3" class="text-center">Action</th>  
                            </tr> 
                        </thead>
                        <tbody>
                           <?php
                               if(!empty($info[0]['melting_log_id'])) {
                                $tot['pouring_box'] = 0 ;
                               foreach($info as $j=> $ls){ 
                                $tot['pouring_box'] += $ls['pouring_box'];  ;
                            ?> 
                            <tr> 
                                <td class="text-center"><?php echo ($j + 1);?></td>  
                                <td><?php echo $ls['furnace_on_time']?><br /><?php echo $ls['furnace_off_time']?></td>  
                                <td><?php echo $ls['lining_heat_no']?><br /><span class="badge"><?php echo $ls['heat_code']. str_pad($ls['days_heat_no'],2,'0',STR_PAD_LEFT)?></span></td>  
                                <td class="text-right"><?php echo $ls['pouring_box']?></td>   
                                <td><?php echo $ls['tapp_temp']?><br /><?php echo $ls['pour_temp']?></td>  
                                <td><?php echo $ls['temp_first_box']?><br /><?php echo $ls['temp_last_box']?></td>  
                                <td><?php echo $ls['start_units']?><br /><?php echo $ls['end_units']?></td>  
                                <td><?php echo $ls['ideal_hrs_from']?><br /><?php echo $ls['ideal_hrs_to']?></td>  
                                <td><?php echo $ls['total_hrs']?></td> 
                                <td><?php echo $ls['remarks']?></td>  
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['melting_log_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                                </td>
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['melting_log_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                                </td> 
                                <td class="text-center"> 
                                    <button value="<?php echo $ls['melting_log_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                                </td>                                      
                            </tr>
                            <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><?php echo number_format($tot['pouring_box'],2);?></td>
                                    <td colspan="9"></td>
                                </tr>
                              <?php  }  ?>                                 
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
                        <h4 class="modal-title">Add Melting Log Info</h4>
                        <input type="hidden" name="mode" value="Add" />
                        <input type="hidden" name="work_planning_id" id="work_planning_id" value="" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-4">
                                <label for="core_plan_date">Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right " id="melting_date" name="melting_date" value="<?php echo $srch_date;?>" readonly="true">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Shift</label>
                                <input class="form-control" type="text" name="shift" id="shift" value="<?php echo $srch_shift; ?>" disabled="true">                                             
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Pattern Item</label>
                                <input class="form-control" type="text" name="pattern" id="pattern" value="" disabled="true">                                             
                             </div>
                         </div> 
                         <div class="row">   
                             <div class="form-group col-md-2">
                                <label>Furnace On Time</label>
                                <input class="form-control" type="time" name="furnace_on_time" id="furnace_on_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Furnace Off Time</label>
                                <input class="form-control" type="time" name="furnace_off_time" id="furnace_off_time" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Pouring Start Time</label>
                                <input class="form-control" type="time" name="pouring_start_time" id="pouring_start_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Pouring Finish Time</label>
                                <input class="form-control" type="time" name="pouring_finish_time" id="pouring_finish_time" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Total Time</label>
                                <input class="form-control" type="time" name="total_time" id="total_time" value="">                                             
                             </div>
                         </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                                <label>Lining Heat No</label>
                                <input class="form-control" type="text" name="lining_heat_no" id="lining_heat_no" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Heat Code</label>  
                                <input class="form-control" type="text" name="heat_code" id="heat_code" value="<?php echo $heat_code;?>" readonly="true">
                              </div> 
                             <div class="form-group col-md-2">
                                <label>Days Heat No	</label>
                                 <input class="form-control" type="text" name="days_heat_no" id="days_heat_no" value=""> 
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Pouring Box</label>
                                <input class="form-control" type="text" name="pouring_box" id="pouring_box" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Tapp Temp</label>
                                <input class="form-control" type="text" name="tapp_temp" id="tapp_temp" value="">                                             
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Pour Temp</label>
                                <input class="form-control" type="text" name="pour_temp" id="pour_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>First Box Temp</label>
                                <input class="form-control" type="text" name="temp_first_box" id="temp_first_box" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Last Box Temp</label>
                                <input class="form-control" type="text" name="temp_last_box" id="temp_last_box" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Start Units</label>
                                <input class="form-control" type="text" name="start_units" id="start_units" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>End Units</label>
                                <input class="form-control" type="text" name="end_units" id="end_units" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Boring</label>
                                <input class="form-control" type="text" name="boring" id="boring" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">  
                             
                             
                         </div>
                         <div class="row">  
                             <div class="form-group col-md-2">
                                <label>MS / LMS	</label>
                                <input class="form-control" type="text" name="ms" id="ms" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Foundry Return</label>
                                <input class="form-control" type="text" name="foundry_return" id="foundry_return" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>CI Scrap</label>
                                <input class="form-control" type="text" name="CI_scrap" id="CI_scrap" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Pig Iron	</label>
                                <input class="form-control" type="text" name="pig_iron" id="pig_iron" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>CP C / Shell C</label>
                                <input class="form-control" type="text" name="C" id="C" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Fe-Si</label>
                                <input class="form-control" type="text" name="SI" id="SI" value="">                                             
                             </div> 
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Fe-Mn</label>
                                <input class="form-control" type="text" name="Mn" id="Mn" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Fe-Si-Mg</label>
                                <input class="form-control" type="text" name="fe_si_mg" id="fe_si_mg" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Fe Sulphur</label>
                                <input class="form-control" type="text" name="fe_sulphur" id="fe_sulphur" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Inoculant</label>
                                <input class="form-control" type="text" name="inoculant" id="inoculant" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Pyrometer Tip</label>
                                <input class="form-control" type="text" name="pyrometer_tip" id="pyrometer_tip" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>S</label>
                                <input class="form-control" type="text" name="S" id="S" value="">                                             
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Cr</label>
                                <input class="form-control" type="text" name="Cr" id="Cr" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Cu</label>
                                <input class="form-control" type="text" name="Cu" id="Cu" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Ideal Hrs From</label>
                                <input class="form-control" type="time" name="ideal_hrs_from" id="ideal_hrs_from" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Ideal Hrs To	</label>
                                <input class="form-control" type="time" name="ideal_hrs_to" id="ideal_hrs_to" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Total Hrs</label>
                                <input class="form-control" type="time" name="total_hrs" id="total_hrs" value="">                                             
                             </div>
                         </div>
                         <div class="row">                              
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name</label>
                                <input class="form-control" type="text" name="pouring_person_name_1" id="pouring_person_name_1" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name</label>
                                <input class="form-control" type="text" name="pouring_person_name_2" id="pouring_person_name_2" value="">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name</label>
                                <input class="form-control" type="text" name="pouring_person_name_3" id="pouring_person_name_3" value="">                                             
                             </div>   
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-4">
                                <label>FC Operator</label>
                                <input class="form-control" type="text" name="fc_operator" id="fc_operator" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Helper Name</label>
                                <input class="form-control" type="text" name="helper_name" id="helper_name" value="">                                             
                             </div>  
                             <div class="form-group col-md-4"> 
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks"></textarea>
                            </div>   
                         </div>
                          
                          
                           
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" name="Save" value="Save"  class="btn btn-primary" />
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
                         <h4 class="modal-title">Edit Melting Log Info</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="melting_log_id" id="melting_log_id" />
                        <input type="hidden" name="work_planning_id" id="work_planning_id" value="" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-4">
                                <label for="core_plan_date">Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right " id="melting_date" name="melting_date" value="<?php echo $srch_date;?>" readonly="true">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Shift</label>
                                <input class="form-control" type="text" name="shift" id="shift" value="<?php echo $srch_shift; ?>" disabled="true">                                             
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Pattern Item</label>
                                <input class="form-control" type="text" name="pattern" id="pattern" value="" disabled="true">                                             
                             </div>
                         </div> 
                         <div class="row">   
                             <div class="form-group col-md-2">
                                <label>Furnace On Time</label>
                                <input class="form-control" type="time" name="furnace_on_time" id="furnace_on_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Furnace Off Time</label>
                                <input class="form-control" type="time" name="furnace_off_time" id="furnace_off_time" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Pouring Start Time</label>
                                <input class="form-control" type="time" name="pouring_start_time" id="pouring_start_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Pouring Finish Time</label>
                                <input class="form-control" type="time" name="pouring_finish_time" id="pouring_finish_time" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Total Time</label>
                                <input class="form-control" type="time" name="total_time" id="total_time" value="">                                             
                             </div>
                         </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                                <label>Lining Heat No</label>
                                <input class="form-control" type="text" name="lining_heat_no" id="lining_heat_no" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Heat Code</label>  
                                <input class="form-control" type="text" name="heat_code" id="heat_code" value="<?php echo $heat_code;?>" readonly="true">
                              </div> 
                             <div class="form-group col-md-2">
                                <label>Days Heat No	</label>
                                 <input class="form-control" type="text" name="days_heat_no" id="days_heat_no" value=""> 
                             </div>  
                             <div class="form-group col-md-3">
                                <label>Pouring Box</label>
                                <input class="form-control" type="text" name="pouring_box" id="pouring_box" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Tapp Temp</label>
                                <input class="form-control" type="text" name="tapp_temp" id="tapp_temp" value="">                                             
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Pour Temp</label>
                                <input class="form-control" type="text" name="pour_temp" id="pour_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>First Box Temp</label>
                                <input class="form-control" type="text" name="temp_first_box" id="temp_first_box" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Last Box Temp</label>
                                <input class="form-control" type="text" name="temp_last_box" id="temp_last_box" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Start Units</label>
                                <input class="form-control" type="text" name="start_units" id="start_units" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>End Units</label>
                                <input class="form-control" type="text" name="end_units" id="end_units" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Boring</label>
                                <input class="form-control" type="text" name="boring" id="boring" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">  
                             
                             
                         </div>
                         <div class="row">  
                             <div class="form-group col-md-2">
                                <label>MS / LMS	</label>
                                <input class="form-control" type="text" name="ms" id="ms" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Foundry Return</label>
                                <input class="form-control" type="text" name="foundry_return" id="foundry_return" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>CI Scrap</label>
                                <input class="form-control" type="text" name="CI_scrap" id="CI_scrap" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Pig Iron	</label>
                                <input class="form-control" type="text" name="pig_iron" id="pig_iron" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>CP C / Shell C</label>
                                <input class="form-control" type="text" name="C" id="C" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Fe-Si</label>
                                <input class="form-control" type="text" name="SI" id="SI" value="">                                             
                             </div> 
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Fe-Mn</label>
                                <input class="form-control" type="text" name="Mn" id="Mn" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Fe-Si-Mg</label>
                                <input class="form-control" type="text" name="fe_si_mg" id="fe_si_mg" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Fe Sulphur</label>
                                <input class="form-control" type="text" name="fe_sulphur" id="fe_sulphur" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Inoculant</label>
                                <input class="form-control" type="text" name="inoculant" id="inoculant" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Pyrometer Tip</label>
                                <input class="form-control" type="text" name="pyrometer_tip" id="pyrometer_tip" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>S</label>
                                <input class="form-control" type="text" name="S" id="S" value="">                                             
                             </div>
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Cr</label>
                                <input class="form-control" type="text" name="Cr" id="Cr" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Cu</label>
                                <input class="form-control" type="text" name="Cu" id="Cu" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Ideal Hrs From</label>
                                <input class="form-control" type="time" name="ideal_hrs_from" id="ideal_hrs_from" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Ideal Hrs To	</label>
                                <input class="form-control" type="time" name="ideal_hrs_to" id="ideal_hrs_to" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Total Hrs</label>
                                <input class="form-control" type="time" name="total_hrs" id="total_hrs" value="">                                             
                             </div>
                         </div>
                         <div class="row">                              
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name</label>
                                <input class="form-control" type="text" name="pouring_person_name_1" id="pouring_person_name_1" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name</label>
                                <input class="form-control" type="text" name="pouring_person_name_2" id="pouring_person_name_2" value="">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name</label>
                                <input class="form-control" type="text" name="pouring_person_name_3" id="pouring_person_name_3" value="">                                             
                             </div>   
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-4">
                                <label>FC Operator</label>
                                <input class="form-control" type="text" name="fc_operator" id="fc_operator" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Helper Name</label>
                                <input class="form-control" type="text" name="helper_name" id="helper_name" value="">                                             
                             </div>  
                             <div class="form-group col-md-4"> 
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks"></textarea>
                            </div>   
                         </div>
                           
                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" name="Save" value="Update"  class="btn btn-primary" />
                    </div> 
                    </form>
                </div>
            </div>
        </div>
        
       
        <div class="modal fade" id="view_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content"> 
                    <div class="modal-header">                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
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
