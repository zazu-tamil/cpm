<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Work Order Planning Statement</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Work Order Planning Statement</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date);?>" required>
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
              <h3 class="box-title text-white">Work Order Planning Statement</h3> 
              <h3 class="box-title text-white pull-right">M J P Enterprises Private Limited  </h3> 
            </div>
            <div class="box-body">  
                <div class="sticky-table-demo table-responsive">   
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th rowspan="2" class="text-center">SNo</th>
                        <th rowspan="2" class="text-left">Item</th> 
                        <th rowspan="2" class="text-left">PO CF</th> 
                        <th rowspan="2" class="text-left">PO Cur</th> 
                        <th rowspan="2" class="text-left">Opening Stock</th> 
                        <th rowspan="2" class="text-left">Planned</th> 
                        <th rowspan="2" class="text-left">Produced</th> 
                        <th rowspan="2" class="text-left">Rejection</th> 
                        <th rowspan="2"class="text-left">Despatch</th> 
                        <th colspan="2" class="text-left">Closing Stock</th> 
                        <th colspan="4" class="text-center">To Be Plan</th>    
                    </tr> 
                    <tr class="bg-blue-gradient">
                        <th>Qty</th>
                        <th>Qty.Wt</th>
                        <th>Qty</th>
                        <th>Qty.Wt</th>
                        <th>Box</th>
                        <th>Box.Wt</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php   
                        $cum_qty_wt = $cum_box_wt = $cum_box = $cum_closing_stock_wt =  0;
                        foreach($record_list as $customer => $pattern_list) {  ?>
                        <tr>
                            <th colspan="15"><?php echo $customer;?></th>
                        </tr>
                        <?php   
                            $tot_qty = $tot_qty_wt = 0;
                            $tot_box = $tot_box_wt = 0;
                            $tot_closing_stock = $tot_closing_stock_wt = 0;
                            foreach($pattern_list as $j => $info) {  
                            $to_be_plan = (($info['cf_ord_qty'] + $info['curr_order_qty']) - ($info['curr_despatch_qty'] + $info['closing_stock']));    
                            
                            $tot_closing_stock += $info['closing_stock'];
                            $tot_closing_stock_wt += ($info['closing_stock'] * $info['piece_weight_per_kg']);
                            if($to_be_plan > 0 )
                            {
                                $tot_qty += $to_be_plan;
                                $tot_qty_wt += $to_be_plan * $info['piece_weight_per_kg'];
                            }
							if($info['item_type'] == 'Parent'){
								if($to_be_plan > 0  and $info['no_of_cavity'] > 0 )
								{
									$box = ($to_be_plan / $info['no_of_cavity']);
									$tot_box += ($to_be_plan / $info['no_of_cavity']);
									$box_wt = (($to_be_plan / $info['no_of_cavity']) * $info['bunch_weight']);
									$tot_box_wt += (($to_be_plan / $info['no_of_cavity']) * $info['bunch_weight']);
								} else {
									$box = $box_wt = 0;
								}
							} else  {    
								
									$tot_box += 0;
									$tot_box_wt += 0;
									$box = $box_wt = 0;
							}
                        ?>
                        <tr>
                            <td class="text-center"><?php echo ($j+1)?></td> 
                            <td class="text-left"><?php echo $info['pattern_item']?><br /> [ <i><?php echo $info['item_type']?></i> ]</td> 
                            <td class="text-right"><?php echo number_format($info['cf_ord_qty'],0)?></td>  
                            <td class="text-right"><?php echo number_format($info['curr_order_qty'],0)?></td>  
                            <td class="text-right"><?php echo number_format($info['opening_stock'],0)?></td>    
                            <td class="text-right"><?php echo number_format($info['curr_planned_qty'],0)?></td>    
                            <td class="text-right"><?php echo number_format($info['curr_produced_qty'],0)?></td>    
                            <td class="text-right"><?php echo number_format($info['curr_rejection_qty'],0)?></td>    
                            <td class="text-right"><?php echo number_format($info['curr_despatch_qty'],0)?></td>    
                            <td class="text-right"><?php echo number_format($info['closing_stock'],0)?></td>     
                            <td class="text-right"><?php echo number_format(($info['closing_stock'] * $info['piece_weight_per_kg']),3)?></td>     
                            <td class="text-right"><?php if($to_be_plan > 0 ) echo number_format($to_be_plan ,0); else echo "0";?></td>    
                            <td class="text-right"><?php if($to_be_plan > 0 ) echo number_format(($to_be_plan * $info['piece_weight_per_kg'] ) ,3); else echo "0";?></td>    
                            <td class="text-right"><?php if($to_be_plan > 0 and $info['no_of_cavity'] > 0 ) echo number_format($box ,0); else echo "0";?></td>    
                            <td class="text-right"><?php if($to_be_plan > 0 and $info['no_of_cavity'] > 0 ) echo number_format( $box_wt ,3); else echo "0";?></td>    
                             
                        </tr>
                        <?php 
                        
                        } ?>
                        <tr>
                            <th colspan="9"></th>
                            <th class="text-right"><?php echo number_format($tot_closing_stock,0)?></th>
                            <th class="text-right"><?php echo number_format($tot_closing_stock_wt,3)?></th>
                            <th class="text-right"><?php echo number_format($tot_qty,0)?></th>
                            <th class="text-right"><?php echo number_format($tot_qty_wt,3)?></th>
                            <th class="text-right"><?php echo number_format($tot_box,0)?></th>
                            <th class="text-right"><?php echo number_format($tot_box_wt,3)?></th>
                        </tr>
                        <?php 
                        $cum_qty_wt += $tot_qty_wt;
                        $cum_box_wt += $tot_box_wt;
                        $cum_box += $tot_box;
                        $cum_closing_stock_wt += $tot_closing_stock_wt;
                        } ?> 
                        <tr class="text-fuchsia">
                            <th colspan="9">Cumulative </th>
                            <th class="text-right"></th> 
                            <th class="text-right"><?php echo number_format($cum_closing_stock_wt,3)?></th>
                            <th class="text-right"></th> 
                            <th class="text-right"><?php echo number_format($cum_qty_wt,3)?></th> 
                            <th class="text-right"><?php echo number_format($cum_box,0)?></th>
                            <th class="text-right"><?php echo number_format($cum_box_wt,3)?></th>
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
