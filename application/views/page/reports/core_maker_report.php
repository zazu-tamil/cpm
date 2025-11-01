<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Core Maker Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Core Maker Report</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date);?>" required="true">
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-2"> 
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date);?>" required="true">
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                 <div class="form-group col-md-4">
                    <label>Core Maker</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_core_maker_id',array('' => 'Select') + $core_maker_opt  ,set_value('srch_core_maker_id') ,' id="srch_core_maker_id" class="form-control" required="true"');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="col-sm-3 col-md-4">
                    <label>Pattern Name,Core Item</label>
                    <input type="text" class="form-control" name="srch_key" id="srch_key" value="<?php echo set_value('srch_key','') ?>" placeholder="Search Pattern Name,Core Item" />
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
              <h3 class="box-title text-white">Core Maker Report - <span><?php echo $core_maker_opt[$srch_core_maker_id]?> From <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?></span></h3> 
            </div>
            <div class="box-body table-responsive">  
            <div class="sticky-table-demo ">    
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Date</th>
                        <th>Pattern Item</th> 
                        <th>Core Item</th> 
                        <th>Produced Qty</th> 
                        <th>Damaged Qty</th>  
                        <th>Rate</th>  
                        <th>Amount</th>  
                    </tr> 
                    </thead>
                    <tbody>
                        <?php 
                            $tot['amt']= $tot['produced_qty'] = $tot['damage_qty']= 0;
                        foreach($record_list as $j => $info) { 
                          
                          $tot['produced_qty'] += $info['produced_qty'];  
                          $tot['damage_qty'] += $info['damage_qty'];  
                          $tot['amt'] += $info['amount'];  
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td><?php echo $info['core_plan_date']?></td>
                            <td><?php echo $info['item']?></td> 
                            <td><?php echo $info['core_item']?></td> 
                            <td class="text-right"><?php echo number_format($info['produced_qty']);?></td> 
                            <td class="text-right"><?php echo number_format($info['damage_qty'],2)?></td>
                            <td class="text-right"><?php echo number_format($info['core_maker_rate'],2);?></td>   
                            <td class="text-right"><?php echo number_format($info['amount'],2);?></td>  
                        </tr>
                        <?php } ?>
                            <tr>
                                <th class="text-right" colspan="4">Total</th>
                                <th class="text-right"><?php echo number_format($tot['produced_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['damage_qty'],2)?></th>
                                <th></th>
                                <th class="text-right"><?php echo number_format($tot['amt'],2)?></th> 
                            </tr>
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
            </div>
            <div class="box-footer with-border ">
               <div class="form-group col-sm-12 text-left">
                    <label>Total Records : <?php echo count($record_list);?></label>
                </div> 
            </div>
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
