<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Moulding - Material Consumption</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Moulding Log</a></li> 
    <li class="active">Material Consumption</li>
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
        <button type="button" class="btn btn-success btn_add mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
     </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th> 
                <th>Date & Shift</th>  
                <!--<th>New Sand</th>  
                <th>Green Sand</th>  
                <th>Water</th>-->  
                <th>Bentonite</th>  
                <th>Bentokol</th> 
                <!--<th>Total Mix</th>  
                <th>Cum Bentonite</th>  
                <th>Cum Bentokol</th>  
                <th>Total Mix Bento</th> --> 
                <th>Remarks</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1);?></td>   
                    <td><?php echo date('d-m-Y', strtotime($ls['planning_date'])) ?><br /><?php echo $ls['shift']?></td>  
                    <!--<td><?php //echo $ls['new_sand']?></td>  
                    <td><?php //echo $ls['green_sand']?></td>  
                    <td><?php //echo $ls['water']?></td>  -->
                    <td><?php echo $ls['bentonite']?></td>  
                    <td><?php echo $ls['bentokol']?></td>  
                    <!--<td><?php //echo $ls['total_mix']?></td>-->  
                    <!--<td><?php //echo $ls['cum_bentonite']?></td>  
                    <td><?php //echo $ls['cum_bentokol']?></td>  
                    <td><?php //echo $ls['total_mix_bento']?></td>  -->
                    <td><?php echo $ls['remarks']?></td>  
                    <?php if(($this->session->userdata('cr_is_admin') == 1 )|| (($this->session->userdata('cr_is_admin') != 1 ) && ($ls['days'] <= 3))) {  ?>
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['moulding_material_log_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td> 
                    <td class="text-center"> 
                        <button value="<?php echo $ls['moulding_material_log_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td> 
                    <?php } else { echo "<td colspan='2'></td>"; } ?>                                       
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table>
        
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmadd">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add Moulding - Material Consumption Info</h4>
                        <input type="hidden" name="mode" value="Add" />
                        <input type="hidden" name="work_planning_id" value="<?php echo $work_planning_id?>" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-5">
                                <label for="core_plan_date">Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right " id="moulding_date" name="moulding_date" value="<?php echo $srch_date;?>" readonly="true">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Shift</label>
                                <input class="form-control" type="text" name="shift" id="shift" value="<?php echo $srch_shift; ?>" disabled="true">                                             
                             </div> 
                         </div> 
                         <div class="row hide">   
                             <div class="form-group col-md-4">
                                <label>New Sand</label>
                                <input class="form-control" type="text" name="new_sand" id="new_sand" value="" step="1">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Green Sand</label>
                                <input class="form-control" type="text" name="green_sand" id="green_sand" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Water</label>
                                <input class="form-control" type="text" name="water" id="water" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">   
                             <div class="form-group col-md-4">
                                <label>Bentonite</label>
                                <input class="form-control" type="text" name="bentonite" id="bentonite" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Bentokol</label>
                                <input class="form-control" type="text" name="bentokol" id="bentokol" value="">                                             
                             </div>
                             <div class="form-group col-md-4 hide">
                                <label>Total Mix</label>
                                <input class="form-control" type="text" name="total_mix" id="total_mix" value="">                                             
                             </div> 
                         </div> 
                         <div class="row hide">   
                             <div class="form-group col-md-4">
                                <label>Cum Bentonite</label>
                                <input class="form-control" type="text" name="cum_bentonite" id="cum_bentonite" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Cum Bentokol</label>
                                <input class="form-control" type="text" name="cum_bentokol" id="cum_bentokol" value="">                                             
                             </div>
                             <div class="form-group col-md-4 ">
                                <label>Total Mix Bento</label>
                                <input class="form-control" type="text" name="total_mix_bento" id="total_mix_bento" value=""> 
                             </div> 
                         </div> 
                         <div class="row">
                            <div class="col-md-12"> 
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
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmedit">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                         <h4 class="modal-title">Edit Moulding - Material Consumption Info</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="moulding_material_log_id" id="moulding_material_log_id" />
                        <input type="hidden" name="work_planning_id" id="work_planning_id" value="<?php echo $work_planning_id?>" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-5">
                                <label for="core_plan_date">Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right" id="moulding_date" name="moulding_date" value="<?php echo $srch_date;?>" disabled="true">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-5">
                                <label>Shift</label>
                                <input class="form-control" type="text" name="shift" id="shift" value="<?php echo $srch_shift; ?>" disabled="true">                                             
                             </div> 
                         </div> 
                         <div class="row hide">   
                             <div class="form-group col-md-4">
                                <label>New Sand</label>
                                <input class="form-control" type="text" name="new_sand" id="new_sand" value="" step="1">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Green Sand</label>
                                <input class="form-control" type="text" name="green_sand" id="green_sand" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Water</label>
                                <input class="form-control" type="text" name="water" id="water" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">   
                             <div class="form-group col-md-4">
                                <label>Bentonite</label>
                                <input class="form-control" type="text" name="bentonite" id="bentonite" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Bentokol</label>
                                <input class="form-control" type="text" name="bentokol" id="bentokol" value="">                                             
                             </div>
                             <div class="form-group col-md-4 hide">
                                <label>Total Mix</label>
                                <input class="form-control" type="text" name="total_mix" id="total_mix" value="">                                             
                             </div> 
                         </div> 
                         <div class="row hide">   
                             <div class="form-group col-md-4">
                                <label>Cum Bentonite</label>
                                <input class="form-control" type="text" name="cum_bentonite" id="cum_bentonite" value="">                                             
                             </div>
                             <div class="form-group col-md-4">
                                <label>Cum Bentokol</label>
                                <input class="form-control" type="text" name="cum_bentokol" id="cum_bentokol" value="">                                             
                             </div>
                             <div class="form-group col-md-4 hide">
                                <label>Total Mix Bento</label>
                                <input class="form-control" type="text" name="total_mix_bento" id="total_mix_bento" value="">                                             
                             </div> 
                         </div> 
                         <div class="row">
                            <div class="col-md-12"> 
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
