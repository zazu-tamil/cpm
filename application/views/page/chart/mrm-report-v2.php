<?php  include_once(VIEWPATH . '/inc/header.php');  
 
//echo "<pre>";
//print_r($mrm_target);
//print_r($actual_data);
//print_r($mrm_list);
//echo "</pre>";  
 
?>
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
      <h3 class="box-title text-white">Search Filter</h3>
    </div>
    <div class="box-body">
     <form method="post" action="" id="frmsearch">          
     <div class="row">   
         <div class="form-group col-md-3"> 
            <label>From Date</label> 
              <input type="month" class="form-control" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date');?>" required>
         </div> 
         <div class="form-group col-md-3"> 
            <label>To Date</label> 
              <input type="month" class="form-control" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date');?>" required>
         </div>
        <!-- <div class="form-group col-md-4">
            <label>MRM Option</label>
              <div class="input-group"> 
                <?php 
                //echo  urlencode($srch_opt_type) . "<br>";
               // echo form_dropdown('srch_opt_type',array('' => 'Select') + $mrm_list  ,set_value('srch_opt_type', ($srch_opt_type)) ,' id="srch_opt_type" class="form-control" ');?> 
                    
              </div>                                   
         </div>    -->
         <div class="form-group col-md-2 text-left">
            <br />
            <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Reports</button>
        </div>
        
        <div class="form-group col-md-12 ">
            <label>MRM Option</label>
            <div class="row">
                <?php foreach($mrm_list as $inf) {?>
                <div class="col-md-3 form-group">
                     
                      <div class="radio">
                        <label>
                          <input type="radio" name="srch_opt_type" id="optionsRadios1" value='<?php echo $inf ; ?>' <?php if($inf == $srch_opt_type) echo "Checked" ; ?>>
                          <strong class="text-fuchsia"><?php echo $inf ; ?></strong>
                        </label>
                      </div>
                </div>
                <?php } ?>
            </div>    
        </div>
     </div>  
    </form>
    </div> 
  </div> 
<?php
if($submit_flg) {  
   foreach($mrm_target as $grp => $det) {  
    ?>
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-line-chart"></i> Line Chart - <strong class="text-maroon"><?php echo $det['mrm_target_name'];?></strong></h3> 
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="lineChart_<?php echo $grp?>" style="height:250px"></canvas>
          </div>
        </div> 
    </div>  
    <div class="box box-info"> 
        <div class="box-header with-border">
          <h3 class="box-title text-white">Production Target Analysis  [ <strong class="text-maroon"> Period : <?php echo date('M d, Y', strtotime($det['frm_date'])) ;?></strong> to <strong class="text-maroon"><?php echo date('M d, Y', strtotime($det['to_date'])) ?> </strong> ]</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Target</th>
                        <?php foreach($det['chart_data'] as $k => $info) {?>
                        <th class="text-right"><?php echo $info['al_month'];?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                         
                        <td><?php echo $det['mrm_target_name'];?></td>
                        <td><?php echo $det['mrm_target_value'];?></td>
                        <?php foreach($det['chart_data'] as $k => $info) {?>
                        <td class="text-right"><?php echo $info['actual_value'];?></td>
                        <?php } ?>
                    </tr>
                </tbody> 
            </table>
        </div>
    </div>  

<div style="page-break-after:always;"> </div>       
<?php } ?> 

<?php } ?> 
</section>
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>