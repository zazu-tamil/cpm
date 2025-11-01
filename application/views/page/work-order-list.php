<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Order Register</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Work Order</a></li> 
    <li class="active">Work Order List</li>
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
            <form action="<?php echo site_url('work-order-list');?>" method="post" id="frm">
            <div class="row"> 
                <div class="form-group col-md-3">
                    <label>From Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
                    </div>
                </div> 
                <div class="form-group col-md-3">
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date) ;?>">
                    </div>
                </div> 
                <div class="col-sm-3 col-md-6"> 
                    <label for="srch_customer_id">Customer</label>
                    <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt,set_value('srch_customer_id',$srch_customer_id) ,' id="srch_customer_id" class="form-control"');?>
                </div>
            </div>
            <div class="row">     
                <div class="col-sm-3 col-md-8"> 
                    <label for="srch_pattern_id">Pattern Item</label>
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
      <a  class="btn btn-success mb-1" href="<?php echo site_url('work-order-entry'); ?>"><span class="fa fa-plus-circle"></span> Add New </a>
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
	  <table class="table table-condensed table-bordered " id="content-table"> 
        <tr>
            <th width="30%" class="text-center"><h2>MJP</h2> </th>
            <th class="text-center"><h3>Order Register</h3></b>
            <th width="30%" class="text-left"><b><?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?></b></th>
        </tr>
       </table> 
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead> 
            <tr>
                <th>#</th>
                <th>Order Date & No</th>
                <th>Customer</th>  
                <th>Customer PO No</th>  
                <th>Remarks</th>  
                <th>No of Items</th>  
                <th>No of Box</th>  
                <th>Total Tonage</th>  
                <th colspan="3" class="text-center">Action</th>  
            </tr> 
        </thead>
          <tbody>
               <?php $tot['tot_box'] = $tot['total_tonage'] = 0;
                   foreach($record_list as $j=> $ls){
                    $tot['tot_box'] += $ls['tot_box'];
                    $tot['total_tonage'] += $ls['total_tonage'];
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo date('d-m-Y', strtotime($ls['order_date']));?><br /><span class="label label-success"><?php echo $ls['work_order_no']?></span></td>   
                    <td><?php echo $ls['customer']?></td>   
                    <td><span class="label label-info"><?php echo $ls['customer_PO_No']?></span></td>  
                    <td><?php echo $ls['remarks']?></td>    
                    <td class="text-right"><?php echo $ls['no_of_item']?></td>    
                    <td class="text-right"><?php echo $ls['tot_box']?></td>    
                    <td class="text-right"><?php echo $ls['total_tonage']?></td>    
                    <td class="text-center">
                        <button data-toggle="modal" data-target="#view_modal" value="<?php echo $ls['work_order_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo site_url('work-order-edit/').$ls['work_order_id']?>" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['work_order_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>  
                <tr>
                    <th colspan="6">Total</th>
                    <th class="text-right"><?php echo number_format($tot['tot_box'],0)?></th>  
                    <th class="text-right"><?php echo number_format($tot['total_tonage'],3)?></th> 
                    <th colspan="3"></th> 
                </tr>                               
            </tbody>
      </table> 
        
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
                        <b>Work Order Items</b><br /> 
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
		<table class="table table-condensed table-bordered " id="content-table"> 
		<tr>
			<th>Prepared by</th>
			<th>Approved by/Date</th>
			<th>
				 <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
			 </th>
		</tr> 
		</table> 
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
