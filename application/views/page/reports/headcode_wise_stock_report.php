<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Headcode wise Stock Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">Headcode wise Stock Report</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  
        <div class="box box-info noprint"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Search Filter</h3>
            </div>
        <div class="box-body">
             <form method="post" action="" id="frmsearch">          
             <div class="row">  
                 <div class="form-group col-md-3">
                    <label>Customer</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" required="true" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-3">
                    <label>Pattern</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" required="true"');?> 
                            
                      </div>                                   
                 </div> 
                 <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Reports</button>
                </div>
             </div>  
            </form>
         </div> 
         </div> 
         <?php if(($submit_flg)) { ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Headcode wise Stock Report</h3> 
            </div>
            <div class="box-body table-responsive">
                <div class="sticky-table-demo">      
                <?php  if(!empty($record_list)) { ?>    
                  
                    <table class="table table-bordered table-responsive">
                    <thead>
                    <tr class="bg-blue-gradient"> 
                        <th>Planning Date</th> 
                        <th>Shift</th> 
                        <th>HeadCode</th> 
                        <th class="text-right">Produced Qty</th>  
                        <th class="text-right">Rejected Qty</th>  
                        <th class="text-right">Despatch Qty</th>  
                        <th class="text-right">Stock Qty</th>  
                    </tr>  
                    </thead>
                    <tbody>
                        <?php  foreach($record_list as $cust => $info1) {  ?>
                            <tr>
                                <th colspan="7" class="text-red">Customer : <?php echo $cust; ?></th>
                            </tr>
                         <?php  foreach($info1 as $item => $info2) {  ?>
                            <tr>
                                <th colspan="7" class="text-blue">Item : <?php echo $item; ?></th>
                            </tr>
                         <?php 
                            $tot_qty = 0; 
                            $tot_produced_qty = 0; 
                            $tot_rejection_qty = 0; 
                            $tot_despatch_qty = 0; 
                            foreach($info2 as $info) {  
                                $tot_qty += $info['stock_qty'];
                                $tot_produced_qty += $info['produced_qty'];
                                $tot_rejection_qty += $info['rejection_qty'];
                                $tot_despatch_qty += $info['despatch_qty'];
                         ?>
                            <tr>
                                <td><?php echo $info['planning_date']; ?></td>
                                <td><?php echo $info['shift']; ?></td>
                                <td><?php echo $info['heat_code']; ?></td>
                                <td class="text-right"><?php echo $info['produced_qty']; ?></td>
                                <td class="text-right"><?php echo $info['rejection_qty']; ?></td>
                                <td class="text-right"><?php echo $info['despatch_qty']; ?></td>
                                <td class="text-right"><?php echo $info['stock_qty']; ?></td>
                            </tr> 
                        <?php }  ?>
                            <tr>
                                <th colspan="3" class="text-blue">Total</th>
                                <th class="text-right"><?php echo $tot_produced_qty; ?></th>
                                <th class="text-right"><?php echo $tot_rejection_qty; ?></th>
                                <th class="text-right"><?php echo $tot_despatch_qty; ?></th>
                                <th class="text-right"><?php echo $tot_qty; ?></th>
                            </tr>
                        <?php }  ?>    
                        <?php }  ?>   
                    </tbody>
                    </table>
                  <?php } ?>
            </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
