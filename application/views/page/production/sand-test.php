<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>System Sand Test Register</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Lab</a></li> 
    <li class="active">System Sand Test Register</li>
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
        <h3 class="box-title"><strong>System Sand Test Register</strong></h3>
        <span class="pull-right"><button data-toggle="modal" data-target="#add_modal" value="" class="add_record btn btn-success btn-md" title="Add Heat Code"><i class="fa fa-plus-circle"></i> Add Sand Test Log</button></span>
     </div>
    <div class="box-body table-responsive">  
        
        <table class="table table-hover table-bordered table-striped table-responsive">
            <thead> 
                <tr>
                    <th>#</th> 
                    <th>Date</th>  
                    <th>Shift</th>    
                    <th>Time</th> 
                    <th>Item</th>  
                    <th>Temp</th>   
                    <th>COM</th>  
                    <th>MOI</th> 
                    <th>Remarks</th>  
                    <th colspan="3" class="text-center">Action</th>  
                </tr> 
            </thead>
            <tbody>
               <?php
                   if(!empty($record_list[0]['system_sand_register_id'])) {
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1);?></td>  
                    <td><?php echo $ls['planning_date']?></td>  
                    <td><?php echo $ls['shift']?></td>  
                    <td><?php echo $ls['test_time']?></td>  
                    <td><?php echo $ls['pattern_item']?></td>  
                    <td><?php echo $ls['temp']?></td>   
                    <td><?php echo $ls['com']?></td>   
                    <td><?php echo $ls['moi']?></td>  
                    <td><?php echo $ls['remarks']?></td> 
                    <td class="text-center">
                        <a href="<?php echo site_url('print-str/').$ls['system_sand_register_id']?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> STR</a>
                    </td> 
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['system_sand_register_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td> 
                    <td class="text-center"> 
                        <button value="<?php echo $ls['system_sand_register_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
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
                        <h4 class="modal-title">Add Sand Test Register</h4>
                        <input type="hidden" name="mode" value="Add" /> 
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-3">
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
                             </div> 
                             <div class="row"> 
                             <div class="form-group col-md-6">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?> 
                             </div> 
                             <div class="form-group col-md-6">
                                <label>Pattern Item</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Item'),set_value('pattern_id') ,' id="pattern_id" class="form-control" required');?>                                            
                             </div>
                             
                         </div> 
                         <div class="row">  
                             <div class="form-group col-md-3">
                                <label>Time</label>
                                <input class="form-control" type="time" name="test_time" id="test_time" value="<?php echo date('H:i');?>">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Temp <em>[50'C Max]</em> </label>
                                <input class="form-control" type="text" name="temp" id="temp" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>COM <em>[35-50%]</em></label>
                                <input class="form-control" type="text" name="com" id="com" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>MOI <em>[3-3.50% Max]</em></label>
                                <input class="form-control" type="text" name="moi" id="moi" value="">                                             
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-md-3">
                                <label>Permeability <em>[120 Mins]</em> </label>
                                <input class="form-control" type="text" name="permeability" id="permeability" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Green Comp Strength <em>[0.9-1.4]</em></label>
                                <input class="form-control" type="text" name="green_comp_strength" id="green_comp_strength" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Volatile Matter <em>[3.0% Min]</em></label>
                                <input class="form-control" type="text" name="volatile_matter" id="volatile_matter" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Loss On Ignition <em>[6.5% Max]</em> </label>
                                <input class="form-control" type="text" name="loss_on_ignition" id="loss_on_ignition" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">
                            
                             <div class="form-group col-md-3">
                                <label>Active Clay [7-10 %]</label>
                                <input class="form-control" type="text" name="active_clay" id="active_clay" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Total Clay <em>[10-14%]</em></label>
                                <input class="form-control" type="text" name="total_clay" id="total_clay" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Dead Clay <em>[5% Max]</em> </label>
                                <input class="form-control" type="text" name="dead_clay" id="dead_clay" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>New Sand <em>[Kg/Mix]</em></label>
                                <input class="form-control" type="text" name="new_sand" id="new_sand" value="">                                             
                             </div>
                         </div>  
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>Bentonite<em>[Kg/Mix]</em></label>
                                <input class="form-control" type="text" name="bentonite" id="bentonite" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Coal Dust <em>[Kg/Mix]</em> </label>
                                <input class="form-control" type="text" name="coal_dust" id="coal_dust" value="">                                             
                             </div> 
                             <div class="form-group col-md-6">
                                <label>Remarks</label>
                                <textarea  class="form-control"  name="remarks" id="remarks"></textarea>                                           
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
                         <h4 class="modal-title">Edit Sand Test Register Info</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="system_sand_register_id" id="system_sand_register_id" /> 
                    </div>
                    <div class="modal-body"> 
                          
                        <div class="row"> 
                             <div class="form-group col-md-3">
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
                             </div> 
                             <div class="row"> 
                             <div class="form-group col-md-6">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?> 
                             </div> 
                             <div class="form-group col-md-6">
                                <label>Pattern Item</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Item'),set_value('pattern_id') ,' id="pattern_id" class="form-control" required');?>                                            
                             </div>
                             
                         </div> 
                         <div class="row">  
                             <div class="form-group col-md-3">
                                <label>Time</label>
                                <input class="form-control" type="time" name="test_time" id="test_time" value="<?php echo date('H:i');?>">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Temp <em>[50'C Max]</em> </label>
                                <input class="form-control" type="text" name="temp" id="temp" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>COM <em>[35-50%]</em></label>
                                <input class="form-control" type="text" name="com" id="com" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>MOI <em>[3-3.50% Max]</em></label>
                                <input class="form-control" type="text" name="moi" id="moi" value="">                                             
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-md-3">
                                <label>Permeability <em>[120 Mins]</em> </label>
                                <input class="form-control" type="text" name="permeability" id="permeability" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Green Comp Strength <em>[0.9-1.4]</em></label>
                                <input class="form-control" type="text" name="green_comp_strength" id="green_comp_strength" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Volatile Matter <em>[3.0% Min]</em></label>
                                <input class="form-control" type="text" name="volatile_matter" id="volatile_matter" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Loss On Ignition <em>[6.5% Max]</em> </label>
                                <input class="form-control" type="text" name="loss_on_ignition" id="loss_on_ignition" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">
                            
                             <div class="form-group col-md-3">
                                <label>Active Clay [7-10 %]</label>
                                <input class="form-control" type="text" name="active_clay" id="active_clay" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Total Clay <em>[10-14%]</em></label>
                                <input class="form-control" type="text" name="total_clay" id="total_clay" value="">                                             
                             </div> 
                             <div class="form-group col-md-3">
                                <label>Dead Clay <em>[5% Max]</em> </label>
                                <input class="form-control" type="text" name="dead_clay" id="dead_clay" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>New Sand <em>[Kg/Mix]</em></label>
                                <input class="form-control" type="text" name="new_sand" id="new_sand" value="">                                             
                             </div>
                         </div>  
                         <div class="row"> 
                             <div class="form-group col-md-3">
                                <label>Bentonite<em>[Kg/Mix]</em></label>
                                <input class="form-control" type="text" name="bentonite" id="bentonite" value="">                                             
                             </div>
                             <div class="form-group col-md-3">
                                <label>Coal Dust <em>[Kg/Mix]</em> </label>
                                <input class="form-control" type="text" name="coal_dust" id="coal_dust" value="">                                             
                             </div> 
                             <div class="form-group col-md-6">
                                <label>Remarks</label>
                                <textarea  class="form-control"  name="remarks" id="remarks"></textarea>                                           
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
