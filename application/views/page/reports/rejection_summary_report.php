<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
< 
 <section class="content-header">
  <h1>Rejection Type Summary Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Rejection Report</a></li> 
    <li class="active">Customer Wise Rejection Report</li>
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
            <?php 
           /* echo "<pre>";
            print_r($rejection_type_opt);
            echo "</pre>";*/
            ?>
            <div class="box-header with-border">
              <h3 class="box-title text-white">Rejection Breakup Summary Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive ">  
                <?php  if(!empty($rej_summary)) { ?>   
                 <?php 
                 $c_tot_qty = $c_tot_wt = $c_rej_qty = $c_rej_wt = 0 ;
                  
                 foreach($rej_summary as $date => $info){ ?>
                 <?php foreach($info as $shift => $info1){ ?> 
                <table class="table table-bordered " style="font-size: 12px;" id="tbl_prt" >
                    <thead>
                    <tr>
                        <td colspan="10" align="center" style="border: 1px solid black;"><h1>MJP</h1></td>
                        <td colspan="31" align="center" style="border: 1px solid black;">
                            <h3><strong>Fettling Production Log Sheet</strong> </h3> 
                        </td>
                        <td colspan="10" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                            Document Level 3 <br />
                            Doc Ref No: MJP/WD/MEL/005 <br />
                            Issue Date : 15-02-2023<br /> 
                             
                        </td>
                    </tr>
                    
                    <tr>
                        <th colspan="5" style="border: 1px solid black;">Date :  <?php echo $date; ?> </th>
                        <th colspan="6" style="border: 1px solid black;"> Shift : <?php echo $shift; ?></th>
                        <th colspan="40" style="border: 1px solid black;">  </th>
                    </tr> 
                    <tr> 
                        <th>Customer Name</th> 
                        <th>Items</th> 
                        <th colspan="2">Produced</th> 
                        <th colspan="2">Inspected</th> 
                        <th colspan="2">Rejection</th> 
                        <th colspan="2">Rejection %</th> 
                        <?php foreach($rejection_type_opt as $grp => $rejtype){?>
                        <th colspan="<?php echo (count($rejtype)+2); ?>" class="text-center"><?php echo $grp; ?></th>  
                         <?php } ?>                         
                         
                    </tr> 
                    <tr>  
                        <th>&nbsp;</th> 
                        <th>&nbsp;</th> 
                        <th>Qty</th>  
                        <th>Wt</th>   
                        <th>Qty</th>  
                        <th>Wt</th>  
                        <th>Qty</th>  
                        <th>Wt</th>
                        <th>Qty</th>  
                        <th>Wt</th>
                        <?php foreach($rejection_type_opt as $grp => $rejtype){?>
                            <?php foreach($rejtype as $id => $rejname){?>
                            <th><?php echo $rejname; ?></th>  
                            <?php } ?> 
                            <th><?php echo substr($grp,0,3);?><br />wt</th>
                            <th><?php echo substr($grp,0,3);?><br />%</th>
                        <?php } ?> 
                        
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tot_qty = $tot_wt = $t_rej_qty = $t_rej_qty_wt =  0 ;  $dep_tot_wt =  $dep_tot_qty  = array();
                        foreach($info1 as $w_plan_id => $info2){ 
                        $tot_qty+=  $info2['produced_qty'];   
                        $tot_wt+=  ($info2['produced_qty'] * $info2['wt']); 
                        $t_rej_qty +=  array_sum($tot_rej_qty[$date][$shift][$info2['pattern_item']]); 
                        $t_rej_qty_wt +=  ( array_sum($tot_rej_qty [$date][$shift][$info2['pattern_item']]) * $rec_list[$w_plan_id]['wt']); 
                        ?>
                        <tr>
                            <td><?php echo $info2['customer']; ?></td> 
                            <td><?php echo $info2['pattern_item']; ?><br /><i class="badge"><?php echo $info2['wt']; ?></i></td> 
                            <td><?php echo $info2['produced_qty']; ?></td> 
                            <td><?php echo ($info2['produced_qty'] * $info2['wt']); ?></td>
                            <td><?php echo $info2['produced_qty']; ?></td> 
                            <td><?php echo ($info2['produced_qty'] * $info2['wt']); ?></td>
                            <td><?php echo number_format(array_sum($tot_rej_qty[$date][$shift][$info2['pattern_item']]),0)?></td>
                            <td><?php echo number_format(( array_sum($tot_rej_qty [$date][$shift][$info2['pattern_item']]) * $rec_list[$w_plan_id]['wt']),2)?></td>
                            
                            <td><?php echo number_format((array_sum($tot_rej_qty [$date][$shift][$info2['pattern_item']]) / $rec_list[$w_plan_id]['produced_qty'] * 100 ),2)?></td>
                            <td><?php echo number_format(((array_sum($tot_rej_qty[$date][$shift][$info2['pattern_item']]) * $rec_list[$w_plan_id]['wt']) / ($rec_list[$w_plan_id]['produced_qty'] * $rec_list[$w_plan_id]['wt']) * 100 ),2)?></td>
                             
                             <?php foreach($rejection_type_opt as $grp => $rejtype){ $dep_tot  =  0;?>
                                <?php foreach($rejtype as $id => $rejname){?>
                                <td><?php 
                                if(isset($qc_list[$w_plan_id][$grp][$id])){
                                    echo $qc_list[$w_plan_id][$grp][$id];
                                    $dep_tot += $qc_list[$w_plan_id][$grp][$id];
                                     $tot['rej_ty'][$date][$shift][$id][]= $qc_list[$w_plan_id][$grp][$id];
                                     $tot['rej_ty_wt'][$date][$shift][$id][]= ($qc_list[$w_plan_id][$grp][$id] * $rec_list[$w_plan_id]['wt']);
                                     
                                  //   $tot_shift['rej_ty'][$shift][$id][]= $qc_list[$w_plan_id][$grp][$id];
                                  //   $tot_shift['rej_ty_wt'][$shift][$id][]= ($qc_list[$w_plan_id][$grp][$id] * $rec_list[$w_plan_id]['wt']);
                                }
                                //echo $rejname; 
                                ?></td>  
                                <?php } ?> 
                                <td><?php if($dep_tot > 0 ) echo number_format(($dep_tot * $info2['wt']),2); ?></td>
                                <td><?php if($dep_tot > 0 ) echo number_format(($dep_tot / $info2['produced_qty'] * 100),2); ?></td>
                                
                                <?php 
                                $dep_tot_wt[$grp][] = ($dep_tot * $info2['wt']);  
                                $dep_tot_qty[$grp][] = ($dep_tot);  
                                } ?> 
                        </tr>
                        <?php 
                        
                        } ?> 
                        <tr>
                            <th colspan="2">Total</th>
                            <th><?php echo number_format($tot_qty,0); ?></th>
                            <th><?php echo number_format($tot_wt,2); ?></th>
                             <th><?php echo number_format($tot_qty,0); ?></th>
                            <th><?php echo number_format($tot_wt,2); ?></th>
                            <th><?php echo number_format($t_rej_qty,0); ?></th>
                            <th><?php echo number_format($t_rej_qty_wt,2); ?></th>
                            <th><?php echo number_format(($t_rej_qty /$tot_qty * 100 ),2); ?></th>
                            <th><?php echo number_format(($t_rej_qty_wt / $tot_wt * 100),2); ?></th>
                             <?php foreach($rejection_type_opt as $grp => $rejtype){?>
                            <?php foreach($rejtype as $id => $rejname){?>
                            <th><?php if(isset($tot['rej_ty'][$date][$shift][$id])) echo array_sum($tot['rej_ty'][$date][$shift][$id]); ?></th>  
                            <?php } ?> 
                            <th><?php if(isset($dep_tot_wt[$grp])) echo number_format(array_sum($dep_tot_wt[$grp]),2);?></th>
                            <th><?php if(isset($dep_tot_qty[$grp])) echo number_format((array_sum($dep_tot_qty[$grp]) / $tot_qty * 100),2);?></th>
                            <?php   } ?> 
                        </tr>
                        <tr>
                            <td colspan="51" class="no-padding no-border" > <br />
                            
                                <table class="table table-bordered text-center " style="font-size: 12px;"   >
                                <tr>
                                    <th>TUMBLAST MACHINE OPERATOR/INSPECTOR </th> 
                                    <th>SHOT BLASTNG MACHINE OPERATOR/INSPECTOR</th> 
                                    <th>AG4 MACHINE OPERATOR</th>
                                    <th>CONTRACTOR GRINDING MACHINE OPERATOR</th> 
                                </tr>
                                <tr>
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['tumblast_machine_operator']; ?></td> 
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['shot_blastng_machine_operator']; ?></td> 
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['ag4_machine_operator']; ?></td> 
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['contractor_grinding_machine_operator']; ?></td> 
                                </tr>
                                <tr>
                                    <th>COMPANY GRINDING MACHINE OPERATOR</th>
                                    <th>PAINTING PERSON</th> 
                                    <th>SHIFT SUPERVISOR</th>
                                    <th>FACTORY MANAGER</th>
                                </tr>
                                <tr>
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['company_grinding_machine_operator']; ?></td> 
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['painting_person']; ?></td> 
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['shift_supervisor']; ?></td> 
                                    <td><?php if(isset($operator[$date][$shift])) echo $operator[$date][$shift]['factory_manager']; ?></td> 
                                </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="20"> <b>Prepared By</b></td>
                            <td colspan="20"> <b>Approved By </b></td>
                            <td colspan="20"> 
                            Rev no: 00 <br />
                            Rev date: 10.9.2019 <br />
                            Supersedes 00 
                            </td>
                        </tr>
                    </tbody>
                </table>   
                   <?php 
                   $c_tot_qty += $tot_qty;
                   $c_tot_wt += $tot_wt; 
                   $c_rej_qty += $t_rej_qty;
                   $c_rej_wt += $t_rej_qty_wt; 
                   } ?> 
                   <?php } ?>  
                    
                    <table class="table table-bordered " style="font-size: 12px;"  >
                    <tr>
                        <th>Consolidated Produced Qty :</th> <th><?php echo number_format($c_tot_qty,2); ?></th>
                        <th>Consolidated Produced Wt : </th> <th><?php echo number_format($c_tot_wt,2); ?></th>
                    </tr>
                    <tr>
                        <th>Consolidated Rej Qty :</th> <th> <?php echo number_format($c_rej_qty,2); ?></th>
                        <th>Consolidated Rej Wt : </th> <th><?php echo number_format($c_rej_wt,2); ?></th>
                    </tr> 
                    <tr>
                        <th>Consolidated Rej Qty [%] :</th> <th> <?php echo number_format(($c_rej_qty / $c_tot_qty * 100),2); ?></th>
                        <th>Consolidated Rej Wt [%] :</th> <th> <?php echo number_format(($c_rej_wt / $c_tot_wt * 100),2); ?></th>
                    </tr> 
                   </table> 
                  <?php } ?>
            </div>
             <div class="box-footer text-center">
                <form method="post">
                    <input type="hidden" name="srch_from_date" value="<?php echo $srch_from_date?>" />
                    <input type="hidden" name="srch_to_date" value="<?php echo $srch_to_date?>" />
                    <input type="hidden" name="srch_customer_id" value="<?php echo $srch_customer_id?>" />
                    <input type="hidden" name="srch_pattern_id" value="<?php echo $srch_pattern_id?>" />
                <button type="submit" class="btn btn-info" name="btn_print" value="print"><i class="fa fa-print"></i> Print</button>
                </form>
             </div>
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
