<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Customer Wise Melting Master List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Customer Wise Melting Master List</li>
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
              <h3 class="box-title text-white">Customer Wise Melting Master List</h3> 
              <h3 class="box-title text-white pull-right">M J P Enterprises Private Limited  </h3> 
            </div>
            <div class="box-body table-responsive">  
                <div class="sticky-table-demo">    
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped table-responsive table-condensed">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th class="text-center">SNo</th>
                        <th class="text-left">Item</th> 
                        <th class="text-left">Grade</th> 
                        <th class="text-right">No of Cavity</th> 
                        <th class="text-right">Pieces Weight</th> 
                        <th>C%</th>
                        <th>Si%</th>
                        <th>Mn%</th>
                        <th>P%</th>
                        <th>S%</th>
                        <th>Cr%</th>
                        <th>Cu%</th>
                        <th>Mg%</th>
                        <th>BHN</th>   
                        <th>Tensile</th>   
                        <th>Elongation</th>   
                        <th>Yeild Strength</th>   
                        <th>Poring Temp</th>   
                        <th>Inoculant</th>   
                        <th>Knock Out Time</th>   
                        <th>Charge Mix</th>   
                        <th width="15%">Remarks</th>   
                    </tr> 
                    </thead>
                    <tbody>
                        <?php   foreach($record_list as $customer => $pattern_list) {  ?>
                        <tr>
                            <th colspan="18"><?php echo $customer;?></th>
                        </tr>
                        <?php   foreach($pattern_list as $j => $info) {  ?>
                        <tr>
                            <td class="text-center"><?php echo ($j+1)?></td> 
                            <td class="text-left"><?php echo $info['pattern_item']?></td> 
                            <td class="text-right"><?php echo $info['grade']?></td>  
                            <td class="text-right"><?php echo $info['no_of_cavity']?></td>  
                            <td class="text-right"><?php echo number_format($info['piece_weight_per_kg'],3);?></td> 
                            <td class="text-center"><?php echo $info['C']?></td> 
                            <td class="text-center"><?php echo $info['SI']?></td> 
                            <td class="text-center"><?php echo $info['Mn']?></td> 
                            <td class="text-center"><?php echo $info['P']?></td> 
                            <td class="text-center"><?php echo $info['S']?></td> 
                            <td class="text-center"><?php echo $info['Cr']?></td> 
                            <td class="text-center"><?php echo $info['Cu']?></td> 
                            <td class="text-center"><?php echo $info['Mg']?></td> 
                            <td class="text-center"><?php echo $info['BHN']?></td> 
                            <td class="text-center"><?php echo $info['tensile']?></td> 
                            <td class="text-center"><?php echo $info['elongation']?></td> 
                            <td class="text-center"><?php echo $info['yeild_strength']?></td> 
                            <td class="text-center"><?php echo $info['poring_temp']?></td>
                            <td class="text-center"><?php echo $info['inoculant_percentage']?></td>
                            <td class="text-center"><?php echo $info['knock_out_time']?></td>
                            <td class="text-center"><?php echo $info['charge_mix']?></td>
                            <td class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                             
                        </tr>
                        <?php } ?>
                        <?php } ?> 
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
