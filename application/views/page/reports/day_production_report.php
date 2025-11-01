<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($op_stock_list);
echo "</pre>"; */
?>
 <section class="content-header">
  <h1>Day Production Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">Day Production Report</li>
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
              <h3 class="box-title text-white">Day Production Report : <span><i> [ <?php echo date('d-m-Y' , strtotime($srch_date)) ?> To <?php echo date('d-m-Y' , strtotime($srch_to_date)) ?> ]  </i></span></h3> 
            </div>
            <div class="box-body table-responsive">
                <div class="sticky-table-demo">      
                <?php  if(!empty($op_stock_list)) { ?>   
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                    <tr class="bg-blue-gradient">   
                        <th>Item</th>  
                        <th colspan="2" class="text-center">Opening Stock</th> 
                        <th colspan="2" class="text-center">Produced</th> 
                        <th colspan="2" class="text-center">Rejection </th> 
                        <th colspan="2" class="text-center">Despatch </th> 
                        <th colspan="2" class="text-center">Stock Adj</th> 
                        <th colspan="2" class="text-center">Closing Stock</th>
                    </tr> 
                    <tr class="bg-blue-gradient">
                        <th></th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Wt</th>
                    </tr>
                    </thead>
                    <tbody>
                         <?php 
                            $tot['opening_stock'] = $tot['curr_produced'] = $tot['curr_rejection']= $tot['curr_despatch'] = $tot['curr_adj_stock'] = $tot['closing_stock']= 0;
                         foreach($op_stock_list as $customer => $info1) {  ?> 
                         <tr>
                            <th colspan="11">Customer : <?php echo $customer; ?></th>
                         </tr>
                         <?php foreach($info1 as $pattern => $info2) {  ?>
                         <?php foreach($info2 as $j => $info) {  
                            $tot['opening_stock'] += ($info['opening_stock'] * $info['piece_weight_per_kg']);
                            $tot['curr_produced'] += ($info['curr_produced_qty'] * $info['piece_weight_per_kg']);
                            $tot['curr_rejection'] += ($info['curr_rejection_qty'] * $info['piece_weight_per_kg']);
                            $tot['curr_despatch'] += ($info['curr_despatch_qty'] * $info['piece_weight_per_kg']);
                            $tot['curr_adj_stock'] += ($info['curr_adj_stock_qty'] * $info['piece_weight_per_kg']);
                            $tot['closing_stock'] += ((($info['opening_stock'] + $info['curr_produced_qty']) - (  $info['curr_rejection_qty'] + $info['curr_despatch_qty'] + $info['curr_adj_stock_qty'])) * $info['piece_weight_per_kg']);
                         ?>
                            
                            <tr>
                                <td><?php echo $info['pattern_item']; ?></td> 
                                <td class="text-right"><?php echo number_format($info['opening_stock'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['opening_stock'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_produced_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_produced_qty'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_rejection_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_rejection_qty'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_despatch_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_despatch_qty'] * $info['piece_weight_per_kg']),3); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_adj_stock_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format(($info['curr_adj_stock_qty'] * $info['piece_weight_per_kg']),3); ?></td> 
                                <td class="text-right"><?php echo number_format((($info['opening_stock'] + $info['curr_produced_qty']) - (  $info['curr_rejection_qty'] + $info['curr_despatch_qty'] + $info['curr_adj_stock_qty'])),0); ?></td>
                                <td class="text-right"><?php echo number_format(((($info['opening_stock'] + $info['curr_produced_qty']) - (  $info['curr_rejection_qty'] + $info['curr_despatch_qty'] + $info['curr_adj_stock_qty'])) * $info['piece_weight_per_kg']),3 ); ?></td>
                            </tr>
                         <?php } ?> 
                         <?php } ?> 
                         <?php } ?> 
                         <tr>
                            <th>Total Weight</th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tot['opening_stock'],3); ?></th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tot['curr_produced'],3); ?></th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tot['curr_rejection'],3); ?></th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tot['curr_despatch'],3); ?></th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tot['curr_adj_stock'],3); ?></th>
                            <th></th>
                            <th class="text-right"><?php echo number_format($tot['closing_stock'],3); ?></th>
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
