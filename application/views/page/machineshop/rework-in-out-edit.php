<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
   <h1> Rework <?php echo $rework_type; ?> Edit </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Machine Shop</a></li> 
    <li class="active">Rework <?php echo $rework_type; ?> Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="" id="frm"> 
<div class="box box-success ">
    <div class="box-header text-right">
    <?php if($rework_type == 'Inward') {?>   
     <a href="<?php echo site_url('rework-inward-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To Rework Inward List</a>
     <?php } else {?> 
     <a href="<?php echo site_url('rework-outward-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To Rework Outward List</a>
     <?php } ?> 
     </div>
<div class="box-body bg-gray">
    <div class="row">
        <div class="col-md-1">
            <input type="hidden" name="mode" id="mode" value="Edit" />
            <input type="hidden" name="ms_rework_id" id="ms_rework_id" value="<?php echo $record_list['ms_rework_id']; ?>" />
            <input type="hidden" name="rework_type" id="rework_type" value="<?php echo $record_list['rework_type']; ?>" />
        </div>
        <div class="col-md-10">
            
                <div class="box box-info">
                     <div class="box-header"></div>
                     <div class="box-body">
                       <div class="row">  
                         <div class="form-group col-md-6">
                            <label>Date</label>
                            <input class="form-control" type="date" name="rework_date" id="rework_date" required="true" value="<?php echo $record_list['rework_date']?>">                                             
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
                                                <th>Qty</th> 
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
                                                
                                                <td width="10%">
                                                    <input type="hidden" name="ms_rework_itm_id[<?php echo $i; ?>]" id="ms_rework_itm_id<?php echo $i; ?>" value="<?php echo ((isset($record_list['itm'][$i]['ms_rework_itm_id'])) ? $record_list['itm'][$i]['ms_rework_itm_id'] : ''); ?>" />
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
                             <?php if($rework_type == 'Inward') {?>   
                             <a href="<?php echo site_url('rework-inward-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To Rework Inward List</a>
                             <?php } else {?> 
                             <a href="<?php echo site_url('rework-outward-list') ?>" class="btn btn-info btn-mini"><i class="fa fa-angle-double-left"></i>  Back To Rework Outward List</a>
                             <?php } ?> 
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
