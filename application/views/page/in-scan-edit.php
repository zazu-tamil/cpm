<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>In Scan Edit</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Booking</a></li> 
    <li class="active">In Scan Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<form method="post" action="">
  <!-- Default box -->
   
  <!--<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Create Booking</h3>   
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>-->
    <!--<div class="box-body"> -->
        <div class="box box-info">
        <div class="box-body">
        <div class="row">  
             <div class="form-group col-md-3">
                <label>AWB No</label>
                <input class="form-control" type="text" name="awbno" id="awbno" value="<?php echo $record_edit['awbno'];?>" placeholder="AWB No" >                                             
             </div>   
             <div class="form-group col-md-3">
                <input type="hidden" name="mode" value="Edit" />
                <input type="hidden" name="booking_id" value="<?php echo $record_edit['booking_id'];?>" />
                <label>Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" id="booking_date" name="booking_date" value="<?php echo $record_edit['booking_date'];?>">
                </div>
                <!-- /.input group -->                                             
             </div> 
             <div class="form-group col-md-3">
                <label>Time</label>
                 <div class="input-group">
                    <input type="text" class="form-control timepicker" name="booking_time" id="booking_time">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->                                           
             </div> 
             <div class="form-group col-md-3">
                <label>Customer Ref.No</label>
                 <div class="input-group">
                    <input type="text" class="form-control" name="customer_ref_no" id="customer_ref_no" value="<?php echo $record_edit['customer_ref_no']?>" placeholder="Customer Ref.No"> 
                  </div>
                  <!-- /.input group -->                                           
             </div>   
         </div> 
         </div> 
         </div>  
        <div class="row">
            <div class="col-md-6">
               <div class="box box-info">
                    <div class="box-body">
                         <div class="row"> 
                            <div class="form-group col-md-12">
                                <label>Origin Pincode</label>
                                <input class="form-control" type="text" name="origin_pincode" id="origin_pincode" value="<?php echo $record_edit['origin_pincode'];?>" placeholder="Origin Pincode">                                             
                             </div>
                            <div class="form-group col-md-12"> 
                                <label>Origin State</label>
                                <?php echo form_dropdown('origin_state_code',array('' => 'Select') + $state_opt ,set_value('origin_state_code',$record_edit['origin_state_code']) ,' id="origin_state_code" class="form-control" readonly');?>                                             
                            </div>
                            <div class="form-group col-md-12">  
                                <label>Origin City</label>
                                <?php echo form_dropdown('origin_city_code',array('' => 'Select') ,set_value('origin_city_code',$record_edit['origin_city_code']) ,' id="origin_city_code" class="form-control" readonly');?>                                          
                            </div>
                            <div class="form-group col-md-3">
                                <label>Code</label>
                                <input class="form-control" type="text" name="consignor_code" id="consignor_code" value="<?php echo $record_edit['consignor_code'];?>" placeholder="Code">                                             
                             </div>
                             <div class="form-group col-md-9">
                                <label>Consignor Customer</label>
                                <?php echo form_dropdown('consignor_id',array('' => 'Select') + $customer_opt,set_value('consignor_id',$record_edit['consignor_id']) ,' id="consignor_id" class="form-control"');?>                                             
                             </div>  
                         </div>
                     </div>
               </div> 
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                 <div class="box-body">
                     <div class="row"> 
                         <div class="form-group col-md-12">
                            <label>Destination Pincode</label>
                            <input class="form-control" type="text" name="dest_pincode" id="dest_pincode" value="<?php echo $record_edit['dest_pincode'];?>" placeholder="Destination Pincode">                                             
                         </div>
                        <div class="form-group col-md-12"> 
                            <label>Destination State</label>
                            <?php echo form_dropdown('dest_state_code',array('' => 'Select') + $state_opt,set_value('dest_state_code',$record_edit['dest_state_code']) ,' id="dest_state_code" class="form-control" readonly');?>                                             
                        </div>
                        <div class="form-group col-md-12">  
                            <label>Destination City</label>
                            <?php echo form_dropdown('dest_city_code',array('' => 'Select'),set_value('dest_city_code',$record_edit['dest_city_code']) ,' id="dest_city_code" class="form-control" readonly');?>                                              
                        </div>
                        <div class="form-group col-md-3">
                            <label>Code</label>
                            <input class="form-control" type="text" name="consignee_code" id="consignee_code" value="<?php echo $record_edit['consignee_code']; ?>" placeholder="Code">                                             
                         </div>
                         <div class="form-group col-md-9">
                            <label>Consignee Customer</label>
                            <?php echo form_dropdown('consignee_id',array('' => 'Select') ,set_value('consignee_id',$record_edit['consignee_id']) ,' id="consignee_id" class="form-control"');?>                                             
                         </div> 
                     </div>
                  </div>
                 </div>
            </div>
        </div>
         <div class="row">
         <div class="col-md-12">
            <div class="box box-info box-solid ">
                <div class="box-header with-border" data-widget="collapse">
                     
                  <h3 class="box-title">Consignor & Consignee Info</h3>    
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body bg-gray-light">
                   <div class="row">
                     <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border text-center"><b class="text-blue">Consignor Details</b></div>
                         <div class="box-body"> 
                            <div class="row"> 
                                 <div class="form-group col-md-12">
                                    <label>Company</label>
                                    <input class="form-control" type="text" name="sender_company" id="sender_company" value="<?php echo $record_edit['sender_company'];?>" placeholder="Company Name">                                             
                                 </div> 
                                 <div class="form-group col-md-12">
                                    <label>Sender Name</label>
                                    <input class="form-control" type="text" name="sender_name" id="sender_name" value="<?php echo $record_edit['sender_name'];?>" placeholder="Sender Name">                                             
                                 </div> 
                                 <div class="form-group col-md-12">
                                    <label>Mobile</label>
                                    <input class="form-control" type="text" name="sender_mobile" id="sender_mobile" value="<?php echo $record_edit['sender_mobile'];?>" placeholder="Mobile">                                             
                                 </div>
                                 <div class="form-group col-md-12">
                                    <label>Full Address</label>
                                    <textarea class="form-control" name="sender_address" placeholder="Address" id="sender_address"><?php echo $record_edit['sender_address'];?></textarea>                                             
                                 </div> 
                                 <?php /* 
                                 <div class="form-group col-md-5 hide">
                                    <label>State</label>
                                    <?php echo form_dropdown('state_code',array('' => 'Select') + $state_opt,set_value('state_code','') ,' id="state_code" class="form-control"');?>                                             
                                 </div>
                                 <div class="form-group col-md-4 hide">
                                    <label>City</label>
                                    <?php echo form_dropdown('city_code',array('' => 'Select') ,set_value('city_code') ,' id="city_code" class="form-control"');?>                                             
                                 </div>
                                 <div class="form-group col-md-3 hide">
                                    <label>Pincode</label>
                                    <input class="form-control" type="text" name="pincode" id="pincode" value="" placeholder="Pincode">                                             
                                 </div>
                                 */ ?>
                            </div>
                         </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border text-center"><b class="text-blue">Consignee Details</b></div>
                         <div class="box-body">  
                            <div class="row"> 
                                <div class="form-group col-md-12">
                                    <label>Company</label>
                                    <input class="form-control" type="text" name="receiver_company" id="receiver_company" value="<?php echo $record_edit['receiver_company'];?>" placeholder="Company Name">                                             
                                 </div> 
                                 <div class="form-group col-md-12">
                                    <label>Receiver Name</label>
                                    <input class="form-control" type="text" name="receiver_name" id="receiver_name" value="<?php echo $record_edit['receiver_name'];?>" placeholder="Receiver Name">                                             
                                 </div> 
                                 <div class="form-group col-md-12">
                                    <label>Mobile</label>
                                    <input class="form-control" type="text" name="receiver_mobile" id="receiver_mobile" value="<?php echo $record_edit['receiver_mobile'];?>" placeholder="Mobile">                                             
                                 </div> 
                                 <div class="form-group col-md-12">
                                    <label>Full Address</label>
                                    <textarea class="form-control" name="receiver_address" placeholder="Address" id="receiver_address"><?php echo $record_edit['receiver_address'];?></textarea>                                             
                                 </div> 
                                 <?php /* 
                                 <div class="form-group col-md-5">
                                    <label>State</label>
                                    <?php echo form_dropdown('state_code',array('' => 'Select') + $state_opt,set_value('state_code','') ,' id="state_code" class="form-control"');?>                                             
                                 </div>
                                 <div class="form-group col-md-4">
                                    <label>City</label>
                                    <?php echo form_dropdown('city_code',array('' => 'Select') ,set_value('city_code') ,' id="city_code" class="form-control"');?>                                             
                                 </div>
                                 <div class="form-group col-md-3">
                                    <label>Pincode</label>
                                    <input class="form-control" type="text" name="pincode" id="pincode" value="" placeholder="Pincode">                                             
                                 </div>
                                 */?>
                            </div> 
                         </div>
                        </div>
                    </div>
                 </div>
                </div>
                <!-- /.box-body -->
             </div>
          <!-- /.box -->
         </div>
         </div> 
         <div class="row">
            <div class="col-md-4">
                <div class="box box-info">
                 <div class="box-header"><strong>Services</strong></div>
                 <div class="box-body"> 
                 <div class="row">
                     <div class="form-group col-md-12">
                        <label>Carrier </label>
                        <?php echo form_dropdown('carrier_id',array('' => 'Select') + $carrier_opt ,set_value('carrier_id',$record_edit['carrier_id']) ,' id="carrier_id" class="form-control"');?>                                             
                     </div>
                     <div class="form-group col-md-12">    
                        <label>Service</label>
                        <?php echo form_dropdown('service_id',array('' => 'Select') + $service_opt ,set_value('service_id',$record_edit['service_id']) ,' id="service_id" class="form-control"');?>                                             
                     </div>
                     <div class="form-group col-md-12">
                        <label>Package Type</label>
                        <?php echo form_dropdown('package_type_id',array('' => 'Select') + $package_type_opt ,set_value('package_type_id',$record_edit['package_type_id']) ,' id="package_type_id" class="form-control"');?>                                             
                     </div> 
                     <div class="form-group col-md-12">
                        <label>Product Type</label>
                        <?php echo form_dropdown('product_type_id',array('' => 'Select') + $product_type_opt ,set_value('product_type_id',$record_edit['product_type_id']) ,' id="product_type_id" class="form-control"');?>                                             
                     </div> 
                     <div class="form-group col-md-4 text-center">
                        <label for="to_pay">To Pay</label>                                              
                     </div>
                     <div class="form-group col-md-2 text-center"> 
                        <input class="flat-red" type="checkbox" name="to_pay" id="to_pay" value="1">                                             
                     </div>
                     <div class="form-group col-md-4 text-center">
                        <label for="cod">Is COD</label>                                              
                     </div>
                     <div class="form-group col-md-2 text-center"> 
                        <input class="flat-red" type="checkbox" name="cod" id="cod" value="1">                                             
                     </div>                       
                     <div class="form-group col-md-12 cod_amt hide">                          
                       <label>COD Amount</label>  
                       <input class="form-control" type="number" name="cod_amount" id="cod_amount" value="<?php echo $record_edit['cod_amount'];?>" placeholder="COD Amount">                                             
                     </div>  
                     <div class="form-group col-md-12">
                        <label>Commodity</label>
                        <?php echo form_dropdown('commodity_type',array('' => 'Select')+ $commodity_type_opt ,set_value('commodity_type',$record_edit['commodity_type']) ,' id="commodity_type" class="form-control"');?>                                             
                     </div>
                     <div class="form-group col-md-12">
                        <label>Commodity Invoice Value</label>
                        <input class="form-control" type="text" name="commodity_invoice_value" id="commodity_invoice_value" value="<?php echo $record_edit['commodity_invoice_value'];?>" placeholder="Commodity Invoice Value">                                             
                     </div>
                     <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Description"><?php echo $record_edit['description'];?></textarea>                                             
                     </div>
                 </div> 
                 </div>
                 </div>
            </div>
            <div class="col-md-4">
                <div class="box box-info">
                 <div class="box-header"><strong>Package Weight</strong></div>
                    <div class="box-body"> 
                        <div class="form-group col-md-12">
                            <label>No Of Pieces </label>
                            <input class="form-control text-right" type="number" name="no_of_pieces" id="no_of_pieces" value="<?php echo $record_edit['no_of_pieces'];?>" placeholder="No of Pieces">                                             
                         </div>
                         <div class="form-group col-md-12">
                            <label>Actual Weight <i class="label label-info">In Kg</i></label>
                            <input class="form-control text-right" type="number" name="weight" id="weight" step="any" min="0" value="<?php echo $record_edit['weight'];?>" placeholder="Weight">                                             
                         </div>
                         <div class="form-group col-md-12">
                            <label>Dimension [ L x W x H ] <i class="label label-info">In Cms</i></label>
                            <div class="row">
                                <div class="form-group col-md-4">
                                   
                                  <input type="text" id="length" name="length" class="form-control text-right" placeholder="Length" value="<?php echo $record_edit['length'];?>">
                                </div>
                                <div class="form-group col-md-4">
                                  <input type="text" id="width" name="width" class="form-control text-right" placeholder="Width" value="<?php echo $record_edit['width'];?>">
                                </div>
                                <div class="form-group col-md-4">
                                  <input type="text" id="height" name="height" class="form-control text-right" placeholder="Height" value="<?php echo $record_edit['height'];?>">
                                </div>
                                <div class="form-group col-md-12 text-center">
                                  <button class="btn btn-warning btn_calc_wt" type="button">Calculate Volumetric</button>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Volumetric Weight  : </label>
                                    <div class="surface_wt"></div>
                                    <div class="air_wt"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Chargable Weight</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Actual</label>
                                </div>    
                                <div class="form-group col-md-3">
                                    <input class="chargable_opt flat-red" type="radio" name="chargable_opt" value="Actual" <?php if($record_edit['chargable_opt'] == 'Actual') echo 'checked="true"'?>>  
                                </div>
                                <div class="form-group col-md-3"> 
                                    <label>Volumetric</label>
                                </div>    
                                <div class="form-group col-md-3">
                                    <input class="chargable_opt flat-red" type="radio" name="chargable_opt" value="Volumetric" <?php if($record_edit['chargable_opt'] == 'Volumetric') echo 'checked="true"'?>> 
                                </div>
                                <div class="form-group col-md-12"> 
                                    <input class="form-control text-right" type="number" name="chargable_weight" id="chargable_weight" step="any" min="0" value="<?php echo $record_edit['chargable_weight'];?>" placeholder="Chargable Weight">
                                </div>
                              </div>                                          
                         </div>
                    </div>
                 </div>
            </div>
            <div class="col-md-4">
                <div class="box box-info">
                 <div class="box-header"><strong>Charges</strong></div>
                 <div class="box-body"> 
                 <div class="row">
                     <div class="form-group col-md-6">
                        <label>Is Manual Calculation</label>
                      </div>
                     <div class="form-group col-md-6">   
                        <input class="is_manual_rate flat-red" type="checkbox" name="is_manual_rate" value="1" <?php if($record_edit['is_manual_rate'] == '1') echo 'checked="true"'?>>                                             
                     </div>
                     <div class="form-group col-md-12">
                        <label>Rate</label>
                        <input class="form-control text-right calc" type="number" name="rate" id="rate" value="<?php echo $record_edit['rate'];?>" placeholder="Rate">                                             
                     </div>
                     <div class="form-group col-md-12">    
                        <label>COD Charges</label>
                        <input class="form-control text-right calc" type="number" name="cod_charges" id="cod_charges" value="<?php echo $record_edit['cod_charges'];?>" placeholder="COD Charges" readonly="true">                                             
                     </div>
                     <div class="form-group col-md-12">
                        <label>Fuel Surcharges</label>
                        <input class="form-control text-right calc" type="number" name="fuel_charges" id="fuel_charges" value="<?php echo $record_edit['fuel_charges'];?>" placeholder="Fuel Surcharges">                                             
                     </div>
                 </div>
                 <div class="row">
                     <div class="form-group col-md-12">
                        <label>Sub Total</label>
                        <input class="form-control text-right" type="number" name="sub_total" id="sub_total" value="<?php echo $record_edit['sub_total'];?>" readonly="true" placeholder="Sub Total">                                             
                     </div>
                     <div class="form-group col-md-6">
                        <label>GST %</label>
                        <select class="form-control calc" name="tax_percentage" id="tax_percentage">
                            <option value="">Select GST</option>
                            <option value="18" selected>GST 18%</option>
                        </select>                                            
                     </div>
                     <div class="form-group col-md-6">
                        <label>GST Amount</label>
                        <input class="form-control text-right calc" type="number" name="tax_amt" id="tax_amt" value="<?php echo $record_edit['tax_amt'];?>" readonly="true" placeholder="GST Amount">                                             
                     </div>
                     <div class="form-group col-md-12">
                        <label>Grand Total</label>
                        <input class="form-control text-right" type="number" name="grand_total" id="grand_total" value="<?php echo $record_edit['grand_total'];?>" readonly="true" placeholder="Grand Total">                                             
                     </div>
                 </div>
                 <div class="row">
                     <div class="form-group col-md-12">
                        <label>Payment Mode</label>
                        <?php echo form_dropdown('payment_mode',array('' => 'Select','Cash' => 'Cash','Cheque' => 'Cheque','NEFT' => 'NEFT' ) ,set_value('payment_mode',$record_edit['payment_mode']) ,' id="payment_mode" class="form-control"');?>                                             
                     </div> 
                 </div>
                 </div>
                 </div>
            </div>
         </div>
         <div class="box box-info">
          <div class="box-body text-center"> 
            <a href="<?php echo site_url('in-scan-list');?>" class="btn btn-info btn-mini"><i class="fa fa-backward"></i>  Back To In-Scan List</a>
            <button type="submit" class="btn btn-success btn-mini"><i class="fa fa-save"></i>  Update</button>
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
