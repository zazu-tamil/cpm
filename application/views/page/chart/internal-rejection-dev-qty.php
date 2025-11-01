<?php  include_once(VIEWPATH . '/inc/header.php');  ?>
 <section class="content-header">
  <h1>Internal Rejection - Chart</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Chart</a></li>  
    <li class="active">Internal Rejection </li>
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
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
             </div>  
             <div class="row">
                <div class="form-group col-md-2">
                    <label>Department</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_grp', $rejection_grp_opt ,set_value('srch_rej_grp') ,' id="srch_rej_grp" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-3">
                    <label>Rejection Type</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_type_id',array('' => 'All Rejection Type') + $rejection_typ_opt  ,set_value('srch_rej_type_id') ,' id="srch_rej_type_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div> 
                <!-- <div class="form-group col-md-3">
                    <label>Rejection % More Than</label>
                      <div class="input-group">
                         <input type="number" name="srch_more_than" class="form-control" step="any" value="<?php echo set_value('srch_more_than',$srch_more_than)?>"  />    
                      </div>                                   
                </div>--> 
				<div class="form-group col-md-2">
				<label>Shift</label>
				  <div class="input-group">
					<?php echo form_dropdown('srch_shift',$shift_opt ,set_value('srch_shift' , $srch_shift) ,' id="srch_shift" class="form-control" ');?> 
						
				  </div>                                   
				</div> 				 
                <div class="form-group col-md-2 text-left">
                    <br />
                   <button class="btn btn-success" name="btn_show" value="Show Chart'"><i class="fa fa-pie-chart"></i> Show Chart</button>
                </div>
             </div>
            </form>
         </div> 
    </div>  
            <?php
	           if(!empty($record_list)){
            ?>
            <div class="box box-success">
              <div class="box-header with-border noprint"><h3 class="box-title">Department Wise Rejection Based on Weight</h3>
                
              </div> 
              <div class="box-body">
                <table class="table table-bordered " id="content-table"> 
                <thead>
                <tr>
                    <th class="text-center" width="20%"><h1>MJP</h2></td>
                    <th class="text-center" width="50%">
                        <h2>Trend Charts</h2> 
                    </th>
                    <th width="30%">
                       <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                       
                    </th>
                </tr>  
                <tr>
                    <td colspan="3" class="">
                        
                         <?php foreach($rej_type_group as $grp => $info) { ?>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                          <i class="fa fa-bar-chart-o"></i> 
                                          <h4 class="box-title"><?php echo $grp; ?> Dept Rejection Type Wise Rejection Based On Qty</h4> 
                                        </div>
                                        <div class="box-body">
                                           <canvas id="pieChart_<?php echo $grp; ?>" style="height:300px"></canvas>
                                        </div> 
                                      </div>
                                </div>
                                 
                                <div class="col-md-6">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                          <i class="fa fa-bar-chart-o"></i> 
                                          <h4 class="box-title"><?php echo $grp; ?> Dept Rejection Type Wise Rejection Based On Qty - DataSheet</h4> 
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                  <tr>  
                                                    <th class="text-right">Rejection Type</th>
                                                    <th class="text-right">Prod.Qty</th>
                                                    <th class="text-right">Rej.Qty</th>
                                                    <th class="text-right">Rejection %</th>   
                                                  </tr>                                   
                                                </thead>
                                                <tbody>
                                                   <?php $j=0;foreach($info as $typ => $info1) { ?>
                                                    <tr>
                                                        <td class="text-right"><?php echo $typ; ?></td>
                                                        <td class="text-right"><?php if($j==0) echo $tot_prod_qty; else echo " "; ?></td>
                                                        <td class="text-right"><?php echo array_sum($info1['qty']); ?></td>
                                                        <td class="text-right"><?php echo round((array_sum($info1['qty']) * 100 / $tot_prod_qty ),2); ?></td>
                                                    </tr>
                                                    <?php $j++; } ?>
                                                </tbody>
                                            </table>
                                        </div> 
                                      </div>
                                </div> 
                             </div>
                             <?php } ?>
                               
                    </td>
                </tr> 
            <tr>
                <th>Prepared by</th>
                <th>Approved by/Date</th>
                <th>
                     <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                </th>
            </tr>  
            </table>
            
             
               <?php
	           }
            ?> 
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
