<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Customer Wise Planning Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Planning Report</a></li> 
    <li class="active">Customer Wise Planning Report</li>
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
              <h3 class="box-title text-white">Customer Wise Planning Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive">   
                <div class="sticky-table-demo1">    
                <?php  if(!empty($record_list)) { ?>    
                 
                <table class="table table-bordered table-striped table-responsive ">
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center"><h1>MJP</h1></div>
                        <th colspan="3" class="text-center"><h3>Production Planning<h3></th>
                        <th colspan="3" class="text-left">
                            <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                           
                        </th>
                    </tr> 
                    <tr>
                        <th>SNo</th>
                        <th>Date</th> 
                        <th>Customer</th> 
                        <th>PO</th> 
                        <th>Item</th> 
                        <th>No of Cavity</th> 
                        <th colspan="3">Planned</th>  
                    </tr> 
                    <tr>
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th>Box</th>  
                        <th>Qty</th>  
                        <th>Wt</th> 
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $tot['planned_box'] = $tot['planned_qty'] = 0;
                            $tot['planned_wt']=0;
                        foreach($record_list as $j => $info) { 
                          
                          $tot['planned_box'] += $info['planned_box'];  
                          $tot['planned_qty'] += $info['planned_qty'];  
                          $tot['planned_wt'] += ($info['planned_qty'] * $info['piece_weight_per_kg']) ;  
                           
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td class="text-left"><?php echo date('d-m-Y', strtotime($info['m_date'])); ?></td> 
                            <td class="text-left"><?php echo $info['customer']?></td> 
                            <td class="text-left"><?php echo $info['customer_PO_No']?></td> 
                            <td class="text-left"><?php echo $info['pattern_item']?></td> 
                            <td class="text-left"><?php echo $info['no_of_cavity']?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_box']);?></td> 
                            <td class="text-right"><?php echo number_format($info['planned_qty']);?></td> 
                            <td class="text-right"><?php echo number_format(($info['planned_qty'] * $info['piece_weight_per_kg']),3);?></td> 
                        </tr>
                        <?php } ?> 
                            <tr>
                                <th class="text-right" colspan="6">Total</th>
                                <th class="text-right"><?php echo number_format($tot['planned_box'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_wt'],3)?></th> 
                            </tr> 
                    </tbody>
                 <tr>
                    <th colspan="3" class="text-center"> <strong>Prepared By</strong> </div>
                    <th colspan="3" class="text-center"><strong>Approved By</strong></div>
                    <th colspan="3" class="text-left">
                            <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                    </div>
                 </div>    
                </table>  
                  
                  <?php } ?>
                </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
