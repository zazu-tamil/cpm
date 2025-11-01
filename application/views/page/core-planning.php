<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Core Planning - Daily</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Core Shop</a></li> 
    <li class="active">Core Planning</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
  <form method="post" action=""> 
  <div class="box box-success">
    <div class="box-header with-border">
       <b>Core Planning Item List</b>
    </div>
    <div class="box-body table-responsive"> 
       <table class="table table-hover table-bordered table-striped table-responsive text-center">
        <thead> 
            <tr>
                <th colspan="4"></th>
                <th colspan="2" class="text-center">Core Required</th>
                <th colspan="2" class="text-center">Core Available</th>
                <th colspan="3" class="text-center">Balance to Produce </th>
                <th colspan="2" class="text-center">Core Plan</th>

            </tr>    
            <tr>
                <th>#</th>   
                <th>Customer</th>  
                <th>Match Plate No </th>  
                <th>Pattern Item</th>  
                <th>Qty</th> 
                <th>Box</th> 
                <th>Qty</th> 
                <th>Box</th> 
                <th>Qty</th> 
                <th>Box</th>  
                <th>Wt</th>  
                <th class="text-center">Select</th>  
                <th class="text-center">Qty</th>  
            </tr> 
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1);?></td>   
                    <td><?php echo $ls['customer']?></td>   
                    <td><?php echo $ls['match_plate_no']?></td>  
                    <td><?php echo $ls['pattern_item']?></td>   
                    <td class="text-right"><?php echo number_format($ls['wo_core_req'],2)?></td>   
                    <td class="text-right"><?php echo number_format($ls['wo_core_req_box'],2)?></td>   
                    <td class="text-right"><?php echo number_format($ls['avail_qty'],2)?></td>   
                    <td class="text-right"><?php echo number_format($ls['avail_box'],2)?></td>   
                    <td class="text-right"><?php echo number_format($ls['bal_qty'],2)?></td>   
                    <td class="text-right"><?php echo number_format($ls['bal_box'],2)?></td>   
                    <td class="text-right"><?php echo number_format($ls['bal_wt'],2)?></td>   
                    <td class="text-center">
                        <input type="checkbox" name="pattern_id[]" value="<?php echo $ls['pattern_id']; ?>" />
                        <input type="hidden" name="customer_id[<?php echo $ls['pattern_id']; ?>]" value="<?php echo $ls['customer_id']; ?>" />
                    </td>   
                    <td class="text-center" width="10%"><input type="number" name="plan_qty[<?php echo $ls['pattern_id']; ?>]" class="form-control plan_qty pull-right"  value="" /></td>   
                                                          
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table> 
        
    </div>
    <!-- /.box-body --> 
  </div>
  <!-- /.box -->
  <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-edit"></i> Core Planning - Daily</h3>
        </div>
       <div class="box-body">  
            <div class="row"> 
                <div class="form-group col-md-3">
                    <input type="hidden" name="mode" value="Add" />
                    <label>Planning Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="core_plan_date" name="core_plan_date" value="<?php echo date('Y-m-d');?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                <div class="col-md-4"> 
                    <label for="srch_customer">Core Maker</label>
                    <?php echo form_dropdown('core_maker_id',array('' => 'Select Core Maker') + $core_maker_opt ,set_value('core_maker_id') ,' id="core_maker_id" class="form-control"');?>
                </div> 
                <div class="col-sm-3 col-md-2"> 
                    <br />
                    <button class="btn btn-info" type="submit">Save</button>
                </div>
            </div>
            
       </div> 
    </div>   
    </form>
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
