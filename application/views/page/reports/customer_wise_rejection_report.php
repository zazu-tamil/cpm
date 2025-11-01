<?php  include_once(VIEWPATH . '/inc/header.php'); 
//echo $tot_rej_qty11;
?>
 <section class="content-header">
  <h1>Customer Wise Rejection Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Rejection Report</a></li> 
    <li class="active">Customer Wise Rejection Report</li>
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
             </div> 
             <div class="row">
                <div class="form-group col-md-2">
                    <label>Department</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_grp',array('' => 'All Department') + $rejection_grp_opt ,set_value('srch_rej_grp') ,' id="srch_rej_grp" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-2">
                    <label>Rejection Type</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_type_id',array('' => 'All Rejection Type') + $rejection_typ_opt  ,set_value('srch_rej_type_id') ,' id="srch_rej_type_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div> 
                 <div class="form-group col-md-2">
                    <label>Rejection % More Than</label>
                      <div class="input-group">
                         <input type="number" name="srch_more_than" class="form-control" step="any" value="<?php echo set_value('srch_more_than',$srch_more_than)?>"  />    
                      </div>                                   
                 </div> 
					<div class="form-group col-md-2">
					<label>Shift</label>
					  <div class="input-group">
						<?php echo form_dropdown('srch_shift',$shift_opt ,set_value('srch_shift' , $srch_shift) ,' id="srch_shift" class="form-control" ');?> 
							
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
         <?php if(($submit_flg)) {   ?>    
         <?php  if(!empty($record_list1)) { ?>      
         <div class="box box-success"> 
            <?php 
            /*echo "<pre>";
            print_r($record_list1);
            echo "</pre>";*/
            ?>
            <div class="box-header with-border">
              <h3 class="box-title text-white">Customer Wise Rejection Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive">  
                 <div class="sticky-table-demo">
                  <table class="table table-bordered table-responsive">
                    <thead>
                    <tr class="bg-blue-gradient"> 
                        <th>Date</th> 
                        <th>Customer</th>  
                        <th>Item</th> 
                        <th>Dept</th> 
                        <th>Rej.Type</th>
                        <th>Prod.Qty</th>  
                        <th>Prod.Wt</th>  
                        <th>Rej.Qty</th> 
                        <th>Rej.Wt</th> 
                        <th>Rej[%]</th> 
                    </tr> 
                    </thead>
                    <tbody>
                        <?php 
                            $tot = array(); $tot_prod_qty =$tot_rej_qty = $tot_rej_wt = $tot_prod_wt = 0;
                        foreach($record_list1 as $j => $info) { $tot[$j]['produced_wt'] = $tot[$j]['rejection_qty'] = $tot[$j]['rej_wt'] = $tot[$j]['produced_qty']=  0; ?>
                         <tr> 
                            <td><?php echo date('d-m-Y', strtotime($j))?></td> 
                            <td colspan="9"></td>
                         </tr>
                         <?php foreach($info as $a => $info1) { $tot[$a]['produced_wt'] = $tot[$a]['rejection_qty'] = $tot[$a]['rej_wt'] = $tot[$a]['produced_qty']= 0; ?>
                         <tr>
                            <td></td>
                            <td><?php echo $a?></td>
                            <td colspan="8"></td>
                         </tr>
                         <?php foreach($info1 as $b => $info2) { $tot[$b]['produced_wt'] =  $tot[$b]['rejection_qty'] = $tot[$b]['rej_wt'] = $tot[$b]['produced_qty']=  0 ; ?>
                         <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo $b?></td>
                            <td colspan="7"></td>
                         </tr>
                        <?php foreach($info2 as $c => $info3) { $tot[$c]['produced_wt'] =  $tot[$c]['rejection_qty'] = $tot[$c]['rej_wt'] = $tot[$c]['produced_qty']=  0 ; ?>
                         <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $c?></td>
                            <td colspan="6"></td>
                         </tr>
                         <?php foreach($info3 as $d => $info4) {  
                           
                         
                         $tot[$c]['produced_qty'] = $info4['produced_qty'];   
                         $tot[$c]['produced_wt'] = $info4['produced_wt'];   
                         $tot[$c]['rejection_qty'] += $info4['rejection_qty'];   
                         $tot[$c]['rej_wt'] += $info4['rej_wt'];   
                            
                           
                         ?>
                         <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $d?></td> 
                            <td class="text-right"><?php echo number_format($info4['produced_qty'],0)?></td> 
                            <td class="text-right"><?php echo number_format($info4['produced_wt'],3)?></td> 
                            <td class="text-right"><?php echo number_format($info4['rejection_qty'],0)?></td> 
                            <td class="text-right"><?php echo number_format($info4['rej_wt'],3)?></td> 
                            <td class="text-right"><?php echo number_format((( $info4['rej_wt'] /$info4['produced_wt']) * 100),2)?></td> 
                         </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total  [ <?php echo $c?> ] </th> 
                            <th></td>
                            <th class="text-right"><?php echo number_format($tot[$c]['produced_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$c]['produced_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format($tot[$c]['rejection_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$c]['rej_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format((($tot[$c]['rejection_qty'] / $tot[$c]['produced_qty']) * 100),2)?></th>
                        </tr>
                        <?php 
                         $tot[$b]['produced_qty'] = $tot[$c]['produced_qty'];   
                         $tot[$b]['produced_wt'] = $tot[$c]['produced_wt'];   
                         $tot[$b]['rejection_qty'] += $tot[$c]['rejection_qty'];   
                         $tot[$b]['rej_wt'] += $tot[$c]['rej_wt']; 
                         
                        } 
                         $tot[$a]['produced_qty'] = $tot[$b]['produced_qty'];   
                         $tot[$a]['produced_wt'] += $tot[$b]['produced_wt'];   
                         $tot[$a]['rejection_qty'] += $tot[$b]['rejection_qty'];   
                         $tot[$a]['rej_wt'] += $tot[$b]['rej_wt'];
                        ?>
                        <tr class="text-purple">
                            <th colspan="3" class="text-right">Total  [ <?php echo $b?> ] </th> 
                            <th></td>
                            <th></td>
                            <th class="text-right"><?php echo number_format($tot[$b]['produced_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$b]['produced_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format($tot[$b]['rejection_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$b]['rej_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format((($tot[$b]['rejection_qty'] / $tot[$b]['produced_qty']) * 100),2)?></th>
                        </tr>
                        <?php
                        $tot_prod_qty += $tot[$b]['produced_qty']; 
                        $tot_prod_wt += $tot[$b]['produced_wt'];
                        $tot_rej_qty += $tot[$b]['rejection_qty'];
                        $tot_rej_wt += $tot[$b]['rej_wt']; 
                        } 
                         $tot[$j]['produced_qty'] += $tot[$a]['produced_qty'];   
                         $tot[$j]['produced_wt'] += $tot[$a]['produced_wt'];   
                         $tot[$j]['rejection_qty'] += $tot[$a]['rejection_qty'];   
                         $tot[$j]['rej_wt'] += $tot[$a]['rej_wt'];
                        ?> 
                        <tr>
                            <th colspan="2" class="text-right">Total [ <?php echo $a?> ] </th> 
                            <th></td>
                            <th></td>
                            <th></td>
                            <th class="text-right"><?php echo number_format($tot[$a]['produced_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$a]['produced_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format($tot[$a]['rejection_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$a]['rej_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format((($tot[$a]['rejection_qty'] / $tot[$a]['produced_qty']) * 100),2)?></th>
                        </tr>
                        <?php } ?> 
                        <tr class="text-fuchsia">
                            <th class="text-right">Total  [ <?php echo date('d-m-Y', strtotime($j))?> ] </th> 
                            <th></td>
                            <th></td>
                            <th></td>
                            <th></td>
                            <th class="text-right"><?php echo number_format($tot[$j]['produced_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$j]['produced_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format($tot[$j]['rejection_qty'],0)?></th>
                            <th class="text-right"><?php echo number_format($tot[$j]['rej_wt'],3)?></th>
                            <th class="text-right"><?php echo number_format((($tot[$j]['rejection_qty'] / $tot[$j]['produced_qty']) * 100),2)?></th>
                        </tr>
                        <?php 
                            //$tot_prod_qty += $tot[$j]['produced_qty'];
                           // $tot_prod_wt += $tot[$j]['produced_wt'];
                           // $tot_rej_qty += $tot[$j]['rejection_qty'];
                           // $tot_rej_wt += $tot[$j]['rej_wt'];
                        } ?>
                        
                    </tbody>
                  </table> 
                  
                  
            </div>
            </div>
             <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-4"><strong>Prod.Qty : <?php echo number_format($production['production_qty'],0);?></strong></div> 
                    <div class="col-md-4"><strong>Rej.Qty : <?php echo number_format($tot_rej_qty,0);?></strong></div> 
                    <div class="col-md-4"><strong>Rej [%] : <?php echo number_format((($tot_rej_qty /$production['production_qty']) * 100),2);?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><strong>Prod.Wt : <?php echo number_format($production['production_wt'],3);?></strong></div>
                    <div class="col-md-4"><strong>Rej.Wt : <?php echo number_format($tot_rej_wt,3);?></strong></div>
                    <div class="col-md-4"><strong>Rej [%] : <?php echo number_format((($tot_rej_wt /$production['production_wt']) * 100),2);?></strong></div>
                </div>
             </div>
            </div> 
            <?php } ?> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
