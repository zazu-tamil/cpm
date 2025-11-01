<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Production Summary Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Production Summary Report</li>
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
              <h3 class="box-title text-white">Production Summary Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body">  
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Date</th> 
                        <th>Item</th> 
                        <th>Opening Stock</th> 
                        <th colspan="3">Planned</th> 
                        <th colspan="2">Produced</th> 
                        <th colspan="2">Rejection</th> 
                        <th colspan="2">Despatched</th> 
                        <th>Closing Stock</th>
                    </tr> 
                    <tr style="text-align: center;"> 
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th>Box</th>  
                        <th>Qty</th>  
                        <th>Wt</th> 
                        <th>Qty</th>  
                        <th>Wt</th>
                        <th>Qty</th>  
                        <th>Wt</th>
                        <th>Qty</th>  
                        <th>Wt</th>
                        <th>Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $closing_stock = 0;
                            $tot['planned_box']=$tot['planned_qty']= $tot['produced_qty'] = $tot['rejection_qty']=  $tot['despatch_qty'] = 0;
                            $tot['planned_wt']= $tot['produced_wt'] = $tot['rejection_wt']=  $tot['despatch_wt'] = 0;
                        foreach($record_list as $j => $info) { 
                          
                          $tot['planned_box'] += $info['planned_box'];  
                          $tot['planned_qty'] += $info['planned_qty'];  
                          $tot['planned_wt'] += ($info['planned_qty'] * $info['piece_weight_per_kg']) ;  
                          $tot['produced_qty'] += $info['produced_qty'];  
                          $tot['produced_wt'] += ($info['produced_qty'] * $info['piece_weight_per_kg']) ; 
                          $tot['rejection_qty'] += $info['rejection_qty'];  
                          $tot['rejection_wt'] += ($info['rejection_qty'] * $info['piece_weight_per_kg']) ; 
                          $tot['despatch_qty'] += $info['despatch_qty'];  
                          $tot['despatch_wt'] += ($info['despatch_qty'] * $info['piece_weight_per_kg']) ;
                          
                         // $closing_stock =  (($info['openning_stock'] + $info['produced_qty']) - ($info['rejection_qty'] + $info['despatch_qty']));
                          $closing_stock =  (($info['openning_stock'] + $info['produced_qty']) - ( $info['despatch_qty']));
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td class="text-left"><?php echo date('d-m-Y', strtotime($info['m_date'])); ?></td> 
                            <td class="text-left"><?php echo $info['pattern_item'] . $info['pattern_id']?></td> 
                            <td class="text-right"><?php echo number_format($info['openning_stock']);?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_box']);?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_qty']);?></td> 
                            <td class="text-right"><?php echo number_format(($info['planned_qty'] * $info['piece_weight_per_kg']),3);?></td> 
                            <td class="text-right"><?php echo number_format($info['produced_qty']);?></td> 
                            <td class="text-right"><?php echo number_format(($info['produced_qty'] * $info['piece_weight_per_kg']),3);?></td>
                            <td class="text-right"><?php echo number_format($info['rejection_qty']);?></td> 
                            <td class="text-right"><?php echo number_format(($info['rejection_qty'] * $info['piece_weight_per_kg']),3);?></td>
                            <td class="text-right"><?php echo number_format($info['despatch_qty']);?></td> 
                            <td class="text-right"><?php echo number_format(($info['despatch_qty'] * $info['piece_weight_per_kg']),3);?></td>
                            <td class="text-right"><?php echo number_format($closing_stock ,0);?></td> 
                        </tr>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="4">Total</th> 
                                <th class="text-right"><?php echo number_format($tot['planned_box'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_wt'],3)?></th>
                                <th class="text-right"><?php echo number_format($tot['produced_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['produced_wt'],3)?></th>
                                <th class="text-right"><?php echo number_format($tot['rejection_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['rejection_wt'],3)?></th>
                                <th class="text-right"><?php echo number_format($tot['despatch_qty'],0)?></th> 
                                <th class="text-right"><?php echo number_format($tot['despatch_wt'],3)?></th>
                                <th></th> 
                            </tr>
                        </tfoot>
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
