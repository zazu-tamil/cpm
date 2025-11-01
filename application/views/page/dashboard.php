<?php  include_once(VIEWPATH . '/inc/header.php'); 
//print_r($liq_metal);
//echo array_sum($liq_metal);
?>
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php if(isset($liq_metal[date("Y-m-d", strtotime("-1 day"))])) echo number_format(($liq_metal[date("Y-m-d", strtotime("-1 day"))] / 1000),3); else echo '0'; ?></h3>

              <p>Liquid Metal as on <?php echo date("d-m-Y", strtotime("-1 day"));?> </p> 
            </div>
            <div class="icon">
              <i class="fa fa-flask"></i>
            </div>
             
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo number_format((array_sum($liq_metal)/1000),3); ?></h3>

              <p>Liquid Metal as on <?php echo date("M");?></p>
            </div>
            <div class="icon">
              <i class="fa fa-tint"></i>
            </div> 
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php 
              if(isset($poured_casting_wt[date('Y-m-d')]))
                echo number_format(($poured_casting_wt[date('Y-m-d')] /1000),3);
              else 
                echo '0.000';
              ?></h3>

              <p>Today's Production</p>
            </div>
            <div class="icon">
              <i class="fa fa-cube"></i>
            </div>  
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3><?php echo number_format((array_sum($poured_casting_wt) /1000),3); ?></h3>

              <p>Total Production [ <?php echo date("M");?> ]</p>
            </div>
            <div class="icon">
              <i class="fa fa-cube"></i>
            </div> 
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php 
              if(isset($despatch[date('Y-m-d')]))
                echo number_format(($despatch[date('Y-m-d')] /1000),3);
              else 
                echo '0.000';
              ?></h3>

              <p>Today's Despatch</p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>  
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo number_format((array_sum($despatch) /1000),3); ?></h3>

              <p>Total Despatch [ <?php echo date("M");?> ]</p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div> 
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
        
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-table"></i>

              <h3 class="box-title">Datewise Summary</h3> 
               
            </div>
            <div class="box-body" >
               <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-right">Liquid Metal</th> 
                        <th class="text-right">Production</th> 
                        <th class="text-right">Rejection</th>
                        <th class="text-right">Despatch</th>
                    </tr>
                </thead>
                <!--<tbody>
                    <?php 
                        /*
                        $tot_rej = $tot_liq_metal = 0; 
                        foreach($liq_metal as $dat => $info) { 
                        $tot_liq_metal += $info;  
                        if(isset($rejection[date('Y-m-d', strtotime($dat))])) 
                         $tot_rej += $rejection[date('Y-m-d', strtotime($dat))];
                    ?>  
                    <tr>
                        <td><?php echo date('M d,Y', strtotime($dat)) ;?></td>
                        <td class="text-right"><?php echo number_format($info,3);?></td> 
                        <td class="text-right"><?php if(isset($production[date('Y-m-d', strtotime($dat))])) echo number_format($production[date('Y-m-d', strtotime($dat))],3);?></td>
                        <td class="text-right"><?php if(isset($rejection[date('Y-m-d', strtotime($dat))])) echo number_format($rejection[date('Y-m-d', strtotime($dat))],3);?></td>
                        <td class="text-right"><?php if(isset($despatch[date('Y-m-d', strtotime($dat))])) echo number_format($despatch[date('Y-m-d', strtotime($dat))],3);?></td>
                    </tr>
                    <?php } */ ?>
                    <tr>
                        <th>Total</th>
                        <th class="text-right"><?php// echo number_format($tot_liq_metal,3);?></th> 
                        <th class="text-right"><?php //echo number_format(array_sum($production),3); ?></th>
                        <th class="text-right"><?php //echo number_format($tot_rej,3); ?></th>
                        <th class="text-right"><?php //echo number_format(array_sum($despatch),3); ?></th>
                    </tr>-->
                    <?php //print_r($poured_casting_wt);
                       $tot_liq_metal = $tot_rej = $tot_poured_casting_wt =  0;
                        for($k=date('d');$k>=1;$k--) {
                        $dat = str_pad($k,2,'0',STR_PAD_LEFT).'-'.date('m-Y');
                         if(isset($rejection[date('Y-m-d', strtotime($dat))])) 
                         $tot_rej += $rejection[date('Y-m-d', strtotime($dat))];
                         if(isset($liq_metal[date('Y-m-d', strtotime($dat))])) 
                         $tot_liq_metal += $liq_metal[date('Y-m-d', strtotime($dat))];
                         if(isset($poured_casting_wt[date('Y-m-d', strtotime($dat))])) 
                         $tot_poured_casting_wt += $poured_casting_wt[date('Y-m-d', strtotime($dat))];
                        ?>
                        <tr>
                            <td><?php echo  str_pad($k,2,'0',STR_PAD_LEFT).'-'.date('m-Y');?></td>  
                            <td class="text-right"><?php if(isset($liq_metal[date('Y-m-d', strtotime($dat))])) echo number_format($liq_metal[date('Y-m-d', strtotime($dat))],3); else echo "0.00";?></td>
                            <td class="text-right"><?php if(isset($poured_casting_wt[date('Y-m-d', strtotime($dat))])) echo number_format($poured_casting_wt[date('Y-m-d', strtotime($dat))],3); else echo "0.00";?></td>
                            <td class="text-right"><?php if(isset($rejection[date('Y-m-d', strtotime($dat))])) echo number_format($rejection[date('Y-m-d', strtotime($dat))],3); else echo "0.00";?></td>
                            <td class="text-right"><?php if(isset($despatch[date('Y-m-d', strtotime($dat))])) echo number_format($despatch[date('Y-m-d', strtotime($dat))],3); else echo "0.00";?></td>
                        </tr>
                        
                     <?php } ?>
                        <tr>
                            <th>Total</th>
                            <th class="text-right"><?php echo number_format($tot_liq_metal,3);?></th> 
                            <th class="text-right"><?php echo number_format($tot_poured_casting_wt,3); ?></th>
                            <th class="text-right"><?php echo number_format($tot_rej,3); ?></th>
                            <th class="text-right"><?php echo number_format(array_sum($despatch),3); ?></th>
                        </tr>
                </tbody>
                
               </table>
            </div>
            <!-- /.chat -->
             
          </div>
          
          
         <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-table"></i>

              <h3 class="box-title">Productions <i class="text-sm text-red">in tons</i> - Last 12 Month</h3> 
               
            </div>
            <div class="box-body" >
               <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th class="text-right">Liquid Metal</th>  
                        <th class="text-right">Poured Casting</th>   
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach($last_12_month_production as $dat => $info) {    ?>
                    <tr>
                        <td><?php echo $info['alp_mon'];?></td>
                        <td class="text-right"><?php echo $info['liq_metal'];?></td>  
                        <td class="text-right"><?php echo $info['poured_casting_wt'];?></td>  
                    </tr>
                    <?php } ?>  
                </tbody>
               </table>
            </div>
            <!-- /.chat -->
            <div class="box-footer text-center">
                 
            </div> 
          </div>
          
         

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">
 
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-table"></i>

              <h3 class="box-title">Moulding</h3> 
               
            </div>
            <div class="box-body" >
               <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-right">Planned Box</th> 
                        <th class="text-right">Produced Box</th>
                        <th class="text-right">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        $tot_box = $tot_eff =  0;
                        foreach($moulding as $dat => $info) { 
                         $tot_box += $info['produced_box'];   
                         $tot_eff += $info['efficiency'];   
                    ?>
                    <tr>
                        <td><?php echo date('M d,Y', strtotime($dat)) ;?></td>
                        <td class="text-right"><?php echo number_format($info['planned_box'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['produced_box'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['efficiency'],2);?></td> 
                       
                    </tr>
                    <?php } ?> 
                    <tr>
                        <th> Total</th>
                        <td class="text-right"><?php echo number_format($tot_box,0);?></td> 
                        <td class="text-right"><?php if(!empty($moulding)) echo number_format(($tot_eff / count($moulding)),2);?></td> 
                    </tr>
                </tbody>
               </table>
            </div>
            <!-- /.chat -->
            <div class="box-footer text-center">
                <i class="text-red">Man hour productivity should be Min 3.75</i>
            </div> 
          </div>
          
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-table"></i>

              <h3 class="box-title">Moulding - Last 3 Month</h3> 
               
            </div>
            <div class="box-body" >
               <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-right">Planned Box</th> 
                        <th class="text-right">Produced Box</th>
                        <th class="text-right">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach($last_month_moulding as $dat => $info) {    ?>
                    <tr>
                        <td><?php echo  date('M,Y', strtotime($info['m_date'].'-01'));?></td>
                        <td class="text-right"><?php echo number_format($info['planned_box'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['produced_box'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['efficiency'],2);?></td> 
                       
                    </tr>
                    <?php } ?>  
                </tbody>
               </table>
            </div>
            <!-- /.chat -->
            <div class="box-footer text-center">
                <i class="text-red">Man hour productivity should be Min 3.75</i>
            </div> 
          </div>
          
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-table"></i>

              <h3 class="box-title">Rejection <i class="text-sm text-red">in tons</i> - Last 12 Month</h3> 
               
            </div>
            <div class="box-body" >
               <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th class="text-right">Internal Rej</th>  
                        <th class="text-right">Customer Rej</th>  
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach($last_12_month_rejection as $dat => $info) {    ?>
                    <tr>
                        <td><?php echo   $info['alp_mon'];?></td>
                        <td class="text-right"><?php echo number_format(($info['int_rej'] / 1000),3);?></td> 
                        <td class="text-right"><?php echo number_format(($info['cust_rej'] /1000),3);?></td> 
                        <td class="text-right"><?php echo number_format((($info['int_rej'] + $info['cust_rej'])/1000),3);?></td> 
                       
                    </tr>
                    <?php } ?>  
                </tbody>
               </table>
            </div>
            <!-- /.chat -->
            <div class="box-footer text-center">
                 
            </div> 
          </div>

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
