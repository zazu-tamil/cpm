<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Work Order Entry</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Work Order</a></li> 
    <li class="active">Work Order Entry</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="">
    <input type="hidden" name="mode" value="Add" />
  <!-- Default box --> 
        <div class="box box-info">
        <div class="box-body">
            <div class="row">  
                 <div class="form-group col-md-3">
                    <label>Work Order No</label>
                    <?php echo form_input('work_order_no',set_value('work_order_no' ,$work_order_no),'id="work_order_no" class="form-control" placeholder="Work Order No" readonly ') ?>                  
                 </div>  
                 <div class="form-group col-md-3"> 
                    <label for="order_date">Order Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="order_date" name="order_date" value="<?php echo date('Y-m-d');?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                 <div class="form-group col-md-6">
                    <label for="customer_id">Customer</label>
                    <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?> 
                 </div>    
             </div>
             <div class="row">
                  <div class="form-group col-md-3">
                    <label for="customer_PO_No">Customer PO No</label>
                    <input class="form-control" type="text" name="customer_PO_No" id="customer_PO_No" value="" placeholder="Customer PO No" required>                                             
                 </div> 
                 <div class="form-group col-md-5"> 
                   <label for="mode_of_order">Mode Of Order</label>
                    <div class="radio">
                        <label style="padding-left:50px;">
                            <input type="radio" name="mode_of_order"  value="Email" checked="true" /> Email  
                        </label> 
                        <label style="padding-left:50px;">
                            <input type="radio" name="mode_of_order"  value="Phone" /> Phone  
                        </label> 
                        <label style="padding-left:50px;">
                             <input type="radio" name="mode_of_order"  value="In-Person"  /> In-Person
                        </label>
                    </div>                                             
                 </div> 
                 <div class="form-group col-md-3"> 
                   <label for="is_conversion_type">Conversion Type</label>
                    <div class="radio">
                        <label style="padding-left:50px;">
                            <input type="radio" name="is_conversion_type"  value="Yes" /> Yes 
                        </label> 
                        
                        <label style="padding-left:50px;">
                             <input type="radio" name="is_conversion_type"  value="No" checked="true"  /> No
                        </label>
                    </div>                                             
                 </div>  
             </div>
             <div class="row"> 
                  <div class="form-group col-md-12">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" placeholder="remarks" id="remarks"></textarea>                                             
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
                            <tr id="clone-row">
                                <td width="30%">
                                    <?php echo form_dropdown('pattern_id[]',array('' => 'Select Item') ,set_value('pattern_id') ,' class="form-control pattern_id" required');?>
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
                                      <input type="date" class="form-control pull-right " name="delivery_date[]" value="">
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
