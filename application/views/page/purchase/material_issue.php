<?php  include_once(VIEWPATH . '/inc/header.php'); 
/*echo "<pre>";
print_r($molding_item_list);
echo "</pre>"; */

?>
<style>
#content-table {font-size: 12px; background-color: white;}
#content-table th {border:1px solid black;}
#content-table td {border:1px solid black;}
</style>
 <section class="content-header">
  <h1>MATERIAL ISSUE SLIP</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Purchase</a></li>  
    <li class="active">Material Issue Slip</li>
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
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date) ;?>">
                    </div>
                </div> 
                <div class="form-group col-md-3">
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date) ;?>">
                    </div>
                </div>  
                <div class="form-group col-md-6 text-left">
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
                                <td align="center" style="border: 1px solid black;">
                                    <h3><strong>MATERIAL ISSUE SLIP</strong> </h3> 
                                </td>
                                <td colspan="2" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                                   <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                                   
                                </td>
                            </tr>  
                            
                            <tr> 
                                <th class="text-center">Date</th> 
                                <th class="text-center">SL.NO</th>
                                <th class="text-center">ITEM DESCRIPTION</th>
                                <th class="text-center">REQ.QTY</th> 
                                <th class="text-center">ISSUED QTY</th> 
                            </tr>
                            </thead> 
                                <tr>
                                    <th colspan="5">Molding</th>
                                </tr>
                                <?php foreach($molding_item_list as $date => $info) { ?>
                                
                                <?php foreach($info as $i => $rec) { ?>
                                    <tr>
                                        <?php if($i==0) { ?>  
                                        <td rowspan="<?php echo count($info)?>" class="text-center"><?php echo date('d-m-Y' , strtotime($date)); ?></td>
                                        <?php } ?> 
                                        <td class="text-right"><?php echo ($i+1); ?></td> 
                                        <td><?php echo $item_label[$rec['item']]; ?></td>  
                                        <td class="text-right"><?php echo number_format($rec['qty'],2); ?></td>           
                                        <td class="text-right"><?php echo number_format($rec['qty'],2); ?></td>           
                                    </tr>
                                <?php } ?> 
                                <?php } ?> 
                                <tr>
                                    <th colspan="5">Melting</th>
                                </tr>
                                <?php foreach($melting_item_list as $date => $info) { ?>
                                
                                <?php foreach($info as $i => $rec) { ?>
                                    <tr>
                                        <?php if($i==0) { ?>  
                                        <td rowspan="<?php echo count($info)?>" class="text-center"><?php echo date('d-m-Y' , strtotime($date)); ?></td>
                                        <?php } ?> 
                                        <td class="text-right"><?php echo ($i+1); ?></td> 
                                        <td><?php echo $item_label[$rec['item']]; ?></td> 
                                        <td class="text-right"><?php echo number_format($rec['qty'],2); ?></td>           
                                        <td class="text-right"><?php echo number_format($rec['qty'],2); ?></td>           
                                    </tr>
                                <?php } ?> 
                                <?php } ?> 
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="center" style="border: 1px solid black;"></td>
                                         
                                        <td colspan="2" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
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
