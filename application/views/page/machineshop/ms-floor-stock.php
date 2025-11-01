<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>MS Openning Floor Stock</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">MS Openning Floor Stock</li>
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
                <div class="form-group col-md-4">
                    <label for="srch_sub_contractor_id">Sub-Contractor [Machining]</label>
                    <?php echo form_dropdown('srch_sub_contractor_id',array('' => 'All Sub-Contractor') + $sub_contractor_opt,set_value('srch_sub_contractor_id',$srch_sub_contractor_id) ,' id="srch_sub_contractor_id" class="form-control"');?>
                </div>
                <div class="col-sm-3 col-md-4"> 
                    <label for="srch_customer">Customer</label>
                    <?php echo form_dropdown('srch_customer',array('' => 'All Customer') + $customer_opt,set_value('srch_customer',$srch_customer) ,' id="srch_customer" class="form-control"');?>
                </div>
                 
                <div class="col-sm-3 col-md-4 hide">
                    <label>Search pincode ,name , phone , mobile or email</label>
                    <input type="text" class="form-control" name="srch_key" id="srch_key" value="<?php echo set_value('srch_key','') ?>" placeholder="Search pincode ,name , phone , mobile or email" />
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
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th>
                <th>Stock Date</th>  
                <th>Sub Contractor</th>  
                <th>Customer</th>  
                <th>Pattern Item</th>  
                <th>Stock Qty</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo date('d-m-Y', strtotime($ls['floor_stock_date']));?></td>   
                    <td><?php echo $ls['sub_contractor']?></td>   
                    <td><?php echo $ls['customer']?></td>   
                    <td><?php echo $ls['pattern_item']?></td>   
                    <td><?php echo $ls['stock_qty']?></td>  
                    <td class="text-center hide">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['ms_floor_stock_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['ms_floor_stock_id']?>" class="del_record_cfs btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table>
        
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xs" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmadd">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" id="scrollmodalLabel">Add MS Floor Stock</h3>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">
                       <div class="row"> 
                             <div class="form-group col-md-12">
                                <label for="sub_contractor_id">Sub-Contractor</label>
                                <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id') ,' id="sub_contractor_id" class="form-control" required');?> 
                             </div>   
                             <div class="form-group col-md-12">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control"');?> 
                             </div>
                              <div class="form-group col-md-12">
                                <label for="pattern_item">Pattern Name</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Pattern Item') ,set_value('pattern_id') ,' id="pattern_id" class="form-control"');?>                                             
                             </div>   
                         </div>
                         <div class="row">  
                              <div class="form-group col-md-6">
                                <label for="floor_stock_date">Stock Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                    <input type="text" class="form-control pull-right datepicker" id="floor_stock_date" name="floor_stock_date" value="<?php echo date('Y-m-d');?>">
                                 </div>                                                
                             </div> 
                             <div class="form-group col-md-6">
                                <label for="stock_qty">Stock Qty</label>
                                <input class="form-control" type="text" name="stock_qty" id="stock_qty" value="" placeholder="Stock Qty">                                             
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
                        <h3 class="modal-title" id="scrollmodalLabel">Edit MS Floor Stock</h3>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="ms_floor_stock_id" id="ms_floor_stock_id" />
                    </div>
                    <div class="modal-body"> 
                        <div class="row"> 
                             <div class="form-group col-md-12">
                                <label for="sub_contractor_id">Sub-Contractor</label>
                                <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id') ,' id="sub_contractor_id" class="form-control" required');?> 
                             </div>   
                             <div class="form-group col-md-12">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control"');?> 
                             </div>
                              <div class="form-group col-md-12">
                                <label for="pattern_item">Pattern Name</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Pattern Item') ,set_value('pattern_id') ,' id="pattern_id" class="form-control"');?>                                             
                             </div>   
                         </div>
                         <div class="row">  
                              <div class="form-group col-md-6">
                                <label for="floor_stock_date">Stock Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                    <input type="text" class="form-control pull-right datepicker" id="floor_stock_date" name="floor_stock_date" value="<?php echo date('Y-m-d');?>">
                                 </div>                                                
                             </div> 
                             <div class="form-group col-md-6">
                                <label for="stock_qty">Stock Qty</label>
                                <input class="form-control" type="text" name="stock_qty" id="stock_qty" value="" placeholder="Stock Qty">                                             
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
