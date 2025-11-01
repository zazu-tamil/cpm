<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>HeadCode Wise Production & Rejection Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">HeadCode Wise Production & Rejection Report</li>
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
                 <div class="form-group col-md-4">
                    <label>Customer</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-4">
                    <label>Pattern</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Item') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                            
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
              <h3 class="box-title text-white">Head Code Wise Production & Rejection Report : <span><i> [ <?php echo date('d-m-Y', strtotime($srch_from_date))  ?> to <?php echo date('d-m-Y', strtotime($srch_to_date)) ?> ]</i></span></h3> 
            </div>
            <div class="box-body text-center table-responsive">
                <div class="sticky-table-demo">     
                <?php  if(!empty($record_list)) { ?>    
                  
                    <table class="table table-bordered table-condensed">
                    <thead>
                    <tr class="bg-blue-gradient"> 
                        <th>#</th> 
                        <th>Lining Heat No</th>
                        <th>Day Code</th> 
                        <th>Heat Code</th> 
                        <th>Customer</th> 
                        <th>Customer PO</th> 
                        <th>Item</th> 
                        
                        <th class="text-center">Produced Qty</th> 
                        <th class="text-center">Rejection Qty</th> 
                        <th class="text-center">Rejection Break Up</th> 
                    </tr> 
                    </thead>
                    <tbody>
                        <?php  
                          $tot1['pouring_box'] = $tot1['produced_qty'] = $tot1['rejection_qty'] = 0; 
                        foreach($record_list as $date => $info1) {  
                        ?>
                            <tr>
                                <th colspan="8" class="text-fuchsia">Date : <?php echo date('d-m-Y', strtotime($date)); ?></th>
                            </tr>
                            <?php  
                             //$tot['qty'] = $tot['amt'] = 0;
                            foreach($info1 as $j => $info) {  
                                $tot1['pouring_box'] += $info['pouring_box']; 
                                $tot1['produced_qty'] += $info['produced_qty'];  
                                $tot1['rejection_qty'] += $info['rejection_qty'];  
                            ?>
                            <tr>
                                <td><?php echo ($j+1); ?></td> 
                                <td class="text-left"><?php echo $info['lining_heat_no']?></td>
                                <td class="text-left"><?php echo $info['days_heat_no']?></td>
                                <td class="text-left"><?php echo $info['heat_code']?></td> 
                                <td class="text-left"><?php echo $info['customer']?></td>
                                <td class="text-left"><?php echo $info['customer_PO_No']?></td>
                                <td class="text-left"><?php echo $info['item']?></td>
                                
                                <td class="text-right"><?php echo number_format($info['produced_qty'],0);?></td>   
                                <td class="text-right"><?php echo number_format($info['rejection_qty'],0);?></td> 
                                <td class="text-left"><?php echo str_replace(',','<br>', $info['rej_type']);?></td>  
                            </tr>
                            <?php } ?>
                             
                        <?php } ?>
                            <tr class="text-blue">
                                <th colspan="7">Total</th>
                                
                                <th class="text-right"><?php echo number_format($tot1['produced_qty'],0);?></th>  
                                <th class="text-right"><?php echo number_format($tot1['rejection_qty'],0);?></th>  
                                <th></th>
                            </tr> 
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
