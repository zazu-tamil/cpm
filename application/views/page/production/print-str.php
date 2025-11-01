 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP STR</title>
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
                       <h3><strong>System Sand Test Register</strong></h3>                         
                    </td>
                    <td colspan="2" align="left" style="border: 1px solid black;padding: 4px;font-weight: bold;">
                        <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                        <!--<table class="table no-border " style="border: 0px;height: 100%;">
                            <tr><td class="col-md-12">Document: Level 4</td></tr> 
                            <tr><td class="col-md-12">Doc Ref No: MJP/FT/QA/002</td></tr> 
                            <tr><td class="col-md-12">Issue Date : 01/09/19</td></tr> 
                            <tr><td class="col-md-12">Page No: 1 of 1</td></tr> 
                        </table>-->
                    </td>
                </tr>
                
                 <tr>
                    <td colspan="6" style="border: 1px solid black;padding: 10px;">
                        <div class="row"> 
                             <div class="form-group col-sm-6">
                                <label for="core_plan_date"><ins>Date</ins> : </label> <br />
                                <label><strong><?php echo date('d-m-Y', strtotime( $record_list['planning_date']));?></strong> </label>                                   
                             </div> 
                             <div class="form-group col-sm-6">
                                <label><ins>Shift</ins> : </label><br />
                                <label><strong><?php echo $record_list['shift']?></strong> </label>                                              
                             </div> 
                         </div> 
                         <div class="row"> 
                             <div class="form-group col-sm-6">
                                <label for="customer_id"><ins>Customer</ins> : </label> <br />
                                <label><strong><?php echo $record_list['customer']?></strong> </label>    
                             </div> 
                             <div class="form-group col-sm-6">
                                <label><ins>Item Name</ins> : </label> <br />
                                <label><strong><?php echo $record_list['pattern_item']?></strong> </label>                                               
                             </div> 
                         </div> 
                         <div class="row">  
                             <div class="form-group col-sm-3">
                                <label><ins>Time</ins> : </label> <br />
                                <label><strong><?php echo $record_list['test_time']?></strong> </label>                                                  
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Temp</ins> <em>[50'C Max]</em> : </label> <br />
                                <label><strong><?php echo $record_list['temp']?></strong> </label>                                               
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>COM</ins> <em>[35-50%]</em> : </label> <br />
                                <label><strong><?php echo $record_list['com']?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>MOI</ins> <em>[3-3.50% Max]</em>: </label> <br />
                                <label><strong><?php echo $record_list['moi']?></strong> </label>                                           
                             </div> 
                         </div>
                         <div class="row">
                            <div class="form-group col-sm-3">
                                <label><ins>Permeability</ins> <em>[120 Min]</em> : </label> <br />
                                <label><strong><?php echo $record_list['permeability']?></strong> </label>                                           
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Green Comp Strength</ins> <em>[0.9-1.4]</em> : </label> <br />
                                <label><strong><?php echo $record_list['green_comp_strength']?></strong> </label>                                                
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Volatile Matter</ins> <em>[3.0% Min]</em>: </label> <br />
                                <label><strong><?php echo $record_list['volatile_matter']?></strong> </label>                                            
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Loss On Ignition</ins> <em>[6.5% Max]</em> : </label> <br />
                                <label><strong><?php echo $record_list['loss_on_ignition']?></strong> </label>                                             
                             </div> 
                         </div> 
                         <div class="row">
                            
                             <div class="form-group col-sm-3">
                                <label><ins>Active Clay</ins> [7-10 %] : </label> <br />
                                <label><strong><?php echo $record_list['active_clay']?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Total Clay</ins> <em>[10-14%]</em>: </label> <br />
                                <label><strong><?php echo $record_list['total_clay']?></strong> </label>                                             
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Dead Clay</ins> <em>[5% Max]</em> : </label> <br />
                                <label><strong><?php echo $record_list['dead_clay']?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>New Sand</ins> <em>[Kg/Mix]</em> : </label> <br />
                                <label><strong><?php echo $record_list['new_sand']?></strong> </label>                                               
                             </div>
                         </div>  
                         <div class="row"> 
                             <div class="form-group col-sm-3">
                                <label><ins>Bentonite</ins><em>[Kg/Mix]</em> : </label> <br />
                                <label><strong><?php echo $record_list['bentonite']?></strong> </label>                                             
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Coal Dust</ins> <em>[Kg/Mix]</em> : </label> <br />
                                <label><strong><?php echo $record_list['coal_dust']?></strong> </label>                                               
                             </div> 
                             <div class="form-group col-sm-6">
                                <label><ins>Remarks</ins> : </label> <br />
                                <label><strong><?php echo $record_list['remarks']?></strong> </label>                                        
                             </div>  
                         </div> 
                    
                    </td>
                 </tr>
                 
                <tr> 
                    <td valign="bottom" style="height: 70px;border: 1px solid black;"  align="center" colspan="2"><strong>Prepared By</strong></td>
                    <td valign="bottom" align="center" style="border: 1px solid black;" colspan="2"><strong>Approved By</strong></td> 
                    <td colspan="2" style=" border: 1px solid black;vertical-align: left;font-weight: bold;" align="left" >
                        <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                        <!--<table class="table table-condensed no-border " style="border:0px;height: 100%;">
                            <tr><td class="col-sm-12">Rev No: 00</td></tr> 
                            <tr><td class="col-sm-12">Rev Date : 10/09/2019</td></tr> 
                            <tr><td class="col-sm-12">Supersedes: 00</td></tr> 
                        </table>-->
                    </td>
                </tr>
                 
            </table>
        </div>
    </div>
     

     
    <div class="row text-center noprint">
        <div class="col-sm-12">
            <a href="<?php echo site_url('sand-test')?>" class="btn btn-info" >Back to System Sand Test Register </a> 
        </div>
         
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
