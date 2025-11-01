<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>HeadCode Wise Rejection Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">HeadCode Wise Rejection Report</li>
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
                      <div class="input-group1">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Item') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                       </div>                                   
                 </div> 
                 <div class="form-group col-md-4"> 
                    <label>Head Code</label> 
                      <input type="text" class="form-control" id="srch_key" name="srch_key" value="<?php echo set_value('srch_key',$srch_key);?>">
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
              <h3 class="box-title text-white">Head Code Wise Rejection Report : <span><i> [ <?php echo date('d-m-Y', strtotime($srch_from_date))  ?> to <?php echo date('d-m-Y', strtotime($srch_to_date)) ?> ]</i></span></h3> 
            </div>
            <div class="box-body text-center table-responsive">
                <div class="sticky-table-demo">     
                <?php  if(!empty($record_list)) { ?>    
                  
                    <table class="table table-bordered table-condensed">
                    <thead>
                    <tr class="bg-blue-gradient"> 
                        <th>#</th> 
                        <th>Rejection Date</th> 
                        <th>Plannning Date</th> 
                        <th>Shift</th> 
                        <th>Heat Code</th> 
                        <th>Dept</th> 
                        <th>Rej Type</th> 
                        <th class="text-center">Rejection Qty</th>  
                    </tr> 
                    </thead>
                    <tbody>
                        <?php  foreach($record_list as $customer => $info) {   ?>
                            <tr>
                                <th colspan="7" class="text-fuchsia">Date : <?php echo $customer; ?></th>
                            </tr>
                         <?php   foreach($info as $itm => $info1) {   ?>
                            <tr>
                                <th colspan="7" class="text-green">Item : <?php echo $itm; ?></th>
                            </tr>    
                            <?php     $tot_qty = 0;
                            foreach($info1 as $j => $info) {    
                                $tot_qty += $info['rejection_qty'];  
                            ?>
                            <tr>
                                <td><?php echo ($j+1); ?></td> 
                                <td class="text-left"><?php echo date('d-m-Y', strtotime($info['qc_date']))?></td>
                                <td class="text-left"><?php echo date('d-m-Y', strtotime($info['planning_date']))?></td>
                                <td class="text-left"><?php echo $info['shift']?></td>
                                <td class="text-left"><?php echo $info['heat_code']?></td>    
                                <td class="text-left"><?php echo $info['rejection_group']?></td>    
                                <td class="text-left"><?php echo $info['rejection_type']?></td>    
                                <td class="text-right"><?php echo number_format($info['rejection_qty'],0);?></td>   
                            </tr>
                            <?php } ?>
                              <tr>
                                <td class="text-right" colspan="7"><strong>Total</strong></td>
                                <td class="text-right"><strong><?php echo round($tot_qty); ?></strong></td>
                             </tr>
                            <?php } ?>
                             
                        <?php } ?>
                            
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
