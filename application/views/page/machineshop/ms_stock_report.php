<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($op_stock_list);
print_r($frm_to_rec);
echo "</pre>";*/
?>
 <section class="content-header">
  <h1>Machine Shop Stock Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">MS Stock Report</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
                    </div>
                 </div> 
                  <div class="form-group col-md-2">
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date) ;?>">
                    </div>
                 </div>  
                 <div class="form-group col-md-4">
                    <label>Machine Shop</label> 
                        <?php echo form_dropdown('srch_sub_contractor_id',array('' => 'Select Sub Contractor') + $sub_contractor_opt  ,set_value('sub_contractor_id',$srch_sub_contractor_id) ,' id="srch_sub_contractor_id" class="form-control" required="true" ');?> 
                  </div> 
                 <div class="form-group col-md-4">
                    <label>Customer</label> 
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                                                
                 </div>  
                 <div class="form-group col-md-4">
                    <label>Pattern</label> 
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Item') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                                                  
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
              <h3 class="box-title text-white">Machine Shop Stock Report : <span><i> as on <?php echo date('d-m-Y' , strtotime($srch_date)) ?>  </i></span></h3> 
            </div>
            <div class="box-body">  
                <div class="sticky-table-demo">    
                <?php  if(!empty($op_stock_list)) { ?>   
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                    <tr class="bg-blue-gradient">  
                          
                        <th>Pattern Item</th>  
                        <th>Opening Stock</th> 
                        <th>Foundry Despatch Qty</th>  
                        <th>Rework In-Qty</th>  
                        <th>MS Rej Qty[ internal ]</th>  
                        <th>Rework Out-Qty</th> 
                        <th>MS Despatch Qty</th> 
                        <th>Closing Stock</th>
                    </tr> 
                    </thead>
                    <tbody>
                         <?php foreach($op_stock_list as $customer => $info1) {  ?> 
                         <tr>
                            <th colspan="6">Customer : <?php echo $customer; ?></th>
                         </tr>
                         <?php 
                           
                         foreach($info1 as $pattern => $op_qty) {  ?>
                         <tr>
                            <th colspan="6">Item : <?php echo $pattern; ?></th>
                         </tr>
                         <?php /*foreach($info2 as $j => $info) {  ?> 
                            <tr>
                                <td><?php echo $info['pattern_item']; ?> </td> 
                                <td class="text-right"><?php echo number_format($info['op_stock_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format($info['inward_qty'],0); ?></td> 
                                <td class="text-right"><?php echo number_format($info['intl_rej_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format($info['despatch_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format((($info['op_stock_qty'] + $info['inward_qty']) -  ($info['intl_rej_qty'] + $info['despatch_qty'])),0); ?></td>
                            </tr>
                         <?php } */?> 
                         
                          <?php  
                           $tot_iq = 0;$tot_intq = 0; $tot_dq =  $tot_rewin  = $tot_rewout = 0;
                            $datediff = strtotime($srch_to_date) - strtotime($srch_date);
                            $datediff = floor($datediff/(60*60*24));
                            
                            for($i = 0; $i < $datediff + 1; $i++){
                                $date = date("d-m-Y", strtotime($srch_date . ' + ' . $i . 'day'));
                                if(isset($frm_to_rec[$customer][$pattern][$date]['inward_qty'])) 
                                    $inward_qty = $frm_to_rec[$customer][$pattern][$date]['inward_qty']; 
                                else 
                                    $inward_qty = 0;
                                    
                                if(isset($frm_to_rec[$customer][$pattern][$date]['intl_rej_qty'])) 
                                    $intl_rej_qty = $frm_to_rec[$customer][$pattern][$date]['intl_rej_qty']; 
                                else 
                                    $intl_rej_qty = 0;
                                    
                                if(isset($frm_to_rec[$customer][$pattern][$date]['despatch_qty'])) 
                                    $despatch_qty = $frm_to_rec[$customer][$pattern][$date]['despatch_qty']; 
                                else 
                                    $despatch_qty = 0;
                                    
                                if(isset($frm_to_rec[$customer][$pattern][$date]['rework_in'])) 
                                    $rework_in = $frm_to_rec[$customer][$pattern][$date]['rework_in']; 
                                else 
                                    $rework_in = 0;
                                    
                                if(isset($frm_to_rec[$customer][$pattern][$date]['rework_out'])) 
                                    $rework_out = $frm_to_rec[$customer][$pattern][$date]['rework_out']; 
                                else 
                                    $rework_out = 0;     
                                    
                                        
                                
                                if($i==0) {
                                  $day_op_qty = $op_qty;
                                  $day_close_qty = ($day_op_qty +   $inward_qty + $rework_in) - ($intl_rej_qty  + $despatch_qty + $rework_out);
                                  
                                } else {
                                    $day_op_qty = $day_close_qty;
                                   $day_close_qty = ($day_op_qty +   $inward_qty + $rework_in) - ($intl_rej_qty  + $despatch_qty + $rework_out);
                                }    
                                    
                           ?> 
                            <tr>
                                <td><?php echo $date ; ?></td>
                                <td class="text-right"><?php echo round($day_op_qty);?></td>
                                <td class="text-right"><?php echo round($inward_qty); ?></td>
                                <td class="text-right"><?php echo round($rework_in); ?></td>
                                <td class="text-right"><?php echo round($intl_rej_qty); ?></td>
                                <td class="text-right"><?php echo round($rework_out); ?></td> 
                                <td class="text-right"><?php echo round($despatch_qty); ?></td>  
                                <td class="text-right"><?php echo round($day_close_qty); ?></td> 
                            </tr>
                         <?php 
                            $tot_iq += $inward_qty;
                            $tot_intq += $intl_rej_qty;
                            $tot_dq += $despatch_qty;
                            $tot_rewin += $rework_in;
                            $tot_rewout += $rework_out;
                         } ?> 
                            <tr>
                                <th colspan="2">Total [ <?php echo $pattern; ?> ]</th>
                                <th class="text-right"><?php echo round($tot_iq); ?></th>
                                <th class="text-right"><?php echo round($tot_rewin); ?></th>
                                <th class="text-right"><?php echo round($tot_intq); ?></th>
                                <th class="text-right"><?php echo round($tot_rewout); ?></th>
                                <th class="text-right"><?php echo round($tot_dq); ?></th> 
                                <th></th>
                            </tr>
                         <?php } ?> 
                         <?php } ?> 
                    </tbody>
                    </table>
                <?php  } ?>   
                 
                <?php /*  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient"> 
                        <!--<th>S.No</th> --> 
                        <th>Customer</th>  
                        <th>Pattern Item</th>   
                        <th>Core Item</th>   
                        <th>Core Available</th> 
                    </tr> 
                    </thead>
                    <tbody>
                        <?php /* foreach($record_list as $cust => $info) {  ?>
                        <!--<tr>
                            <td class="text-left"><?php echo $cust?></td> 
                            <td colspan="3"></td>
                        </tr>-->
                        <?php  foreach($info as $pat => $info2) {  ?>
                        <!--<tr>
                            <td class="text-left"><?php echo $cust?></td>
                            <td class="text-left"><?php echo $pat?></td>
                            <td colspan="2"></td>
                        </tr>--> 
                        <?php  foreach($info2 as $j => $info3) {  ?>
                        <tr>
                            <td class="text-left"><?php echo ($j+1)?></td> 
                            <?php if($j == 0) {?>
                            <td class="text-left"><?php echo $cust?></td>
                            <td class="text-left"><?php echo $pat?></td>
                            <?php } else { ?> 
                            <td colspan="2"></td>
                            <?php }  ?> 
                            <td class="text-left"><?php echo $info3['core_item']?></td> 
                            <td class="text-right"><?php echo number_format($info3['core_stock']);?></td>  
                        </tr>
                        <?php } ?> 
                        <?php } ?> 
                        <?php } * /?> 
                        <?php  foreach($record_list as $cust => $info) {  ?>
                         <tr>
                            <td class="text-left"><?php echo $cust?></td> 
                            <td colspan="3"></td>
                        </tr> 
                        <?php  foreach($info as $pat => $info2) {  ?>
                         <tr>
                            <td class="text-left"><?php //echo $cust?></td>
                            <td class="text-left"><?php echo $pat?></td>
                            <td colspan="2"></td>
                        </tr>  
                        <?php  foreach($info2 as $j => $info3) {  ?>
                        <tr> 
                            <td colspan="2"></td> 
                            <td class="text-left"><?php echo $info3['core_item']; ?></td> 
                            <td class="text-right"><?php echo number_format($info3['core_stock']);?></td>  
                        </tr>
                        <?php } ?> 
                        <?php } ?> 
                        <?php } ?> 
                    </tbody>
                     
                </table>  
                 
                  <?php } */ ?>
            </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
