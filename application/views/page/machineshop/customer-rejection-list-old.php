<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1> Customer Rejection List </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Customer Rejection</a></li> 
    <li class="active">Customer Rejection List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
  <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
        </div>
       <div class="box-body"> 
            <form action="" method="post" id="frm">
            <div class="row">
                <div class="col-md-3"> 
                    <label for="srch_rejection_group">Rejection Group</label>
                    <?php echo form_dropdown('srch_rejection_group',array('' => 'All') + $rejection_group_opt,set_value('srch_rejection_group',$srch_rejection_group) ,' id="srch_rejection_group" class="form-control"');?>
                </div>
                <div class="form-group col-md-4">
                    <label>Customer</label>
                         <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                                                 
                 </div>  
                 <div class="form-group col-md-3">
                    <label>Pattern</label> 
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id',$srch_pattern_id) ,' id="srch_pattern_id" class="form-control" ');?> 
                 </div> 
                <div class="col-sm-2 col-md-2"> 
                <br />
                    <button class="btn btn-info" type="submit">Show</button>
                </div>
            </div>
            </form> 
       </div> 
    </div>   
  <div class="box">
    <div class="box-header with-border">
      <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body table-responsive no-padding"> 
       <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>  
                <th>Customer</th>  
                <th>Item</th>  
                <th>Heat Code</th>  
                <th>Rej Group & Type</th>  
                <th>Qty</th>  
                <th>Status</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr>
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo date('d-m-Y', strtotime($ls['rej_date']));?></td>   
                    <td><?php echo $ls['customer']?></td>   
                    <td><?php echo $ls['pattern_item']?></td>   
                    <td><?php echo $ls['heat_code']?></td>    
                    <td><?php echo $ls['rej_group']?><br /><?php echo $ls['rejection_type_name']?></td>   
                    <td><?php echo $ls['qty']?></td>   
                    <td><?php echo $ls['status']?></td>   
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['customer_rejection_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['customer_rejection_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>                                 
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
                        <h4 class="modal-title" id="scrollmodalLabel">Add Customer Rejection </h4>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">
                         <div class="form-group col-md-6">
                            <label>Rejection Date</label>
                            <input class="form-control" type="date" name="rej_date" id="rej_date" required="true" value="">                                             
                         </div>
                         <div class="form-group col-md-6">
                            <label>Customer</label>
                            <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt  ,set_value('customer_id') ,' id="customer_id" class="form-control" required="true" ');?> 
                          </div>  
                         <div class="form-group col-md-6">
                            <label>Pattern Item</label> 
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Item') + $pattern_opt ,set_value('pattern_id') ,' id="pattern_id" class="form-control" required="true"');?> 
                         </div> 
                         <div class="form-group col-md-6">
                            <label>Heat Code</label>
                            <input class="form-control" type="text" name="heat_code" id="heat_code" required="true" value="">                                             
                         </div>  
                         <div class="form-group col-md-6">
                            <label>Rejection Group</label>
                            <?php echo form_dropdown('rej_group', (array('' => 'Select') + $rejection_group_opt), set_value("rej_group"),' class="form-control" id="rej_group" required="true" '); ?>
                         </div>  
                        <div class="form-group col-md-6">
                            <label>Rejection Type</label>
                            <?php echo form_dropdown('rej_type_id', (array('' => 'Select') ), set_value("rej_type_id"),' class="form-control" id="rej_type_id" '); ?>
                         </div>  
                         <div class="form-group col-md-6">
                            <label>Rejection Qty</label>
                            <input class="form-control" type="text" name="qty" id="qty" value="" required="true">                                             
                         </div>                                  
                         <div class="form-group col-md-6">
                            <label>Status</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status"  value="Active" checked="true" /> Active 
                                </label> 
                            </div>
                            <div class="radio">
                                <label>
                                     <input type="radio" name="status"  value="InActive"  /> InActive
                                </label>
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
                                <h3 class="modal-title" id="scrollmodalLabel">Edit Customer Rejection</h3>
                                <input type="hidden" name="mode" value="Edit" />
                                <input type="hidden" name="customer_rejection_id" id="customer_rejection_id" />
                            </div>
                            <div class="modal-body"> 
                                 <div class="form-group col-md-6">
                                    <label>Rejection Date</label>
                                    <input class="form-control" type="date" name="rej_date" id="rej_date" required="true" value="">                                             
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label>Customer</label>
                                    <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt  ,set_value('customer_id') ,' id="customer_id" class="form-control" required="true" ');?> 
                                  </div>  
                                 <div class="form-group col-md-6">
                                    <label>Pattern Item</label> 
                                        <?php echo form_dropdown('pattern_id',array('' => 'Select Item') + $pattern_opt ,set_value('pattern_id') ,' id="pattern_id" class="form-control" required="true"');?> 
                                 </div> 
                                 <div class="form-group col-md-6">
                                    <label>Heat Code</label>
                                    <input class="form-control" type="text" name="heat_code" id="heat_code" required="true" value="">                                             
                                 </div>  
                                 <div class="form-group col-md-6">
                                    <label>Rejection Group</label>
                                    <?php echo form_dropdown('rej_group', (array('' => 'Select') + $rejection_group_opt), set_value("rej_group"),' class="form-control" id="rej_group" required="true" '); ?>
                                 </div>  
                                <div class="form-group col-md-6">
                                    <label>Rejection Type</label>
                                    <?php echo form_dropdown('rej_type_id', (array('' => 'Select') ), set_value("rej_type_id"),' class="form-control" id="rej_type_id" '); ?>
                                 </div>  
                                 <div class="form-group col-md-6">
                                    <label>Rejection Qty</label>
                                    <input class="form-control" type="text" name="qty" id="qty" value="" required="true">                                             
                                 </div>                                  
                                 <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status"  value="Active" checked="true" /> Active 
                                        </label> 
                                    </div>
                                    <div class="radio">
                                        <label>
                                             <input type="radio" name="status"  value="InActive"  /> InActive
                                        </label>
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
            <label>Total Records : <?php echo $total_records;?></label>
        </div>
        <div class="form-group col-sm-6">
            <?php echo $pagination; ?>
        </div>
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
