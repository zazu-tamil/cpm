<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Daily Planning  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Planning & Production</a></li> 
    <li class="active">Daily Planning</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
  <form method="post" action="" id="frm"> 
    <input type="hidden" name="mode" value="Add" />
  <div class="box box-success">
    <div class="box-header with-border">
       <b>Daily Planning Item List</b>
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-condensed table-responsive text-center">
        <thead> 
            <tr>
                <th colspan="8"></th>
                <th colspan="3" class="text-center">To be Produced</th>
                <th colspan="2" class="text-center">Core</th>  
                <th colspan="2" class="text-center">Plan Box</th>

            </tr>    
            <tr> 
                <th>Customer</th> 
                <th>Customer<br />PO</th>  
                <th>Pattern<br />Item</th>  
                <th>Type /<br />No Of Core</th>  
                <th>Box.Wt</th>  
                <th>WO Qty</th>  
                <th>Planned Qty</th>  
                <th>Produced Qty</th>  
                <th>Qty</th> 
                <th>Box</th> 
                <th>Wt</th> 
                <th>Required</th> 
                <th>Available</th>                 
                <th class="text-center">Select</th>  
                <th class="text-center">No of Box</th>  
            </tr> 
        </thead>
          <tbody>
               <?php foreach($record_list as $match_plate_no=> $ls1){ ?> 
               <tr>
                <td colspan="15" style="text-align: left;"><strong> Match Plate No : <?php echo $match_plate_no?></strong></td>
               </tr>
               <tr> 
                <th>Customer</th>  
                <th>Customer<br />PO</th>  
                <th>Pattern<br />Item</th>  
                <th>Type /<br />No Of Core</th>  
                <th>Box.Wt</th>  
                <th>WO Qty</th>  
                <th>Planned Qty</th>  
                <th>Produced Qty</th> 
                <th>Qty</th> 
                <th>Box</th> 
                <th>Wt</th> 
                <th>Required</th> 
                <th>Available</th>                 
                <th class="text-center">Select</th>  
                <th class="text-center">No of Box</th>  
            </tr> 
               <?php foreach($ls1 as $j=> $ls){ ?> 
                <tr <?php  if($ls['in_out_state'] != '0') { echo 'class="text-red bg-gray" '; } else { if($ls['match_plate_no_ch1']!= '' or $ls['match_plate_no_ch1']!= 0) { echo "";} else { echo 'class="text-fuchsia"';} } ?>> 
                       
                    <td><?php echo $ls['customer']?></td>  
                    <td><a href="<?php echo site_url('work-order-edit/'). $ls['work_order_id'];?>" target="_blank"><?php echo $ls['customer_PO_No']?></a></td>  
                    <td>
						<?php echo htmlspecialchars($ls['pattern_item']);?><?php if($ls['match_plate_no_ch1']!= '' or $ls['match_plate_no_ch1']!= 0) {?>&nbsp;<i class="badge bg-green">P</i><input type="hidden" name="is_parent[<?php echo $ls['work_order_item_id']; ?>]" value="Parent" /><?php } ?>
						<?php  if($ls['in_out_state'] != '0') { echo "<br><i>Item Un-available : ".$ls['in_out_state']."</i>"; } ?>
					</td>   
                    <td><?php echo $ls['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls['no_of_core']?></span></td>   
                    <td class="text-right">
                        <?php echo number_format($ls['bunch_weight'],2)?> 
                    </td>  
                    <td class="text-right">
                        <?php
                            if(isset($wo_stock_list[$ls['work_order_id']][$ls['work_order_item_id']])) 
                                echo number_format($wo_stock_list[$ls['work_order_id']][$ls['work_order_item_id']]['order_qty'],0);
                            else
                                echo '0';    
                        ?> 
                    </td> 
                    <td class="text-right">
                        <?php
                            if(isset($wo_stock_list[$ls['work_order_id']][$ls['work_order_item_id']])) 
                                echo number_format($wo_stock_list[$ls['work_order_id']][$ls['work_order_item_id']]['planned_qty'],0);
                            else
                                echo '0';    
                        ?> 
                    </td> 
                    <td class="text-right">
                        <?php
                            if(isset($wo_stock_list[$ls['work_order_id']][$ls['work_order_item_id']])) 
                                echo number_format($wo_stock_list[$ls['work_order_id']][$ls['work_order_item_id']]['produced_qty'],0);
                            else
                                echo '0';    
                        ?> 
                    </td> 
                    <td class="text-right"><?php echo number_format($ls['wo_req_qty'],0)?></td>   
                    <td class="text-right"><?php echo number_format($ls['wo_req_box'],0)?></td>   
                    <td class="text-right"><?php echo number_format($ls['wo_box_wt'],2)?></td>
                    <td class="text-right"><?php if($ls['pattern_type'] == 'Core') echo number_format(($ls['no_of_core'] * $ls['wo_req_box']),2); else echo '';?></td> 
                    <!--<td class="text-right"><?php //echo number_format($ls['core_avail_qty'],2)?></td>  -->
                    <td class="text-right"><?php  if($ls['pattern_type'] == 'Core') {
                    if(isset($core_stock_list[$ls['pattern_id']])) {
                        echo number_format(array_sum(($core_stock_list[$ls['pattern_id']])),2);
                        $core_itm = '';
                         foreach($core_stock_list[$ls['pattern_id']] as $key => $val){
                            $core_itm .=   $key . ":<b>" . $val. "</b><br>";
                         } ?>
                         <br /><a href="#" data-toggle="popover" title="Core Available" data-html="true" data-placement="top"  data-content="<?php //if(!empty($core_itm)) echo str_replace("'",'-',$core_itm) ;?> " onclick="return false;"><i class="fa fa-info-circle"></i></a>
                    <?php     
                    } else echo "0"; } else echo ""; ?></td>  
                    <td class="text-center">
                        <?php if($ls['child_pattern_1'] == '') { ?>
                        <input type="checkbox" name="work_order_item_id[]" value="<?php echo $ls['work_order_item_id']; ?>" class="chk_work_order_item_id" /> 
                        <?php } 
                        if(isset($child_record_list[$ls['child_pattern_1']])) {  
                         ?>
                        <input type="checkbox" name="work_order_item_id[]" value="<?php echo $ls['work_order_item_id']; ?>" class="chk_work_order_item_id" />
                        <?php } else {
                            if($ls['match_plate_no_ch1']!= '' or $ls['match_plate_no_ch1']!= 0)    
                                echo "<i class='text-red'>No Work Order for Child Item </i>";
                        } ?> 
                    </td>   
                    <td class="text-center" width="10%">
                        <?php /*max="<?php echo number_format(($ls['no_of_cavity'] * $ls['wo_req_box']),2)?>" */ ?>
                        <input type="number" name="plan_qty[<?php echo $ls['work_order_item_id']; ?>]" class="form-control plan_qty text-right"  value="0" data="<?php echo $ls['bunch_weight']; ?>"   disabled="true" />
                        <input type="hidden" name="customer_id[<?php echo $ls['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['customer_id']; ?>" />
                        <input type="hidden" name="pattern_id[<?php echo $ls['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['pattern_id']; ?>" />
                        <input type="hidden" name="work_order_id[<?php echo $ls['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_id']; ?>" />
                        <input type="hidden" name="box_wt[<?php echo $ls['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['bunch_weight']; ?>" />
                    </td>   
                                                          
                </tr>
                <?php 
                if(isset($child_record_list[$ls['child_pattern_1']])) { 
                foreach($child_record_list[$ls['child_pattern_1']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?> &nbsp;<i class="badge bg-red">C1</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                         Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_1_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td>  
                    <td class="text-center" > 
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_1_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>  
                                                          
                </tr>
                <?php }} ?> 
                <?php 
                if(isset($child_record_list[$ls['child_pattern_2']]))  { $ls1 = '';
                foreach($child_record_list[$ls['child_pattern_2']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?>&nbsp;<i class="badge bg-red">C2</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                         Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_2_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td> 
                    <td class="text-center">
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_2_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>    
                                                          
                </tr>
                <?php }} ?> 
                <?php 
                if(isset($child_record_list[$ls['child_pattern_3']]))  { $ls1 = '';
                foreach($child_record_list[$ls['child_pattern_3']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?>&nbsp;<i class="badge bg-red">C3</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                        Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_3_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td>  
                    <td class="text-center">
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_3_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>    
                                                          
                </tr>
                <?php }} ?> 
                <?php 
                if(isset($child_record_list[$ls['child_pattern_4']]))  { $ls1 = '';
                foreach($child_record_list[$ls['child_pattern_4']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?>&nbsp;<i class="badge bg-red">C4</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                        Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_4_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td>  
                    <td class="text-center">
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_4_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>    
                                                          
                </tr>
                <?php }} ?> 
                
                <?php 
                if(isset($child_record_list[$ls['child_pattern_5']]))  { $ls1 = '';
                foreach($child_record_list[$ls['child_pattern_5']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?>&nbsp;<i class="badge bg-red">C5</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                        Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_5_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td>  
                    <td class="text-center">
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_5_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>    
                                                          
                </tr>
                <?php }} ?>
                <?php 
                if(isset($child_record_list[$ls['child_pattern_6']]))  { $ls1 = '';
                foreach($child_record_list[$ls['child_pattern_6']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?>&nbsp;<i class="badge bg-red">C4</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                        Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_6_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td>  
                    <td class="text-center">
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_6_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>    
                                                          
                </tr>
                <?php }} ?>
                <?php 
                if(isset($child_record_list[$ls['child_pattern_7']]))  { $ls1 = '';
                foreach($child_record_list[$ls['child_pattern_7']] as $k=> $ls1){ ?> 
                <tr class="text-blue"> 
                       
                    <td><?php echo $ls1['customer']?></td>   
                    <td><?php echo $ls1['customer_PO_No']?></td>  
                    <td><?php echo htmlspecialchars($ls1['pattern_item'])?>&nbsp;<i class="badge bg-red">C4</i></td>   
                    <td><?php echo $ls1['pattern_type']?><br /><span class="badge bg-light-blue"><?php echo $ls1['no_of_core']?></span></td>   
                    <td class="text-right" colspan="5">
                        Cavity: <?php echo number_format(($child_record_list[$ls['pattern_item']][0]['child_pattern_7_cavity']),2); ?> 
                    </td>   
                    <td class="text-right" colspan="4">Piece Wt:<?php echo number_format($ls1['piece_weight_per_kg'],2)?></td>  
                    <td class="text-center">
                        <input type="checkbox" name="child_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][]" value="<?php echo $ls1['work_order_item_id']; ?>" class="child_work_order_item_id" /> 
                    </td>   
                    <td class="text-center" width="10%">
                        <input type="hidden" name="child_customer_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['customer_id']; ?>" />
                        <input type="hidden" name="child_pattern_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['pattern_id']; ?>" />
                        <input type="hidden" name="child_work_order_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls1['work_order_id']; ?>" />
                        <input type="hidden" name="child_item_no_of_cavity[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo ($child_record_list[$ls['pattern_item']][0]['child_pattern_7_cavity']); ?>" />
                        <input type="hidden" name="parent_work_order_item_id[<?php echo $ls['work_order_item_id']; ?>][<?php echo $ls1['work_order_item_id']; ?>]" class="form-control"  value="<?php echo $ls['work_order_item_id']; ?>" />
                    </td>    
                                                          
                </tr>
                <?php }} ?> 
                
                <?php } ?>                     
                <?php } ?>                                 
            </tbody>
      </table> 
        
    </div>
    <!-- /.box-body --> 
  </div>
  <!-- /.box -->
  <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-edit"></i> Daily Planning  </h3>
        </div>
       <div class="box-body">  
            <div class="row"> 
                <div class="form-group col-md-2">
                    <input type="hidden" name="mode" value="Add" />
                    <label>Planning Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="planning_date" name="planning_date" value="<?php echo date('Y-m-d');?>" required="true">
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="col-md-2"> 
                    <label for="srch_customer">Shift</label>
                    <?php echo form_dropdown('shift',array('' => 'Select Shift') + $shift_opt ,set_value('shift', 'Shift-A') ,' id="shift" class="form-control" required="true"');?>
                 </div> 
                 <div class="col-md-4"> 
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks"></textarea>
                 </div>
                 <div class="col-md-4"> 
                    <label>Total Box's : <span class="tot_box_planned">0</span></label> <br />
                    <label>Total Box Weight : <span class="tot_box_wt_planned">0</span> Kgs</label> 
                    <br />
                    <button class="btn btn-info pull-right" type="submit">Save</button>
                 </div>
            </div>
            
       </div> 
    </div>   
    </form>
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
