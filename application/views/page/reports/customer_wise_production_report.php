<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Customer Wise Moulding Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Moulding Report</a></li> 
    <li class="active">Customer Wise Moulding Report</li>
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
         <?php if(($submit_flg)) { ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Customer Wise Moulding Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive">   
                <div class="sticky-table-demo">    
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Date</th> 
                        <th>Customer</th>  
                        <th>Item</th> 
                        <th colspan="3">Planned</th>  
                        <th colspan="3">Produced</th>  
                        <th class="text-center">Breakdown</th> 
                        <th class="text-left">Breakdown <br> Remarks</th> 
                        <th class="text-center">Efficiency</th> 
                    </tr> 
                    <tr class="bg-blue-gradient">
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th> 
                        <th>Box</th>  
                        <th>Qty</th>  
                        <th>B.Wt</th> 
                        <th>Box</th>  
                        <th>Qty</th>  
                        <th>Wt</th>  
                        <th class="text-center">Hrs</th> 
                        <th></th> 
                        <th></th> 
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $tot['planned_box'] = $tot['planned_qty']= $tot['planned_box_wt']= $tot['produced_box'] = $tot['produced_qty'] = 0;
                            $tot['produced_wt']=0;
                            $tot['eff']=0;
                            $tot['breakdown_sec']=0;
                        foreach($record_list as $j => $info) { 
                          
                          $tot['eff'] += $info['eff'];  
                          $tot['breakdown_sec'] += $info['breakdown_sec'];  
                          $tot['planned_box'] += $info['planned_box'];  
                          $tot['planned_qty'] += $info['planned_qty'];  
                          $tot['planned_box_wt'] += $info['planned_box_wt'];  
                          $tot['produced_box'] += $info['produced_box'];  
                          $tot['produced_qty'] += $info['produced_qty'];  
                          $tot['produced_wt'] += ($info['produced_qty'] * $info['piece_weight_per_kg']) ;  
                           
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td class="text-left"><?php echo date('d-m-Y', strtotime($info['m_date'])); ?></td> 
                            <td class="text-left"><?php echo $info['customer']?></td>  
                            <td class="text-left"><?php echo $info['pattern_item']?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_box']);?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_qty']);?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_box_wt'],3);?></td> 
                            <td class="text-right"><?php echo number_format($info['produced_box']);?></td> 
                            <td class="text-right"><?php echo number_format($info['produced_qty']);?></td> 
                            <td class="text-right"><?php echo number_format(($info['produced_qty'] * $info['piece_weight_per_kg']),3);?></td>
                            <td class="text-center"><?php echo ($info['breakdown'])?></td> 
                            <td><?php echo $info['breakdown_remarks']; ?></td>
                            <td class="text-center"><?php echo number_format($info['eff'],2)?></td>                             
                        </tr>
                        <?php } ?>
                        <?php 
                        if(isset($child_record_list[$info['work_planning_id']])) {
                        foreach($child_record_list[$info['work_planning_id']] as $j1 => $info1) {  
                         $tot['produced_qty'] += ($info['produced_box'] * $info1['no_of_cavity']);
                         $tot['produced_wt'] += ($info['produced_box'] * $info1['piece_weight_per_kg']);
                        ?>
                        <tr class="text-fuchsia">
                            <td><?php //echo ($j1+1)?>Child</td>
                            <td class="text-left"><?php echo date('d-m-Y', strtotime($info1['m_date'])); ?></td> 
                            <td class="text-left"><?php echo $info1['customer']?></td>  
                            <td class="text-left"><?php echo $info1['pattern_item']?></td> 
                            <td class="text-right">-</td> 
                            <td class="text-right">-</td> 
                            <td class="text-right">-</td> 
                            <td class="text-right">-</td> 
                            <td class="text-right"><?php echo number_format(($info['produced_box'] * $info1['no_of_cavity']));?></td> 
                            <td class="text-right"><?php echo number_format(($info['produced_box'] * $info1['piece_weight_per_kg']),3);?></td>
                            <td class="text-center">-</td> 
                            <td class="text-center">-</td> 
                            <td class="text-center">-</td> 
                        </tr>
                        <?php } ?>
                        <?php } 
                        // Convert to hours and minutes
                        $hours = floor($tot['breakdown_sec'] / 3600);
                        $minutes = floor(($tot['breakdown_sec'] % 3600) / 60);

                        // Format like HH:MM
                        $total_breakdown_time = sprintf("%02d:%02d", $hours, $minutes);
                        ?> 
                            <tr>
                                <th class="text-right" colspan="4">Total</th>
                                <th class="text-right"><?php echo number_format($tot['planned_box'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_box_wt'],3)?></th> 
                                <th class="text-right"><?php echo number_format($tot['produced_box'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['produced_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['produced_wt'],3)?></th> 
                                <th class="text-center"><?php echo $total_breakdown_time; ?></th>
                                <th></th>
                                <th class="text-center"><?php echo number_format(($tot['eff'] / count($record_list)),2)?></th>
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
