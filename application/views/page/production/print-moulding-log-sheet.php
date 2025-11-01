 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP Molding Logsheet</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="<?php echo base_url() ?>asset/bower_components/jquery/dist/jquery.min.js"></script>
  <!--<script src="<?php echo base_url() ?>asset/bower_components/jquery.excelexportjs.js"></script>-->
  <script src="<?php echo base_url() ?>asset/bower_components/excelexport.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    @media print{
       .noprint{
           display:none;
       }
       
        body {
          overflow-y: hidden; /* Hide vertical scrollbar */
          overflow-x: hidden; /* Hide horizontal scrollbar */
        }
    }
    i{font-size: 12px;}
    #sts tr {border: 1px solid black;}
  </style>  
<script>
jQuery(function($) {  
 
 
 /*$(".btnexp1").click(function(){
    
   
   //alert($(this).attr('id'));
   $("#mtc").excelexportjs({
                containerid: "mtc"
               , datatype: 'table'
               , worksheetName: 'MJP Test Cerificate'
   });
   
 }); */
 
    $(".btnexp").click(function() {    
    
    var ee = excelExport("content-table").parseToCSV().parseToXLS('MJP Test Cerificate'); 
		location.href = ee.getXLSDataURI();
	});

});
</script> 
</head>
<body onload="window.print();" style="font-size: 11px;">
<?php 
 /*echo "<pre>";
print_r($record_list); 
echo "</pre>"; */
?>
<div class="wrapper1">
  <!-- Main content -->
  <section class="invoice">
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12" id="mtc">
            <table class="table table-condensed table-bordered " id="content-table"> 
                <tr>
                    <td colspan="2" align="center" style="border: 1px solid black;"><h1>MJP</h1></td>
                    <td colspan="2" align="center" style="border: 1px solid black;">
                       <h3><strong>Molding Logsheet</strong></h3>                         
                    </td>
                    <td colspan="2" align="left" style="border: 1px solid black;padding: 4px;font-weight: bold;">
                        <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                       
                    </td>
                </tr>
                
                 <tr>
                    <td colspan="6" style="border: 1px solid black;padding: 10px;">
                        <div class="row"> 
                             <div class="form-group col-sm-3">
                                <label for="core_plan_date"><ins>Date</ins> : </label> <br />
                                <label><strong><?php echo date('d-m-Y', strtotime( $record_list['planning_date']));?></strong> </label>                                   
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Shift</ins> : </label><br />
                                <label><strong><?php echo $record_list['shift']?></strong> </label>                                              
                             </div> 
                              <div class="form-group col-sm-3">
                                <label for="customer_id"><ins>Customer</ins> : </label> <br />
                                <label><strong><?php echo $record_list['customer']?></strong> </label>    
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Item Name</ins> : </label> <br />
                                <label><strong><?php echo $record_list['pattern_item']?></strong> </label>                                               
                             </div> 
                         </div> 
                      
                         <div class="row">  
                             <div class="form-group col-sm-3">
                                <label><ins>Production Date From</ins> : </label> <br />
                                <label><strong><?php echo date('d-m-Y', strtotime( $record_list['pattern_prod_from_datetime']));?></strong> </label>                                                  
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Production From Time </ins> <em>[24 Hrs]</em> : </label> <br />
                                <label><strong><?php echo  date('H:i', strtotime($record_list['pattern_prod_from_time']));?></strong> </label>                                               
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Production Date To</ins>: </label> <br />
                                <label><strong><?php echo  date('d-m-Y', strtotime($record_list['pattern_prod_to_datetime']));?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Production From Time</ins> <em>[24 Hrs]</em>: </label> <br />
                                <label><strong><?php echo date('H:i', strtotime($record_list['pattern_prod_to_time'])); ?></strong> </label>                                           
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-sm-3">
                                <label><ins>Breakdown Time From</ins> <em>[24 Hrs]</em> : </label> <br />
                                <label><strong><?php echo date('H:i', strtotime($record_list['breakdown_from_time']));?></strong> </label>                                           
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Breakdown Time To</ins> <em>[24 Hrs]</em> : </label> <br />
                                <label><strong><?php echo date('H:i', strtotime($record_list['breakdown_to_time']));?></strong> </label>                                                
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>HRDS Top</ins>: </label> <br />
                                <label><strong><?php echo $record_list['moulding_hrd_top']?></strong> </label>                                            
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>HRDS Bottom</ins>: </label> <br />
                                <label><strong><?php echo $record_list['moulding_hrd_bottom']?></strong> </label>                                             
                             </div> 
                         </div> 
                         <div class="row">
                            
                             <div class="form-group col-sm-3">
                                <label><ins>Produced Box</ins>: </label> <br />
                                <label><strong><?php echo $record_list['produced_box']?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Closed Mould Qty</ins> <em>[10-14%]</em>: </label> <br />
                                <label><strong><?php echo $record_list['closed_mould_qty']?></strong> </label>                                             
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Pattern Condition</ins> <em>( Loose mounting / Bush )</em> : </label> <br />
                                <label><strong><?php echo ($record_list['chk_pattern_condition']== '1' ?  'Ok' : 'Not Ok')?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Logo & Idenfication Marks</ins> : </label> <br />
                                <label><strong><?php echo ($record_list['chk_logo_identify'] ?  'Ok' : 'Not Ok')?></strong> </label>                                               
                             </div>
                         </div>  
                         <div class="row"> 
                             <div class="form-group col-sm-3">
                                <label><ins>Gating System Idenfication</ins> : </label> <br />
                                <label><strong><?php echo ($record_list['chk_gating_sys_identify'] ?  'Ok' : 'Not Ok')?></strong> </label>                                             
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Mold Closing Status</ins> : </label> <br />
                                <label><strong><?php echo ($record_list['chk_mold_closing_status'] ?  'Ok' : 'Not Ok')?></strong> </label>                                               
                             </div> 
                            
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-sm-6">
                                <label><ins>Modification Details in Pattern</ins> : </label> <br />
                                <label><strong><?php echo $record_list['modification_details']?></strong> </label>                                               
                             </div> 
                             <div class="form-group col-sm-6">
                                <label><ins>Remarks</ins> : </label> <br />
                                <label><strong><?php echo $record_list['remarks']?></strong> </label>                                        
                             </div>     
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-sm-3">
                                <label><ins>Bottom Moulding Machine Operator</ins> : </label> <br />
                                <label><strong><?php echo $record_list['bottom_moulding_machine_operator']?></strong> </label>                                             
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Top Moulding Machine Operator</ins> : </label> <br />
                                <label><strong><?php echo $record_list['top_moulding_machine_operator']?></strong> </label>                                               
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Core Setter Name</ins> : </label> <br />
                                <label><strong><?php echo $record_list['core_setter_name']?></strong> </label>                                               
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Mould Closer Name</ins> : </label> <br />
                                <label><strong><?php echo $record_list['mould_closer_name']?></strong> </label>                                        
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Supervisor</ins> : </label> <br />
                                <label><strong><?php echo $record_list['supervisor']?></strong> </label>                                        
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Additional Operators</ins> : </label> <br />
                                <label><strong><?php echo $record_list['addt_other_operators']?></strong> </label>                                        
                             </div>
                             
                         </div> 
                    
                    </td>
                 </tr>
                 
                <tr> 
                    <td valign="bottom" style="height: 70px;border: 1px solid black;"  align="center" colspan="2"><strong>Prepared By</strong></td>
                    <td valign="bottom" align="center" style="border: 1px solid black;" colspan="2"><strong>Approved By</strong></td> 
                    <td colspan="2" style=" border: 1px solid black;vertical-align: left;font-weight: bold;" align="left" >
                        <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                        
                    </td>
                </tr>
                 
            </table>
        </div>
    </div>
     

     
    <div class="row text-center noprint">
        <div class="col-sm-12">
            <a href="<?php echo site_url('moulding-heatcode-log')?>" class="btn btn-info" >Back to Moulding Log Sheet Entry </a> 
        </div>
         
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
