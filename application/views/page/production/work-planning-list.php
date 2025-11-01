<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($core_stock_list);
echo "</pre>";*/
?>
 <section class="content-header">
  <h1>Daily Planning List</h1>
  <ol class="breadcrumb">  
    <li><a href="#"><i class="fa fa-book"></i> Planning </a></li> 
    <li class="active">Daily Planning List</li>
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
                    <label>Planning Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_date" name="srch_date" value="<?php echo set_value('srch_date',$srch_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="col-md-3"> 
                    <label for="srch_customer">Shift</label>
                    <?php echo form_dropdown('srch_shift',array('' => 'Select Shift') + $shift_opt ,set_value('srch_shift',$srch_shift) ,' id="srch_shift" class="form-control"');?>
                 </div>   
                  
                <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Records</button>
                </div>
             </div>  
            </form>
         </div> 
         </div> 
              
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Daily Planning List As On <span><i> [ <?php echo date('d-m-Y', strtotime($srch_date))  ?>  ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive">  
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th> 
                        <th>Customer</th> 
                        <th>PO</th> 
                        <th>Item</th> 
                        <th>No of Cavity</th> 
                        <th>Box Wt</th> 
                        <th>Core</th> 
                        <th colspan="4" class="text-center">Planned</th> 
                        <th colspan="3" class="text-center">Action</th> 
                    </tr> 
                    <tr style="text-align: center;"> 
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th></th>  
                        <th>Available</th>  
                        <th>Box</th>  
                        <th>Box Wt</th>  
                        <th>Qty</th>  
                        <th>Tot Qty Wt</th> 
                        <th colspan="3"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $tot['planned_box'] = $tot['planned_qty'] = $tot['planned_box_wt'] = 0; $prt_box = 0 ;
                            $tot['planned_wt']=0;
                        foreach($record_list as $j => $info) { 
                          
                          $tot['planned_box'] += $info['planned_box'];  
                         // $tot['planned_box_wt'] += ($info['planned_box'] * $info['bunch_weight']);  
                          $tot['planned_box_wt'] += ($info['planned_box_wt']);  
                          $tot['planned_qty'] += $info['planned_qty'];  
                          $tot['planned_wt'] += ($info['planned_qty'] * $info['piece_weight_per_kg']) ;  
                          
                           
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>  
                            <td class="text-left"><?php echo $info['customer']?></td> 
                            <td class="text-left"><?php echo $info['customer_PO_No']?></td> 
                            <td class="text-left">
                                <?php echo $info['pattern_item']?> 
                                 <?php  if($info['prt_work_plan_id'] > 0) {   ?>
                                    &nbsp;&nbsp;<i class="badge bg-red">C</i>
                                 <?php } ?>
                            </td> 
                            <td class="text-center">
                                <?php echo $info['no_of_cavity']?> 
                            </td> 
                            <td class="text-center">
                                <?php if($info['prt_work_plan_id'] == 0 || $info['prt_work_plan_id'] == '') {  ?>
                                <?php echo number_format(($info['planned_box_wt'] / $info['planned_box']),3);?> 
                                <?php } ?>
                            </td> 
                            <td class="text-center">
                                <?php if(isset($core_stock_list[$info['pattern_id']])) {
                                 //echo implode(',',$core_stock_list[$info['pattern_id']]);
                                 echo array_sum($core_stock_list[$info['pattern_id']]);
                                 $core_itm = '<table class="table table-bordered table-condensed">';
                                 foreach($core_stock_list[$info['pattern_id']] as $key => $val){
                                    $core_itm .=  '<tr><td>' . htmlspecialchars($key) . '</td><td>' . $val. '</td></tr>';
                                 }
                                 $core_itm .= '</table>'; 
                                 ?> 
                                 <br />
                                 <a href="#" data-toggle="popover" title="Core Available" data-html="true" data-placement="top"  data-content='<?php if(!empty($core_itm)) echo $core_itm;?>' onclick="return false;"><i class="fa fa-info-circle"></i></a>
                                 <?php } ?>
                            </td>
                            <td class="text-right">
                                <?php if($info['prt_work_plan_id'] == 0 || $info['prt_work_plan_id'] == '') {  ?>
                                <input value="<?php echo number_format($info['planned_box']);?>" name="box[<?php echo $info['work_planning_id']?>]" class="form-control text-right col-2 box_<?php echo $info['work_planning_id']?>"/>
                                <?php  }   ?>
                            </td> 
                            <td class="text-right">
                                <?php if($info['prt_work_plan_id'] == 0 || $info['prt_work_plan_id'] == '') {  ?>
                                 <?php //echo number_format(($info['planned_box']* $info['bunch_weight']),3);?> 
                                 <?php echo number_format(($info['planned_box_wt']),3);?> 
                                <?php  }   ?>
                            </td> 
                            <td class="text-right">
                                <?php if($info['prt_work_plan_id'] == 0 || $info['prt_work_plan_id'] == '') { $prt_box = $info['planned_box'];  ?>
                                <?php echo number_format($info['planned_qty']);?>
                                 <?php  } else {  ?>
                                    <?php 
                                    echo number_format(($prt_box * $info['no_of_cavity']),0);
                                    $tot['planned_qty'] += ($prt_box * $info['no_of_cavity']);
                                    $tot['planned_wt'] += ($prt_box * $info['piece_weight_per_kg']);
                                    ?>
                                 <?php } ?>
                            </td> 
                            <td class="text-right">
                                <?php if($info['prt_work_plan_id'] == 0 || $info['prt_work_plan_id'] == '') { $prt_box = $info['planned_box'];  ?>
                                <?php  echo number_format(($info['planned_qty'] * $info['piece_weight_per_kg']),3);  ?>
                                 <?php  } else {  ?>
                                <?php  echo number_format((($prt_box * $info['no_of_cavity']) * $info['piece_weight_per_kg']),3);  ?>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <button data-toggle="modal" data-target="#view_modal" value="<?php echo $info['work_planning_id']?>" class="view_record btn btn-warning btn-xs" title="View"><i class="fa fa-eye"></i></button>
                            </td>
                             <?php if(($this->session->userdata('cr_is_admin') == 1 )|| (($this->session->userdata('cr_is_admin') != 1 ) && ($info['days'] <= 3))) {  ?>
                            <td class="text-center">
                                <?php if($info['prt_work_plan_id'] == 0 || $info['prt_work_plan_id'] == '') {   ?>
                                <button  value="<?php echo $info['work_planning_id']?>" class="edit_record btn btn-success btn-xs" title="Update"><i class="fa  fa-check-square-o"></i></button>
                                <?php }  ?>
                            </td>                            
                            <td class="text-center">
                                <button value="<?php echo $info['work_planning_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                            </td> 
                            <?php } else { echo "<td colspan='2'></td>"; } ?> 
                        </tr>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="7">Total</th>
                                <th class="text-right"><?php echo number_format($tot['planned_box'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_box_wt'],3)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_qty'],0)?></th>
                                <th class="text-right"><?php echo number_format($tot['planned_wt'],3)?></th> 
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </tbody>
                     
                </table>  
                <div class="modal fade" id="view_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content"> 
                            <div class="modal-header">                        
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button> 
                                <h3 class="modal-title" id="scrollmodalLabel"><strong>View Details</strong></h3>
                            </div>
                            <div class="modal-body table-responsive"> 
                                 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  
                            </div>  
                        </div>
                    </div>
                </div>
                
                  
                  <?php } ?>
            </div>
             
            </div> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
