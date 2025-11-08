<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($record_list);
echo "</pre>";*/
?>
 <section class="content-header">
  <h1>Customer Wise Melting Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Melting Report</a></li> 
    <li class="active">Customer Wise Melting Report</li>
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
				 <div class="form-group col-md-2">
                    <label>Shift</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_shift',$shift_opt ,set_value('srch_shift' , $srch_shift) ,' id="srch_shift" class="form-control" ');?> 
                            
                      </div>                                   
                 </div> 
                <div class="form-group col-md-12 text-center">
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
              <h3 class="box-title text-white">Customer Wise Melting Report : <span><i> [ <?php echo $srch_from_date ?> to <?php echo $srch_to_date ?> ]</i></span></h3> 
            </div>
            <div class="box-body bg-gray-light table-responsive">  
                <?php  if(!empty($record_list)) { $cum['liq'] = $cum['units'] =  $cum['poured_casting_wt'] = 0; ?>
                    <?php  foreach($record_list as $j => $info) { 
                        $cum['units'] += $info['units'];
						//if(isset($tot_liq_metal[$info['mid']]))
                          $tot_liq = array_sum($tot_liq_metal[$info['mid']]);  

                        $time = $info['ideal_hrs']; // e.g. "02:30:00"
                        list($h, $m, $s) = explode(':', $time);
                        $total_seconds += ($h * 3600) + ($m * 60) + $s;
                        //else {
                        //  $tot_liq = 0;  
                        //  echo "<h1>Chemical Composition Missing </h1>";
                       // }  
                        $mt_ls_per = (((($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap']) - $tot_liq) / ($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap'])) * 100); 
                        ?>
                        <div class="box box-info">  
                        <div class="box-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-condensed text-center">
                                    
                                    <tr>
                                        <th>#</th>
                                        <th>Planning Date</th>
                                        <th>Shift</th>
                                        <th>Date</th>
                                        <th>Lining Heat No</th>
                                        <th>Heat Code</th>
                                        <th>Tapp Temp</th>
                                        <th>Ladle 1 First Box Temp</th>
                                        <th>Ladle 2 First Box Temp</th> 
                                    </tr>
                                    <tr>
                                        <td><?php echo ($j+1)?></td>
                                        <td><?php echo date('d-m-Y', strtotime($info['planning_date'])) ?></td>
                                        <td><?php echo $info['shift']?></td>
                                        <td><?php echo date('d-m-Y', strtotime($info['melting_date'])) ?></td>
                                        <td><?php echo $info['lining_heat_no']?> <i style="display:none;"><br /><?php echo $info['mid']?></i></td>
                                        <td><span class="badge"><?php echo $info['heat_code']?> <?php echo $info['days_heat_no']?></span></td>
                                        <td><?php echo $info['tapp_temp']?></td>
                                        <td><?php echo $info['ladle_1_first_box_pour_temp']?></td>
                                        <td><?php echo $info['ladle_2_first_box_pour_temp']?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered text-center table-condensed">
                                    <tr>
                                        <th colspan="3" class="text-center">Furnace</th>
                                        <th colspan="3" >Pouring</th>
                                        <th colspan="3">Idle</th>
                                        <th colspan="4">Electrical</th>
                                        <!--<th colspan="2">Melt Loss</th>-->
                                    </tr>
                                    <tr>
                                        <th>On</th>
                                        <th>Off</th>
                                        <th>Tot Hrs</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Tot Hrs</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Tot Hrs</th> 
                                        <th>Init</th> 
                                        <th>Final</th> 
                                        <th>Units</th> 
                                        <!--
                                        <th>Units/Ton</th> 
                                        <th>Kg</th> 
                                        <th>%</th> -->
                                    </tr>
                                    <tr>
                                        <td><?php echo $info['furnace_on_time']?></td>
                                        <td><?php echo $info['furnace_off_time']?></td>
                                        <td><?php echo $info['furnace_time']?></td>
                                        <td><?php echo $info['pouring_start_time']?></td>
                                        <td><?php echo $info['pouring_finish_time']?></td>
                                        <td><?php echo $info['pouring_time']?></td>
                                        <td><?php echo $info['ideal_hrs_from']?></td>
                                        <td><?php echo $info['ideal_hrs_to']?></td>
                                        <td><?php echo $info['ideal_hrs']?></td>
                                        <td><?php echo $info['start_units']?></td>
                                        <td><?php echo $info['end_units']?></td>
                                        <td><strong class="text-fuchsia"><?php echo $info['units']; ?></strong></td>
                                        <?php  /*
                                        <td><strong class="text-green"><?php echo number_format((($info['units'] / $tot_liq) * 1000),3);?></strong></td>
                                        <td><?php echo number_format((($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap']) - $tot_liq),2); ?></td>
                                        <td><b class="label <?php if($mt_ls_per > 5) echo 'bg-red'; else echo 'label-success' ?>"><?php echo number_format((((($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap']) - $tot_liq) / ($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap'])) * 100),2); ?></b></td>
                                         */ ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Material Charging</b>
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        <th>Pig Iron</th>
                                        <th>Return</th>
                                        <th>MS/LMS</th>
                                        <th>Spillage</th>
                                        <th>CI Boring</th> 
                                        <th>CI Scrap</th> 
                                        <th>Total</th> 
                                    </tr>
                                    <tr> 
                                        <td><?php echo $info['pig_iron']?></td>
                                        <td><?php echo $info['foundry_return']?></td>
                                        <td><?php echo $info['ms']?></td> 
                                        <td><?php echo $info['spillage']?></td> 
                                        <td><?php echo $info['boring']?></td> 
                                        <td><?php echo $info['CI_scrap']?></td> 
                                        <td><?php echo ($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap'])?></td> 
                                    </tr>
                                     
                                </table>
                            </div>
                            <div class="col-md-6">
                                <b>Ingredient Additives</b>
                                <table class="table table-bordered table-condensed">
                                    <tr>
                                        
                                        <th>CPC/Shell C</th>
                                        <th>Fe-Mn</th>
                                        <th>Fe-Si</th>
                                        <th>Inoculant</th>
                                        <th>Fe-S</th>
                                        <th>Fe-Si-Mg</th>
                                        <th>Cu</th>
                                        <th>Gr.Coke</th>
                                        <th>Pyrometer Tip</th>
                                    </tr>
                                    <tr> 
                                        <td><?php echo $info['C']?></td>
                                        <td><?php echo $info['Mn']?></td>
                                        <td><?php echo $info['SI']?></td> 
                                        <td><?php echo $info['inoculant']?></td> 
                                        <td><?php echo $info['fe_sulphur']?></td> 
                                        <td><?php echo $info['fe_si_mg']?></td> 
                                        <td><?php echo $info['Cu']?></td> 
                                        <td><?php echo $info['graphite_coke']?></td> 
                                        <td><?php echo $info['pyrometer_tip']?></td> 
                                    </tr>
                                     
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <table class="table table-bordered table-striped table-condensed"> 
                                    <tr>
                                        <th>#</th> 
                                        <th>Item</th>
                                        <th>Grade</th>
                                        <th class="text-right">Poured Box</th>
                                        <th class="text-right">Box Wt</th>
                                        <th class="text-right">Closed Mould Qty Wt</th> 
                                        <th class="text-right">Liquid Metal</th>
                                        <th class="text-right">Poured Casting Wt</th>
                                        <th class="text-right">FR Wt</th>
                                    </tr>
                                 <?php 
                                    $tot['pouring_box']  = $tot['liq_wt']= $tot['poured_casting_wt'] = 0;
                                    //$closed_mould_qty_wt = 
                                  foreach($child_list[$info['mid']] as $j => $info11) {  
                                    
                                    if($info11['pouring_box'] > 0 )
                                    {
                                        $liq_metal = (($info11['bunch_weight'] * $info11['pouring_box']) - $closed_mould_qty_list[$info11['work_planning_id']]);
                                        $poured_casting_wt = (($info11['casting_weight'] * $info11['pouring_box']) - $closed_mould_qty_list[$info11['work_planning_id']]);
                                       
                                    } else {
                                        $liq_metal = ($info11['bunch_weight'] * $info11['pouring_box']); 
                                        $poured_casting_wt = ($info11['casting_weight'] * $info11['pouring_box']); 
                                    }  
                                    
                                      $tot['pouring_box'] += $info11['pouring_box'];  
                                      $tot['liq_wt'] += $liq_metal ;   
                                      $tot['poured_casting_wt'] += $poured_casting_wt ;   
                                      $cum['liq'] += $liq_metal ;   
                                      $cum['poured_casting_wt'] += $poured_casting_wt ;   
                                 ?>
                                    
                                    <tr>
                                        <td><?php echo ($j+1)?></td>   
                                        <td class="text-left"><?php echo $info11['item']; ?><?php if(isset($child_record_list[$info11['work_planning_id']])) { ?><br /><i class="text-fuchsia"><?php  echo implode(',', $child_record_list[$info11['work_planning_id']]);  ?></i><?php } ?></td> 
                                        <td class="text-left"><?php echo $info11['grade_name'];?></td> 
                                        <td class="text-right"><?php echo $info11['pouring_box'];?></td> 
                                        <td class="text-right"><?php echo number_format($info11['bunch_weight'],3);?></td> 
                                        <td class="text-right"><?php echo number_format($closed_mould_qty_list[$info11['work_planning_id']],3);?></td> 
                                        <td class="text-right"><?php  echo number_format($liq_metal,3); ?></td> 
                                        <td class="text-right"><?php echo number_format($poured_casting_wt,3);?></td>
                                        <td class="text-right"><?php echo number_format(($liq_metal - $poured_casting_wt),3);?></td>
                                    </tr>
                                <?php 
                                    if($info11['pouring_box'] > 0 ) {    
                                        if($closed_mould_qty_list[$info11['work_planning_id']] > 0)
                                            $closed_mould_qty_list[$info11['work_planning_id']] = $closed_mould_qty_list[$info11['work_planning_id']] - $info11['closed_mould_qty_wt'];
                                    }
                                    
                                    } 
                                ?> 
                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td class="text-right"><?php echo number_format($tot['pouring_box'],2);?></td>
                                        <th></th>
                                        <th></th> 
                                        <td class="text-right"><strong class="text-orange"><?php echo number_format($tot['liq_wt'],3);?></strong></td>
                                        <td class="text-right"><strong class=""><?php echo number_format($tot['poured_casting_wt'],3);?></strong></td>
                                        <td class="text-right"><strong class=""><?php echo number_format(($tot['liq_wt'] - $tot['poured_casting_wt']),3);?></strong></td>
                                         
                                    </tr>    
                                    </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                 <table class="table table-bordered table-responsive">
                                    <tr>
                                        <th colspan="3" class="text-center bg-green">Consumption</th>
                                        <th colspan="3" class="text-center bg-blue">Melting Loss</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Units <br /><span class="label label-info">A</span></th>
                                        <th class="text-center">Liquid Metal <br /><span class="label label-info">B</span></th>
                                        <th class="text-center">Units/Ton <br /><span class="label label-info">A / B * 1000</span></th>
                                        <th class="text-center">Material <br /><span class="label label-warning">C</span></th>
                                        <th class="text-center">Kg <br /><span class="label label-warning">(C-B)</span></th>
                                        <th class="text-center">% <br /><span class="label label-warning">(C-B)/(C *100)</span></th>
                                    </tr>
                                    <tr class="bg-gray">
                                        <td class="text-green text-center"><strong><?php echo number_format(($info['units']),0);?></strong></td>
                                        <td class="text-blue text-center"><strong><?php echo number_format(($tot['liq_wt']),3);?></strong></td>
                                        <td class="text-fuchsia text-center"><strong><?php echo number_format((($info['units'] / $tot['liq_wt']) * 1000), 3);?></strong></td>
                                        <td class="text-orange text-center"><strong>
                                            <?php 
                                            $tot_material = ($info['pig_iron']+ $info['foundry_return']+ $info['ms']+$info['spillage']+ $info['boring'] +$info['CI_scrap']) ;
                                            echo number_format($tot_material,0);
                                            ?></strong></td>
                                        <td class="text-purple text-center"><strong><?php  echo number_format((( $tot_material - $tot['liq_wt'])), 2); ?></strong> </td>
                                        <td class="text-maroon text-center">
                                           <strong> <?php  echo number_format((( $tot_material - $tot['liq_wt']) / $tot_material * 100 ), 2); ?></strong>
                                        </td>
                                    </tr>
                                 </table>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-12">
                                <b>Chemical Composition</b>
                                <table class="table table-bordered text-center table-condensed">
                                    <tr>
                                        <th></th>
                                        <th>C%</th>
                                        <th>Si%</th>
                                        <th>Mn%</th>
                                        <th>P%</th>
                                        <th>S%</th>
                                        <th>Cr%</th>
                                        <th>Cu%</th>
                                        <th>Mg%</th>
                                        <th>BHN</th>
                                    </tr>
                                    <tr>
                                        <td>Spec</td>
                                        <td><?php echo $child_list[$info['mid']][0]['C']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['SI']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['Mn']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['P']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['S']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['Cr']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['Cu']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['Mg']?></td> 
                                        <td><?php echo $child_list[$info['mid']][0]['BHN']?></td> 
                                    </tr>
                                    <tr>
                                        <td>Base</td>
                                        <td><?php echo $info['b_c']?></td>
                                        <td><?php echo $info['b_si']?></td>
                                        <td><?php echo $info['b_mn']?></td> 
                                        <td><?php echo $info['b_p']?></td> 
                                        <td><?php echo $info['b_s']?></td> 
                                        <td><?php echo $info['b_cr']?></td> 
                                        <td><?php echo $info['b_cu']?></td> 
                                        <td><?php echo $info['b_mg']?></td> 
                                        <td><?php echo $info['b_bmn']?></td> 
                                    </tr>
                                    <tr>
                                        <td>Final</td>
                                        <td><?php echo $info['f_c']?></td>
                                        <td><?php echo $info['f_si']?></td>
                                        <td><?php echo $info['f_mn']?></td> 
                                        <td><?php echo $info['f_p']?></td> 
                                        <td><?php echo $info['f_s']?></td> 
                                        <td><?php echo $info['f_cr']?></td> 
                                        <td><?php echo $info['f_cu']?></td> 
                                        <td><?php echo $info['f_mg']?></td> 
                                        <td><?php echo $info['f_bmn']?></td> 
                                    </tr>
                                </table>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <b>Pouring Person Name - 1 : <?php echo $info['pouring_person_name_1']?></b>
                            </div>
                            <div class="col-md-4 form-group">
                                <b>Pouring Person Name - 2 : <?php echo $info['pouring_person_name_2']?></b>
                            </div>
                            <div class="col-md-4 form-group">
                                <b>Pouring Person Name - 3 : <?php echo $info['pouring_person_name_3']?></b>
                            </div> 
                        </div>  
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <b>FC Operator : <?php echo $info['fc_operator']?></b>
                            </div>
                            <div class="col-md-4 form-group">
                                <b>Helper : <?php echo $info['helper_name']?></b>
                            </div>
                            <div class="col-md-4 form-group">
                                <b>Supervisor : <?php echo $info['supervisor']?></b>
                            </div> 
                        </div>  
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <b>Remarks : </b><br /><?php echo $info['remarks']?>
                            </div> 
                        </div>     
                        </div>   
                        </div>   
                    <?php } ?>                                    
                    <?php 
                    $total_hours = floor($total_seconds / 3600);
                    $total_minutes = floor(($total_seconds % 3600) / 60);
                    $total_seconds = $total_seconds % 60;
                    ?>
                 <?php } ?>
            </div>
             <div class="box-footer">
                <div class="row">
                    <div class="col-md-2">Cumulative Units : <strong><?php echo $cum['units']?></strong></div>
                    <div class="col-md-2">Liq.Metal : <strong><?php echo number_format($cum['liq'],3)?></strong></div>
                    <div class="col-md-2">P.Casting Wt : <strong><?php echo number_format($cum['poured_casting_wt'],3)?></strong></div>
                    <div class="col-md-2">FR Wt : <strong><?php echo number_format(($cum['liq'] - $cum['poured_casting_wt']),3);?></strong></div>
                    <div class="col-md-2">Units/ton :<strong> <?php echo number_format(( (($cum['units'] / $cum['liq']) * 1000)),3);?></strong></div>
                    <div class="col-md-2">Total Breakdown Hrs :<strong> <?php echo sprintf("Total Ideal Hours: %02d:%02d:%02d", $total_hours, $total_minutes, $total_seconds); ?></strong></div>
                </div>
             </div>
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
