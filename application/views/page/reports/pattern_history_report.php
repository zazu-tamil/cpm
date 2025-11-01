<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Pattern History Card</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li>  
    <li class="active">Pattern History Card</li>
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
                        <?php echo form_dropdown('srch_customer_id',array('' => 'Select Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" required ');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-4">
                    <label>Pattern</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_pattern_id',array('' => 'Select Item') + $pattern_opt ,set_value('srch_pattern_id') ,' id="srch_pattern_id" class="form-control" required ');?> 
                            
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
              <h3 class="box-title text-white">Pattern History Card : <span><i> [ <?php echo date('d-m-Y', strtotime($srch_from_date))  ?> to <?php echo date('d-m-Y', strtotime($srch_to_date)) ?> ]</i></span></h3> 
            </div>
            <div class="box-body text-center">    
            <div class="sticky-table-demo">    
                <?php  if(!empty($record_list)) { ?>    
                    <table class="table table-bordered table-condensed">
                        <thead>
						<tr>
                            <th class="text-center"><h2>MJP</h2></td>
                            <th class="text-center"><h2>Pattern History Card </h2> </td>
                            <th colspan="2" class="text-right">
                               <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
								<br />
                             Page 1 of 1
							</th>
                        </tr> 
						<tr>
                            <th>Customer:</th>
                            <td><?php echo $customer_opt[$srch_customer_id];?></td>
                            <th>Item:</th>
                            <td><?php echo $pattern_opt[$srch_pattern_id];?></td>
                        </tr>
                        <tr>
                            <th>Pattern Code :</th>
                            <td><?php echo $record_list[0]['match_plate_no'];?></td>
                            <th>Type of the Core:</th>
                            <td><?php echo $record_list[0]['type_of_core'];?></td>
                        </tr>
                        <tr>
                            <th>Type of the Pattern :</th>
                            <td><?php echo $record_list[0]['pattern_type'];?></td>
                            <th>Pattern Material:</th>
                            <td><?php echo $record_list[0]['pattern_material'];?></td>
                        </tr>
                        <tr>
                            <th>Number of Core / Cavity :</th>
                            <td><?php echo $record_list[0]['no_of_core'];?></td>
                            <th>Number of Cavity:</th>
                            <td><?php echo $record_list[0]['no_of_cavity'];?></td>
                        </tr>
                        <tr>
                            <th>Number of Core / Core box :</th>
                            <td><?php echo $record_list[0]['no_of_core_per_box'];?></td>
                            <th>Core Box Material:</th>
                            <td><?php echo $record_list[0]['corebox_material'];?></td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">Frequency of Checking: Six Months Once/ after 15000 moulds once</th>
                        </tr>
						</thead>
                    </table>
                    <table class="table table-bordered table-condensed">
                    <thead>
                    <tr class="bg-green-gradient"> 
                        <th>#</th> 
                        <th>Date</th> 
                        <th class="text-center">Produced Moulds</th>  
                        <th class="text-center">Cumulative Moulds</th>  
                        <th class="text-center">Pattern Modification Details <br />(If Problem Raised)</th> 
                        <th class="text-center">Remarks</th>  
                    </tr> 
                      
                    </thead>
                    <tbody>
                        <?php  
                         $k = 1; 
                         $cum['poured_box'] = 0; 
                         $tot1['poured_box'] = 0; 
                       
                        ?>
                            
                            <?php  
                             //$tot['qty'] = $tot['amt'] = 0;
                            foreach($record_list as $j => $info) {     
                                $tot1['poured_box'] += $info['poured_box']; 
                                 
                                 $cum['poured_box'] += $info['poured_box']; 
                               
                            ?>
                            <tr>
                                <td><?php echo ($k++); ?></td>      
                                <td class="text-left"><?php echo date('d-m-Y', strtotime($info['p_date'])); ?></td>      
                                <td class="text-right"><?php echo number_format($info['poured_box'],0);?></td>
                                <td class="text-right"><?php echo number_format($cum['poured_box'],0);?></td> 
                                <td class="text-left"><?php if($info['mod_state'] != '1' ) echo $info['modification_details'];?></td>   
                                <td></td>      
                            </tr>
                            <?php 
                            if($info['mod_state'] != '1') $cum['poured_box'] = 0;
                             /*if($info['mod_state'] == '1')
                                   $cum['poured_box'] += $info['poured_box'];
                                else     
                                   $cum['poured_box'] = $info['poured_box'];*/
                            } ?>
                            
                        
                             
                    </tbody>
                    <tfoot>
                        <tr>
                             <th colspan="2">Prepared by</th>
                             <th colspan="2">Approved by/Date</th>
                             <th colspan="2" class="text-right">
                                 <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                             </th>
                        </tr>  	             
                    </tfoot>
                    </table>
                  <?php } ?>
            </div>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
