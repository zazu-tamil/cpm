<?php  include_once(VIEWPATH . '/inc/header.php');  ?>
 <section class="content-header">
  <h1>Internal Rejection - Chart</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Chart</a></li>  
    <li class="active">Internal Rejection </li>
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
                      <div class="input-group">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'All Pattern') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
             </div>  
             <div class="row">
                <div class="form-group col-md-2">
                    <label>Department</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_grp',array('' => 'All Department') + $rejection_grp_opt ,set_value('srch_rej_grp') ,' id="srch_rej_grp" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-3">
                    <label>Rejection Type</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_rej_type_id',array('' => 'All Rejection Type') + $rejection_typ_opt  ,set_value('srch_rej_type_id') ,' id="srch_rej_type_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div> 
                <!-- <div class="form-group col-md-3">
                    <label>Rejection % More Than</label>
                      <div class="input-group">
                         <input type="number" name="srch_more_than" class="form-control" step="any" value="<?php echo set_value('srch_more_than',$srch_more_than)?>"  />    
                      </div>                                   
                </div>--> 
				<div class="form-group col-md-2">
				<label>Shift</label>
				  <div class="input-group">
					<?php echo form_dropdown('srch_shift',$shift_opt ,set_value('srch_shift' , $srch_shift) ,' id="srch_shift" class="form-control" ');?> 
						
				  </div>                                   
				</div> 				 
                <div class="form-group col-md-2 text-left">
                    <br />
                   <button class="btn btn-success" name="btn_show" value="Show Chart'"><i class="fa fa-pie-chart"></i> Show Chart</button>
                </div>
             </div>
            </form>
         </div> 
    </div>  
            <?php
	           if(!empty($record_list)){
            ?>
            <div class="box box-success">
              <div class="box-header with-border"><h3 class="box-title">Total Production Vs Rejection</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
              </div> 
              <div class="box-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="box box-info">
                            <div class="box-header with-border text-left">
                              <i class="fa fa-bar-chart-o"></i> 
                              <h3 class="box-title">Chart</h3> 
                            </div>
                            <div class="box-body">
                               <canvas id="pieChart_tot" style="height:300px"></canvas>
                            </div> 
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                              <i class="fa fa-bar-chart-o"></i> 
                              <h3 class="box-title">DataSheet</h3> 
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                      <tr>  
                                        <th class="text-right">Produced Weight</th>
                                        <th class="text-right">Rejection Weight</th>
                                        <th class="text-right">Rejection %</th>   
                                      </tr>                                   
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><?php echo $tot_prod_wt; ?></td>
                                            <td class="text-right"><?php echo $tot_rej_wt; ?></td>
                                            <td class="text-right"><?php echo round(($tot_rej_wt * 100 /$tot_prod_wt ),2); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr />
                                <table class="table table-bordered table-striped">
                                    <thead>
                                      <tr>  
                                        <th class="text-right">Produced Qty</th>
                                        <th class="text-right">Rejection Qty</th>
                                        <th class="text-right">Rejection %</th>   
                                      </tr>                                   
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><?php echo $tot_prod_qty; ?></td>
                                            <td class="text-right"><?php echo $tot_rej_qty; ?></td>
                                            <td class="text-right"><?php echo round(($tot_rej_qty * 100 /$tot_prod_qty ),2); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                          </div>
                    </div> 
                 </div> 
                </div> 
             </div> 
             
             
             <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h3 class="box-title"> Department Wise Rejection Based on Qty</h3> 
                        </div>
                        <div class="box-body">
                           <canvas id="pieChart_grp" style="height:300px"></canvas>
                        </div> 
                      </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h3 class="box-title">Department Wise Rejection Based on Qty DataSheet</h3> 
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>  
                                    <th class="text-right">Rejection Dept</th>
                                    <th class="text-right">Prod.Qty</th>
                                    <th class="text-right">Rej.Qty</th>
                                    <th class="text-right">Rejection %</th>   
                                  </tr>                                   
                                </thead>
                                <tbody>
                                   <?php $j=0; foreach($rej_group as $grp => $info) { ?>
                                    <tr>
                                        <td class="text-right"><?php echo $grp; ?></td>
                                        <td class="text-right"><?php if($j==0) echo $tot_prod_qty; else echo " "; ?></td>
                                        <td class="text-right"><?php echo array_sum($info['qty']); ?></td>
                                        <td class="text-right"><?php echo round((array_sum($info['qty']) * 100 / $tot_prod_qty ),2); ?></td>
                                    </tr>
                                    <?php $j++; } ?>
                                </tbody>
                            </table>
                        </div> 
                      </div>
                </div> 
             </div>
             <div class="row"> 
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h3 class="box-title"> Department Wise Rejection Based on Weight</h3> 
                        </div>
                        <div class="box-body">
                           <canvas id="pieChart_grp_wt" style="height:300px"></canvas>
                        </div> 
                      </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h3 class="box-title">Department Wise Rejection Based on Weight DataSheet</h3> 
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>  
                                    <th class="text-right">Rejection Dept</th>
                                    <th class="text-right">Prod.Weight</th>
                                    <th class="text-right">Rej.Weight</th>
                                    <th class="text-right">Rejection %</th>   
                                  </tr>                                   
                                </thead>
                                <tbody>
                                   <?php $j=0; foreach($rej_group as $grp => $info) { ?>
                                    <tr>
                                        <td class="text-right"><?php echo $grp; ?></td>
                                        <td class="text-right"><?php if($j==0) echo $tot_prod_wt; else echo " "; ?></td>
                                        <td class="text-right"><?php echo array_sum($info['wt']); ?></td>
                                        <td class="text-right"><?php echo round((array_sum($info['wt']) * 100 /$tot_prod_wt ),2); ?></td>
                                    </tr>
                                    <?php $j++; } ?>
                                </tbody>
                            </table>
                        </div> 
                      </div>
                </div> 
             </div>
             <?php foreach($rej_type_group as $grp => $info) { ?>
             <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h4 class="box-title"><?php echo $grp; ?> Dept Rejection Type Wise Rejection Based On Qty</h4> 
                        </div>
                        <div class="box-body">
                           <canvas id="pieChart_<?php echo $grp; ?>" style="height:300px"></canvas>
                        </div> 
                      </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h4 class="box-title"><?php echo $grp; ?> Dept Rejection Type Wise Rejection Based On Qty - DataSheet</h4> 
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>  
                                    <th class="text-right">Rejection Type</th>
                                    <th class="text-right">Prod.Qty</th>
                                    <th class="text-right">Rej.Qty</th>
                                    <th class="text-right">Rejection %</th>   
                                  </tr>                                   
                                </thead>
                                <tbody>
                                   <?php $j=0;foreach($info as $typ => $info1) { ?>
                                    <tr>
                                        <td class="text-right"><?php echo $typ; ?></td>
                                        <td class="text-right"><?php if($j==0) echo $tot_prod_qty; else echo " "; ?></td>
                                        <td class="text-right"><?php echo array_sum($info1['qty']); ?></td>
                                        <td class="text-right"><?php echo round((array_sum($info1['qty']) * 100 / $tot_prod_qty ),2); ?></td>
                                    </tr>
                                    <?php $j++; } ?>
                                </tbody>
                            </table>
                        </div> 
                      </div>
                </div> 
             </div>
             <?php } ?>
             
             <?php foreach($rej_type_group as $grp => $info) { ?>
             <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h4 class="box-title"><?php echo $grp; ?> Dept Rejection Type Wise Rejection Based On Weight</h4> 
                        </div>
                        <div class="box-body">
                           <canvas id="pieChart_wt_<?php echo $grp; ?>" style="height:300px"></canvas>
                        </div> 
                      </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <i class="fa fa-bar-chart-o"></i> 
                          <h4 class="box-title"><?php echo $grp; ?> Dept Rejection Type Wise Rejection Based On Weight - DataSheet</h4> 
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>  
                                    <th class="text-right">Rejection Type</th>
                                    <th class="text-right">Prod.Weight</th>
                                    <th class="text-right">Rej.Weight</th>
                                    <th class="text-right">Rejection %</th>   
                                  </tr>                                   
                                </thead>
                                <tbody>
                                   <?php $j=0;foreach($info as $typ => $info1) { ?>
                                    <tr>
                                        <td class="text-right"><?php echo $typ; ?></td>
                                        <td class="text-right"><?php if($j==0) echo $tot_prod_wt; else echo " "; ?></td>
                                        <td class="text-right"><?php echo array_sum($info1['wt']); ?></td>
                                        <td class="text-right"><?php echo round((array_sum($info1['wt']) * 100 / $tot_prod_wt ),2); ?></td>
                                    </tr>
                                    <?php $j++; } ?>
                                </tbody>
                            </table>
                        </div> 
                      </div>
                </div> 
             </div>
             <?php } ?>
             
            <div class="row">
                <div class="col-md-6">
                     <div class="box box-success">
                        <div class="box-header with-border">
                          <h3 class="box-title">Items Wise Rejection Based on Weight - Chart</h3>  
                        </div>
                        <div class="box-body">
                          <canvas id="pieChart" style="height:250px"></canvas>
                        </div> 
                      </div>
                </div>
                <div class="col-md-6"> 
                         <div class="box box-success">
                            <div class="box-header with-border">
                              <h3 class="box-title">Items Wise Rejection - Datasheet</h3>  
                            </div>
                            <div class="box-body">
                               <table class="table table-bordered table-striped">
                               <thead>
                                <th>#</th>
                                <th>Item</th> 
                                <th>Prod.Wt</th> 
                                <th>Rej.Wt</th>
                                <th>Rej.%</th>
                               </thead>
                                <?php $tot = array(); $tot['prod_wt'] = $tot['rej_wt']= 0;
                                foreach($record_list as $j => $info) {  
                                    $tot['prod_wt'] += $info['prod_wt'];
                                    $tot['rej_wt'] += $info['rej_wt'];
                                ?>
                                <tr>
                                    <td><?php echo ($j+1); ?></td>
                                    <td><?php echo $info['item']; ?></td> 
                                    <td class="text-right"><?php echo $info['prod_wt']; ?></td> 
                                    <td class="text-right"><?php echo $info['rej_wt']; ?></td>
                                    <td class="text-right"><?php echo number_format(($info['rej_wt'] / $info['prod_wt'] * 100),2); ?></td>
                                </tr>
                                <?php } ?>
                                <tfoot>
                                    <th colspan="2" class="text-right">Total</th>
                                    <th class="text-right"><?php echo number_format($tot['prod_wt'], 3); ?></th>
                                    <th class="text-right"><?php echo number_format($tot['rej_wt'], 3); ?></th>
                                    <th class="text-right"><?php echo number_format(($tot['rej_wt'] / $tot['prod_wt'] * 100), 2); ?></th>
                                    
                                </tfoot>
                               </table>
                            </div>  
                    </div>
                </div>
             </div>
             
             <div class="row">
                <div class="col-md-6">
                     <div class="box box-success">
                        <div class="box-header with-border">
                          <h3 class="box-title">Items Wise Rejection Based on Qty - Chart</h3>  
                        </div>
                        <div class="box-body">
                          <canvas id="pieChart_qty" style="height:250px"></canvas>
                        </div> 
                      </div>
                </div>
                <div class="col-md-6"> 
                         <div class="box box-success">
                            <div class="box-header with-border">
                              <h3 class="box-title">Items Wise Rejection - Datasheet</h3>  
                            </div>
                            <div class="box-body">
                               <table class="table table-bordered table-striped">
                               <thead>
                                <th>#</th>
                                <th>Item</th>
                                <th class="text-right">Prod.qty</th> 
                                <th class="text-right">Rej.qty</th> 
                                <th>Rej.%</th>
                               </thead>
                                <?php $tot = array(); $tot['produced_qty'] = $tot['rejection_qty'] = 0; 
                                foreach($record_list as $j => $info) { 
                                    $tot['produced_qty']+= $info['produced_qty'];
                                    $tot['rejection_qty']+= $info['rejection_qty'];
                                ?>
                                <tr>
                                    <td><?php echo ($j+1); ?></td>
                                    <td><?php echo $info['item']; ?></td>
                                    <td class="text-right"><?php echo number_format($info['produced_qty'],0); ?></td> 
                                    <td class="text-right"><?php echo number_format($info['rejection_qty'],0); ?></td> 
                                    <td class="text-right"><?php echo number_format(($info['rejection_qty'] / $info['produced_qty'] * 100),2); ?></td>
                                </tr>
                                <?php } ?>
                                <tfoot>
                                    <th colspan="2" class="text-right">Total</th>
                                    <th class="text-right"><?php echo number_format($tot['produced_qty'], 0); ?></th>
                                    <th class="text-right"><?php echo number_format($tot['rejection_qty'], 0); ?></th>
                                    <th class="text-right"><?php echo number_format(($tot['rejection_qty'] / $tot['produced_qty'] * 100), 2); ?></th>
                                </tfoot>
                               </table>
                            </div> 
                          </div> 
                </div>
             </div>
             
               <?php
	           }
            ?> 
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
