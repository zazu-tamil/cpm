<?php
 
 	//echo "<pre>";
    //print_r($record_list);
    //print_r($qc_list);
    //print_r($rej_summary);
    //print_r($rec_list);
    //print_r($tot_rej_qty);
	//echo "</pre>";  
     
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP Rejection Breakup Summary Report :  From <?php echo date('d-m-Y', strtotime($srch_from_date)); ?> to <?php echo date('d-m-Y', strtotime($srch_to_date));  ?>  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="<?php echo base_url() ?>asset/bower_components/jquery/dist/jquery.min.js"></script> 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group;  }
    tfoot { display:table-footer-group }
    @media print{
       .noprint{
           display:none;
       }
       
        
    }
    i{font-size: 12px;}
    #sts tr {border: 1px solid black;}
    #mtc th{border:1px solid black; text-align: center;}
    #mtc td{border:1px solid black; text-align: center;}
  
  </style>  
 
</head>
<body onload="window.print();" style="font-size: 11px;">
 
<div class="">
  <!-- Main content -->
  <section class="invoice">
     
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12" id="mtc">
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
                        <td colspan="10" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold; text-align: left;">
                            <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                            <!--Document Level 3 <br />
                            Doc Ref No: MJP/WD/MEL/005 <br />
                            Issue Date : 15-02-2023<br /> -->
                             
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
                                    <td><?php if(isset($operator[$date][$shift])) 
                                    echo $operator[$date][$shift]['factory_manager']; ?></td> 
                                </tr>
                            </table>
                                 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="20"> <b>Prepared By</b></td>
                            <td colspan="20"> <b>Approved By </b></td>
                            <td colspan="20" style="text-align: left;"> 
                            <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                    
                            <!--Rev no: 00 <br />
                            Rev date: 10.9.2019 <br />
                            Supersedes 00 -->
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
    </div>
     <div class="text-center">
        <a class="btn btn-success noprint" href="<?php echo site_url('rejection-summary-report')?>">Back To Reject Summary Report</a>
     </div>
 
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
