<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Work Order Edit</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Work Order</a></li> 
    <li class="active">Work Order Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="">
    <input type="hidden" name="mode" value="edit" />
    <input type="hidden" name="work_order_id" value="<?php echo $record_list['mst']['work_order_id']?>" />
  <!-- Default box --> 
        <div class="box box-info">
        <div class="box-body">
            <div class="row">  
                 <div class="form-group col-md-3">
                    <label>Work Order No</label>
                    <?php echo form_input('work_order_no',set_value('work_order_no' ,$record_list['mst']['work_order_no']),'id="work_order_no" class="form-control" placeholder="Work Order No" readonly ') ?>                  
                 </div>  
                 <div class="form-group col-md-3"> 
                    <label for="order_date">Order Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="order_date" name="order_date" value="<?php echo set_value('order_date', $record_list['mst']['order_date']);?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                 <div class="form-group col-md-6">
                    <label for="customer_id">Customer</label>
                    <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id',$record_list['mst']['customer_id']) ,' id="customer_id" class="form-control"  required');?> 
                 </div>    
             </div>
             <div class="row">
                  <div class="form-group col-md-3">
                    <label for="customer_PO_No">Customer PO No</label>
                    <input class="form-control" type="text" name="customer_PO_No" id="customer_PO_No" value="<?php echo set_value('customer_PO_No', $record_list['mst']['customer_PO_No']);?>" placeholder="Customer PO No" required>                                             
                 </div> 
                 <div class="form-group col-md-5"> 
                   <label for="mode_of_order">Mode Of Order</label>
                    <div class="radio">
                        <label style="padding-left:50px;">
                            <input type="radio" name="mode_of_order"  value="Email"  <?php echo set_radio('mode_of_order', $record_list['mst']['mode_of_order'],($record_list['mst']['mode_of_order'] == 'Email' ? true : false));?> /> Email  
                        </label> 
                        <label style="padding-left:50px;">
                            <input type="radio" name="mode_of_order"  value="Phone" <?php echo set_radio('mode_of_order', $record_list['mst']['mode_of_order'],($record_list['mst']['mode_of_order'] == 'Phone' ? true : false));?>  /> Phone  
                        </label> 
                        <label style="padding-left:50px;">
                             <input type="radio" name="mode_of_order"  value="In-Person"  <?php echo set_radio('mode_of_order', $record_list['mst']['mode_of_order'],($record_list['mst']['mode_of_order'] == 'In-Person' ? true : false));?>  /> In-Person
                        </label>
                    </div>                                             
                 </div> 
                 <div class="form-group col-md-3"> 
                   <label for="is_conversion_type">Conversion Type</label>
                    <div class="radio">
                        <label style="padding-left:50px;">
                            <input type="radio" name="is_conversion_type"  value="Yes" <?php echo set_radio('is_conversion_type', $record_list['mst']['is_conversion_type'],($record_list['mst']['is_conversion_type'] == 'Yes' ? true : false));?> /> Yes 
                        </label> 
                        
                        <label style="padding-left:50px;">
                             <input type="radio" name="is_conversion_type"  value="No" <?php echo set_radio('is_conversion_type', $record_list['mst']['is_conversion_type'],($record_list['mst']['is_conversion_type'] == 'No' ? true : false));?>  /> No
                        </label>
                    </div>                                             
                 </div>  
             </div>
             <div class="row"> 
                  <div class="form-group col-md-9">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" placeholder="Description" id="remarks"><?php echo set_value('remarks', $record_list['mst']['remarks']);?></textarea>                                             
                 </div>
                 <div class="form-group col-md-3"> 
                   <label for="status">Status</label>
                    <div class="radio">
                        <label style="padding-left:50px;">
                            <input type="radio" name="status"  value="Active" <?php echo set_radio('status', $record_list['mst']['status'],($record_list['mst']['status'] == 'Active' ? true : false));?> /> Active 
                        </label> 
                        
                        <label style="padding-left:50px;">
                             <input type="radio" name="status"  value="Close" <?php echo set_radio('status', $record_list['mst']['status'],($record_list['mst']['status'] == 'Close' ? true : false));?>  /> Close
                        </label>
                    </div>                                             
                 </div> 
             </div>   
         </div> 
         </div>  
        <div class="row">
            <div class="col-md-12">
               <div class="box box-info ">
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered table-striped table-responsive" id="inv_itm">
                        <thead> 
                            <tr> 
                                <th>Pattern Item</th>  
                                <th>UOM</th>  
                                <th>Qty</th> 
                                <th>Deliver Date</th>  
                                <th>Peice Weight</th>  
                                <th>Total Weight</th>  
                                <th></th>
                                <th></th>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach($record_list['chld'] as $k => $info ) {?>
                            <tr>
                                <td width="30%">
                                    <?php echo form_dropdown('cr_pattern_id['. $info['work_order_item_id'] .']',array('' => 'Select Item')+ $pattern_opt ,set_value('pattern_id',$info['pattern_id']) ,' class="form-control pattern_id" required');?>
                                </td>
                                <td width="15%">
                                    <?php echo form_dropdown('cr_uom['. $info['work_order_item_id'] .']',array('' => 'Select UOM')+ $uom_opt ,set_value('uom',$info['uom']) ,' class="uom form-control" required');?>
                                </td>
                                <td width="10%">
                                    <input class="form-control text-right qty" type="text" name="cr_qty[<?php echo $info['work_order_item_id'] ?>]" value="<?php echo set_value('qty',$info['qty']) ?>" placeholder="Qty" required>
                                </td>
                                <td width="15%">
                                    <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="date" class="form-control pull-right" name="cr_delivery_date[<?php echo $info['work_order_item_id'] ?>]" value="<?php echo set_value('delivery_date',$info['delivery_date']) ?>">
                                    </div>
                                </td>
                                <td>
                                   <input class="form-control text-right weight_per_piece" type="number" name="cr_weight_per_piece[<?php echo $info['work_order_item_id'] ?>]" value="<?php echo set_value('weight_per_piece',$info['weight_per_piece']) ?>" placeholder="Peice Weight" readonly="true"> 
                                </td>
                                <td>
                                   <input class="form-control text-right total_weight" type="number" name="cr_total_weight[<?php echo $info['work_order_item_id'] ?>]" value="<?php echo set_value('total_weight',$info['total_weight']) ?>" placeholder="Total Weight" readonly="true"> 
                                </td>
                                <td colspan="2">
                                    <button value="<?php echo $info['work_order_item_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr id="clone-row">
                                <td width="30%">
                                    <?php echo form_dropdown('pattern_id[]',array('' => 'Select Item')+ $pattern_opt ,set_value('pattern_id') ,' class="form-control pattern_id" required');?>
                                </td>
                                <td width="15%">
                                    <?php echo form_dropdown('uom[]',array('' => 'Select UOM')+ $uom_opt ,set_value('uom') ,' class="uom form-control" required');?>
                                </td>
                                <td width="10%">
                                    <input class="form-control text-right qty" type="text" name="qty[]" value="" placeholder="Qty" required>
                                </td>
                                <td width="15%">
                                    <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="date" class="form-control pull-right" name="delivery_date[]" value="">
                                    </div>
                                </td>
                                <td>
                                   <input class="form-control text-right weight_per_piece" type="number" name="weight_per_piece[]" value="" placeholder="Peice Weight" readonly="true"> 
                                </td>
                                <td>
                                   <input class="form-control text-right total_weight" type="number" name="total_weight[]" value="" placeholder="Total Weight" readonly="true"> 
                                </td>
                                <td>
                                    <a class="btn-success btn btn-xs add_row" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>   
                                </td>
                                <td>
                                    <a class="btn-warning btn btn-xs remove_row"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                        </tbody>
                        </table>      
                    </div>
               </div> 
            </div>
              
        </div> 
         <div class="box box-info">
          <div class="box-body text-center"> 
            <a href="<?php echo site_url('work-order-list');?>" class="btn btn-info">Back to Work Order List</a>
            <button type="submit" class="btn btn-success btn-mini"><i class="fa fa-save"></i>  Save</button>
          </div>
         </div> 
        
    <!--</div>
    <!- - /.box-body - - >
    <div class="box-footer">
        
    </div>
    <!- - /.box-footer- ->
  </div> -->
  <!-- /.box -->
  </form>  
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
