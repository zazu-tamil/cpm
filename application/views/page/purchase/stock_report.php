<?php  include_once(VIEWPATH . '/inc/header.php'); 
/* 
echo "<pre>";
//print_r($op_stock_qty);
//print_r($op_issued_qty);
print_r($issued_qty);
//print_r($inward_qty);
print_r($item_opt);
echo "</pre>";   */ 
 
?>
 <section class="content-header">
  <h1>Stock Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Purchase</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Stock Report</a></li> 
    <li class="active">Stock Report</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date) ;?>">
                    </div>
                 </div> 
                 <div class="form-group col-md-3">
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date) ;?>">
                    </div>
                 </div> 
                <div class="form-group col-md-4">
                    <label>Item</label> 
                        <?php echo form_dropdown('srch_item_id',array('' => 'All Item') + $item_opt  ,set_value('srch_item_id') ,' id="srch_item_id" class="form-control"  ');?> 
                                                 
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
              <h3 class="box-title text-white">Stock Report from <?php echo date('d-m-Y' , strtotime($srch_from_date)); ?> to <?php echo date('d-m-Y' , strtotime($srch_to_date)); ?>  </h3> 
            </div>
            <div class="box-body">  
                <div class="sticky-table-demo1"> 
                <?php foreach($item_opt1 as $item_id => $itm) { ?>    
                    <div class="box box-info"> 
                        <div class="box-header with-border"><h3 class="box-title text-white"> ITEM : <?php echo strtoupper($itm); ?></h3></div> 
                        <div class="box-body">  
                            <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr class="bg-blue-gradient">   
                                    <th rowspan="2">Date</th>  
                                    <th rowspan="2" class="text-right">Opening Stock</th> 
                                    <th colspan="2" class="text-center">Inward Qty</th> 
                                    <th rowspan="2" class="text-right">Issued Qty</th> 
                                    <th rowspan="2" class="text-right">Adj Qty</th> 
                                    <th rowspan="2" class="text-right">Closing Stock</th>
                                </tr> 
                                <tr class="bg-blue-gradient">
                                    <th class="text-right">Pur Qty</th>
                                    <th class="text-right">Rej In-Qty</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                    $datediff = strtotime($srch_to_date) - strtotime($srch_from_date);
                                    $datediff = floor($datediff/(60*60*24));
                                    
                                    $tot_pur_qty = $tot_rej_qty = $tot_iss_qty = $tot_adj_qty = 0;
                                    
                                    for($i = 0; $i < $datediff + 1; $i++){
                                        $date = date("Y-m-d", strtotime($srch_from_date . ' + ' . $i . 'day')); 
                                        
                                    if(isset($inward_qty[$item_id][$date])) 
                                       $pur_qty =  $inward_qty[$item_id][$date];
                                    else 
                                       $pur_qty = 0;  
                                       
                                       
                                       
                                    if(isset($rej_inward_qty[$item_id][$date])) 
                                       $rej_qty =  $rej_inward_qty[$item_id][$date];
                                    else 
                                       $rej_qty = 0;   
                                    
                                    if(isset($issued_qty[$item_list[$item_id]][$date])) 
                                       $iss_qty =  $issued_qty[$item_list[$item_id]][$date];
                                    else 
                                       $iss_qty = 0;   
                                      
                                    if(isset($adj_qty[$item_id][$date])) 
                                       $adjt_qty =  $adj_qty[$item_id][$date];
                                    else 
                                       $adjt_qty = 0;      
                                              
                                       
                                             
                                    if($i==0) {
                                      $day_op_qty = (($op_stock_qty[$item_id]) - ( isset($op_issued_qty[$item_id]) ? $op_issued_qty[$item_id] : 0 ) + ( isset($op_adj_qty[$item_id]) ? $op_adj_qty[$item_id] : 0 ));
                                       
                                      $day_close_qty = ($day_op_qty +   $pur_qty  + $rej_qty + $adjt_qty ) - ($iss_qty);
                                      
                                    } else {
                                        $day_op_qty = $day_close_qty;
                                        $day_close_qty = ($day_op_qty +   $pur_qty  + $rej_qty  + $adjt_qty) - ($iss_qty);
                                    }        
                                ?>
                                    <tr>
                                        <td><?php echo date("d-m-Y", strtotime($date)) ; ?></td>
                                        <td class="text-right"><?php echo number_format($day_op_qty,2); ?></td>
                                        <td class="text-right"><?php echo number_format($pur_qty,2); ?></td>
                                        <td class="text-right"><?php echo number_format($rej_qty,2); ?></td> 
                                        <td class="text-right"><?php echo number_format($iss_qty,2); ?></td>   
                                        <td class="text-right"><?php echo number_format($adjt_qty,2); ?></td>   
                                        <td class="text-right"><?php echo number_format($day_close_qty,2); ?></td>   
                                    </tr>
                                <?php 
                                    $tot_pur_qty += $pur_qty; 
                                    $tot_rej_qty += $rej_qty; 
                                    $tot_iss_qty += $iss_qty; 
                                    $tot_adj_qty += $adjt_qty; 
                                    }
                                ?>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th> 
                                        <th class="text-right"><?php echo number_format($tot_pur_qty,2); ?></th>
                                        <th class="text-right"><?php echo number_format($tot_rej_qty,2); ?></th> 
                                        <th class="text-right"><?php echo number_format($tot_iss_qty,2); ?></th>   
                                        <th class="text-right"><?php echo number_format($tot_adj_qty,2); ?></th>   
                                        <th class="text-right"></th>   
                                    </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                     
                <?php } ?>     
                </div> 
                
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
