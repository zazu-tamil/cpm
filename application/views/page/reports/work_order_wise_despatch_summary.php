<?php  include_once(VIEWPATH . '/inc/header.php');  ?>
 <section class="content-header">
  <h1>PO Based Despatch Summary</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Despatch Summary</a></li> 
    <li class="active">PO Based Despatch Summary</li>
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
              <h3 class="box-title text-white">PO Based Despatch Summary : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive">  
                 <div class="sticky-table-demo">  
                <?php /*  if(!empty($record_list)) { ?>                                        
                    <table class="table table-bordered table-responsive"> 
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>OrderDate</th> 
                        <th>PO.No</th>  
                        <th>Item</th> 
                        <th>Commit.Date</th> 
                        <th class="text-right">Order Qty</th>  
                        <th class="text-left">Despatch Date</th>   
                        <th class="text-left">DC No</th>   
                        <th class="text-right">Despatch Qty</th> 
                    </tr>  
                    </thead>
                    <tbody>
                        <?php  
                         $tot1['qty'] = $tot1['wt'] = 0; 
                        foreach($record_list as $cust => $info1) {  
                        ?>
                            <tr>
                                <th colspan="7" class="text-blue">Customer : <?php echo $cust; ?></th>
                            </tr>
                            <?php  
                             //$tot['qty'] = $tot['wt'] = 0;
							 $wo = ''; $dq = 0;
                            foreach($info1 as $j => $info) {  
                             //   $tot['qty'] += $info['qty'];
                             //   $tot['wt'] += $info['wt'];
							 if($wo == '') {
								$wo = $info['work_order_item_id']; $dq += $info['despatch_qty'];
                            ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($info['order_date'])); ?></td>
                                <td><?php echo $info['customer_PO_No']?></td> 
                                <td><?php echo $info['pattern_item']?></td>
								<td><?php echo date('d-m-Y', strtotime($info['delivery_date'])); ?></td>
                                <td class="text-right"><?php echo number_format($info['qty'],0);?></td>
                                <td><?php if($info['despatch_qty'] > 0) echo date('d-m-Y', strtotime($info['despatch_date'])); ?></td> 
								<td><?php if($info['despatch_qty'] > 0) echo $info['dc_no']?></td>
                                <td class="text-right"><?php if($info['despatch_qty'] > 0) echo number_format($info['despatch_qty'],0);?></td> 
                            </tr>
                            <?php } elseif($wo == $info['work_order_item_id']){  $dq += $info['despatch_qty']; ?>
							<tr>
                                <td colspan="5"> </td>
                                <td><?php if($info['despatch_qty'] > 0) echo date('d-m-Y', strtotime($info['despatch_date'])); ?></td> 
								<td><?php if($info['despatch_qty'] > 0) echo $info['dc_no']?></td>
                                <td class="text-right"><?php if($info['despatch_qty'] > 0) echo number_format($info['despatch_qty'],0);?></td> 
                            </tr>
                            <?php } else { ?>
							<tr>
                            <th colspan="7" class="text-right">Total</th>
                            <th class="text-right"><?php if($dq > 0) echo number_format($dq,0);?></th>
                            </tr>
							<tr>
                                <td><?php echo date('d-m-Y', strtotime($info['order_date'])); ?></td>
                                <td><?php echo $info['customer_PO_No']?></td> 
                                <td><?php echo $info['pattern_item']?></td>
								<td><?php echo date('d-m-Y', strtotime($info['delivery_date'])); ?></td>
                                <td class="text-right"><?php echo number_format($info['qty'],0);?></td>
                                <td><?php if($info['despatch_qty'] > 0) echo date('d-m-Y', strtotime($info['despatch_date'])); ?></td> 
								<td><?php if($info['despatch_qty'] > 0) echo $info['dc_no']?></td>
                                <td class="text-right"><?php if($info['despatch_qty'] > 0) echo number_format($info['despatch_qty'],0);?></td>  
                            </tr>
                            <?php $dq = $info['despatch_qty']; $wo = $info['work_order_item_id']; }  ?>
                            <?php }  ?>
                             
                        <?php 
                               // $tot1['qty'] += $tot['qty'];
                               // $tot1['wt'] += $tot['wt'];
                        } ?>
                             
                    </tbody>
                    </table>
                  <?php } */ ?>
                  
                  <?php  if(!empty($record_list1)) { ?>                                        
                    <table class="table table-bordered table-responsive"> 
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>OrderDate</th> 
                        <th>PO.No</th>  
                        <th>Item</th> 
                        <th>Commit.Date</th> 
                        <th class="text-right">Order Qty</th>  
                        <th class="text-left">Despatch Date</th>   
                        <th class="text-left">DC No</th>   
                        <th class="text-right">Despatch Qty</th> 
                    </tr>  
                    </thead>
                    <tbody>
                        <?php  
                         
                        foreach($record_list1 as $cust => $info) {  
                        ?>
                         <tr>
                            <th colspan="7" class="text-blue">Customer : <?php echo $cust; ?></th>
                        </tr>
                        <?php  
                          
                        foreach($info as $id => $info1) {  
                            $tot1['qty'] = $tot1['wt'] = 0; $ord_qty = 0; $intl_days = 0;
                        foreach($info1 as $j => $info2) { 
                            $tot1['qty'] += $info2['despatch_qty']; 
                            $ord_qty = $info2['qty']; 
                            
                            //if(count($info1) == ($j-1)){ 
                                //$cm_dt = new DateTime($info2['delivery_date']);
                                //$l_dly_dt = new DateTime($info2['despatch_date']);
                                //$interval = $l_dly_dt->diff($cm_dt); 
                                //$intl_days = $interval->format('%a');
                                //$intl_days = $interval->d;
                                $intl_days = $info2['diff'];
                           // }
                        ?>
                         <tr>
                                <?php if($j == 0) { ?>
                                <td><?php echo date('d-m-Y', strtotime($info2['order_date'])); ?></td>
                                <td><?php echo $info2['customer_PO_No']?></td> 
                                <td><strong><?php echo $info2['pattern_item']?></strong></td>
								<td><?php echo date('d-m-Y', strtotime($info2['delivery_date'])); ?></td>
                                <td class="text-right"><strong><?php echo number_format($info2['qty'],0);?></strong></td>
                                <?php } else {?>
                                <td colspan="5">&nbsp;</td>
                                <?php } ?>
                                <td><?php if($info2['despatch_qty'] > 0) echo date('d-m-Y', strtotime($info2['despatch_date'])); ?></td> 
								<td><?php if($info2['despatch_qty'] > 0) echo $info2['dc_no']?></td>
                                <td class="text-right"><?php if($info2['despatch_qty'] > 0) echo number_format($info2['despatch_qty'],0);?></td> 
                            </tr>   
                        <?php }
                        
                          $act_ord_qty = $ord_qty - ($ord_qty * 15/100);
                          $qty_rating = ($tot1['qty'] * 100 / $act_ord_qty); 
                         ?>
                        <tr>
                            <th colspan="2" class="text-right text-info">Despatch : <?php if($tot1['qty'] > 0 ) echo number_format($qty_rating,0) ."%";?></th>
                            <th class="text-center text-info"><?php if($tot1['qty'] > 0 ) echo  (int) $intl_days. " Days";?></th>
                            <th colspan="2" class="text-center text-info">Balance : <?php if($tot1['qty'] > 0 ) echo ($ord_qty - $tot1['qty']) ;?></th>
                            <th colspan="2" class="text-right text-info">Total Despatch Qty</th>
                            <th class="text-right"><?php echo number_format($tot1['qty'],0);?></th>
                        </tr>
                        <?php  if($qty_rating >= 100){  
                            if($intl_days >= 0) 
                                $delivery_rating = 100;    
                            elseif(abs($intl_days) <= 3) 
                                $delivery_rating = 95;    
                            elseif(abs($intl_days) <= 7) 
                                $delivery_rating = 90;    
                            elseif(abs($intl_days) <= 14) 
                                $delivery_rating = 75;  
                            elseif(abs($intl_days) > 14) 
                                $delivery_rating = 50;   
								
								
								
                        ?> 
                          <tr>
                            <th colspan="4" class="text-center text-white bg-maroon-gradient">Qty Rating : 100%</th>
                            <th colspan="4" class="text-center text-white bg-maroon-gradient">Delivery Rating : <?php echo $delivery_rating;?>% </th>
                          </tr>  
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
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
