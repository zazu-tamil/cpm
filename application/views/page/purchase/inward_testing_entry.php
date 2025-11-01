<?php  include_once(VIEWPATH . '/inc/header.php');  ?>
 <section class="content-header">
  <h1>Incoming Material Test Register</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> QC - Inspection</a></li> 
    <li class="active">Quality Check - Purchase Inward Item</li>
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
                    <label>Inward Date From</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_date_from" name="srch_date_from" value="<?php echo set_value('srch_date_from',$srch_date_from) ;?>">
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <label>To</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_date_to" name="srch_date_to" value="<?php echo set_value('srch_date_to',$srch_date_to) ;?>">
                    </div>
                </div> 
                 
                <div class="col-sm-3 col-md-2"> 
                <br />
                    <button class="btn btn-info" type="submit">Show Inward Items</button>
                </div>
            </div>
            </form> 
       </div> 
    </div> 
  <div class="box box-success">
     <?php if(isset($record_list)) { ?> 
    <div class="box-header with-border"> 
        <strong>Quality Check Entry - Purchase Inward Item</strong>
     </div>
    <div class="box-body table-responsive">  
       <table class="table table-hover table-bordered table-responsive">
        <thead> 
            <tr>  
                <th>#</th>  
                <th>Inward Date</th>  
                <th>Supplier Name</th>  
                <th>Inv No/ DC No</th>  
                <th>Item</th> 
                <th>Supplied Qty</th>    
                <th>TC Rec</th>    
                <th>Criteria</th>    
                <th colspan="2">Action</th>    
            </tr> 
        </thead> 
        <tbody>
             <?php 
                   foreach($record_list as $i => $info){
                ?> 
                <tr> 
                    <td><?php echo ($i+1)?></td> 
                    <td><?php echo date('d-m-Y', strtotime($info['inward_date'])) ?></td>
                    <td><?php echo $info['supplier_name']?></td>                          
                    <td><?php echo $info['inv_no']?></td>                          
                    <td><?php echo $info['item_name']?></td>                          
                    <td class="text-right"><?php echo $info['supplied_qty']?></td>   
                    <td><?php echo $info['tc_received']?></td>   
                    <td><?php echo $info['criteria']?></td>   
                    <?php if(!empty($info['purchase_inward_testing_id'])) { ?>
                    <td class="text-center">
                         <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $info['purchase_inward_testing_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit" data="<?php echo $info['supplier_name']?> || <?php echo $info['item_name']?> || <?php echo $info['supplied_qty']?>"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center"> 
                        <button value="<?php echo $info['purchase_inward_testing_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>  
                    <?php } else { ?> 
                    <td class="text-center" colspan="2">
                     <button data-toggle="modal" data-target="#add_modal" value="<?php echo $info['pid']; ?>" class="add_record btn btn-info btn-xs" title="Add" data="<?php echo $info['supplier_name']?> || <?php echo $info['item_name']?> || <?php echo $info['supplied_qty']?>"><i class="fa fa-plus-circle"></i></button>
                    </td>       
                     <?php } ?>                      
                </tr> 
                <?php } ?>    
        </tbody>    
        </table>
        
        
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmadd">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add Quality Check - Purchase Inward Item </h4>
                        <input type="hidden" name="mode" value="Add" />
                        <input type="hidden" name="purchase_inward_id" id="purchase_inward_id" value="" />
                    </div>
                    <div class="modal-body"> 
                          <div class="row"> 
                             <div class="form-group col-md-12">
                                <label class="ref"></label>                                           
                             </div>
                             <div class="form-group col-md-4">
                                <label>TC Received</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="tc_received"  value="Yes" checked="true" /> Yes 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="tc_received"  value="No"  /> No
                                    </label>
                                </div> 
                             </div> 
                             <div class="form-group col-md-8">
                                <label>Actual Results</label> 
                                <?php echo form_textarea('result','','class="form-control" id="result"'); ?>
                             </div>
                             <div class="form-group col-md-4">
                                <label>Acceptance Criteria</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="criteria"  value="Accepted" checked="true" /> Accepted 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="criteria"  value="Rejected"  /> Rejected
                                    </label>
                                </div> 
                             </div> 
                             <div class="form-group col-md-8">
                                <label>Remarks</label>
                               <?php echo form_textarea('remarks','','class="form-control" id="remarks"'); ?>
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
                                <h4 class="modal-title" id="scrollmodalLabel">Edit Quality Check - Purchase Inward Item</h4>
                                <input type="hidden" name="mode" value="Edit" />
                                <input type="hidden" name="purchase_inward_testing_id" id="purchase_inward_testing_id" />
                                <input type="hidden" name="purchase_inward_id" id="purchase_inward_id" />
                            </div>
                            <div class="modal-body"> 
                                 <div class="row"> 
                             <div class="form-group col-md-12">
                                <label class="ref">sdfasdf</label>                                           
                             </div>
                             <div class="form-group col-md-4">
                                <label>TC Received</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="tc_received"  value="Yes" checked="true" /> Yes 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="tc_received"  value="No"  /> No
                                    </label>
                                </div> 
                             </div> 
                             <div class="form-group col-md-8">
                                <label>Actual Results</label> 
                                <?php echo form_textarea('result','','class="form-control" id="result"'); ?>
                             </div>
                             <div class="form-group col-md-4">
                                <label>Acceptance Criteria</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="criteria"  value="Accepted" checked="true" /> Accepted 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="criteria"  value="Rejected"  /> Rejected
                                    </label>
                                </div> 
                             </div> 
                             <div class="form-group col-md-8">
                                <label>Remarks</label>
                               <?php echo form_textarea('remarks','','class="form-control" id="remarks"'); ?>
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
