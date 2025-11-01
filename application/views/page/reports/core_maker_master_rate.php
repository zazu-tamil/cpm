<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Core Maker Master Rate</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Core Maker Master Rate</li>
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
                    <label>Core Maker</label>
                      <div class="input-group">
                        <?php echo form_dropdown('srch_core_maker_id',array('' => 'Select Core Maker') + $core_maker_opt  ,set_value('srch_core_maker_id') ,' id="srch_core_maker_id" class="form-control" required="true"');?> 
                            
                      </div>                                   
                 </div>  
                 <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Reports</button>
                 </div>
                 <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success " type="submit" name="export" value="xls"><i class="fa fa-download"></i> Export Excel</button>
                 </div>
             </div>  
            </form>
         </div> 
         </div> 
         <?php if(($submit_flg)) { ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Core Maker Master Rate - <span><?php echo $core_maker_opt[$srch_core_maker_id]?></span></h3> 
            </div>
            <div class="box-body table-responsive">  
                <div class="sticky-table-demo ">    
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Core Maker</th>
                        <th>Customer</th>
                        <th>Pattern Item</th> 
                        <th>Core Item</th>  
                        <th>Rate</th>   
                    </tr> 
                    </thead>
                    <tbody>
                        <?php 
                         foreach($record_list as $j => $info) {  
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td><?php echo $info['core_maker']?></td>
                            <td><?php echo $info['customer']?></td> 
                            <td><?php echo $info['pattern_item']?></td> 
                            <td><?php echo $info['core_item_name']?></td>    
                            <td class="text-right"><?php echo number_format($info['rate'],2);?></td>  
                        </tr>
                        <?php } ?> 
                    </tbody>
                     
                </table>  
                 
                  <?php } ?>
            </div>
            </div>
            <div class="box-footer with-border ">
               <div class="form-group col-sm-12 text-left">
                    <label>Total Records : <?php echo count($record_list);?></label>
                </div> 
            </div>
            </div> 
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
