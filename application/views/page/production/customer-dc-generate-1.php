<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Generate Customer Despatch </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Despatch </a></li> 
    <li class="active">Generate Customer DC</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
        </div>
       <div class="box-body"> 
            <form action="<?php echo site_url('customer-despatch-v2'); ?>" method="post" id="frm">
            <div class="row"> 
                <div class="col-md-6">
                     <label>Customer</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_customer_id',array('' => 'Select Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?>
                      </div> 
                </div> 
                <!--<div class="col-md-5">
                     <label>Item</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'Select Item') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?>
                      </div> 
                </div> -->
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
                <div class="col-md-5"> 
                <br />
                    <button class="btn btn-info" type="submit">Show Records</button>
                </div>
            </div>
            </form> 
       </div> 
    </div> 
    <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-book"></i> Items</h3>
        </div>
       <div class="box-body"> 
         <?php  if(!empty($record_list)) { ?>  
                <table class="table table-bordered table-condensed">
                    <thead>
                    <tr class="text-blue"> 
                        <th>#</th> 
                        <th>Date</th> 
                        <th>Heat Code</th> 
                        <th>Customer PO</th>  
                        <th class="text-center">Stock Qty</th> 
                    </tr> `
                    </thead>
                    <tbody>
                    <?php foreach($record_list as $item=> $info){ ?> 
                        <tr>
                            <td colspan="4"><?php echo $item;?></td>
                        </tr>
                    <?php $tot = 0; foreach($info as $j=> $ls){ $tot+= $ls['bal_qty']; ?> 
                        <tr>
                            <td class="text-center"><?php echo ($j + 1);?></td>   
                             <td><?php echo $ls['melting_date'];?></td>  
                            <td><?php echo $ls['heat_code'] . $ls['days_heat_no']?></td>  
                            <td><?php echo $ls['customer_PO_No'];?></td>  
                            <td class="text-right"><?php echo $ls['bal_qty'];?></td> 
                        </tr>
                    <?php } ?>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right"><?php echo $tot;?></td>
                        </tr>    
                    <?php } ?>
                    </tbody>
                  </table>
          <?php } ?>            
       </div> 
    </div> 
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>