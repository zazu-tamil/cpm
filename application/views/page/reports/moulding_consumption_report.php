<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Moulding Consumption Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Material Consumption Report</a></li> 
    <li class="active">Moulding Consumption Report</li>
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
         <?php if(($submit_flg)) { ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Moulding Material Consumption Report : <span><i> [ <?php echo date('d-m-Y',strtotime($srch_from_date))  ?> to <?php echo date('d-m-Y',strtotime($srch_to_date)) ?> ]</i></span></h3> 
            </div>
            <div class="box-body table-responsive">  
                 <div class="sticky-table-demo">  
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Date</th>  
                        <th>Bentonite</th>    
                        <th>Bentokol</th>    
                    </tr> 
                     
                    </thead>
                    <tbody>
                        <?php 
                            $tot['new_sand'] =$tot['green_sand'] =$tot['water'] =$tot['bentonite'] =$tot['bentokol']   = 0; 
                        foreach($record_list as $j => $info) { 
                          
                          $tot['bentonite'] += $info['bentonite'];    
                          $tot['bentokol'] += $info['bentokol'];    
                           
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td class="text-left"><?php echo date('d-m-Y', strtotime($info['moulding_date'],2)); ?></td> 
                            
                            <td class="text-right"><?php echo number_format($info['bentonite'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['bentokol'],2);?></td>  
                        </tr>
                        <?php } ?> 
                        <tr>
                            <th class="text-right" colspan="2">Total</th> 
                            <th class="text-right"><?php echo number_format($tot['bentonite'],2);?></th>  
                            <th class="text-right"><?php echo number_format($tot['bentokol'],2);?></th> 
                        </tr> 
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
