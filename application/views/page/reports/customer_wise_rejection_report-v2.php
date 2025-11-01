<?php  include_once(VIEWPATH . '/inc/header.php'); 
//echo $tot_rej_qty; 
?>
 <?php 
/* echo "<pre>";
print_r($rej_list);
echo "</pre>";  */
?>
 <section class="content-header">
  <h1>Internal Rejection</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Rejection Report</a></li> 
    <li class="active">Internal Rejection</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-3"> 
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
             </div> 
             <div class="row">
                <div class="form-group col-md-2">
                    <label>Department</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_grp',array('' => 'All Department') + $rejection_grp_opt ,set_value('srch_rej_grp') ,' id="srch_rej_grp" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-2">
                    <label>Rejection Type</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_type_id',array('' => 'All Rejection Type') + $rejection_typ_opt  ,set_value('srch_rej_type_id') ,' id="srch_rej_type_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div> 
                 <div class="form-group col-md-2">
                    <label>Rejection % More Than</label>
                      <div class="input-group">
                         <input type="number" name="srch_more_than" class="form-control" step="any" value="<?php echo set_value('srch_more_than',$srch_more_than)?>"  />    
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
        <?php if(($submit_flg)) {   ?>   
        <?php  if(!empty($production_list)) { ?>      
         <div class="box box-success"> 
           
            <div class="box-header with-border">
              <!--<h3 class="box-title text-white">Customer Wise Rejection Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3>--> 
                <table class="table table-condensed table-bordered " id="content-table"> 
                <tr>
                    <th width="30%" class="text-center"><h2>MJP</h2> </th>
                    <th class="text-center"><h3>Internal Rejection</h3></b>
                    <th width="30%" class="text-left"><b><?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?></b></th>
                </tr>
                </table>  
            </div>
            <div class="box-body table-responsive">  
                 <div class="sticky-table-demo">
                      <table class="table table-bordered table-responsive">
                        <thead>
                        <tr class="bg-blue-gradient">  
                            <th rowspan="2">Item</th> 
                            <th class="text-center" colspan="2">Production</th> 
                            <th class="text-center" colspan="2">Rejection</th>  
                            <th class="text-center" rowspan="2">Department Rejection</th>
                        </tr> 
                        <tr class="bg-blue-gradient">  
                            <th class="text-center" >Qty</th>  
                            <th class="text-center" >Wt</th> 
                            <th class="text-center" >Qty</th> 
                            <th class="text-center" >Wt</th> 
                        </tr> 
                        </thead>
                        <tbody>
                           <?php  
                           $tot_prod_qty =  $tot_rej_qty= $tot_prod_wt = $tot_rej_wt =0 ;
                           foreach($production_list as $date => $det) {  ?> 
                           <tr>
                                <th colspan="6" class="text-fuchsia">Date : <?php echo date('d-m-Y', strtotime($date)); ?></th>
                           </tr>
                           <?php  foreach($det as $shift => $det1) {  ?> 
                           <tr>
                                <th colspan="6"><?php echo $shift; ?></th>
                           </tr>
                           <?php  foreach($det1 as $j => $det2) {  
                            $tot_prod_qty += $det2['produced_qty'];
                            $tot_rej_qty += $det2['rejection_qty'];
                            $tot_prod_wt += ($det2['produced_qty'] * $det2['wt']);
                            $tot_rej_wt += ($det2['rejection_qty'] * $det2['wt']);
                            ?> 
                           <tr>
                                <td><strong><?php echo $det2['customer']; ?></strong> <br /><?php echo $det2['pattern_item']; ?></td>
                                <td class="text-right"><?php echo number_format($det2['produced_qty']); ?></td> 
                                <td class="text-right"><?php echo number_format(($det2['produced_qty'] * $det2['wt']),3); ?></td>
                                <td class="text-right"><?php echo number_format($det2['rejection_qty']); ?><hr /><?php if($det2['rejection_qty'] > 0 ) echo number_format(($det2['rejection_qty'] * 100 / $det2['produced_qty']),2). "%"; ?></td> 
                                <td class="text-right"><?php echo number_format(($det2['rejection_qty'] * $det2['wt']),3); ?><hr /><?php if($det2['rejection_qty'] > 0 ) echo number_format((($det2['rejection_qty'] * $det2['wt'] ) * 100 / ($det2['produced_qty'] * $det2['wt'])),2). "%"; ?></td>
                                <td class="no-padding">
                                     <?php if(isset($rej_list[$det2['work_planning_id']])) { ?>
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <th>Rej.Type</th>  
                                            <th>Rej.Qty</th> 
                                            <th>Rej.Wt</th> 
                                            <th>Rej-Qty[%]</th> 
                                            <th>Rej-Wt[%]</th> 
                                        </thead>
                                        <tbody>
                                           
                                           <?php foreach($rej_list[$det2['work_planning_id']] as $dept => $info) {  ?> 
                                            <tr>
                                                <th colspan="5"><?php echo $dept; ?></th>
                                            </tr>
                                            <?php $tot['rej_qty'] = $tot['rej_wt'] = 0;
                                            foreach($info  as $k => $info1) {  
                                            $tot['rej_qty'] += $info1['rej_qty'];
                                            $tot['rej_wt'] += ($info1['rej_qty'] * $det2['wt']);
                                            ?> 
                                            <tr>
                                                <td><?php echo $info1['rejection_type_name']; ?></td>
                                                <td class="text-right"><?php echo $info1['rej_qty']; ?></td>
                                                <td class="text-right"><?php echo number_format(($info1['rej_qty'] * $det2['wt']),3); ?></td>
                                                <td class="text-right"><?php echo number_format(($info1['rej_qty'] * 100 / ($det2['produced_qty'])),2); ?></td>
                                                <td class="text-right"><?php echo number_format((($info1['rej_qty'] * $det2['wt']) * 100 / ($det2['produced_qty'] * $det2['wt'])),2); ?></td>
                                            </tr>
                                             <?php }  ?> 
                                             <tr>
                                                <th class="text-right">Total - <?php echo $dept; ?></th>
                                                <th class="text-right"><?php echo number_format($tot['rej_qty'],0); ?></th>
                                                <th class="text-right"><?php echo number_format($tot['rej_wt'],3); ?></th>
                                                <th class="text-right"><?php echo number_format(($tot['rej_qty'] * 100 / ($det2['produced_qty'])),2); ?></td>
                                                <th class="text-right"><?php echo number_format(($tot['rej_wt'] * 100 / ($det2['produced_qty'] * $det2['wt'])),2); ?></td>
                                            </tr> 
                                             <?php }  ?> 
                                             
                                        </tbody>
                                    </table>
                                    <?php }  ?> 
                                </td>
                           
                           </tr>
                           <?php }  ?> 
                           <?php }  ?> 
                           <?php }  ?> 
                           <tr class="bg-light-blue">
                                <th>Total </th>
                                <th class="text-right"><?php echo number_format($tot_prod_qty,0); ?></th>
                                <th class="text-right"><?php echo number_format($tot_prod_wt,3); ?></th>
                                <th class="text-right"><?php echo number_format($tot_rej_qty,0); ?></th>
                                <th class="text-right"><?php echo number_format($tot_rej_wt,3); ?></th>
                                <th class="text-center">Rej Qty : <?php echo number_format(($tot_rej_qty / $tot_prod_qty * 100),2); ?>% || Rej Wt : <?php echo number_format(($tot_rej_wt / $tot_prod_wt * 100),2); ?>%</th>
                           </tr>
                        </tbody> 
                    </table> 
                  
                  
                </div>
            </div>
             <div class="box-footer with-border">
                 <table class="table table-condensed table-bordered " id="content-table"> 
                <tr>
                    <th>Prepared by</th>
                    <th>Approved by/Date</th>
                    <th>
                         <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                     </th>
                </tr> 
                </table> 
             </div>
            </div> 
            <?php }  ?> 
            <?php }  ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
