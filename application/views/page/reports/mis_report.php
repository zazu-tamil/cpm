<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($op_stock_list);
echo "</pre>"; */
?>
 <section class="content-header">
  <h1>MIS Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">MIS Report</li>
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
              <h3 class="box-title text-white">MIS Report : <span><i> [ <?php echo date('d-m-Y' , strtotime($srch_date)) ?> To <?php echo date('d-m-Y' , strtotime($srch_to_date)) ?> ]  </i></span></h3>
              
            </div>
            <div class="box-body table-responsive">
            <div class="sticky-table-demo">      
                <?php  if(!empty($op_stock_list)) { ?>   
                    <table class="table table-bordered table-striped">        
                    <thead>
                    <tr class="bg-green-gradient">   
                        <th>Item</th>    
                        <th colspan="2" class="text-center">Produced</th>                          
                        <th colspan="2" class="text-center">Despatch </th>
						<th colspan="2" class="text-center">Rejection </th>						
                        <th colspan="5" class="text-center">Rejection Break-Up </th> 
                    </tr> 
                    <tr class="bg-green-gradient">     
                        <th></th> 
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th> 
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th> 
						<th class="text-right">Rej.Type</th>
						<th class="text-right">Qty</th>
                        <th class="text-right">Wt</th> 
                        <th class="text-right">Qty Rej %</th> 
                        <th class="text-right">Wt Rej %</th> 
                    </tr>
                    </thead>
                    <tbody>
                         <?php 
                            $tot['opening_stock'] = $tot['curr_produced'] = $tot['curr_rejection']= $tot['curr_despatch'] = $tot['closing_stock']= 0;
                            $tot['curr_produced_qty'] = $tot['curr_rejection_qty']= $tot['curr_despatch_qty'] = 0;
                         foreach($op_stock_list as $customer => $info1) {  ?> 
                         <tr>
                            <th colspan="12">Customer : <?php echo $customer; ?></th>
                         </tr>
                         <?php foreach($info1 as $pattern => $info2) {  ?>
                         <?php foreach($info2 as $j => $info) {  
                             $tot['curr_produced'] += ($info['curr_produced_qty'] * $info['piece_weight_per_kg']);
                             $tot['curr_rejection'] += ($info['curr_rejection_qty'] * $info['piece_weight_per_kg']);
                             $tot['curr_despatch'] += ($info['curr_despatch_qty'] * $info['piece_weight_per_kg']);
                             
                             $tot['curr_produced_qty'] += ($info['curr_produced_qty']);
                             $tot['curr_rejection_qty'] += ($info['curr_rejection_qty']);
                             $tot['curr_despatch_qty'] += ($info['curr_despatch_qty']);
                         ?>
                            
                            <tr>
                                <td><?php echo $info['pattern_item']; ?></td> 
                                <td class="text-right"><?php echo number_format($info['curr_produced_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_produced_qty'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_despatch_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_despatch_qty'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_rejection_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_rejection_qty'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td colspan="5"> 
                                    <?php if($info['curr_rejection_qty'] > 0) { ?> 
                                    <i>
                                    <table class="table table-bordered table-responsive">
                                        <?php foreach($rej_list[$info['customer_id']][$info['pattern_id']] as  $rej_grp => $det) {?>
                                        <tr><th colspan="5" class="text-center"><?php echo $rej_grp; ?></th></tr>
                                        <?php 
										$tot_rg_qty = $tot_rg_qty_wt = $tot_rg_qty_pet = 0;
										foreach($det as $rj) { 
										$tot_rg_qty += $rj['rej_qty'];
										$tot_rg_qty_wt += $rj['rej_qty'] * $info['piece_weight_per_kg'];
										 
										?>
                                        <tr>                                            
                                            <td><?php echo $rj['rejection_type_name']; ?></td>
											 <td class="text-right"><?php echo number_format(($rj['rej_qty']),0); ?></td> 
											 <td class="text-right"><?php echo number_format(($rj['rej_qty'] * $info['piece_weight_per_kg']),3); ?></td> 
                                            <td class="text-right"><?php echo number_format(($rj['rej_qty'] * 100 / $info['curr_produced_qty']),2); ?>%</td> 
                                            <td class="text-right"><?php echo number_format((($rj['rej_qty'] * $info['piece_weight_per_kg']) * 100 / $info['curr_produced_qty']),2); ?>%</td> 
                                        </tr>
                                        <?php } ?>
										<tr>
											<th><?php echo $rej_grp; ?> - Total</th>
											<th class="text-right"><?php echo number_format(($tot_rg_qty),0); ?></th>
											<th class="text-right"><?php echo number_format(($tot_rg_qty_wt),3); ?></th>
											<th class="text-right"><?php echo number_format((($tot_rg_qty * 100) / $info['curr_produced_qty']),2); ?>%</th>
											<th class="text-right"><?php echo number_format((($tot_rg_qty_wt * 100) / ($info['curr_produced_qty'] * $info['piece_weight_per_kg'])),2); ?>%</th>
										</tr>				
                                        <?php } ?> 
										<tr> 
											<th class="text-right" colspan="3">Total Rejection %</th>
											<th class="text-right"><?php echo number_format((($info['curr_rejection_qty'] * 100) / $info['curr_produced_qty']),2); ?>%</th>
											<th class="text-right"><?php echo number_format(((($info['curr_rejection_qty'] * $info['piece_weight_per_kg']) * 100) / ($info['curr_produced_qty'] * $info['piece_weight_per_kg'])),2); ?>%</th>
										</tr>	
                                    </table>
                                    </i>
                                    <?php } ?>    
                                </td>
                         <?php } ?> 
                            </tr>
                         <?php } ?> 
                         <?php } ?> 
                         <tr>
                            <th>Total Weight</th> 
                            <th class="text-right"><?php echo number_format($tot['curr_produced_qty'],0); ?></th>                            
                            <th class="text-right"><?php echo number_format($tot['curr_produced'],3); ?></th>                            
                            <th class="text-right"><?php echo number_format($tot['curr_despatch_qty'],0); ?></th> 
                            <th class="text-right"><?php echo number_format($tot['curr_despatch'],3); ?></th> 
							<th class="text-right"><?php echo number_format($tot['curr_rejection_qty'],0); ?></th> 
                            <th class="text-right"><?php echo number_format($tot['curr_rejection'],3); ?></th>							
                            <th class="text-right" colspan="2">Based On Weight : <?php echo number_format((($tot['curr_rejection'] * 100) / $tot['curr_produced']),2); ?>%</th>
							<th colspan="3">Based On Qty : <?php echo number_format((($tot['curr_rejection_qty'] * 100) / $tot['curr_produced_qty']),2); ?>%</th>
                         </tr>
                    </tbody>
                    </table>
                <?php  } ?>   
                 
                
                </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
