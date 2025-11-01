<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Melting Consumption Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Material Consumption Report</a></li> 
    <li class="active">Melting Consumption Report</li>
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
                 <div class="form-group col-md-3"> 
                    <label>From Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-3"> 
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date);?>" required>
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                  
                <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Reports</button>
                </div>
             </div>  
            </form>
         </div> 
         </div> 
         <?php if(($submit_flg)) { 
         /*echo "<pre>";
         print_r($record_list);
         echo "</pre>";  */ 
         ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Melting Material Consumption Report : <span><i> [ <?php echo date('d-m-Y',strtotime($srch_from_date))  ?> to <?php echo date('d-m-Y',strtotime($srch_to_date)) ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive" style="font-size: 11px;"> 
            <div class="sticky-table-demo1">   
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped table-responsive"> 
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Date</th> 
                        <th>Heat Code</th>    
                        <th>Furnace [Hrs]</th>    
                        <th>Pouring Hrs</th>    
                        <th>P.Box</th>    
                        <th>Power Consumed</th>    
                        <th>Boring</th>    
                        <th>MS / LMS</th>    
                        <th>Foundry Return</th>    
                        <th>CI Scrap</th>    
                        <th>PI</th>    
                        <th>Spillage</th>    
                        <th>CP C / Shell C</th>    
                        <th>Fe-Si</th>    
                        <th>Fe-Mn</th>    
                        <th>Fe-Si-Mg</th>    
                        <th>Fe Sulphur</th>    
                        <th>Inoculant</th>    
                        <th>GR.Coke</th>    
                        <th>P.Tip</th>    
                        <th>S</th>    
                        <th>Cr</th>    
                        <th>Cu</th>    
                        <th>Ni</th>    
                        <th>Mo</th>    
                        <th>Mat.<br>Consump</th>    
                        <th>Liq.M</th>    
                        <th>U/Ton</th>    
                        <th>M.Loss</th>    
                    </tr>  
                    </thead>
                    <tbody>
                        <?php 
                         $tot['graphite_coke'] = $tot['melt_loss'] = $tot['m_consumpt'] = $tot['liq_metal'] = $tot['unit_per_ton'] = $tot['pouring_box'] = $tot['spillage'] = $tot['units'] = $tot['boring'] = $tot['ms'] = $tot['foundry_return'] =$tot['CI_scrap'] =$tot['pig_iron'] =$tot['C'] = $tot['SI'] = $info['SI'] =$tot['Mn'] = $tot['fe_si_mg']  =$tot['fe_sulphur'] =$tot['inoculant'] = $tot['pyrometer_tip']= $tot['S']  = $tot['Cr']  = $tot['Cu'] = $tot['ni'] = $tot['mo'] = 0; 
                        foreach($record_list as $j => $info) { 
                          
                          $tot['units'] += $info['units'];    
                          $tot['boring'] += $info['boring'];    
                          $tot['ms'] += $info['ms'];    
                          $tot['foundry_return'] += $info['foundry_return'];    
                          $tot['CI_scrap'] += $info['CI_scrap'];    
                          $tot['pig_iron'] += $info['pig_iron'];    
                          $tot['spillage'] += $info['spillage'];    
                          $tot['C'] += $info['C'];    
                          $tot['SI'] += $info['SI'];    
                          $tot['Mn'] += $info['Mn'];    
                          $tot['fe_si_mg'] += $info['fe_si_mg'];    
                          $tot['fe_sulphur'] += $info['fe_sulphur'];    
                          $tot['inoculant'] += $info['inoculant'];    
                          $tot['graphite_coke'] += $info['graphite_coke'];    
                          $tot['pyrometer_tip'] += $info['pyrometer_tip'];    
                          $tot['S'] += $info['S'];    
                          $tot['Cr'] += $info['Cr'];    
                          $tot['Cu'] += $info['Cu'];    
                          $tot['ni'] += $info['ni'];    
                          $tot['mo'] += $info['mo'];    
                          $tot['m_consumpt'] += $info['m_consumpt'];    
                          $tot['pouring_box'] += $info['pouring_box'];    
                          $tot['liq_metal'] += $info['liq_metal'];    
                          $tot['unit_per_ton'] += $info['unit_per_ton'];    
                          $tot['melt_loss'] += $info['melt_loss'];    
                           
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td class="text-left"><?php echo date('d-m-Y', strtotime($info['melting_date'],2)); ?></td> 
                            <td class="text-right"><?php echo $info['heat_code'] . $info['days_heat_no'];?></td> 
                            <td class="text-right"><?php echo date('H:i', strtotime($info['furnace'])) ;?></td> 
                            <td class="text-right"><?php echo date('H:i', strtotime($info['pouring_time']));?></td> 
                            <td class="text-right"><?php echo number_format($info['pouring_box'],0);?></td> 
                            <td class="text-right"><?php echo number_format($info['units'],3);?></td> 
                            <td class="text-right"><?php echo number_format($info['boring'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['ms'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['foundry_return'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['CI_scrap'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['pig_iron'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['spillage'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['C'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['SI'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['Mn'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['fe_si_mg'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['fe_sulphur'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['inoculant'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['graphite_coke'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['pyrometer_tip'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['S'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['Cr'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['Cu'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['ni'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['mo'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['m_consumpt'],3);?></td>  
                            <td class="text-right"><?php echo number_format($info['liq_metal'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['unit_per_ton'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['melt_loss'],2);?></td>  
                        </tr>
                        <?php } ?> 
                        <tr>
                            <th class="text-right" colspan="5">Total</th>
                            <th class="text-right"><?php echo number_format($tot['pouring_box'],0);?></td> 
                            <th class="text-right"><?php echo number_format($tot['units'],3);?></td> 
                            <th class="text-right"><?php echo number_format($tot['boring'],2);?></td>  
                            <th class="text-right"><?php echo number_format($tot['ms'],2);?></td>  
                            <th class="text-right"><?php echo number_format($tot['foundry_return'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['CI_scrap'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['pig_iron'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['spillage'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['C'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['SI'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['Mn'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['fe_si_mg'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['fe_sulphur'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['inoculant'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['graphite_coke'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['pyrometer_tip'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['S'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['Cr'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['Cu'],3);?></th>  
                            <th class="text-right"><?php echo number_format($tot['ni'],3);?></th>  
                            <th class="text-right"><?php echo number_format($tot['mo'],3);?></th>  
                            <th class="text-right"><?php echo number_format($tot['m_consumpt'],3);?></th>  
                            <th class="text-right"><?php echo number_format($tot['liq_metal'],3);?></th>  
                            <th class="text-right"><?php echo number_format($tot['unit_per_ton'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['melt_loss'],2);?></th>  
                        </tr> 
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
