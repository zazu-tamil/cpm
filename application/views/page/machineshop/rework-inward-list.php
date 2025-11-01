<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1> Rework Inward List </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> MS Rework</a></li> 
    <li class="active">Rework Inward List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
  <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
        </div>
       <div class="box-body"> 
            <form action="" method="post" id="frm">
            <div class="row">
                 <div class="form-group col-md-2"> 
                    <label>From Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-2"> 
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
                <div class="form-group col-md-4">
                    <label>Customer</label>
                         <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                 </div>  
                 <div class="form-group col-md-3">
                    <label>Pattern</label> 
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id',$srch_pattern_id) ,' id="srch_pattern_id" class="form-control" ');?> 
                 </div> 
                <div class="col-sm-2 col-md-2"> 
                <br />
                    <button class="btn btn-info" type="submit">Show</button>
                </div>
            </div>
            </form> 
       </div> 
    </div>   
  <div class="box">
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
    <div class="box-body table-responsive no-padding"> 
       <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Inward Date</th>  
                <th>Sub Contractor</th>  
                <th>Customer</th>  
                <th>DC No & Date</th>  
                <th>Invoice No & Date</th>  
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
                    <td><?php echo date('d-m-Y', strtotime($ls['rework_date']));?></td>   
                    <td><?php echo $ls['sub_contractor']?></td>    
                    <td><?php echo $ls['customer']?></td>    
                    <td><?php echo $ls['dc_info']?></td>    
                    <td><?php echo $ls['invoice_info']?></td>  
                    <td><?php echo $ls['status']?></td>  
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['ms_rework_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                    </td> 
                    <td class="text-center">
                        <a href="<?php echo site_url('rework-in-out-edit/'). $ls['ms_rework_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                    </td>                               
                    <td class="text-center">
                        <button value="<?php echo $ls['ms_rework_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
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
                        <h4 class="modal-title" id="scrollmodalLabel">Add Rework Inward Entry</h4>
                        <input type="hidden" name="mode" value="Add" />
                        <input type="hidden" name="rework_type" id="rework_type" value="Inward" />
                    </div>
                    <div class="modal-body">
                      <div class="row">  
                         <div class="form-group col-md-4">
                            <label>Inward Date</label>
                            <input class="form-control" type="date" name="rework_date" id="rework_date" required="true" value="">                                             
                         </div>
                         <div class="form-group col-md-4">
                            <label for="sub_contractor_id">Sub-Contractor</label>
                            <?php echo form_dropdown('sub_contractor_id',array('' => 'Select Sub-Contractor') + $sub_contractor_opt,set_value('sub_contractor_id') ,' id="sub_contractor_id" class="form-control" required');?> 
                         </div>   
                         <div class="form-group col-md-4">
                            <label>DC No & Date</label>
                            <input class="form-control" type="text" name="dc_info" id="dc_info" value="" placeholder="DC No & Date">                                             
                         </div>  
                          <div class="form-group col-md-4">
                            <label>Invoice No & Date</label>
                            <input class="form-control" type="text" name="invoice_info" id="invoice_info" value="" placeholder="Invoice No & Date">                                             
                         </div> 
                         <div class="form-group col-md-4">
                            <label>Vehicle No</label>
                            <input class="form-control" type="text" name="veh_reg_no" id="veh_reg_no" value="" placeholder="Vehicle No">                                             
                         </div>  
                         <div class="form-group col-md-4">
                            <label>Customer</label>
                            <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt  ,set_value('customer_id') ,' id="customer_id" class="form-control" required="true" ');?> 
                          </div>  
                                               
                         <div class="form-group col-md-4">
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
                                                    <?php echo form_dropdown('pattern_id['. $i . ']',array('' => 'Select Item') ,set_value('pattern_id') ,' class="form-control pattern_id" ');?>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" name="Save" value="Save"  class="btn btn-primary" />
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
                                <h3 class="modal-title" id="scrollmodalLabel"><strong>Rework Inward Details</strong></h3>
                            </div>
                            <div class="modal-body table-responsive">
                            
                                <span class="master"></span>
                                <b>Rework Items</b><br /> 
                                <span class="child"></span> 
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
