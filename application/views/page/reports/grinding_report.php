<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Grinding Despatch Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">Grinding Report</li>
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
                 <div class="form-group col-md-3">
                    <label>Sub Contractor[Machining]</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_sub_contractor_id',array('' => 'All Sub-Contractor[Machining]') + $sub_contractor_opt  ,set_value('srch_sub_contractor_id') ,' id="srch_sub_contractor_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div> 
                 <div class="form-group col-md-3">
                    <label>Customer</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-3">
                    <label>Pattern</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                            
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
              <h3 class="box-title text-white">Customer Wise Despatch Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body">  
                 <div class="sticky-table-demo">  
                <?php  if(!empty($record_list)) { ?>    
                  
                    <table class="table table-bordered table-responsive">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>Date</th>  
                        <th>Item</th> 
                        <th>Qty</th>  
                        <th>Rate</th>  
                        <th>Amount</th>
                    </tr>  
                    </thead>
                    <tbody>
                        <?php  
                         $tot1['qty'] = $tot1['amt'] = 0; 
                        foreach($record_list as $sub_contractor => $info1) {  
                        ?>
                            <tr>
                                <th colspan="7" class="text-blue">Sub Contractor : <?php echo $sub_contractor; ?></th>
                            </tr>
                            <?php  
                             $tot['qty'] = $tot['amt'] = 0;
                            foreach($info1 as $j => $info) {  
                                $tot['qty'] += $info['qty'];
                                $tot['amt'] += $info['amt'];
                            ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($info['despatch_date'])); ?></td> 
                                <td><?php echo $info['item']?></td>
                                <td class="text-right"><?php echo number_format($info['qty'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['grinding_rate'],2);?></td>
                                <td class="text-right"><?php echo number_format($info['amt'],2);?></td>
                            </tr>
                            <?php 
                                
                            } ?>
                            <tr>
                                <th colspan="2">Total</th>
                                <th class="text-right"><?php echo number_format($tot['qty'],0);?></th>
                                <th></th>
                                <th class="text-right"><?php echo number_format($tot['amt'],2);?></th>
                            </tr>
                        <?php 
                                $tot1['qty'] += $tot['qty'];
                                $tot1['amt'] += $tot['amt'];
                        } ?>
                            <tr>
                                <th colspan="2">Cumulative</th>
                                <th class="text-right"><?php echo number_format($tot1['qty'],0);?></th>
                                <th></th>
                                <th class="text-right"><?php echo number_format($tot1['amt'],2);?></th>
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
