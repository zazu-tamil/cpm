<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Melting Spec Generate</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Master Specification</a></li> 
    <li><a href="#"><i class="fa fa-book"></i> Moulding Specification</a></li> 
    <li class="active">Melting Spec Generate</li>
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
                        <?php echo form_dropdown('srch_customer_id',array('' => 'Select the Customer') + $customer_opt  ,set_value('srch_customer_id') ,' id="srch_customer_id" class="form-control" ');?> 
                            
                      </div>                                   
                 </div>  
                  
                <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Items</button>
                </div>
             </div>  
            </form>
         </div> 
         </div> 
         <?php if(($submit_flg)) { 
         //print_r($record_list);   
         ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Moulding Item Specification</h3> 
            </div>
            <div class="box-body">  
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Code</th>  
                        <th>Item</th>  
                        <th>Box Size</th>  
                        <th>Box Wt</th>  
                        <th>Core Item</th>  
                        <th>No of Cavity</th>  
                        <th>Grade</th>  
                        <th>No of Core</th>  
                        <th>Core Wt</th>  
                        <th>Type Of Core</th>  
                        <th>Remarks</th>  
                    </tr> 
                     
                    </thead>
                    <tbody>
                        <?php 
                            
                        foreach($record_list as $j => $info) {  
                           
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td> 
                            <td class="text-left"><?php echo $info['match_plate_no']?></td>   
                            <td class="text-left"><?php echo $info['pattern_item']?></td> 
                            <td class="text-left"><?php echo $info['box_size']?></td>  
                            <td class="text-left"><?php echo $info['bunch_weight']?></td>  
                            <td class="text-left"><?php echo $info['pattern_type']?></td>  
                            <td class="text-left"><?php echo $info['no_of_cavity']?></td>  
                            <td class="text-left"><?php echo $info['grade']?></td>  
                            <td class="text-left"><?php echo $info['no_of_core']?></td>  
                            <td class="text-left"><?php echo $info['core_weight']?></td>  
                            <td class="text-left"><?php echo $info['type_of_core']?></td>  
                            <td class="text-left"><?php echo $info['item_description']?></td>  
                        </tr>
                        <?php } ?> 
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
             
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
