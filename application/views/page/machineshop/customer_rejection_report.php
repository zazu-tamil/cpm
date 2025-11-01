<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($despatch_qty);
echo "</pre>";*/
?>
 <section class="content-header">
  <h1>Customer Rejection Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">Customer Rejection Report</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date) ;?>">
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
                 <!--<div class="form-group col-md-4">
                    <label>Machine Shop</label> 
                        <?php //echo form_dropdown('srch_sub_contractor_id',array('' => 'Select Sub Contractor') + $sub_contractor_opt  ,set_value('sub_contractor_id',$srch_sub_contractor_id) ,' id="srch_sub_contractor_id" class="form-control" required="true" ');?> 
                  </div> -->
                  <div class="form-group col-md-4">
                    <label>Despatch Type</label> 
                        <?php echo form_dropdown('srch_dc_type', $dc_type_opt  ,set_value('srch_dc_type',$srch_dc_type) ,' id="srch_dc_type" class="form-control" required="true" ');?> 
                  </div>
                  <div class="form-group col-md-4">
                    <label>Rej Group</label> 
                        <?php echo form_dropdown('srch_rej_grp', $rej_grp_opt  ,set_value('srch_rej_grp',$srch_rej_grp) ,' id="srch_rej_grp" class="form-control" required="true" ');?> 
                  </div>
                 <div class="form-group col-md-4">
                    <label>Customer</label> 
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                                                
                 </div>  
                 <div class="form-group col-md-4">
                    <label>Pattern</label> 
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Item') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
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
              <h3 class="box-title text-white">Customer Rejection Report : <span><i> [ <?php echo date('d-m-Y' , strtotime($srch_date)) ?> to <?php echo date('d-m-Y' , strtotime($srch_to_date)) ?>]  </i></span></h3> 
            </div>
            <div class="box-body">  
                <div class="sticky-table-demo">   
                 <?php  if(!empty($record_info)) { ?>
                <table class="table table-bordered table-striped table-responsive">
                     <?php foreach($record_info as $customer => $info1) {  ?> 
                            <tr>
                            <th colspan="2"><strong>Customer : <?php echo $customer; ?></strong></th>
                            </tr>
                     <?php foreach($info1 as $pattern => $info2) {  ?> 
                            <tr>
                            <th colspan="2"><strong>Item : <?php echo $pattern; ?></strong></th> 
                            </tr>
                            <tr>
                            <td>
                                <table class="table table-bordered table-striped table-responsive"> 
                                    <tr class="bg-blue-gradient">   
                                    <th>Date</th>   
                                    <th class="text-right">Despatch Qty</th> 
                                  </tr> 
                             <?php $tot_des_qty = 0; 
                             if(isset($info2['despatch'])){
                             foreach($info2['despatch'] as $i => $info3) {  $tot_des_qty += $info3['despatch_qty'];?> 
                                    <tr>
                                        <td><?php echo date('d-m-Y' , strtotime($info3['despatch_date'])); ?></td>
                                        <td class="text-right"><?php echo number_format($info3['despatch_qty'],0); ?></td>
                                    </tr>
                             <?php  } ?> 
                             <?php  } ?> 
                                    <tr>
                                        <th>Total</th>
                                        <th class="text-right"><?php echo number_format($tot_des_qty,0); ?></th>
                                    </tr>
                                </table>
                             </td>
                             <td>
                                <table class="table table-bordered table-striped table-responsive"> 
                                    <tr class="bg-blue-gradient">   
                                    <th>Date</th>   
                                    <th>Rej Type</th>   
                                    <th class="text-right">Rejection Qty</th> 
                                    <th class="text-right">Remarks</th> 
                                  </tr> 
                             <?php $tot_rej_qty=0; 
                                    if(isset($info2['rej'])){
                                    foreach($info2['rej'] as $j => $info4) { 
                                        $tot_rej_qty +=$info4['rej_qty']; ?> 
                                    <tr>
                                        <td><?php echo date('d-m-Y' , strtotime($info4['rej_date'])); ?></td> 
                                        <td><?php echo $info4['rejection_type']; ?> </td> 
                                        <td class="text-right"><?php echo number_format($info4['rej_qty'],0); ?></td>
                                        <td><?php echo $info4['remarks']; ?></td>
                                    </tr>
                             <?php  } ?> 
                             <?php  } ?> 
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th class="text-right"><?php echo number_format($tot_rej_qty,0); ?></th>
                                        <th></th>
                                    </tr>
                                </table>
                             </td>
                            </tr> 
                             <tr>
                                <th colspan="2" class="text-center">
                                    <?php echo $pattern ;?> - Rejection Percentage : <?php if($tot_des_qty > 0 ) echo round(($tot_rej_qty / $tot_des_qty * 100),2);?>%
                                </th>
                            </tr> 
                     <?php  } ?>   
                           
                     <?php  } ?>  
                 </table>  
                 <?php  } ?>   
                
            </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
