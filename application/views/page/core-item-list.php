<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Core Master</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Core Shop</a></li> 
    <li class="active">Core Item List</li>
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
            <form action="<?php echo site_url('core-item-list');?>" method="post" id="frm">
            <div class="row">  
                <div class="col-sm-3 col-md-4"> 
                    <label for="srch_state">Customer</label>
                    <?php echo form_dropdown('srch_customer',array('' => 'All') + $customer_opt,set_value('srch_customer',$srch_customer) ,' id="srch_state" class="form-control"');?>
                </div>
                <div class="col-sm-3 col-md-4">
                    <label>Pattern Name,Core Item</label>
                    <input type="text" class="form-control" name="srch_key" id="srch_key" value="<?php echo set_value('srch_key','') ?>" placeholder="Search Pattern Name,Core Item" />
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
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body table-responsive">
       
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th> 
                <th>Core Item Name</th>  
                <th>Customer</th> 
                <th>Pattern</th>  
                <th>Core Per Box</th> 
                <th>Weight</th>   
                <!--<th>Rate</th>-->   
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
                    <td><?php echo $ls['core_item_name']?></td>  
                     <td><?php echo $ls['company_name']?></td>   
                     <td><?php echo $ls['pattern_item']?></td>    
                    <td><?php echo $ls['core_per_box']?></td>  
                    <td><?php echo $ls['core_weight']?></td>  
                    <!--<td><?php echo $ls['core_maker_rate']?></td> --> 
                    <td><?php echo $ls['status']?></td>   
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['core_item_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['core_item_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
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
                        <h3 class="modal-title" id="scrollmodalLabel"><strong>Add Core Item</strong></h3>
                        <input type="hidden" name="mode" value="Add" />
                    </div>
                    <div class="modal-body">
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label>Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control"');?>                                            
                             </div>  
                             <div class="form-group col-md-6">
                                <label>Pattern</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select') ,set_value('pattern_id') ,' id="pattern_id" class="form-control"');?>                                             
                             </div>  
                             
                         </div> 
                         <div class="row">                                
                             <div class="form-group col-md-5">
                                <label>Core Item Name</label>
                                <input class="form-control" type="text" name="core_item_name" id="core_item_name" value="" placeholder="Core Item Name">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Core per Box</label>
                                <input class="form-control" type="number" name="core_per_box" id="core_per_box" step="any" value="1" placeholder="Core Per Box">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Core Weight</label>
                                <input class="form-control" type="number" name="core_weight" id="core_weight" step="any" value="" placeholder="Weight">                                             
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
                                         <input type="radio" name="status"  value="InActive"  /> InActive
                                    </label>
                                </div> 
                             </div>
                          </div> 
                         <!--<div class="row">   
                             <div class="form-group col-md-6 hide">
                                <label>Core Maker</label>
                                <?php //echo form_dropdown('core_maker_id',array('' => 'Select Core Marker') + $core_maker_opt,set_value('core_maker_id') ,' id="core_maker_id" class="form-control"');?>                                            
                             </div> 
                             <div class="form-group col-md-4 hide">
                                <label for="core_maker_rate">Core Maker Rate</label>
                                <input class="form-control" type="number" step="any" name="core_maker_rate" id="core_maker_rate" step="any" value="0" placeholder="Core Maker Rate">                                             
                             </div> 
                         </div>-->   
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
                        <h5 class="modal-title" id="scrollmodalLabel"><strong>Edit Core Item</strong> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <input type="hidden" name="mode" value="Edit" />
                        <input type="hidden" name="core_item_id" id="core_item_id" />
                    </div>
                    <div class="modal-body"> 
                         <div class="row"> 
                             <div class="form-group col-md-6">
                                <label>Customer</label>
                                <?php echo form_dropdown('customer_id',array('' => 'Select Customer') + $customer_opt,set_value('customer_id') ,' id="customer_id" class="form-control"');?>                                            
                             </div>  
                             <div class="form-group col-md-6">
                                <label>Pattern</label>
                                <?php echo form_dropdown('pattern_id',array('' => 'Select') ,set_value('pattern_id') ,' id="pattern_id" class="form-control"');?>                                             
                             </div>  
                             
                         </div> 
                         <div class="row">                                
                             <div class="form-group col-md-5">
                                <label>Core Item Name</label>
                                <input class="form-control" type="text" name="core_item_name" id="core_item_name" value="" placeholder="Core Item Name">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Core per Box</label>
                                <input class="form-control" type="number" name="core_per_box" id="core_per_box" step="any" value="1" placeholder="Core Per Box">                                             
                             </div>
                             <div class="form-group col-md-2">
                                <label>Core Weight</label>
                                <input class="form-control" type="number" name="core_weight" id="core_weight" step="any" value="" placeholder="Weight">                                             
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
                                         <input type="radio" name="status"  value="InActive"  /> InActive
                                    </label>
                                </div> 
                             </div>
                          </div> 
                         <!--<div class="row">   
                             <div class="form-group col-md-6 hide">
                                <label>Core Maker</label>
                                <?php //echo form_dropdown('core_maker_id',array('' => 'Select Core Marker') + $core_maker_opt,set_value('core_maker_id') ,' id="core_maker_id" class="form-control"');?>                                            
                             </div> 
                             <div class="form-group col-md-4 hide">
                                <label for="core_maker_rate">Core Maker Rate</label>
                                <input class="form-control" type="number" step="any" name="core_maker_rate" id="core_maker_rate" step="any" value="0" placeholder="Core Maker Rate">                                             
                             </div> 
                         </div>-->  
                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                        <input type="submit" name="Save" value="Update"  class="btn btn-primary" />
                    </div> 
                    </form>
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
