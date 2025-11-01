<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($record_list);
echo "</pre>"; */

?>
<style>
#content-table {font-size: 12px; background-color: white;}
#content-table th {border:1px solid black;}
#content-table td {border:1px solid black;}
</style>
 <section class="content-header">
  <h1>INWARD REGISTER & PURCHASED DATA</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Purchase</a></li>  
    <li class="active">Inward Register</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date) ;?>">
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
                <div class="form-group col-md-6">
                    <label>Item</label> 
                    <?php echo form_dropdown('srch_item_id',array('' => 'All Item') + $itm_opt  ,set_value('srch_item_id') ,' id="srch_item_id" class="form-control" ');?> 
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
         <!--<div class="box box-success">  
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12" id="mtc">-->
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered" id="content-table"> 
                            <thead>
                            <tr>
                                <td colspan="5" align="center" style="border: 1px solid black;"><h1>MJP</h1></td>
                                <td colspan="8" align="center" style="border: 1px solid black;">
                                    <h3><strong>INWARD REGISTER & PURCHASED DATA</strong> </h3> 
                                </td>
                                <td colspan="6" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                                   <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                                     
                                </td>
                            </tr>  
                            <tr>
                                <th rowspan="2" class="text-center">SL.NO</th>
                                <th rowspan="2" class="text-center">DATE</th>
                                <th rowspan="2" class="text-center">P.O NO.</th>
                                <th rowspan="2" class="text-center">P.O DATE.</th>
                                <th rowspan="2" class="text-center">ITEM DESC</th>
                                <th colspan="2" class="text-center">SUPPLIER</th> 
                                <th colspan="2" class="text-center">DATE</th>  
                                <th rowspan="2" class="text-center">DELIVERY <br />RATING %</th>
                                <th colspan="5" class="text-center">QUANTITY & QUALITY</th> 
                                <th rowspan="2" class="text-center">QUALITY <br />RATING %</th> 
                                <th rowspan="2" class="text-center">SUPPLIER <br />RATING %</th> 
                                <th colspan="2" class="text-center">AMOUNT</th> 
                            </tr>  
                            <tr>
                                
                                <th class="text-center">NAME</th>
                                <th class="text-center">INVOICE/<br />DC NO</th>
                                <th class="text-center">EXPECTED</th>
                                <th class="text-center">SUPPLIED</th> 
                                <th class="text-center">ORDERED</th>
                                <th class="text-center">SUPPLIED</th>
                                <th class="text-center">ACCEPTED</th>
                                <th class="text-center">REJECTED</th>
                                <th class="text-center">REWORK</th>  
                                <th class="text-center">RATE</th>  
                                <th class="text-center">TOTAL</th>  
                            </tr>
                            </thead>
                                <?php $k =0;
                                    foreach($record_list as $date => $record_list1) { 
                                        foreach($record_list1 as $i => $rec) {  $k++;
                                     $intl_days = $rec['diff'];
                                     $qty_rating = ($rec['supplied_qty'] * 100 / $rec['ordered_qty']); 
                                     $supplier_rating = ($rec['accepted_qty'] * 100 / $rec['ordered_qty']);
                                     if($qty_rating >= 100){  
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
                                     } else {
                                        $delivery_rating = 0;
                                     }    
                                      
                                    ?>
                                    <tr>
                                        <td class="text-right"><?php echo ($k); ?></td> 
                                        <td><?php echo date('d-m-Y' , strtotime($rec['inward_date'])); ?></td> 
                                        <td><?php echo $rec['po_no']; ?></td> 
                                        <td><?php if(!empty($rec['po_date'])) echo date('d-m-Y' , strtotime($rec['po_date'])); ?></td> 
                                        <td><?php echo $rec['item']; ?></td> 
                                        <td><?php echo $rec['supplier_name']; ?></td> 
                                        <td class="text-center"><?php echo $rec['inv_no']; ?></td> 
                                        <td><?php echo date('d-m-Y' , strtotime($rec['expected_date']));?></td> 
                                        <td><?php echo date('d-m-Y' , strtotime($rec['supplied_date']));?></td>  
                                        <td class="text-center"><?php echo $delivery_rating ; ?>%</td> 
                                        <td class="text-right"><?php echo $rec['ordered_qty']; ?></td> 
                                        <td class="text-right"><?php echo $rec['supplied_qty']; ?></td> 
                                        <td class="text-right"><?php echo $rec['accepted_qty']; ?></td> 
                                        <td class="text-right"><?php echo $rec['rejected_qty']; ?></td> 
                                        <td class="text-right"><?php echo $rec['rework_qty']; ?></td> 
                                        <td class="text-center"><?php echo  number_format($qty_rating,0); ?>%</td>  
                                        <td class="text-center"><?php echo  number_format($supplier_rating,0); ?>%</td>  
                                        <td class="text-right"><?php echo number_format($rec['rate_per_kg'],2); ?></td>  
                                        <td class="text-right"><?php echo number_format(($rec['accepted_qty'] * $rec['rate_per_kg'] ),2); ?></td>  
                                    </tr>
                                <?php } ?> 
                                <?php } ?> 
                             
                        </table>
                        </div>
                    <!--</div>
                </div>
            </div>
         </div> -->
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
