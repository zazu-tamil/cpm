<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($op_stock_list);
echo "</pre>"; */

?>
<style>
#content-table {font-size: 12px; background-color: white;}
#content-table th {border:1px solid black;}
#content-table td {border:1px solid black;}
</style>
 <section class="content-header">
  <h1> Incoming Material Testing Register</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Purchase</a></li>  
    <li class="active"> Incoming Material Testing Register</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date) ;?>">
                    </div>
                </div> 
                <div class="form-group col-md-2">
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date) ;?>">
                    </div>
                </div> 
                <div class="form-group col-md-6">
                    <label>Item</label> 
                    <?php echo form_dropdown('srch_item_id',array('' => 'All Item') + $itm_opt  ,set_value('srch_item_id') ,' id="srch_item_id" class="form-control" ');?> 
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
         <!--<div class="box box-success">  
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12" id="mtc">-->
                        <table class="table table-condensed table-bordered " id="content-table"> 
                            <thead>
                            <tr>
                                <td colspan="2" align="center" style="border: 1px solid black;"><h1>MJP</h1></td>
                                <td colspan="5" align="center" style="border: 1px solid black;">
                                    <h3><strong> INCOMING MATERIAL TESTING REGISTER</strong> </h3> 
                                </td>
                                <td colspan="3" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                                   <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                                     
                                </td>
                            </tr>  
                            <tr>
                                <th rowspan="2" class="text-center">SL.NO</th>
                                <th rowspan="2" class="text-center">DATE</th> 
                                <th rowspan="2" class="text-center">ITEM DESC</th>
                                <th colspan="2" class="text-center">SUPPLIER</th>   
                                <th class="text-center" rowspan="2">SUPPLIED</th>
                                <th class="text-center" rowspan="2">TEST CERTIFICATE<br />RECEIVED</th>
                                <th class="text-center" rowspan="2">ACTUAL RESULTS</th>
                                <th class="text-center" rowspan="2">ACCEPTANCE <br />CRITERIA</th>
                                <th class="text-center" rowspan="2">REMARKS</th>
                            </tr>  
                            <tr>
                                
                                <th class="text-center">NAME</th>
                                <th class="text-center">INVOICE/<br />DC NO</th>  
                            </tr>
                            </thead>
                                <?php foreach($record_list as $i => $rec) {  ?>
                                    <tr>
                                        <td class="text-right"><?php echo ($i+1); ?></td> 
                                        <td><?php echo date('d-m-Y' , strtotime($rec['inward_date'])); ?></td> 
                                        <td><?php echo $rec['item']; ?></td> 
                                        <td><?php echo $rec['supplier_name']; ?></td> 
                                        <td class="text-center"><?php echo $rec['inv_no']; ?></td>  
                                        <td class="text-right"><?php echo $rec['supplied_qty']; ?></td> 
                                        <td class="text-right"><?php echo $rec['tc_received']; ?></td> 
                                        <td class="text-right"><?php echo $rec['result']; ?></td> 
                                        <td class="text-right"><?php echo $rec['criteria']; ?></td> 
                                        <td class="text-right"><?php echo $rec['remarks']; ?></td> 
                                    </tr>
                                <?php } ?> 
                             <tfoot>
                                    <tr>
                                        <td colspan="5" align="center" style="border: 1px solid black;"></td>
                                         
                                        <td colspan="5" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                                           <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                                           
                                        </td>
                                    </tr>  
                                </tfoot>
                        </table>
                    <!--</div>
                </div>
            </div>
         </div> -->
            <?php } ?> 
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
