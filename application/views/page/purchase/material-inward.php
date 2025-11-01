<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Material Inward Item List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Purchase</a></li> 
    <li class="active">Material Inward List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
   
  <div class="box box-info">
    <div class="box-header with-border">
       <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button> 
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
         
      </div>
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>S.No</th>  
                <th>Date</th>  
                <th>Inv No</th>  
                <th>Supplier</th>  
                <th>Item</th>  
                <th>Supplied Qty</th>  
                <th>Accepted Qty</th>  
                <th>Remarks</th>  
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
                    <td><?php echo $ls['inward_date']?></td>   
                    <td><?php echo $ls['inv_no']?></td>   
                    <td><?php echo $ls['supplier_name']?></td>  
                    <td><?php echo $ls['item_name']?></td>   
                    <td class="text-right"><?php echo $ls['supplied_qty']?></td>   
                    <td class="text-right"><?php echo $ls['accepted_qty']?></td>   
                    <td><?php echo $ls['remarks']?></td>   
                    <td><?php echo $ls['status']?></td>   
                    <td class="text-center">
                         <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['purchase_inward_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center"> 
                        <button value="<?php echo $ls['purchase_inward_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                     
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
                                <h4 class="modal-title" id="scrollmodalLabel">Add Material Inward Item</h4>
                                <input type="hidden" name="mode" value="Add" />
                            </div>
                            <div class="modal-body">
                                 <div class="row"> 
                                     <div class="form-group col-md-3">
                                        <label>Inward Date</label>
                                        <input class="form-control" type="date" name="inward_date" id="inward_date" value="">                                             
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>PO No</label>
                                        <input class="form-control" type="text" name="po_no" id="po_no" value="" placeholder="PO No">                                             
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>PO Date</label>
                                        <input class="form-control" type="date" name="po_date" id="po_date" value="">                                             
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>Invoice No/DC No</label>
                                        <input class="form-control" type="text" name="inv_no" id="inv_no" value="0" required="true" placeholder="Invoice No/DC No">                                             
                                     </div>  
                                     <div class="form-group col-md-6">
                                        <label>Supplier Name</label>
                                        <input class="form-control" type="text" name="supplier_name" id="supplier_name" value="" placeholder="Supplier Name">                                             
                                        <div id="supplier"></div>
                                     </div> 
                                     <div class="form-group col-md-6">
                                        <label>Item</label>
                                        <?php echo form_dropdown('item_id',array('' => 'Select Item') + $itm_opt,set_value('item_id') ,' id="item_id" class="form-control" required');?>                                             
                                     </div>
                                     
                                     <div class="form-group col-md-4">
                                        <label>Expected Date</label>
                                        <input class="form-control" type="date" name="expected_date" id="expected_date" value="0" required="true">                                              
                                     </div>  
                                     <div class="form-group col-md-4">
                                        <label>Supplied Date</label>
                                        <input class="form-control" type="date" name="supplied_date" id="supplied_date" value="0" required="true">                                              
                                     </div>  
                                     <div class="form-group col-md-4">
                                        <label>Rate/Kg</label>
                                        <input class="form-control" type="number" step="any" name="rate_per_kg" id="rate_per_kg" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-3">
                                        <label>Ordered Qty</label>
                                        <input class="form-control" type="number" step="any" name="ordered_qty" id="ordered_qty" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-3">
                                        <label>Supplied Qty</label>
                                        <input class="form-control" type="number" step="any" name="supplied_qty" id="supplied_qty" value="0" required="true">                                              
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>Rejected Qty</label>
                                        <input class="form-control" type="number" step="any" name="rejected_qty" id="rejected_qty" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-3">
                                        <label>Accepted Qty</label>
                                        <input class="form-control" type="number" step="any" name="accepted_qty" id="accepted_qty" value="0" required="true">                                              
                                     </div>                                     
                                     <div class="form-group col-md-3">
                                        <label>Rework Qty</label>
                                        <input class="form-control" type="number" step="any" name="rework_qty" id="rejected_qty" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-4">
                                        <label>Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                     </div>
                                     <div class="form-group col-md-3">
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
                                <h4 class="modal-title" id="scrollmodalLabel">Edit Inward Item</h4>
                                <input type="hidden" name="mode" value="Edit" />
                                <input type="hidden" name="purchase_inward_id" id="purchase_inward_id" />
                            </div>
                            <div class="modal-body"> 
                                <div class="row"> 
                                    <div class="form-group col-md-3">
                                        <label>Inward Date</label>
                                        <input class="form-control" type="date" name="inward_date" id="inward_date" value="">                                             
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>PO No</label>
                                        <input class="form-control" type="text" name="po_no" id="po_no" value="" placeholder="PO No">                                             
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>PO Date</label>
                                        <input class="form-control" type="date" name="po_date" id="po_date" value="">                                             
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>Invoice No/DC No</label>
                                        <input class="form-control" type="text" name="inv_no" id="inv_no" value="0" required="true" placeholder="Invoice No/DC No">                                             
                                     </div>  
                                     <div class="form-group col-md-6">
                                        <label>Supplier Name</label>
                                        <input class="form-control" type="text" name="supplier_name" id="supplier_name" value="" placeholder="Supplier Name">                                             
                                        <div id="supplier"></div>
                                     </div> 
                                     <div class="form-group col-md-6">
                                        <label>Item</label>
                                        <?php echo form_dropdown('item_id',array('' => 'Select Item') + $itm_opt,set_value('item_id') ,' id="item_id" class="form-control" required');?>                                             
                                     </div>
                                     
                                     <div class="form-group col-md-4">
                                        <label>Expected Date</label>
                                        <input class="form-control" type="date" name="expected_date" id="expected_date" value="0" required="true">                                              
                                     </div>  
                                     <div class="form-group col-md-4">
                                        <label>Supplied Date</label>
                                        <input class="form-control" type="date" name="supplied_date" id="supplied_date" value="0" required="true">                                              
                                     </div>  
                                     <div class="form-group col-md-4">
                                        <label>Rate/Kg</label>
                                        <input class="form-control" type="number" step="any" name="rate_per_kg" id="rate_per_kg" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-3">
                                        <label>Ordered Qty</label>
                                        <input class="form-control" type="number" step="any" name="ordered_qty" id="ordered_qty" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-3">
                                        <label>Supplied Qty</label>
                                        <input class="form-control" type="number" step="any" name="supplied_qty" id="supplied_qty" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-3">
                                        <label>Rejected Qty</label>
                                        <input class="form-control" type="number" step="any" name="rejected_qty" id="rejected_qty" value="0" required="true">                                              
                                     </div>                                     
                                     <div class="form-group col-md-3">
                                        <label>Accepted Qty</label>
                                        <input class="form-control" type="number" step="any" name="accepted_qty" id="accepted_qty" value="0" required="true">                                              
                                     </div> 
                                     <div class="form-group col-md-3">
                                        <label>Rework Qty</label>
                                        <input class="form-control" type="number" step="any" name="rework_qty" id="rejected_qty" value="0" required="true">                                              
                                     </div>
                                     <div class="form-group col-md-4">
                                        <label>Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                     </div>
                                     <div class="form-group col-md-3">
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
