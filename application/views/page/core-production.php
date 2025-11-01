<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Core Production Sheet</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Core Shop</a></li> 
    <li class="active">Core Production</li>
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
                 
                <div class="col-sm-3 col-md-3">
                    <label>Core Production Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
                    </div>
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
       <table class="table table-condensed table-bordered " id="content-table"> 
        <tr>
            <th width="30%" class="text-center"><h2>MJP</h2> </th>
            <th class="text-center"><h3>Core Production Sheet</h3></b>
            <th width="30%" class="text-left"><b><?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?></b></th>
        </tr>
        </table>
        <br />
	   <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th> 
                <th>Production Date</th>  
                <th>Core Maker</th>  
                <th>Customer</th>  
                <th>Pattern Item</th> 
                <th>Core Item</th> 
                <th>Rate</th>  
                <th>Producted Qty</th>  
                <th>Rejected Qty</th>      
                <th>Amount</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td>   
                    <td><?php echo date('d-m-Y', strtotime($ls['core_plan_date'])) ?></td>  
                    <td><?php echo $ls['core_maker']?></td>  
                    <td><?php echo $ls['customer']?></td>  
                    <td><?php echo $ls['pattern_item']?></td> 
                    <td><?php echo $ls['core_item']?></td> 
                    <td class="text-right"><?php echo number_format($ls['core_maker_rate'],2);?></td>  
                    <td class="text-right"><?php echo number_format($ls['produced_qty'],2);?></td> 
                    <td class="text-right"><?php echo number_format($ls['damage_qty'],2);?></td>  
                    <td class="text-right"><?php echo number_format(($ls['core_maker_rate'] * ($ls['produced_qty'] - $ls['damage_qty'])),2);?></td>  
                     
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['core_plan_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td> 
                    <td class="text-center"> 
                        <button value="<?php echo $ls['core_plan_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table>
       <br />
      <table class="table table-condensed table-bordered " id="content-table"> 
        <tr>
            <th>Prepared by</th>
            <th>Approved by/Date</th>
            <th>
                 <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
             </th>
        </tr> 
        </table>  
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" action="" id="frmadd">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add Core Production Info</h4>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label for="core_plan_date">Core Production Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right datepicker" id="core_plan_date" name="core_plan_date" value="<?php echo date('Y-m-d') ?>">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-6">
                                <label for="core_maker_id">Core Maker</label>
                                <?php echo form_dropdown('core_maker_id',array('' => 'Select Core Maker') + $core_maker_opt ,set_value('core_maker_id') ,' id="core_maker_id" class="form-control" required');?>                                             
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?>                                            
                             </div>  
                             <div class="form-group col-md-6">
                                <label for="pattern_id">Pattern Name</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Pattern Item'),set_value('pattern_id') ,' id="pattern_id" class="form-control" required');?>                                             
                             </div> 
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label for="core_item_id">Core Item</label>
                                <?php echo form_dropdown('core_item_id',array('' => 'Select Core Item'),set_value('core_item_id') ,' id="core_item_id" class="form-control" required');?>                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Core Maker Rate</label>
                                <input class="form-control text-right" type="number" name="core_maker_rate" id="core_maker_rate" value="" step="any" readonly="true">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Core Hardness</label>
                                <input class="form-control" type="text" name="core_hardness" id="core_hardness" value="" required>                                             
                             </div>
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Produced Qty</label>
                                <input class="form-control text-right calc" type="number" name="produced_qty" id="produced_qty" value="" step="1" required>                                             
                             </div>                             
                             <div class="form-group col-md-2">
                                <label>Inspected Qty</label>
                                <input class="form-control text-right calc" type="number" name="inspected_qty" id="inspected_qty" value="" step="1" required>                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Rejected Qty</label>
                                <input class="form-control text-right calc" type="number" name="damage_qty" id="damage_qty" value="0" step="1" required>                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Ok Qty</label>
                                <input class="form-control text-right calc" type="number" name="ok_qty" id="ok_qty" value="0" step="1" readonly="true">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>M.Damage Qty</label>
                                <input class="form-control text-right calc" type="number" name="m_damage_qty" id="m_damage_qty" value="0" step="1" required>                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Amount</label>
                                <input class="form-control text-right" type="number" name="amount" id="amount" value="" step="1" readonly="true">                                             
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
                         <h4 class="modal-title">Edit Core Production</h4>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="core_plan_id" id="core_plan_id" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label for="core_plan_date">Core Production Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control pull-right datepicker" id="core_plan_date" name="core_plan_date" value="<?php echo date('Y-m-d') ?>">
                                </div>                                     
                             </div> 
                             <div class="form-group col-md-6">
                                <label for="core_maker_id">Core Maker</label>
                                <?php echo form_dropdown('core_maker_id',array('' => 'Select Core Maker') + $core_maker_opt ,set_value('core_maker_id') ,' id="core_maker_id" class="form-control" required');?>                                             
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="customer_id">Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control" required');?>                                            
                             </div>  
                             <div class="form-group col-md-6">
                                <label for="pattern_id">Pattern Name</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select Pattern Item'),set_value('pattern_id') ,' id="pattern_id" class="form-control" required');?>                                             
                             </div> 
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label for="core_item_id">Core Item</label>
                                <?php echo form_dropdown('core_item_id',array('' => 'Select Core Item'),set_value('core_item_id') ,' id="core_item_id" class="form-control" required');?>                                             
                             </div> 
                             <div class="form-group col-md-2">
                                <label>Core Maker Rate</label>
                                <input class="form-control text-right" type="number" name="core_maker_rate" id="core_maker_rate" value="" step="any" readonly="true">                                             
                             </div> 
                             <div class="form-group col-md-4">
                                <label>Core Hardness</label>
                                <input class="form-control" type="text" name="core_hardness" id="core_hardness" value="" required>                                             
                             </div>
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-md-2">
                                <label>Produced Qty</label>
                                <input class="form-control text-right" type="number" name="produced_qty" id="produced_qty" value="" step="1" required>                                             
                             </div>                             
                             <div class="form-group col-md-2">
                                <label>Inspected Qty</label>
                                <input class="form-control text-right" type="number" name="inspected_qty" id="inspected_qty" value="" step="1" required>                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Rejected Qty</label>
                                <input class="form-control text-right" type="number" name="damage_qty" id="damage_qty" value="" step="1" required>                                             
                             </div>
                              <div class="form-group col-md-2">
                                <label>Ok Qty</label>
                                <input class="form-control text-right calc" type="number" name="ok_qty" id="ok_qty" value="0" step="1" readonly="true">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>M.Damage Qty</label>
                                <input class="form-control text-right calc" type="number" name="m_damage_qty" id="m_damage_qty" value="0" step="1" required>                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Amount</label>
                                <input class="form-control text-right" type="number" name="amount" id="amount" value="" step="1" readonly="true">                                             
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
                        <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
                    <div class="modal-body table-responsive">
                    
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
