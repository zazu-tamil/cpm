<?php  include_once(VIEWPATH . '/inc/header.php');  ?>
 <section class="content-header">
  <h1>Production Review - Chart</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Chart</a></li>  
    <li class="active">Production Review </li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
<div class="box box-info noprint"> 
    <div class="box-header with-border">
      <h3 class="box-title text-white">Production Target Analysis</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Description</th>
                    <th>Target</th>
                    <?php foreach($moulding as $k => $info) {?>
                    <th class="text-right"><?php echo $info['al_month'];?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?php echo $mrm_target[1]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[1]['mrm_target_value'];?></td>
                    <?php foreach($moulding as $k => $info) {?> 
                    <td class="text-right"><?php echo number_format($info['produced_box'],2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>2</td>
                    <td><?php echo $mrm_target[2]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[2]['mrm_target_value'];?></td>
                    <?php foreach($melting as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['liquid_metal']/1000),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>3</td>
                    <td><?php echo $mrm_target[3]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[3]['mrm_target_value'];?></td>
                    <?php foreach($melting as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['poured_casting_wt']/1000),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>4</td>
                    <td><?php echo $mrm_target[4]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[4]['mrm_target_value'];?></td>
                    <?php foreach($melting as $k => $info) {?>
                    <td class="text-right"><?php echo number_format((($info['poured_casting_wt'] -  $rejection[$k]['rej_wt'])/1000),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>5</td>
                    <td><?php echo $mrm_target[5]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[5]['mrm_target_value'];?></td>
                    <?php foreach($melting as $k => $info) {?>
                    <td class="text-right"><?php echo $info['yield'];?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>6</td>
                    <td><?php echo $mrm_target[6]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[6]['mrm_target_value'];?></td>
                    <?php foreach($production as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['production_wt'] / 1000),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>7</td>
                   <td><?php echo $mrm_target[7]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[7]['mrm_target_value'];?></td>
                    <?php foreach($rejection as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['rej_wt'] /1000),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>8</td>
                    <td><?php echo $mrm_target[8]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[8]['mrm_target_value'];?></td>
                    <?php foreach($production as $k => $info) {?>
                    <td class="text-right"><?php echo number_format((($rejection[$k]['rej_wt'] * 100) / $info['production_wt']),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>9</td>
                    <td><?php echo $mrm_target[9]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[9]['mrm_target_value'];?></td>
                    <?php foreach($moulding_rej as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['rej_wt'] * 100 / $production[$k]['production_wt']),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>10</td>
                    <td><?php echo $mrm_target[10]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[10]['mrm_target_value'];?></td>
                    <?php foreach($melting_rej as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['rej_wt'] * 100 / $production[$k]['production_wt']),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>11</td>
                    <td><?php echo $mrm_target[11]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[11]['mrm_target_value'];?></td>
                    <?php foreach($fettling_rej as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['rej_wt'] * 100 / $production[$k]['production_wt']),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>12</td>
                    <td><?php echo $mrm_target[12]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[12]['mrm_target_value'];?></td>
                    <?php foreach($power as $k => $info) {?>
                    <td class="text-right"><?php echo number_format((($info['unit'] / $melting[$k]['liquid_metal']) * 1000),2);?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>13</td>
                    <td><?php echo $mrm_target[13]['mrm_target_name'];?></td> 
                    <td><?php echo $mrm_target[13]['mrm_target_value'];?></td>
                    <?php foreach($despatch as $k => $info) {?>
                    <td class="text-right"><?php echo number_format(($info['despatch_wt'] /1000),2);?></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>  
<div class="row">
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[1]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_1" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[2]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_2" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>     
      
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[3]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_3" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[4]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_4" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[5]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_5" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[6]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_6" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[7]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_7" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    
     <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[8]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_8" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[9]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_9" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[10]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_10" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    
     <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[11]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_11" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>  
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[12]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_12" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div> 
    
    
    <div class="col-md-12"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $mrm_target[13]['mrm_target_name'];?> - Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart_13" style="height:250px"></canvas>
              </div>
            </div> 
          </div> 
    </div>   
    
</div>  
</section>
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>