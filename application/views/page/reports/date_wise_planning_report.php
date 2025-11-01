<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 
 <section class="content-header">
  <h1>Cumulative Planning Report</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Cumulative Planning Report</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  
        <div class="box box-info"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Search Filter</h3>
            </div>
        <div class="box-body">
             <form method="post" action="" id="frmsearch">          
             <div class="row">   
                 <div class="form-group col-md-3"> 
                    <label>Month</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="month" class="form-control pull-right" id="srch_month" name="srch_month" value="<?php echo set_value('srch_month',$srch_month);?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-5">
                    <label>Customer</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_customer_id',array('' => 'All Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control"');?> 
                            
                      </div>                                   
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
         //echo "<pre>";   
         //print_r($record_list);
         //echo "</pre>";  
         ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Cumulative Planning Summary </h3> 
            </div>
            <div class="box-body table-responsive">  
            <div class="sticky-table-demo">    
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>Item</th>
                        <?php  
                        for ($j=1 ;$j<=(date('t',strtotime($srch_month)));$j++){
						 echo "<th>".$j."</th>";
						} 
                        ?> 
                        <th>Total Box</th>  
                        <th>Weight</th>  
                        <th>Total<br /> Weight</th>  
                    </tr> 
                    </thead>
                    <tbody>
                    <?php foreach($record_list as $itm => $info) {?>
                    <tr>
                        <td><?php echo $itm; ?></td>
                        <?php  $tot_qty= 0;
                        for ($j=1 ;$j<=(date('t',strtotime($srch_month)));$j++){
                          if(isset($info[str_pad($j,2,0,STR_PAD_LEFT)])) { 
						      echo "<td>".number_format($info[str_pad($j,2,0,STR_PAD_LEFT)],0)."</td>";
                              $tot_qty += $info[str_pad($j,2,0,STR_PAD_LEFT)];
                          } else {
                              echo "<td></td>";  
                          }
						} 
                        ?>
                        <td><?php echo $tot_qty; ?></td>
                        <td><?php echo $info['weight']; ?></td>
                        <td><?php echo number_format(($info['weight'] * $tot_qty),3); ?></td>
                    </tr>   
                    <?php } ?> 
                    </tbody> 
                     
                </table>  
                 
                  <?php } ?>
            </div>
            </div>
            <div class="box-footer with-border ">
               
            </div>
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
