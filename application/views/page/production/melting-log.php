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
     <?php //if(isset($work_planning_id)) { ?> 
    <div class="box-header with-border"> 
        <h3 class="box-title"><strong>Melting Log Sheet</strong></h3>
        <span class="pull-right"><button data-toggle="modal" data-target="#add_modal" value="" class="add_record btn btn-success btn-md" title="Add Heat Code"><i class="fa fa-plus-circle"></i> Add Melting Log</button></span>
     </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-responsive">
        <thead> 
            <tr>  
                <th>#</th> 
                <th>Planning Date /Shift</th>  
                <th>Melting Date</th>  
                <th>Head No</th>  
                <th>Furnace Time</th>  
                <th>Pour Time</th>  
                <th>Units Consumed</th>  
                <th>Idle Hrs</th>  
                <th class="text-center">Chemical Composition </th>  
                <th colspan="3" class="text-center">Action </th>  
            </tr> 
        </thead> 
        <tbody>
             <?php 
                   foreach($record_list as $i => $info){
                ?> 
                <tr> 
                    <td><?php echo ($i + 1);?></td>
                    <td><?php echo date('d-m-Y', strtotime($info['planning_date'])) ?><br /><?php echo $info['shift']?></td>  
                    <td><?php echo date('d-m-Y', strtotime($info['planning_date'])) ?></td>  
                    <td><?php echo $info['heat_code']?><?php echo $info['days_heat_no']?></td>
                    <td><?php echo $info['furnace_time']?></td>
                    <td><?php echo $info['pouring_time']?></td>
                    <td><?php echo $info['units']?></td> 
                    <td><?php echo $info['ideal_hrs']?></td> 
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#add_modal_chemical" value="<?php echo $info['melting_heat_log_id']?>" class="add_chemical_log btn btn-primary btn-xs" title="Add Chemical Composition"><i class="fa fa-plus"></i></button>
                    </td>
                     
                    <td class="text-center">
                        <a href="<?php echo site_url('print-melting-log-sheet/'. $info['melting_heat_log_id']);?>" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-print"></i></a>
                    </td>
                    <?php if(($this->session->userdata('cr_is_admin') == 1 )|| (($this->session->userdata('cr_is_admin') != 1 ) && ($info['days'] <= 3))) {  ?>
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $info['melting_heat_log_id']?>" class="edit_record btn btn-primary btn-xs" title="Add Heat Code"><i class="fa fa-edit"></i></button>
                    </td>
                     <td class="text-center"> 
                        <button value="<?php echo $info['melting_heat_log_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td> 
                    <?php } else { echo "<td colspan='2'></td>"; } ?>                                     
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
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-4">
                                <label for="core_plan_date">Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right " id="planning_date" name="planning_date" value="<?php echo $srch_date;?>" readonly="true">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Shift</label>
                                <input class="form-control" type="text" name="shift" id="shift" value="<?php echo $srch_shift; ?>" readonly="true">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="core_plan_date">Melting Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right datepicker " id="melting_date" name="melting_date" value="<?php echo $srch_date;?>">
                                </div>                                     
                             </div>
                         </div> 
                         <div class="row">   
                             <div class="form-group col-md-3">
                                <label>Furnace On Time</label>
                                <input class="form-control" type="time" name="furnace_on_time" id="furnace_on_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Furnace Off Time</label>
                                <input class="form-control" type="time" name="furnace_off_time" id="furnace_off_time" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Pouring Start Time</label>
                                <input class="form-control" type="time" name="pouring_start_time" id="pouring_start_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Finish Time</label>
                                <input class="form-control" type="time" name="pouring_finish_time" id="pouring_finish_time" value="">                                             
                             </div> 
                         </div>
                         <div class="row">   
                              
                             <div class="form-group col-md-3">
                                <label>Breakdown Time From</label>
                                <input class="form-control" type="time" name="ideal_hrs_from" id="ideal_hrs_from" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Breakdown Time To	</label>
                                <input class="form-control" type="time" name="ideal_hrs_to" id="ideal_hrs_to" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Breakdown Hrs</label>
                                <input class="form-control" type="text" name="total_hrs" id="total_hrs" value="" readonly="true">                                             
                             </div> 
                              <div class="form-group col-md-4">
                                <label>Breakdown Reason</label>
                                <textarea class="form-control" name="breakdown_remarks" id="breakdown_remarks" placeholder="Breakdown Reason"></textarea>                                          
                             </div> 
                         </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                                <label>Lining Heat No</label>
                                <input class="form-control" type="text" name="lining_heat_no" id="lining_heat_no" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Heat Code</label>  
                                <input class="form-control" type="text" name="heat_code" id="heat_code" value="<?php echo $heat_code;?>">
                              </div> 
                             <div class="form-group col-md-2">
                                <label>Days Heat No	</label>
                                 <input class="form-control" type="text" name="days_heat_no" id="days_heat_no" value="<?php echo $days_heat_no; ?>"> 
                             </div>  
                             <div class="form-group col-md-2">
                                <label>Tapp Temp</label>
                                <input class="form-control" type="text" name="tapp_temp" id="tapp_temp" value="">                                             
                             </div>
                             <!--<div class="form-group col-md-2">
                                <label>Pour Temp</label>
                                <input class="form-control" type="text" name="pour_temp" id="pour_temp" value="">                                             
                             </div>-->
                         </div>
                         <div class="row"> 
                             
                             <div class="form-group col-md-3">
                                <label>Ladle 1 First Box Temp</label>
                                <input class="form-control" type="text" name="ladle_1_first_box_pour_temp" id="ladle_1_first_box_pour_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Ladle 2 First Temp</label>
                                <input class="form-control" type="text" name="ladle_2_first_box_pour_temp" id="ladle_2_first_box_pour_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Start Units</label>
                                <input class="form-control" type="text" name="start_units" id="start_units" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>End Units</label>
                                <input class="form-control" type="text" name="end_units" id="end_units" value="">                                             
                             </div>
                              
                         </div> 
                        <hr />
                         <div class="row">  
                             <div class="form-group col-md-2">
                                <label>Pig Iron	</label>
                                <input class="form-control" type="text" name="pig_iron" id="pig_iron" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Foundry Return</label>
                                <input class="form-control" type="text" name="foundry_return" id="foundry_return" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>MS / LMS	</label>
                                <input class="form-control" type="text" name="ms" id="ms" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Spillage</label>
                                <input class="form-control" type="text" name="spillage" id="spillage" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>CI Boring</label>
                                <input class="form-control" type="text" name="boring" id="boring" value="0">                                             
                             </div>  
                             <div class="form-group col-md-2">
                                <label>CI Scrap</label>
                                <input class="form-control" type="text" name="CI_scrap" id="CI_scrap" value="0">                                             
                             </div>
                            
                             
                         </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                                <label>CP C / Shell C</label>
                                <input class="form-control" type="text" name="C" id="C" value="0">                                             
                             </div>   
                             <div class="form-group col-md-2">
                                <label>Fe-Mn</label>
                                <input class="form-control" type="text" name="Mn" id="Mn" value="0">                                             
                             </div>   
                             <div class="form-group col-md-2">
                                <label>Fe-Si</label>
                                <input class="form-control" type="text" name="SI" id="SI" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Inoculant</label>
                                <input class="form-control" type="text" name="inoculant" id="inoculant" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Fe Sulphur</label>
                                <input class="form-control" type="text" name="fe_sulphur" id="fe_sulphur" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Fe-Si-Mg</label>
                                <input class="form-control" type="text" name="fe_si_mg" id="fe_si_mg" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Cu</label>
                                <input class="form-control" type="text" name="Cu" id="Cu" value="0">                                             
                             </div>   
                            <div class="form-group col-md-2">
                                <label>Pyrometer Tip</label>
                                <input class="form-control" type="text" name="pyrometer_tip" id="pyrometer_tip" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>S</label>
                                <input class="form-control" type="text" name="S" id="S" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Cr</label>
                                <input class="form-control" type="text" name="Cr" id="Cr" value="0">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Graphite Coke</label>
                                <input class="form-control" type="text" name="graphite_coke" id="graphite_coke" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Ni</label>
                                <input class="form-control" type="text" name="ni" id="ni" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Mo</label>
                                <input class="form-control" type="text" name="mo" id="mo" value="0">                                             
                             </div>
                         </div>
                         <hr />
                         <!--<div class="row"> 
                            <div class="form-group col-md-12">
                                <caption>Chemical Composition</caption>
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>C%</th>
                                        <th>Si%</th>
                                        <th>Mn%</th>
                                        <th>P%</th>
                                        <th>S%</th>
                                        <th>Cr%</th>
                                        <th>Cu%</th>
                                        <th>Mg%</th> 
                                    </tr>
                                    <tr>
                                        <td>Base</td>
                                        <td><input type="text" name="b_c" id="b_c" class="form-control" /></td>
                                        <td><input type="text" name="b_si" id="b_si" class="form-control" /></td>
                                        <td><input type="text" name="b_mn" id="b_mn" class="form-control" /></td>
                                        <td><input type="text" name="b_p" id="b_p" class="form-control" /></td>
                                        <td><input type="text" name="b_s" id="b_s" class="form-control" /></td>
                                        <td><input type="text" name="b_cr" id="b_cr" class="form-control" /></td>
                                        <td><input type="text" name="b_cu" id="b_cu" class="form-control" /></td>
                                        <td><input type="text" name="b_mg" id="b_mg" class="form-control" /></td>
                                         
                                    </tr>
                                    <tr>
                                        <td>Final</td>
                                        <td><input type="text" name="f_c" id="f_c" class="form-control" /></td>
                                        <td><input type="text" name="f_si" id="f_si" class="form-control" /></td>
                                        <td><input type="text" name="f_mn" id="f_mn" class="form-control" /></td>
                                        <td><input type="text" name="f_p" id="f_p" class="form-control" /></td>
                                        <td><input type="text" name="f_s" id="f_s" class="form-control" /></td>
                                        <td><input type="text" name="f_cr" id="f_cr" class="form-control" /></td>
                                        <td><input type="text" name="f_cu" id="f_cu" class="form-control" /></td>
                                        <td><input type="text" name="f_mg" id="f_mg" class="form-control" /></td> 
                                    </tr>
                                </table>
                            </div>
                             
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-3">
                                <label>Hardness BHN</label>
                                <input class="form-control" type="text" name="f_bmn" id="f_bmn" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Tensile Strength N/MM<sup>2</sup></label>
                                <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Yield Strength N/MM<sup>2</sup></label>
                                <input class="form-control" type="text" name="yield_strength" id="yield_strength" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Elongation %</label>
                                <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                             </div>
                            
                         </div> 
                         <hr />-->
                         <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive table-striped">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Cust PO No</th>
                                        <th>Item Desc</th>
                                        <td>Planned Box</td>
                                        <td>Poured Box</td>
                                        <td>Pouring Box</td>
                                        <td>LeftOut Box</td>
                                        <td>LeftOut Box Close</td>
                                    </tr>
                                    <?php foreach($work_planning_itms as $i => $itm) {?>
                                    <tr>
                                         <td><?php echo ($i+1)?></td>
                                         <td><?php echo $itm['customer_PO_No'];?></td>
                                         <td><?php echo $itm['pattern_item'];?> <i class="fa fa-info-circle btninfo" data-toggle="popover" title="MJP" data-content="" data="<?php echo $itm['pattern_id'];?>"></i></td>
                                         <td><?php echo $itm['planned_box'];?> </td>
                                         <td><?php echo $itm['poured_box'];?></td>
                                         <td><input type="text" class="form-control" name="work_plan_id[<?php echo $itm['work_planning_id'];?>]" value="0"  /></td>
                                         <td><input type="text" class="form-control" name="leftout_box[<?php echo $itm['work_planning_id'];?>]" value="0"  /></td>
                                         <td class="text-center"><input type="checkbox" class="" name="leftout_box_close[<?php echo $itm['work_planning_id'];?>]" value="1"  /></td>
                                    </tr>
                                    <?php } ?>
                                    </table>
                                    <br />
                                    <caption>Leftout Box</caption>
                                    <table class="table table-bordered table-responsive table-striped">
                                    <?php if(!empty($leftout_itms)) {?>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Cust PO No</th>
                                        <th>Item Desc</th>
                                        <td>Pouring Box</td>
                                        <td>LeftOut Box</td> 
                                    </tr>
                                     <?php foreach($leftout_itms as $i => $itm_lf) {?>
                                    <tr>
                                         <td><?php echo ($i+1)?></td>
                                         <td><?php echo $itm_lf['customer_PO_No'];?></td>
                                         <td><?php echo $itm_lf['pattern_item'];?> <i class="fa fa-info-circle btninfo" data-toggle="popover" title="MJP" data-content="" data="<?php echo $itm_lf['pattern_id'];?>"></i>
											<br />Leftout on <?php echo $itm_lf['leftout_date'];?><br /><?php echo $itm_lf['leftout_box'];?>
										</td>
                                         <td>
                                         <input type="hidden" class="form-control" name="cf_melting_heat_log_id[<?php echo $itm_lf['work_planning_id'];?>]" value="<?php echo $itm_lf['melting_heat_log_id'];?>"  />
                                         
                                         <input type="text" class="form-control" name="lf_work_plan_id[<?php echo $itm_lf['work_planning_id'];?>]" value=""  /></td>
                                         <td><input type="text" class="form-control" name="lf_leftout_box[<?php echo $itm_lf['work_planning_id'];?>]" value=""  /></td>
                                          
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                         </div> 
                         <hr />
                         <div class="row">                              
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name - 1</label>
                                <?php echo form_dropdown('pouring_person_name_1',array('' => 'Select Employee') + $employee_opt ,set_value('pouring_person_name_1',$pouring_person_name_1) ,' id="pouring_person_name_1" class="form-control" required');?>
                                                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name - 2</label>
                                <?php echo form_dropdown('pouring_person_name_2',array('' => 'Select Employee') + $employee_opt ,set_value('pouring_person_name_2',$pouring_person_name_2) ,' id="pouring_person_name_2" class="form-control" required');?>                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name - 3</label>
                                <?php echo form_dropdown('pouring_person_name_3',array('' => 'Select Employee') + $employee_opt ,set_value('pouring_person_name_3',$pouring_person_name_3) ,' id="pouring_person_name_3" class="form-control"');?>                                            
                             </div>   
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>FC Operator</label>  
                                <?php echo form_dropdown('fc_operator',array('' => 'Select Employee') + $employee_opt ,set_value('fc_operator',$fc_operator) ,' id="fc_operator" class="form-control" required');?>                                            
                             </div>
                             <div class="form-group col-md-3">
                                <label>Helper Name</label>
                                <?php echo form_dropdown('helper_name',array('' => 'Select Employee') + $employee_opt ,set_value('helper_name',$helper_name) ,' id="helper_name" class="form-control" required');?>
                             </div>  
                             <div class="form-group col-md-3">
                                <label for="supervisor">Supervisor</label>
                                <?php echo form_dropdown('supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('supervisor',$supervisor) ,' id="supervisor" class="form-control" required');?>                                    
                             </div> 
                             <div class="form-group col-md-3"> 
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
                        <input type="hidden" name="melting_heat_log_id" id="melting_heat_log_id" /> 
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-4">
                                <label for="core_plan_date">Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right " id="planning_date" name="planning_date" value="<?php echo $srch_date;?>" readonly="true">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Shift</label>
                                <input class="form-control" type="text" name="shift" id="shift" value="<?php echo $srch_shift; ?>" readonly="true">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="core_plan_date">Melting Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right " id="melting_date" name="melting_date" value="<?php echo $srch_date;?>">
                                </div>                                     
                             </div>
                         </div> 
                         <div class="row">   
                             <div class="form-group col-md-3">
                                <label>Furnace On Time</label>
                                <input class="form-control" type="time" name="furnace_on_time" id="furnace_on_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Furnace Off Time</label>
                                <input class="form-control" type="time" name="furnace_off_time" id="furnace_off_time" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Pouring Start Time</label>
                                <input class="form-control" type="time" name="pouring_start_time" id="pouring_start_time" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Finish Time</label>
                                <input class="form-control" type="time" name="pouring_finish_time" id="pouring_finish_time" value="">                                             
                             </div> 
                         </div>
                         <div class="row">   
                              
                             <div class="form-group col-md-3">
                                <label>Breakdown Time From</label>
                                <input class="form-control" type="time" name="ideal_hrs_from" id="ideal_hrs_from" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Breakdown Time To	</label>
                                <input class="form-control" type="time" name="ideal_hrs_to" id="ideal_hrs_to" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Breakdown Hrs</label>
                                <input class="form-control" type="text" name="total_hrs" id="total_hrs" value="" readonly="true">                                             
                             </div> 
                              <div class="form-group col-md-4">
                                <label>Breakdown Reason</label>
                                <textarea class="form-control" name="breakdown_remarks" id="breakdown_remarks" placeholder="Breakdown Reason"></textarea>                                          
                             </div> 
                         </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                                <label>Lining Heat No</label>
                                <input class="form-control" type="text" name="lining_heat_no" id="lining_heat_no" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Heat Code</label>  
                                <input class="form-control" type="text" name="heat_code" id="heat_code" value="<?php echo $heat_code;?>">
                              </div> 
                             <div class="form-group col-md-2">
                                <label>Days Heat No	</label>
                                 <input class="form-control" type="text" name="days_heat_no" id="days_heat_no" value="<?php echo $days_heat_no; ?>"> 
                             </div> 
                              
                             <div class="form-group col-md-2">
                                <label>Tapp Temp</label>
                                <input class="form-control" type="text" name="tapp_temp" id="tapp_temp" value="">                                             
                             </div>
                             <!--<div class="form-group col-md-2">
                                <label>Pour Temp</label>
                                <input class="form-control" type="text" name="pour_temp" id="pour_temp" value="">                                             
                             </div>-->
                         </div>
                         <div class="row"> 
                             
                             <div class="form-group col-md-3">
                                <label>Ladle 1 First Box Temp</label>
                                <input class="form-control" type="text" name="ladle_1_first_box_pour_temp" id="ladle_1_first_box_pour_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Ladle 2 First Temp</label>
                                <input class="form-control" type="text" name="ladle_2_first_box_pour_temp" id="ladle_2_first_box_pour_temp" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Start Units</label>
                                <input class="form-control" type="text" name="start_units" id="start_units" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>End Units</label>
                                <input class="form-control" type="text" name="end_units" id="end_units" value="">                                             
                             </div>
                              
                         </div> 
                        <hr />
                         <div class="row">  
                             <div class="form-group col-md-2">
                                <label>Pig Iron	</label>
                                <input class="form-control" type="text" name="pig_iron" id="pig_iron" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Foundry Return</label>
                                <input class="form-control" type="text" name="foundry_return" id="foundry_return" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>MS / LMS	</label>
                                <input class="form-control" type="text" name="ms" id="ms" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Spillage</label>
                                <input class="form-control" type="text" name="spillage" id="spillage" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>CI Boring</label>
                                <input class="form-control" type="text" name="boring" id="boring" value="">                                             
                             </div>  
                             <div class="form-group col-md-2">
                                <label>CI Scrap</label>
                                <input class="form-control" type="text" name="CI_scrap" id="CI_scrap" value="">                                             
                             </div>
                            
                             
                         </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                                <label>CP C / Shell C</label>
                                <input class="form-control" type="text" name="C" id="C" value="">                                             
                             </div>   
                             <div class="form-group col-md-2">
                                <label>Fe-Mn</label>
                                <input class="form-control" type="text" name="Mn" id="Mn" value="">                                             
                             </div>   
                             <div class="form-group col-md-2">
                                <label>Fe-Si</label>
                                <input class="form-control" type="text" name="SI" id="SI" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Inoculant</label>
                                <input class="form-control" type="text" name="inoculant" id="inoculant" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Fe Sulphur</label>
                                <input class="form-control" type="text" name="fe_sulphur" id="fe_sulphur" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Fe-Si-Mg</label>
                                <input class="form-control" type="text" name="fe_si_mg" id="fe_si_mg" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Cu</label>
                                <input class="form-control" type="text" name="Cu" id="Cu" value="">                                             
                             </div>   
                            <div class="form-group col-md-2">
                                <label>Pyrometer Tip</label>
                                <input class="form-control" type="text" name="pyrometer_tip" id="pyrometer_tip" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>S</label>
                                <input class="form-control" type="text" name="S" id="S" value="">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Cr</label>
                                <input class="form-control" type="text" name="Cr" id="Cr" value="">                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Graphite Coke</label>
                                <input class="form-control" type="text" name="graphite_coke" id="graphite_coke" value="0">                                             
                             </div>
                              <div class="form-group col-md-2">
                                <label>Ni</label>
                                <input class="form-control" type="text" name="ni" id="ni" value="0">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Mo</label>
                                <input class="form-control" type="text" name="mo" id="mo" value="0">                                             
                             </div>
                         </div>
                         <hr />
                         <!--<div class="row"> 
                            <div class="form-group col-md-12">
                                <caption>Chemical Composition</caption>
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>C%</th>
                                        <th>Si%</th>
                                        <th>Mn%</th>
                                        <th>P%</th>
                                        <th>S%</th>
                                        <th>Cr%</th>
                                        <th>Cu%</th>
                                        <th>Mg%</th> 
                                    </tr>
                                    <tr>
                                        <td>Base</td>
                                        <td><input type="text" name="b_c" id="b_c" class="form-control" /></td>
                                        <td><input type="text" name="b_si" id="b_si" class="form-control" /></td>
                                        <td><input type="text" name="b_mn" id="b_mn" class="form-control" /></td>
                                        <td><input type="text" name="b_p" id="b_p" class="form-control" /></td>
                                        <td><input type="text" name="b_s" id="b_s" class="form-control" /></td>
                                        <td><input type="text" name="b_cr" id="b_cr" class="form-control" /></td>
                                        <td><input type="text" name="b_cu" id="b_cu" class="form-control" /></td>
                                        <td><input type="text" name="b_mg" id="b_mg" class="form-control" /></td> 
                                    </tr>
                                    <tr>
                                        <td>Final</td>
                                        <td><input type="text" name="f_c" id="f_c" class="form-control" /></td>
                                        <td><input type="text" name="f_si" id="f_si" class="form-control" /></td>
                                        <td><input type="text" name="f_mn" id="f_mn" class="form-control" /></td>
                                        <td><input type="text" name="f_p" id="f_p" class="form-control" /></td>
                                        <td><input type="text" name="f_s" id="f_s" class="form-control" /></td>
                                        <td><input type="text" name="f_cr" id="f_cr" class="form-control" /></td>
                                        <td><input type="text" name="f_cu" id="f_cu" class="form-control" /></td>
                                        <td><input type="text" name="f_mg" id="f_mg" class="form-control" /></td> 
                                    </tr>
                                </table>
                            </div> 
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-3">
                                <label>Hardness BHN</label>
                                <input class="form-control" type="text" name="f_bmn" id="f_bmn" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Tensile Strength N/MM<sup>2</sup></label>
                                <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Yield Strength N/MM<sup>2</sup></label>
                                <input class="form-control" type="text" name="yield_strength" id="yield_strength" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Elongation %</label>
                                <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                             </div>
                         </div> 
                         <hr />-->
                         <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive table-striped">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Cust PO No</th>
                                        <th>Item Desc</th>
                                        <td>Pouring Box</td>
                                        <td>LeftOut Box</td>
                                        <td>LeftOut Box Close</td>
                                    </tr>
                                    <?php  $k =0; foreach($work_planning_itms as $i => $itm) {  
                                    if(!in_array($itm['work_planning_id'],$melting_work_planning_ids)) {   $k++;
                                    ?>
                                    <tr>
                                         <td><?php echo ($k)?></td>
                                         <td><?php echo $itm['customer_PO_No'];?></td>
                                         <td><?php echo $itm['pattern_item'];?> <i class="fa fa-info-circle btninfo" data-toggle="popover" title="MJP" data-content="" data="<?php echo $itm['pattern_id'];?>"></i></td>
                                         <td><input type="text" class="form-control" name="work_plan_id[<?php echo $itm['work_planning_id'];?>]" value="0"  /></td>
                                         <td><input type="text" class="form-control" name="leftout_box[<?php echo $itm['work_planning_id'];?>]" value="0"  /></td>
                                         <td class="text-center"><input type="checkbox" class="" name="leftout_box_close[<?php echo $itm['work_planning_id'];?>]" value="1"  /></td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                 </table>
                                 <br />
                                 <table class="table table-bordered table-responsive table-striped">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Cust PO No</th>
                                        <th>Item Desc</th>
                                        <td>Pouring Box</td>
                                        <td>LeftOut Box</td>
                                        <td>LeftOut Box Close</td>
                                    </tr>   
                                    <?php foreach($work_planning_itms_lft as $i => $itm) {?>
                                    <tr>
                                         <td><?php echo ($i+1)?></td>
                                         <td><?php echo $itm['customer_PO_No'];?></td>
                                         <td><?php echo $itm['pattern_item'];?> <i class="fa fa-info-circle btninfo" data-toggle="popover" title="MJP" data-content="" data="<?php echo $itm['pattern_id'];?>"></i></td>
                                         <td>
                                            <input type="hidden" class="form-control edit_input" name="ed_cf_melting_heat_log_id[<?php echo $itm['work_planning_id'];?>]" value="0"  />
                                            <input type="text" class="form-control edit_input" name="work_plan_id[<?php echo $itm['work_planning_id'];?>]" value="0"  />
                                         </td>
                                         <td><input type="text" class="form-control edit_input" name="leftout_box[<?php echo $itm['work_planning_id'];?>]" value="0"  /></td>
                                         <td class="text-center"><input type="checkbox" class="" name="leftout_box_close[<?php echo $itm['work_planning_id'];?>]" value="1"  /></td>
                                    </tr>
                                    <?php } ?>
                                    </table>
                                    <?php if(!empty($leftout_itms)) {?>
                                    <br />
                                    <caption>Carry Forward Leftout Box</caption>
                                    <table class="table table-bordered table-responsive table-striped">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Cust PO No</th>
                                        <th>Item Desc</th>
                                        <td>Pouring Box</td>
                                        <td>LeftOut Box</td>
                                    </tr>
                                     <?php foreach($leftout_itms as $i => $itm_lf) {?>
                                    <tr>
                                         <td><?php echo ($i+1)?></td>
                                         <td><?php echo $itm_lf['customer_PO_No'];?></td>
                                         <td><?php echo $itm_lf['pattern_item'];?>
										 <i class="fa fa-info-circle btninfo" data-toggle="popover" title="MJP" data-content="" data="<?php echo $itm_lf['pattern_id'];?>"></i>
										 <br />Leftout on <?php echo $itm_lf['leftout_date'];?><br /><?php echo $itm_lf['leftout_box'];?></td>
                                         <td>
                                            <input type="hidden" class="form-control" name="cf_melting_heat_log_id[<?php echo $itm_lf['work_planning_id'];?>]" value="<?php echo $itm_lf['melting_heat_log_id'];?>"  />
                                            <input type="text" class="form-control" name="lf_work_plan_id[<?php echo $itm_lf['work_planning_id'];?>]" value="0"  />
                                         </td>
                                         <td><input type="text" class="form-control" name="lf_leftout_box[<?php echo $itm_lf['work_planning_id'];?>]" value="0"  /></td>
                                    </tr>
                                    <?php } ?>
                                    
                                </table>
                                <?php } ?>
                            </div>
                         </div> 
                         <hr />
                         <div class="row">                              
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name - 1</label>
                                <?php echo form_dropdown('pouring_person_name_1',array('' => 'Select Employee') + $employee_opt ,set_value('pouring_person_name_1') ,' id="pouring_person_name_1" class="form-control" required');?>
                                                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name - 2</label>
                                <?php echo form_dropdown('pouring_person_name_2',array('' => 'Select Employee') + $employee_opt ,set_value('pouring_person_name_2') ,' id="pouring_person_name_2" class="form-control" required');?>                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Pouring Person Name - 3</label>
                                <?php echo form_dropdown('pouring_person_name_3',array('' => 'Select Employee') + $employee_opt ,set_value('pouring_person_name_3') ,' id="pouring_person_name_3" class="form-control"');?>                                            
                             </div>   
                         </div>
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>FC Operator</label>  
                                <?php echo form_dropdown('fc_operator',array('' => 'Select Employee') + $employee_opt ,set_value('fc_operator') ,' id="fc_operator" class="form-control" required');?>                                            
                             </div>
                             <div class="form-group col-md-3">
                                <label>Helper Name</label>
                                <?php echo form_dropdown('helper_name',array('' => 'Select Employee') + $employee_opt ,set_value('helper_name') ,' id="helper_name" class="form-control" required');?>
                             </div>  
                             <div class="form-group col-md-3">
                                <label for="supervisor">Supervisor</label>
                                <?php echo form_dropdown('supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('supervisor',$supervisor) ,' id="supervisor" class="form-control" required');?>                                    
                             </div>  
                             <div class="form-group col-md-3"> 
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
                    <div class="modal-body table-responsive ">
                        <span class="master"></span>
                        <b>Melting Poured Items</b><br /> 
                        <span class="child"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  
                    </div>  
                </div>
            </div>
        </div> 
        
        <div class="modal fade" id="add_modal_chemical" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmaddchem">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!--<h4 class="modal-title">Melting Log Chemical Composition Info</h4>-->
                        <input type="hidden" name="tbl" value="melting_item_chemical_info" />  
                        <input type="hidden" name="melting_heat_log_id" id="melting_heat_log_id" value="" />  
                        <input type="hidden" name="melting_item_chemical_id" id="melting_item_chemical_id" value="" />
						<table class="table table-condensed table-bordered " id="content-table"> 
                        <tr>
                            <th width="30%" class="text-center"><h2>MJP</h2> </th>
                            <th class="text-center"><h3>Chemical Composition & Hardness Record</h3></b>
                            <th width="30%" class="text-left"><b><?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?></b></th>
                        </tr>
                        </table>		
                    </div>
                    <div class="modal-body">  
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label>Pattern Item </label>
                                <?php echo form_dropdown('melting_item_id',array('' => 'Select Item') ,set_value('melting_item_id') ,' id="melting_item_id" class="form-control" required');?>
                             </div>
                             <div class="form-group col-md-6">
                                <label>Mode</label>
                                  <input type="text" class="form-control" name="mode" id="mode" value="Add Chemical Log" readonly="true" />   
                             </div>
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-12">
                                <caption>Chemical Composition</caption>
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>C%</th>
                                        <th>Si%</th>
                                        <th>Mn%</th>
                                        <th>P%</th>
                                        <th>S%</th>
                                        <th>Cr%</th>
                                        <th>Cu%</th>
                                        <th>Mg%</th> 
                                        <th>Ni%</th> 
                                        <th>Mo%</th> 
                                    </tr>
                                    <tr>
                                        <td>Master</td>
                                        <td><input type="text" name="m_c" id="m_c" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_si" id="m_si" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_mn" id="m_mn" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_p" id="m_p" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_s" id="m_s" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_cr" id="m_cr" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_cu" id="m_cu" class="form-control" readonly="true" /></td>
                                        <td><input type="text" name="m_mg" id="m_mg" class="form-control" readonly="true" /></td> 
                                        <td><input type="text" name="m_ni" id="m_ni" class="form-control" readonly="true" /></td> 
                                        <td><input type="text" name="m_mo" id="m_mo" class="form-control" readonly="true" /></td> 
                                    </tr>
                                    <tr>
                                        <td>Base</td>
                                        <td><input type="text" name="b_c" id="b_c" class="form-control" /></td>
                                        <td><input type="text" name="b_si" id="b_si" class="form-control" /></td>
                                        <td><input type="text" name="b_mn" id="b_mn" class="form-control" /></td>
                                        <td><input type="text" name="b_p" id="b_p" class="form-control" /></td>
                                        <td><input type="text" name="b_s" id="b_s" class="form-control" /></td>
                                        <td><input type="text" name="b_cr" id="b_cr" class="form-control" /></td>
                                        <td><input type="text" name="b_cu" id="b_cu" class="form-control" /></td>
                                        <td><input type="text" name="b_mg" id="b_mg" class="form-control" /></td> 
                                        <td><input type="text" name="b_ni" id="b_ni" class="form-control" /></td> 
                                        <td><input type="text" name="b_mo" id="b_mo" class="form-control" /></td> 
                                    </tr>
                                    <tr>
                                        <td>Final - 1</td>
                                        <td><input type="text" name="f_c" id="f_c" class="form-control" /></td>
                                        <td><input type="text" name="f_si" id="f_si" class="form-control" /></td>
                                        <td><input type="text" name="f_mn" id="f_mn" class="form-control" /></td>
                                        <td><input type="text" name="f_p" id="f_p" class="form-control" /></td>
                                        <td><input type="text" name="f_s" id="f_s" class="form-control" /></td>
                                        <td><input type="text" name="f_cr" id="f_cr" class="form-control" /></td>
                                        <td><input type="text" name="f_cu" id="f_cu" class="form-control" /></td>
                                        <td><input type="text" name="f_mg" id="f_mg" class="form-control" /></td> 
                                        <td><input type="text" name="f_ni" id="f_ni" class="form-control" /></td> 
                                        <td><input type="text" name="f_mo" id="f_mo" class="form-control" /></td> 
                                    </tr>
                                    <tr>
                                        <td>Final - 2</td>
                                        <td><input type="text" name="f2_c" id="f2_c" class="form-control" /></td>
                                        <td><input type="text" name="f2_si" id="f2_si" class="form-control" /></td>
                                        <td><input type="text" name="f2_mn" id="f2_mn" class="form-control" /></td>
                                        <td><input type="text" name="f2_p" id="f2_p" class="form-control" /></td>
                                        <td><input type="text" name="f2_s" id="f2_s" class="form-control" /></td>
                                        <td><input type="text" name="f2_cr" id="f2_cr" class="form-control" /></td>
                                        <td><input type="text" name="f2_cu" id="f2_cu" class="form-control" /></td>
                                        <td><input type="text" name="f2_mg" id="f2_mg" class="form-control" /></td> 
                                        <td><input type="text" name="f2_ni" id="f2_ni" class="form-control" /></td> 
                                        <td><input type="text" name="f2_mo" id="f2_mo" class="form-control" /></td> 
                                    </tr>
                                </table>
                            </div>
                             
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-3 text-center">
                                <label>Hardness BHN</label>
                                <input class="form-control" type="text" name="m_bmn" id="m_bmn" value="" readonly="true">                                             
                             </div>
                             <div class="form-group col-md-3 text-center">
                                <label>Tensile Strength N/MM<sup>2</sup></label>
                                <input class="form-control" type="text" name="m_tensile" id="m_tensile" value="" readonly="true">                                             
                             </div>
                             <div class="form-group col-md-3 text-center">
                                <label>Yield Strength N/MM<sup>2</sup></label>
                                <input class="form-control" type="text" name="m_yield_strength" id="m_yield_strength" value="" readonly="true">                                             
                             </div>
                             <div class="form-group col-md-3 text-center">
                                <label>Elongation %</label>
                                <input class="form-control" type="text" name="m_elongation" id="m_elongation" value="" readonly="true">                                             
                             </div> 
                         </div> 
                         <div class="row"> 
                            <div class="form-group col-md-3"> 
                                <input class="form-control" type="text" name="f_bmn" id="f_bmn" value="">                                             
                             </div>
                             <div class="form-group col-md-3"> 
                                <input class="form-control" type="text" name="tensile" id="tensile" value="">                                             
                             </div>
                             <div class="form-group col-md-3"> 
                                <input class="form-control" type="text" name="yield_strength" id="yield_strength" value="">                                             
                             </div>
                             <div class="form-group col-md-3"> 
                                <input class="form-control" type="text" name="elongation" id="elongation" value="">                                             
                             </div> 
                         </div> 
                         <hr />
                         <div class="melting_item_chemical_list">
                         
                         </div>
                         
                           
                    </div>
                    <div class="modal-footer">
						<table class="table table-condensed table-bordered " id="content-table"> 
                        <tr>
                            <th>Prepared by</th>
                            <th>Approved by/Date</th>
                            <th>
                                 <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                             </th>
                        </tr> 
                        </table> 
                        <button type="reset" id="btn_reset" class="btn btn-warning" style="display: none;">Reset</button> 
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" id="btn_chm_save" name="Save" value="Save"  class="btn btn-primary" />
                    </div> 
                    </form>
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
    <?php //} else { echo "<div class='box-body'> <h3 class='alert alert-danger text-center'>No Planning Found<h3></div>"; } ?> 
    
    
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
