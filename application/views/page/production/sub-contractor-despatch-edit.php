<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Sub-Contractor Despatch </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Despatch </a></li> 
    <li class="active">Sub-Contractor DC Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="" id="edit_modal">
    <input type="hidden" name="mode" value="edit" />
    <input type="hidden" name="sub_contractor_despatch_id" value="<?php echo $record_list['mst']['sub_contractor_despatch_id']?>" />
  <!-- Default box --> 
        <div class="box box-info">
        <div class="box-body">
             <div class="row">  
                 <div class="form-group col-md-2">
                    <label>DC No</label>
                    <?php echo form_input('dc_no',set_value('dc_no',$record_list['mst']['dc_no'] ),'id="dc_no" class="form-control" placeholder="DC No" ') ?>                  
                 </div>  
                 <div class="form-group col-md-2"> 
                    <label for="despatch_date">DC Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="despatch_date" name="despatch_date" value="<?php echo date('Y-m-d' ,strtotime($record_list['mst']['despatch_date']));?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                 <div class="form-group col-md-4">
                    <label for="sub_contractor_id">Sub-Contractor[ Grinding ]</label>
                    <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor')+ $sub_contractor_opt ,set_value('sub_contractor_id',$record_list['mst']['sub_contractor_id']) ,' id="sub_contractor_id" class="form-control" required');?> 
                 </div> 
                 <div class="form-group col-md-4">
                    <label for="customer_id">Customer</label>
                    <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id',$record_list['mst']['customer_id']) ,' id="customer_id" class="form-control" required');?> 
                 </div>   
                 
             </div>
             <div class="row">  
                <div class="form-group col-md-4">
                    <label>Vehicle No</label>
                    <input class="form-control" type="text" name="vehicle_no" id="vehicle_no" value="<?php echo set_value('vehicle_no' ,$record_list['mst']['vehicle_no']);?>" placeholder="Vehicle No">                                             
                 </div>
                <div class="form-group col-md-4">
                    <label>Driver Name</label>
                    <input class="form-control" type="text" name="driver_name" id="driver_name" value="<?php echo set_value('driver_name' ,$record_list['mst']['driver_name']);?>" placeholder="Driver Name">                                             
                 </div> 
                 <div class="form-group col-md-4">
                    <label>Mobile</label>
                    <input class="form-control" type="text" name="mobile" id="mobile" value="<?php echo set_value('mobile' ,$record_list['mst']['mobile']);?>" placeholder="Mobile">                                             
                 </div>
             </div> 
              <div class="row">  
                  <div class="form-group col-md-8">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" placeholder="remarks" id="remarks"><?php echo set_value('remarks' ,$record_list['mst']['remarks']);?></textarea>                                             
                 </div>
                 <div class="form-group col-md-4">
                    <label>Status</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" class="status" value="Outward" <?php echo set_radio('status',$record_list['mst']['status'],($record_list['mst']['status'] == 'Outward' ? true : false)) ?>/> Outward 
                        </label> 
                    </div>
                    <div class="radio">
                        <label>
                             <input type="radio" name="status" class="status" value="Inward" <?php echo set_radio('status',$record_list['mst']['status'],($record_list['mst']['status'] == 'Inward' ? true : false)) ?>  /> Inward
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                             <input type="radio" name="status" class="status" value="Cancelled"  <?php echo set_radio('status',$record_list['mst']['status'],($record_list['mst']['status'] == 'Cancelled' ? true : false)) ?> /> Cancelled
                        </label>
                    </div> 
                 </div> 
             </div>  
             <div class="row inward_row <?php if($record_list['mst']['status'] != 'Inward') echo 'hide'; ?> "> 
                  <div class="form-group col-md-4">
                    <label for="inward_date">Inward Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="inward_date" name="inward_date" value="<?php echo set_value('inward_date' ,$record_list['mst']['inward_date']);?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                 <div class="form-group col-md-4">
                    <label>Inward DC No</label>
                    <input class="form-control" type="text" name="inward_dc_no" id="inward_dc_no" value="<?php echo set_value('inward_dc_no' ,$record_list['mst']['inward_dc_no']);?>" placeholder="Inward DC No">                                             
                 </div> 
                 <div class="form-group col-md-4">
                    <label>Inward Received By</label>
                    <?php echo form_dropdown('inward_received_by',array('' => 'Select Inward Received By') + $employee_opt,set_value('inward_received_by',$record_list['mst']['inward_received_by']) ,' id="inward_received_by" class="form-control"');?>                                             
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
                                <?php 
                                //if(!empty($record_list['chld']))
                                 {
                                foreach($record_list['chld'] as $k => $info ) {?>
                                <tr>
                                    
                                    <td width="20%">
                                        <?php echo form_dropdown('ed_pattern_id['. $info['sub_contractor_despatch_item_id'] .']',array('' => 'Select Item')+ $pattern_opt ,set_value('pattern_id',$info['pattern_id']) ,' class="form-control pattern_id" required');?>
                                    </td> 
                                    <td width="10%">
                                        <input class="form-control text-right qty" type="text" name="ed_qty[<?php echo $info['sub_contractor_despatch_item_id'] ?>]" value="<?php echo set_value('qty',$info['qty']) ?>" placeholder="Qty" required>
                                    </td>
                                   
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <?php for($i=0;$i<(10 - count($record_list['chld']));$i++ ){?>
                                <tr>
                                   
                                    <td width="20%">
                                        <?php echo form_dropdown('pattern_id['. $i . ']',array('' => 'Select Item') +$pattern_opt ,set_value('pattern_id') ,' class="form-control pattern_id_'.$i.'" ');?>
                                    </td> 
                                    
                                    <td width="10%">
                                        <input class="form-control text-right qty" type="text" name="qty[<?php echo $i; ?>]" value="" placeholder="Qty" >
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
        </div> 
         <div class="box box-info">
          <div class="box-body text-center"> 
            <a href="<?php echo site_url('sub-contractor-despatch');?>" class="btn btn-info">Back to Sub-Contractor DC List</a>
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
