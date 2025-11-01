<?php  include_once(VIEWPATH . '/inc/header.php');  ?>
 <section class="content-header">
  <h1>Internal Rejection</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> QC - Inspection</a></li> 
    <li class="active">QC-Rejection</li>
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
        QC - Inspection 
     </div>
    <div class="box-body table-responsive"> <b>Shift Planning & Production Info</b> 
       <table class="table table-hover table-bordered table-responsive">
        <thead> 
            <tr>  
                <th>Planning Date</th>  
                <th>Shift</th>  
                <th>Customer & PO No</th>  
                <th>Pattern</th>  
                <th>Planned Box</th> 
                <th>Poured Box</th> 
                <th>Produced Qty</th>  
                <th class="text-center">Add Rejection Breakup </th>  
            </tr> 
        </thead> 
        <tbody>
             <?php 
                   foreach($record_list as $wo_itm_id => $info){
                ?> 
                <tr class="bg-maroon-active"> 
                    <td><?php echo date('d-m-Y', strtotime($info[0]['planning_date'])) ?></td>
                    <td><?php echo $info[0]['shift']?></td>  
                    <td><?php echo $info[0]['customer']?><br /><?php echo $info[0]['customer_PO_No']?></td>  
                    <td><?php //echo $info[0]['match_plate_no']?><?php echo $info[0]['pattern_item']?></td>  
                    <td><?php echo $info[0]['planned_box']?></td> 
                    <td><?php echo $info[0]['pouring_box']?></td> 
                    <td><?php if($info[0]['prt_work_plan_id'] == '0' || $info[0]['prt_work_plan_id'] == '') { echo $info[0]['produced_qty']; } else { echo number_format(($child_record_list[$info[0]['prt_work_plan_id']] * $info[0]['no_of_cavity']),2); }?></td> 
                    <td class="text-center">
                        <?php if($info[0]['prt_work_plan_id'] == '0' || $info[0]['prt_work_plan_id'] == '') { ?>
                        <?php if($info[0]['pouring_box'] > 0 ) {?>
                        <button data-toggle="modal" data-target="#add_modal" value="<?php echo $info[0]['work_planning_id']?>" class="add_record btn btn-success btn-xs" title="Add Heat Code"><i class="fa fa-plus-circle"></i></button>
                        <?php } ?> 
                        <?php } else { ?>
                        <button data-toggle="modal" data-target="#add_modal" value="<?php echo $info[0]['work_planning_id']?>" class="add_record btn btn-success btn-xs" title="Add Heat Code"><i class="fa fa-plus-circle"></i></button>
                        <?php } ?>
                    </td>                            
                </tr>
                <tr>
                    <td colspan="8">
                        <b>Rejection BreakUp Info</b>
                        <table class="table table-hover table-bordered table-striped table-responsive">
                        <thead> 
                            <tr>
                                <th>#</th> 
                                <th>Date</th>  
                                <th>Heat Code</th>  
                                <th>Group</th>  
                                <th>Type</th>  
                                <th>Qty</th> 
                                <th>Supervisor</th> 
                                <th colspan="2" class="text-center">Action</th>  
                            </tr> 
                        </thead>
                        <tbody>
                           <?php
                               if(!empty($info[0]['qc_inspection_id'])) {
                                $tot_qty = 0;
                               foreach($info as $j=> $ls){
                                
                                $tot_qty += $ls['rejection_qty'];
                            ?> 
                            <tr> 
                                <td class="text-center"><?php echo ($j + 1);?></td>  
                                <td><?php echo $ls['qc_date']?></td>   
                                <td><?php echo $ls['heat_code']?></td>   
                                <td><?php echo $ls['rejection_group']?></td>    
                                <td><?php echo $ls['rejection_type_name']?></td> 
                                <td><?php echo $ls['rejection_qty']?></td>  
                                <td><?php  echo  $ls['shift_supervisor'];?></td>  
                                <td class="text-center">
                                    <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['qc_inspection_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                                </td> 
                                <td class="text-center"> 
                                    <button value="<?php echo $ls['qc_inspection_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                                </td>                                      
                            </tr>
                            <?php } ?>
                             <tr>
                                <th colspan="5" class="text-right">Total Rejection</th>
                                <th><?php echo $tot_qty; ?></th>
                                <th colspan="2"></th>
                             </tr>   
                            <?php } ?>
                                                         
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
                        <h4 class="modal-title">Add Quality Check - Rejection BreakUp Info</h4>
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
                             <div class="form-group col-md-6">
                                <label>QC Date</label>
                                <input class="form-control" type="date" name="qc_date" id="qc_date" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-6">
                                <label for="rejection_group">Rejection Group</label>
                                <?php echo form_dropdown('rejection_group',array('' => 'Select Group') + $rejection_group_opt ,set_value('rejection_group') ,' id="rejection_group" class="form-control"');?>                                              
                             </div>
                              
                         </div>
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label>Rejection Type</label>
                               <?php echo form_dropdown('rejection_type_id',array('' => 'Select Type') ,set_value('rejection_type_id') ,' id="rejection_type_id" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Heat Code</label>
                               <?php echo form_dropdown('melting_heat_log_id',array('' => 'Select Heat Code') ,set_value('melting_heat_log_id') ,' id="melting_heat_log_id" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Rejection Qty</label>
                                <input class="form-control" type="number" name="rejection_qty" id="rejection_qty" value="">                                             
                             </div>
                         </div> 
                        <div class="row">
                             <div class="form-group col-md-4">
                                <label>Shift Supervisor</label>
                               <?php echo form_dropdown('shift_supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('shift_supervisor',$this->session->userdata('shift_supervisor')) ,' id="shift_supervisor" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Tumblast Machine Operator</label>
                               <?php echo form_dropdown('tumblast_machine_operator',array('' => 'Select Tumblast Machine Operator') + $employee_opt ,set_value('tumblast_machine_operator',$this->session->userdata('tumblast_machine_operator')) ,' id="tumblast_machine_operator" class="form-control"');?>                                            
                             </div> 
                              <div class="form-group col-md-4">
                                <label>Shot Blastng Machine Operator</label>
                               <?php echo form_dropdown('shot_blastng_machine_operator',array('' => 'Select Shot Blastng Machine Operator') + $employee_opt ,set_value('shot_blastng_machine_operator',$this->session->userdata('shot_blastng_machine_operator')) ,' id="shot_blastng_machine_operator" class="form-control"');?>                                            
                             </div> 
                         </div>  
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label>AG4 Machine Operator</label>
                               <?php echo form_dropdown('ag4_machine_operator',array('' => 'Select AG4 Machine Operator') + $employee_opt ,set_value('ag4_machine_operator',$this->session->userdata('ag4_machine_operator')) ,' id="ag4_machine_operator" class="form-control"');?>                                            
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Contractor Grinding Machine Operator</label>
                               <?php echo form_dropdown('contractor_grinding_machine_operator',array('' => 'Contractor Grinding Machine Operator') + $employee_opt ,set_value('contractor_grinding_machine_operator',$this->session->userdata('contractor_grinding_machine_operator')) ,' id="contractor_grinding_machine_operator" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Company Grinding Machine Operator</label>
                               <?php echo form_dropdown('company_grinding_machine_operator',array('' => 'Company Grinding Machine Operator') + $employee_opt ,set_value('company_grinding_machine_operator',$this->session->userdata('company_grinding_machine_operator')) ,' id="company_grinding_machine_operator" class="form-control"');?>                                            
                             </div>  
                         </div> 
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label>Painting Person</label>
                               <?php echo form_dropdown('painting_person',array('' => 'Select Painting Person') + $employee_opt ,set_value('painting_person',$this->session->userdata('painting_person')) ,' id="painting_person" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Factory Manager</label>
                               <?php echo form_dropdown('factory_manager',array('' => 'Select Factory Manager') + $employee_opt ,set_value('factory_manager',$this->session->userdata('factory_manager')) ,' id="factory_manager" class="form-control"');?>                                            
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
                         <h4 class="modal-title">Edit Quality Check - Rejection BreakUp Info</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="qc_inspection_id" id="qc_inspection_id" />
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
                             <div class="form-group col-md-6">
                                <label>QC Date</label>
                                <input class="form-control" type="date" name="qc_date" id="qc_date" value="" required="true" >                                             
                             </div>
                             <div class="form-group col-md-6">
                                <label for="rejection_group">Rejection Group</label>
                                <?php echo form_dropdown('rejection_group',array('' => 'Select Group') + $rejection_group_opt ,set_value('rejection_group') ,' id="rejection_group" class="form-control"');?>                                              
                             </div>
                              
                         </div>
                         <div class="row">
                            <div class="form-group col-md-4">
                                <label>Rejection Type</label>
                               <?php echo form_dropdown('rejection_type_id',array('' => 'Select Type') ,set_value('rejection_type_id') ,' id="rejection_type_id" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Heat Code</label>
                               <?php echo form_dropdown('melting_heat_log_id',array('' => 'Select Heat Code') ,set_value('melting_heat_log_id') ,' id="melting_heat_log_id" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Rejection Qty</label>
                                <input class="form-control" type="number" name="rejection_qty" id="rejection_qty" value="">                                             
                             </div>
                         </div> 
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label>Shift Supervisor</label>
                               <?php echo form_dropdown('shift_supervisor',array('' => 'Select Supervisor') + $employee_opt ,set_value('shift_supervisor') ,' id="shift_supervisor" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Tumblast Machine Operator</label>
                               <?php echo form_dropdown('tumblast_machine_operator',array('' => 'Select Tumblast Machine Operator') + $employee_opt ,set_value('tumblast_machine_operator') ,' id="tumblast_machine_operator" class="form-control"');?>                                            
                             </div> 
                              <div class="form-group col-md-4">
                                <label>Shot Blastng Machine Operator</label>
                               <?php echo form_dropdown('shot_blastng_machine_operator',array('' => 'Select Shot Blastng Machine Operator') + $employee_opt ,set_value('shot_blastng_machine_operator') ,' id="shot_blastng_machine_operator" class="form-control"');?>                                            
                             </div> 
                         </div>  
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label>AG4 Machine Operator</label>
                               <?php echo form_dropdown('ag4_machine_operator',array('' => 'Select AG4 Machine Operator') + $employee_opt ,set_value('ag4_machine_operator') ,' id="ag4_machine_operator" class="form-control"');?>                                            
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Contractor Grinding Machine Operator</label>
                               <?php echo form_dropdown('contractor_grinding_machine_operator',array('' => 'Contractor Grinding Machine Operator') + $employee_opt ,set_value('contractor_grinding_machine_operator') ,' id="contractor_grinding_machine_operator" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Company Grinding Machine Operator</label>
                               <?php echo form_dropdown('company_grinding_machine_operator',array('' => 'Company Grinding Machine Operator') + $employee_opt ,set_value('company_grinding_machine_operator') ,' id="company_grinding_machine_operator" class="form-control"');?>                                            
                             </div>  
                         </div> 
                         <div class="row">
                             <div class="form-group col-md-4">
                                <label>Painting Person</label>
                               <?php echo form_dropdown('painting_person',array('' => 'Select Painting Person') + $employee_opt ,set_value('painting_person') ,' id="painting_person" class="form-control"');?>                                            
                             </div>
                             <div class="form-group col-md-4">
                                <label>Factory Manager</label>
                               <?php echo form_dropdown('factory_manager',array('' => 'Select Factory Manager') + $employee_opt ,set_value('factory_manager') ,' id="factory_manager" class="form-control"');?>                                            
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
