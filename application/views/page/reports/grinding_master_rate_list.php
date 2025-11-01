<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Grinding Master Rate List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Grinding Master Rate List</li>
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
                <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Reports</button>
                </div>
             </div>  
            </form>
         </div> 
         </div> 
         <?php if(($submit_flg)) { ?>         
         <div class="box box-success" > 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Grinding Master Rate List</h3> 
              <h3 class="box-title text-white pull-right">M J P Enterprises Private Limited  </h3> 
            </div>
            <div class="box-body" id="mjp">  
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th class="text-center">SNo</th>
                        <th class="text-left">Item</th> 
                        <th class="text-right">Grinding Rate</th> 
                    </tr> 
                    </thead>
                    <tbody>
                        <?php   foreach($record_list as $customer => $pattern_list) {  ?>
                        <tr>
                            <td colspan="3"><strong><?php echo $customer;?></strong></td>
                        </tr>
                        <?php   foreach($pattern_list as $j => $info) {  ?>
                        <tr>
                            <td class="text-center"><?php echo ($j+1)?></td> 
                            <td class="text-left"><?php echo $info['pattern_item']?></td> 
                            <td class="text-right"><?php echo number_format($info['grinding_rate'],2);?></td> 
                             
                        </tr>
                        <?php } ?>
                        <?php } ?> 
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
             <div class="box-footer">
                <button class="btn btn-info btnexp" id="MJP Grinding Rate Master" >Export To Excel File</button>
             </div>
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
