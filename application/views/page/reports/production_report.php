<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Production Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">Production Report</li>
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
              <h3 class="box-title text-white">Production Report : <span><i> [ <?php echo date('d-m-Y', strtotime($srch_from_date))  ?> to <?php echo date('d-m-Y', strtotime($srch_to_date)) ?> ]</i></span></h3> 
            </div>
            <div class="box-body text-center">    
            <div class="sticky-table-demo">    
                <?php  if(!empty($record_list)) { ?>    
                  
                    <table class="table table-bordered table-condensed">
                    <thead>
                    <tr class="bg-green-gradient"> 
                        <th>#</th> 
                        <th>Item</th> 
                        <th colspan="3" class="text-center">Moulding</th>  
                        <th colspan="2" class="text-center">Melting</th> 
                        <th colspan="3" class="text-center">LeftOut</th> 
                        <!--<th rowspan="2" class="text-center">Remarks</th>-->
                    </tr> 
                    <tr class="bg-green-gradient">          
                        <th></th> 
                        <th></th> 
                        <th class="text-center">Box</th> 
                        <th class="text-center">Qty</th> 
                        <th class="text-center">Closed Qty</th>
                        <th class="text-center">Box</th> 
                        <th class="text-center">Qty</th>
                        <th class="text-center">Box</th> 
                        <th class="text-center">Qty</th> 
                        <th class="text-center">Closed</th>  
                    </tr> 
                    </thead>
                    <tbody>
                        <?php  
                         $tot1['mould_box'] = $tot1['mould_qty'] = $tot1['closed_mould_qty'] = 0; 
                         $tot1['poured_box'] = $tot1['poured_qty'] = $tot1['leftout_box'] = $tot1['leftout_qty'] = 0; 
                        foreach($record_list as $date => $info1) {  
                        ?>
                            <tr>
                                <th colspan="9" class="text-fuchsia">Date : <?php echo date('d-m-Y', strtotime($date)); ?></th>
                            </tr>
                            <?php  
                             //$tot['qty'] = $tot['amt'] = 0;
                            foreach($info1 as $j => $info) {  
                                $tot1['mould_box'] += $info['mould_box']; 
                                $tot1['mould_qty'] += $info['mould_qty']; 
                                $tot1['closed_mould_qty'] += $info['closed_mould_qty']; 
                                $tot1['poured_box'] += $info['poured_box']; 
                                $tot1['poured_qty'] += $info['poured_qty']; 
                                $tot1['leftout_box'] += $info['leftout_box']; 
                                $tot1['leftout_qty'] += $info['leftout_qty']; 
                            ?>
                            <tr>
                                <td><?php echo ($j+1); ?></td> 
                                <td class="text-left"><?php echo $info['item']?></td>
                                <td class="text-right"><?php echo number_format($info['mould_box'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['mould_qty'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['closed_mould_qty'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['poured_box'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['poured_qty'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['leftout_box'],0);?></td>
                                <td class="text-right"><?php echo number_format($info['leftout_qty'],0);?></td>
                                <td class="text-right"><?php echo $info['leftout_box_close'];?></td>
                                <!--<td class="text-right"><?php if($info['mould_box'] == $info['poured_box']) echo ""; elseif($info['mould_box'] > $info['poured_box']) echo "Shortage"; else echo "Extra Poured"; ?></td>-->
                            </tr>
                            <?php } ?>
                             
                        <?php } ?>
                            <tr class="text-blue">
                                <th colspan="2">Total</th>
                                <th class="text-right"><?php echo number_format($tot1['mould_box'],0);?></th>
                                <th class="text-right"><?php echo number_format($tot1['mould_qty'],0);?></th>
                                <th class="text-right"><?php echo number_format($tot1['closed_mould_qty'],0);?></th>
                                <th class="text-right"><?php echo number_format($tot1['poured_box'],0);?></th>
                                <th class="text-right"><?php echo number_format($tot1['poured_qty'],0);?></th>
                                <th class="text-right"><?php echo number_format($tot1['leftout_box'],0);?></th>
                                <th class="text-right"><?php echo number_format($tot1['leftout_qty'],0);?></th>
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
