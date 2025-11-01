<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($op_stock_list);
echo "</pre>";*/
?>
 <section class="content-header">
  <h1>Core Stock Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Core Stock Report</a></li> 
    <li class="active">Core Stock Report</li>
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
              <h3 class="box-title text-white">Core Stock Report : <span><i> as on <?php echo date('d-m-Y' , strtotime($srch_date)) ?>  </i></span></h3> 
            </div>
            <div class="box-body">  
                <div class="sticky-table-demo">    
                <?php  if(!empty($op_stock_list)) { ?>   
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                    <tr class="bg-blue-gradient">  
                          
                        <th>Pattern Item</th>   
                        <th>Core Item</th>  
                        <th>Opening Stock</th> 
                        <th>Core Produced Qty</th>  
                        <th>Casting Produced Qty</th>  
                        <th>Core Used Qty</th> 
                        <th>Closing Stock</th>
                    </tr> 
                    </thead>
                    <tbody>
                         <?php foreach($op_stock_list as $customer => $info1) {  ?> 
                         <tr>
                            <th colspan="6">Customer : <?php echo $customer; ?></th>
                         </tr>
                         <?php foreach($info1 as $pattern => $info2) {  ?>
                         <?php foreach($info2 as $j => $info) {  ?>
                            
                            <tr>
                                <td><?php echo $info['pattern_item']; ?> </td>
                                <td><?php echo $info['core_item']; ?></td>
                                <td class="text-right"><?php echo number_format($info['op_stock'],0); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_core_produced_qty'],0); ?></td> 
                                <td class="text-right"><?php echo number_format($info['curr_pouring_qty'],0); ?></td>
                                <td class="text-right"><?php echo number_format($info['curr_core_used'],0); ?></td>
                                <td class="text-right"><?php echo number_format((($info['op_stock'] + $info['curr_core_produced_qty']) -  $info['curr_core_used']),0); ?></td>
                            </tr>
                         <?php } ?> 
                         <?php } ?> 
                         <?php } ?> 
                    </tbody>
                    </table>
                <?php  } ?>   
                 
                <?php /*  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient"> 
                        <!--<th>S.No</th> --> 
                        <th>Customer</th>  
                        <th>Pattern Item</th>   
                        <th>Core Item</th>   
                        <th>Core Available</th> 
                    </tr> 
                    </thead>
                    <tbody>
                        <?php /* foreach($record_list as $cust => $info) {  ?>
                        <!--<tr>
                            <td class="text-left"><?php echo $cust?></td> 
                            <td colspan="3"></td>
                        </tr>-->
                        <?php  foreach($info as $pat => $info2) {  ?>
                        <!--<tr>
                            <td class="text-left"><?php echo $cust?></td>
                            <td class="text-left"><?php echo $pat?></td>
                            <td colspan="2"></td>
                        </tr>--> 
                        <?php  foreach($info2 as $j => $info3) {  ?>
                        <tr>
                            <td class="text-left"><?php echo ($j+1)?></td> 
                            <?php if($j == 0) {?>
                            <td class="text-left"><?php echo $cust?></td>
                            <td class="text-left"><?php echo $pat?></td>
                            <?php } else { ?> 
                            <td colspan="2"></td>
                            <?php }  ?> 
                            <td class="text-left"><?php echo $info3['core_item']?></td> 
                            <td class="text-right"><?php echo number_format($info3['core_stock']);?></td>  
                        </tr>
                        <?php } ?> 
                        <?php } ?> 
                        <?php } * /?> 
                        <?php  foreach($record_list as $cust => $info) {  ?>
                         <tr>
                            <td class="text-left"><?php echo $cust?></td> 
                            <td colspan="3"></td>
                        </tr> 
                        <?php  foreach($info as $pat => $info2) {  ?>
                         <tr>
                            <td class="text-left"><?php //echo $cust?></td>
                            <td class="text-left"><?php echo $pat?></td>
                            <td colspan="2"></td>
                        </tr>  
                        <?php  foreach($info2 as $j => $info3) {  ?>
                        <tr> 
                            <td colspan="2"></td> 
                            <td class="text-left"><?php echo $info3['core_item']; ?></td> 
                            <td class="text-right"><?php echo number_format($info3['core_stock']);?></td>  
                        </tr>
                        <?php } ?> 
                        <?php } ?> 
                        <?php } ?> 
                    </tbody>
                     
                </table>  
                 
                  <?php } */ ?>
            </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
