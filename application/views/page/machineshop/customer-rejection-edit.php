<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
   <h1> Customer Rejection Edit </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Customer Rejection</a></li> 
    <li class="active">Customer Rejection Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="" id="frm"> 
<div class="box box-success ">
    <div class="box-header text-right"><a href="<?php echo site_url('customer-rejection-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To Customer Rejection List</a></div>
<div class="box-body bg-gray">
    <div class="row">
        <div class="col-md-1">
            <input type="hidden" name="mode" id="mode" value="Edit" />
            <input type="hidden" name="customer_rejection_id" id="customer_rejection_id" value="<?php echo $record_list['customer_rejection_id']; ?>" />
        </div>
        <div class="col-md-10">
            
                <div class="box box-info">
                     <div class="box-header"></div>
                     <div class="box-body">
                       <div class="row">  
                         <div class="form-group col-md-6">
                            <label>Rejection Date</label>
                            <input class="form-control" type="date" name="rej_date" id="rej_date" required="true" value="<?php echo $record_list['rej_date']?>">                                             
                         </div>
                         <div class="form-group col-md-6">
                            <label for="sub_contractor_id">Sub-Contractor</label>
                            <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id',$record_list['sub_contractor_id']) ,' id="sub_contractor_id" class="form-control" required');?> 
                         </div>   
                         <div class="form-group col-md-6">
                            <label>DC No & Date</label>
                            <input class="form-control" type="text" name="dc_info" id="dc_info" value="<?php echo $record_list['dc_info']?>" placeholder="DC No & Date">                                             
                         </div>  
                          <div class="form-group col-md-6">
                            <label>Invoice No & Date</label>
                            <input class="form-control" type="text" name="invoice_info" id="invoice_info" value="<?php echo $record_list['invoice_info']?>" placeholder="Invoice No & Date">                                             
                         </div> 
                         <div class="form-group col-md-6">
                            <label>Vehicle No</label>
                            <input class="form-control" type="text" name="veh_reg_no" id="veh_reg_no" value="<?php echo $record_list['veh_reg_no']?>" placeholder="Vehicle No" >                                             
                         </div>  
                         <div class="form-group col-md-6">
                            <label>Customer</label>
                            <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt  ,set_value('customer_id',$record_list['customer_id']) ,' id="customer_id" class="form-control" required="true" ');?> 
                          </div>  
                         <div class="form-group col-md-6">
                            <label>Rejection Group</label>
                            <?php echo form_dropdown('rej_grp', (array('' => 'Select') + $rejection_group_opt), set_value("rej_grp",$record_list['rej_grp']),' class="form-control" id="rej_grp" required="true" '); ?>
                         </div>                         
                         <div class="form-group col-md-6">
                            <label>Status</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status"  value="Active" <?php if($record_list['status'] == 'Active') echo 'checked="true"'; ?> /> Active 
                                </label> 
                            </div>
                            <div class="radio">
                                <label>
                                     <input type="radio" name="status"  value="InActive" <?php if($record_list['status'] == 'InActive') echo 'checked="true"'; ?> /> InActive
                                </label>
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
                                                <th>Type</th>  
                                                <th>Qty</th> 
                                                <th>Remarks</th> 
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <?php for($i=0;$i<10;$i++ ){?>
                                            <tr> 
                                                <td width="30%"> 
                                                    <span id="pat_drp_<?php echo $i; ?>">
                                                    <?php echo form_dropdown('pattern_id['. $i . ']',array('' => 'Select Item') + $pattern_opt ,set_value('pattern_id',(isset($record_list['itm'][$i]['pattern_id'])) ? $record_list['itm'][$i]['pattern_id'] : '') ,' id="pattern_id_'.$i.'" class="form-control pattern_id" ');?>
                                                    </span>
                                                </td>  
                                                <td width="30%">
                                                    <span id="rejtyp_drp_<?php echo $i; ?>">
                                                    <?php echo form_dropdown('rej_type_id['. $i . ']',array('' => 'Select Rej Type') + $rej_type_opt ,set_value('rej_type_id',(isset($record_list['itm'][$i]['rej_type_id'])) ? $record_list['itm'][$i]['rej_type_id'] : '') ,' id="rej_type_id_'.$i.'" class="form-control rej_type_id"');?>
                                                    </span>
                                                </td> 
                                                <td width="10%">
                                                    <input type="hidden" name="customer_rejection_itm_id[<?php echo $i; ?>]" id="customer_rejection_itm_id_<?php echo $i; ?>" value="<?php echo ((isset($record_list['itm'][$i]['customer_rejection_itm_id'])) ? $record_list['itm'][$i]['customer_rejection_itm_id'] : ''); ?>" />
                                                    <input class="form-control text-right qty" type="text" name="qty[<?php echo $i; ?>]" id="qty_<?php echo $i; ?>" value="<?php echo ((isset($record_list['itm'][$i]['qty'])) ? $record_list['itm'][$i]['qty'] : ''); ?>" placeholder="Qty" >
                                                </td> 
                                                <td width="20%">
                                                    <textarea class="form-control remarks" name="remarks[<?php echo $i; ?>]" id="remarks_<?php echo $i; ?>" placeholder="Remarks" ><?php echo ((isset($record_list['itm'][$i]['remarks'])) ? $record_list['itm'][$i]['remarks'] : ''); ?></textarea>
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
                             <a href="<?php echo site_url('customer-rejection-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To Customer Rejection List</a>
                         </div>
                         <div class="col-xs-6 form-group text-center">
                              <button type="submit" class="btn btn-success btn-mini" id="btn_save"><i class="fa fa-save"></i>  Save</button>
                         </div>
                     </div>
                </div>
            
        </div>
        <div class="col-md-1"></div>
    </div> 
</div> 
</div> 
</form>
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
