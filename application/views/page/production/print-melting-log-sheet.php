 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP Melting Logsheet</title>
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
<body onload="window.print1();" style="font-size: 11px;">
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
                       <h3><strong>Melting Logsheet</strong></h3>                         
                    </td>
                    <td colspan="2" align="left" style="border: 1px solid black;padding: 4px;font-weight: bold;">
                        <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                       
                    </td>
                </tr>
                
                 <tr>
                    <td colspan="6" style="border: 1px solid black;padding: 10px;">
                        <div class="row"> 
                             <div class="form-group col-sm-4">
                                <label for="core_plan_date"><ins>Date</ins> : </label> <br />
                                <label><strong><?php echo date('d-m-Y', strtotime( $record_list['planning_date']));?></strong> </label>                                   
                             </div> 
                             <div class="form-group col-sm-4">
                                <label><ins>Shift</ins> : </label><br />
                                <label><strong><?php echo $record_list['shift']?></strong> </label>                                              
                             </div> 
                              <div class="form-group col-sm-4">
                                <label><ins>Melting Date</ins> : </label> <br />
                                <label><strong><?php echo date('d-m-Y', strtotime( $record_list['melting_date']));?></strong> </label>    
                             </div>  
                         </div> 
                      
                         <div class="row">  
                             <div class="form-group col-sm-3">
                                <label><ins>Furnace On Time</ins> : </label> <br />
                                <label><strong><?php echo date('H:i', strtotime( $record_list['furnace_on_time']));?></strong> </label>                                                  
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>Furnace Off Time</ins> : </label> <br />
                                <label><strong><?php echo  date('H:i', strtotime($record_list['furnace_off_time']));?></strong> </label>                                               
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Pouring Start Time</ins>: </label> <br />
                                <label><strong><?php echo  date('H:i', strtotime($record_list['pouring_start_time']));?></strong> </label>                                              
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Finish Time</ins>: </label> <br />
                                <label><strong><?php echo date('H:i', strtotime($record_list['pouring_finish_time'])); ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Ideal Hrs From</ins>: </label> <br />
                                <label><strong><?php echo date('H:i', strtotime($record_list['ideal_hrs_from'])); ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Ideal Hrs To</ins>: </label> <br />
                                <label><strong><?php echo date('H:i', strtotime($record_list['ideal_hrs_to'])); ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Lining Heat No</ins>: </label> <br />
                                <label><strong><?php echo $record_list['lining_heat_no']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Heat Code</ins>: </label> <br />
                                <label><strong><?php echo $record_list['heat_code']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Days Heat No</ins>: </label> <br />
                                <label><strong><?php echo $record_list['days_heat_no']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Tapp Temp</ins>: </label> <br />
                                <label><strong><?php echo $record_list['tapp_temp']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Ladle 1 First Box Temp</ins>: </label> <br />
                                <label><strong><?php echo $record_list['ladle_1_first_box_pour_temp']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Ladle 2 First Temp</ins>: </label> <br />
                                <label><strong><?php echo $record_list['ladle_2_first_box_pour_temp']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Start Units</ins>: </label> <br />
                                <label><strong><?php echo $record_list['start_units']; ?></strong> </label>                                           
                             </div>  
                             <div class="form-group col-sm-2">
                                <label><ins>End Units</ins>: </label> <br />
                                <label><strong><?php echo $record_list['end_units']; ?></strong> </label>                                           
                             </div>  
                         </div>
                         <hr /> 
                         <div class="row">
                            <div class="form-group col-sm-2">
                                <label><ins>Pig Iron</ins>: </label> <br />
                                <label><strong><?php echo $record_list['pig_iron']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Foundry Return</ins>: </label> <br />
                                <label><strong><?php echo $record_list['foundry_return']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>MS / LMS</ins>: </label> <br />
                                <label><strong><?php echo $record_list['ms']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Spillage</ins>: </label> <br />
                                <label><strong><?php echo $record_list['spillage']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>CI Boring</ins>: </label> <br />
                                <label><strong><?php echo $record_list['boring']; ?></strong> </label>                                           
                             </div> 
                              <div class="form-group col-sm-2">
                                <label><ins>CI Scrap</ins>: </label> <br />
                                <label><strong><?php echo $record_list['CI_scrap']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>CP C / Shell C</ins>: </label> <br />
                                <label><strong><?php echo $record_list['C']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Fe-Mn</ins>: </label> <br />
                                <label><strong><?php echo $record_list['Mn']; ?></strong> </label>                                           
                             </div>  
                             <div class="form-group col-sm-2">
                                <label><ins>Fe-Si</ins>: </label> <br />
                                <label><strong><?php echo $record_list['SI']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Inoculant</ins>: </label> <br />
                                <label><strong><?php echo $record_list['inoculant']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Fe Sulphur</ins>: </label> <br />
                                <label><strong><?php echo $record_list['fe_sulphur']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Fe-Si-Mg</ins>: </label> <br />
                                <label><strong><?php echo $record_list['fe_si_mg']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Cu</ins>: </label> <br />
                                <label><strong><?php echo $record_list['Cu']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Pyrometer Tip</ins>: </label> <br />
                                <label><strong><?php echo $record_list['pyrometer_tip']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>S</ins>: </label> <br />
                                <label><strong><?php echo $record_list['S']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Cr</ins>: </label> <br />
                                <label><strong><?php echo $record_list['Cr']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-2">
                                <label><ins>Graphite Coke</ins>: </label> <br />
                                <label><strong><?php echo $record_list['graphite_coke']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-1">
                                <label><ins>Ni</ins>: </label> <br />
                                <label><strong><?php echo $record_list['ni']; ?></strong> </label>                                           
                             </div> 
                             <div class="form-group col-sm-1">
                                <label><ins>Mo</ins>: </label> <br />
                                <label><strong><?php echo $record_list['mo']; ?></strong> </label>                                           
                             </div>  
                         </div>  
                         <hr />
                         <div class="row"> 
                             <?php foreach($record_itm_list as $k => $itms){?>
                                <div class="form-group col-sm-1">
                                    <label><ins>S.No</ins> : </label> <br />
                                    <label><strong><?php echo ($k +1)?></strong> </label>                                             
                                 </div>
                                 <div class="form-group col-sm-2">
                                    <label><ins>Customer</ins> : </label> <br />
                                    <label><strong><?php echo $itms['customer']?></strong> </label>                                             
                                 </div>
                                 <div class="form-group col-sm-3">
                                    <label><ins>Item</ins> : </label> <br />
                                    <label><strong><?php echo $itms['item']?></strong> </label>                                             
                                 </div>
                                 <div class="form-group col-sm-2">
                                    <label><ins>Poured Box</ins> : </label> <br />
                                    <label><strong><?php echo $itms['pouring_box']?></strong> </label>                                             
                                 </div>
                                 <div class="form-group col-sm-2">
                                    <label><ins>Leftout Box</ins> : </label> <br />
                                    <label><strong><?php echo $itms['leftout_box']?></strong> </label>                                             
                                 </div>
                                 <div class="form-group col-sm-2">
                                    <label><ins>Leftout Box Closed</ins> : </label> <br />
                                    <label><strong><?php echo $itms['leftout_box_close']?></strong> </label>                                             
                                 </div>
                             <?php } ?>
                            
                         </div> 
                        <hr />
                         <div class="row"> 
                             <div class="form-group col-sm-4">
                                <label><ins>Pouring Person Name - 1</ins> : </label> <br />
                                <label><strong><?php echo $record_list['pouring_person_name_1']?></strong> </label>                                             
                             </div>
                             <div class="form-group col-sm-4">
                                <label><ins>Pouring Person Name - 2</ins> : </label> <br />
                                <label><strong><?php echo $record_list['pouring_person_name_2']?></strong> </label>                                               
                             </div> 
                             <div class="form-group col-sm-4">
                                <label><ins>Pouring Person Name - 3</ins> : </label> <br />
                                <label>&nbsp;<strong><?php echo $record_list['pouring_person_name_3']?></strong> </label>                                               
                             </div> 
                             <div class="form-group col-sm-3">
                                <label><ins>FC Operator</ins> : </label> <br />
                                <label><strong><?php echo $record_list['fc_operator']?></strong> </label>                                        
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Helper Name</ins> : </label> <br />
                                <label><strong><?php echo $record_list['helper_name']?></strong> </label>                                        
                             </div>
                             <div class="form-group col-sm-3">
                                <label><ins>Supervisor</ins> : </label> <br />
                                <label><strong><?php echo $record_list['supervisor']?></strong> </label>                                        
                             </div>
                              <div class="form-group col-sm-3">
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
                        
                    </td>
                </tr>
                 
            </table>
        </div>
    </div>
     

     
    <div class="row text-center noprint">
        <div class="col-sm-12">
            <a href="<?php echo site_url('melting-log')?>" class="btn btn-info" >Back to Melting Log Sheet Entry </a> 
        </div>
         
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
