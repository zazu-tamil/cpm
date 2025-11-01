<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
   <h1> MS Despatch Edit </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Machine Shop</a></li> 
    <li class="active">MS Despatch Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="" id="frm"> 
<div class="box box-success ">
    <div class="box-header text-right"><a href="<?php echo site_url('ms-despatch-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To MS Despatch List</a></div>
<div class="box-body bg-gray">
    <div class="row"> 
        <div class="col-md-12">
                <input type="hidden" name="mode" id="mode" value="Edit" />
                <input type="hidden" name="ms_despatch_id" id="ms_despatch_id" value="<?php echo $record_list['ms_despatch_id']; ?>" />
        
                <div class="box box-info">
                     <div class="box-header"></div>
                     <div class="box-body">
                              <div class="row">  
                             <div class="form-group col-md-2">
                                <label>DC No</label>
                                <?php echo form_input('dc_no',set_value('dc_no' , $record_list['dc_no']),'id="dc_no" class="form-control" placeholder="DC No" readonly ') ?>                  
                             </div>  
                             <div class="form-group col-md-2"> 
                                <label for="despatch_date">DC Date</label>
                                
                                  <input type="date" class="form-control pull-right" id="despatch_date" name="despatch_date" value="<?php echo $record_list['despatch_date']?>">
                                                                              
                             </div>
                             
                             <div class="form-group col-md-4">
                                <label for="sub_contractor_id">Sub-Contractor</label>
                                <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id',$record_list['sub_contractor_id']) ,' id="sub_contractor_id" class="form-control" required');?> 
                             </div>   
                              <div class="form-group col-md-4">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id',$record_list['customer_id']) ,' id="customer_id" class="form-control" required');?> 
                             </div>  
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-4">
                                <label>Invoice No</label>
                                <input class="form-control" type="text" name="invoice_no" id="invoice_no" value="<?php echo $record_list['invoice_no']?>0" placeholder="Invoice No"> 
                             </div>  
                            <div class="form-group col-md-4">
                                <label>Vehicle No</label>
                                <input class="form-control" type="text" name="vehicle_no" id="vehicle_no" value="<?php echo $record_list['vehicle_no']?>" placeholder="Vehicle No">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label>Driver Name</label>
                                <input class="form-control" type="text" name="driver_name" id="driver_name" value="<?php echo $record_list['driver_name']?>" placeholder="Driver Name">                                             
                             </div> 
                            
                         </div> 
                          <div class="row"> 
                             <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input class="form-control" type="text" name="mobile" id="mobile" value="<?php echo $record_list['mobile']?>" placeholder="Mobile">                                             
                             </div>    
                             <div class="form-group col-md-4">
                                <label>Transporter ID</label>
                                <?php echo form_dropdown('transporter_id',array('' => 'Select Transporter ID') + $transporter_opt,set_value('transporter_id',$record_list['transporter_id']) ,' id="transporter_id" class="form-control" required');?>
                             </div> 
                             
                             <div class="form-group col-md-3">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status"  value="Active" <?php if($record_list['status'] == 'Active') echo 'checked="true"'; ?> /> Active 
                                    </label> 
                                </div>
                                <div class="radio">
                                    <label>
                                         <input type="radio" name="status"  value="Cancelled" <?php if($record_list['status'] == 'Cancelled') echo 'checked="true"'; ?> /> Cancelled
                                    </label>
                                </div> 
                             </div> 
                             <div class="form-group col-md-12">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" placeholder="remarks" id="remarks"></textarea>                                             
                             </div>
                         </div>  
                              <div class="row">
                                <div class="col-md-12">
                               <div class="box box-info">
                                    <div class="box-body table-responsive">
                                        <table class="table table-hover table-bordered table-striped table-responsive" id="inv_itm">
                                        <thead> 
                                            <tr> 
                                                <th>Pattern Item</th>  
                                                <th>Qty</th> 
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <?php for($i=0;$i<10;$i++ ){?>
                                            <tr> 
                                                <td width="60%"> 
                                                    <span id="pat_drp_<?php echo $i; ?>">
                                                    <?php echo form_dropdown('pattern_id['. $i . ']',array('' => 'Select Item') + $pattern_opt ,set_value('pattern_id',(isset($record_list['itm'][$i]['pattern_id'])) ? $record_list['itm'][$i]['pattern_id'] : '') ,' id="pattern_id_'.$i.'" class="form-control pattern_id" ');?>
                                                    </span>
                                                </td>  
                                                
                                                <td width="10%">
                                                    <input type="hidden" name="ms_despatch_itm_id[<?php echo $i; ?>]" id="ms_despatch_itm_id_<?php echo $i; ?>" value="<?php echo ((isset($record_list['itm'][$i]['ms_despatch_itm_id'])) ? $record_list['itm'][$i]['ms_despatch_itm_id'] : ''); ?>" />
                                                    <input class="form-control text-right qty" type="text" name="qty[<?php echo $i; ?>]"id="qty_<?php echo $i; ?>" value="<?php echo ((isset($record_list['itm'][$i]['qty'])) ? $record_list['itm'][$i]['qty'] : ''); ?>" placeholder="Qty" >
                                                </td> 
                                            </tr>
                                            <?php } ?> 
                                             
                                            
                                        </tbody>
                                        </table>      
                                    </div>
                               </div> 
                            </div>
                       </div>    
                     </div>
                     <div class="box-footer">
                        <div class="col-xs-6 form-group text-center">
                             <a href="<?php echo site_url('ms-despatch-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To MS Despatch List</a>
                         </div>
                         <div class="col-xs-6 form-group text-center">
                              <button type="submit" class="btn btn-success btn-mini" id="btn_save"><i class="fa fa-save"></i>  Save</button>
                         </div>
                     </div>
                </div>
            
        </div>
         
    </div> 
</div> 
</div> 
</form>
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
