<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Machine Shop Despatch List </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Machine Shop </a></li> 
    <li class="active">MS Despatch List</li>
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
            <form action="<?php echo site_url('ms-despatch-list'); ?>" method="post" id="frm">
            <div class="row">
                <div class="form-group col-md-3"> 
                    <label>From Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-3"> 
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                <div class="form-group col-md-6">
                    <label for="srch_sub_contractor_id">Sub-Contractor [Machining]</label>
                    <?php echo form_dropdown('srch_sub_contractor_id',array('' => 'All Sub-Contractor') + $sub_contractor_opt,set_value('srch_sub_contractor_id',$srch_sub_contractor_id) ,' id="srch_sub_contractor_id" class="form-control"');?>
                </div>
                <div class="form-group col-md-6">
                     <label>Customer</label> 
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?>
                     
                </div>
                <div class="form-group col-md-4">
                    <label>Pattern</label> 
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                                               
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
         
       
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th> 
                <th>Sub Contractor</th>  
                <th>Invoice No</th>  
                <th>DC No & Date</th>  
                <th>Customer</th>    
                <th>Vehicle Info</th> 
                <th>Remarks</th>  
                <th>Status</th> 
                <th colspan="5" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td>   
                    <td><?php echo $ls['sub_contractor']?></td>   
                    <td><?php echo $ls['invoice_no']?></td>  
                    <td><?php echo $ls['dc_no']?><br /><?php echo $ls['despatch_date']?></td>  
                    <td><?php echo $ls['customer']?></td>  
                    <td><?php echo  $ls['vehicle_no'] .'<br />'. $ls['driver_name'];?>
                    <br /><?php echo '<i class="fa fa-mobile"></i>  '.($ls['mobile']);?> 
                    <br /><?php echo $ls['transporter_name']; ?> - <?php echo $ls['transporter_gst']; ?>
                    </td>   
                    <td><?php echo $ls['remarks']?></td>   
                    <td><?php echo $ls['status']?></td> 
                     
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['ms_despatch_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                    </td>
                     <td class="text-center">
                        <a href="<?php echo site_url('print-ms-dc/').$ls['ms_despatch_id']?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> DC</a>
                    </td> 
                    
                    <?php if(($this->session->userdata('cr_is_admin') == 1 )|| (($this->session->userdata('cr_is_admin') != 1 ) && ($ls['days'] <= 3))) {  ?> 
                    <td class="text-center">
                        <a href="<?php echo site_url('ms-despatch-edit/').$ls['ms_despatch_id']?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                     </td>
                    <td class="text-center">
                        <button value="<?php echo $ls['ms_despatch_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>  
                    <?php } else { echo "<td colspan='2'></td>"; } ?>                                      
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
                        <h4 class="modal-title">Add MS Despatch Info</h4>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">   
                        <span class="sts"></span> 
                         <div class="row">  
                             <div class="form-group col-md-2">
                                <label>DC No</label>
                                <?php echo form_input('dc_no',set_value('dc_no' ,$dc_no),'id="dc_no" class="form-control" placeholder="DC No" readonly ') ?>                  
                             </div>  
                             <div class="form-group col-md-2"> 
                                <label for="despatch_date">DC Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right datepicker" id="despatch_date" name="despatch_date" value="<?php echo date('Y-m-d');?>">
                                </div>
                                <!-- /.input group -->                                             
                             </div>
                             
                             <div class="form-group col-md-4">
                                <label for="sub_contractor_id">Sub-Contractor</label>
                                <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id') ,' id="sub_contractor_id" class="form-control" required');?> 
                             </div>   
                              <div class="form-group col-md-4">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?> 
                             </div>  
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-4">
                                <label>Invoice No</label>
                                <input class="form-control" type="text" name="invoice_no" id="invoice_no" value="0" placeholder="Invoice No"> 
                             </div>  
                            <div class="form-group col-md-4">
                                <label>Vehicle No</label>
                                <input class="form-control" type="text" name="vehicle_no" id="vehicle_no" value="" placeholder="Vehicle No">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label>Driver Name</label>
                                <input class="form-control" type="text" name="driver_name" id="driver_name" value="" placeholder="Driver Name">                                             
                             </div> 
                            
                         </div> 
                          <div class="row"> 
                             <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input class="form-control" type="text" name="mobile" id="mobile" value="" placeholder="Mobile">                                             
                             </div>    
                             <div class="form-group col-md-4">
                                <label>Transporter ID</label>
                                <?php echo form_dropdown('transporter_id',array('' => 'Select Transporter ID') + $transporter_opt,set_value('transporter_id') ,' id="dc_type" class="form-control" required');?>
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
                                         <input type="radio" name="status"  value="Cancelled"  /> Cancelled
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
                                                <td>
                                                    <?php echo form_dropdown('pattern_id['. $i . ']',array('' => 'Select Item') ,set_value('pattern_id') ,' class="form-control pattern_id" ');?>
                                                </td>  
                                                <td>
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
                         <h4 class="modal-title">Edit Customer DC Info</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="customer_despatch_id" id="customer_despatch_id" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row">  
                             <div class="form-group col-md-2">
                                <label>DC No</label>
                                <?php echo form_input('dc_no',set_value('dc_no' ,$dc_no),'id="dc_no" class="form-control" placeholder="DC No" readonly ') ?>                  
                             </div>  
                             <div class="form-group col-md-2"> 
                                <label for="despatch_date">DC Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right datepicker" id="despatch_date" name="despatch_date" value="<?php echo date('Y-m-d');?>">
                                </div>
                                <!-- /.input group -->                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label for="sub_contractor_id">Sub-Contractor</label>
                                <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id') ,' id="sub_contractor_id" class="form-control" required');?> 
                             </div>   
                             <div class="form-group col-md-4">
                                <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?> 
                             </div>  
                         </div>
                         <div class="row"> 
                            <div class="form-group col-md-4">
                                <label>Invoice No</label>
                                <input class="form-control" type="text" name="invoice_no" id="invoice_no" value="0" placeholder="Invoice No"> 
                             </div>  
                            <div class="form-group col-md-4">
                                <label>Vehicle No</label>
                                <input class="form-control" type="text" name="vehicle_no" id="vehicle_no" value="" placeholder="Vehicle No">                                             
                             </div>
                            <div class="form-group col-md-4">
                                <label>Driver Name</label>
                                <input class="form-control" type="text" name="driver_name" id="driver_name" value="" placeholder="Driver Name">                                             
                             </div> 
                            
                         </div> 
                          <div class="row"> 
                             <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input class="form-control" type="text" name="mobile" id="mobile" value="" placeholder="Mobile">                                             
                             </div>    
                             <div class="form-group col-md-4">
                                <label>Transporter ID</label>
                                <?php echo form_dropdown('transporter_id',array('' => 'Select Transporter ID') + $transporter_opt,set_value('transporter_id') ,' id="dc_type" class="form-control" required');?>
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
                                         <input type="radio" name="status"  value="Cancelled"  /> Cancelled
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
                               <div class="box box-info ">
                                    <div class="box-body table-responsive">
                                        <table class="table table-hover table-bordered table-striped table-responsive" id="inv_itm">
                                        <thead> 
                                            <tr> 
                                                <th>Pattern Item</th> 
                                                <th>Qty</th>  
                                                <th></th>
                                                <th></th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <tr id="clone-row">
                                                <td width="70%">
                                                    <?php echo form_dropdown('pattern_id[]',array('' => 'Select Item') ,set_value('pattern_id') ,' class="form-control pattern_id" required');?>
                                                </td> 
                                                <td width="10%">
                                                    <input class="form-control text-right qty" type="text" name="qty[]" value="" placeholder="Qty" required>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <a class="btn-success btn btn-xs add_row" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>   
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn-warning btn btn-xs remove_row"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                        </table>      
                                    </div>
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
        
         
        
         
        
        <div class="modal fade" id="view_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content"> 
                    <div class="modal-header">
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
                    </div>
                    <div class="modal-body table-responsive">
                    
                        <span class="master"></span>
                        <b>Pattern Items</b><br /> 
                        <span class="child"></span>
                        <span class="child1"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  
                    </div>  
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
