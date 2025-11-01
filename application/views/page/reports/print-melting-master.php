<?php
/*	echo "<pre>";
    print_r($mtc_list);
	echo "</pre>"; */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP Melting Master List</title>
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
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
     table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    @media print{
       .noprint{
           display:none;
       }
       
        
    }
    i{font-size: 12px;}
    #sts tr {border: 1px solid black;}
    #itms td{border:1px solid black; text-align: center;}
    
    
    
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
 
    

});
</script> 
</head>
<body onload="window.print();" style="font-size: 11px;">
 
<div class="wrapper1">
  <!-- Main content -->
  <section class="invoice">
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12" id="mtc">
            <table class="table table-condensed table-bordered " id="content-table"> 
                <thead>
                <tr>
                    <td colspan="4" align="center" style="border: 1px solid black;"><h1>MJP</h1></td>
                    <td colspan="18" align="center" style="border: 1px solid black;">
                        <h3><strong>Melting Master List</strong> </h3> 
                    </td>
                    <td colspan="6" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                       <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                       <!-- Document Level 3 <br />
                        Doc Ref No: MJP/WD/MEL/005 <br />
                        Issue Date : 15-02-2023<br /> -->
                         
                    </td>
                </tr>  
                <tr>
                    <th colspan="28" style="border: 1px solid black;">Customer Name: <?php echo $record_list[0]['customer']?></th>
                </tr> 
                
                <tr>
                    <td rowspan="2" style="border: 1px solid black;"><strong>S.No</strong></td>
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Pattern Code</strong></td>
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Item Description</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Grade</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>No.of Cavity</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Piece<br />Wt</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Box<br />Wt</strong></td> 
                   
                    <td colspan="5" align="center" style="border: 1px solid black;"><strong>Charge Mix</strong></td>
                    <td colspan="10" align="center" style="border: 1px solid black;"><strong>Chemical Composition</strong></td>
                    
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Pour<br />temp'C</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Ino%</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>BHN</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;"><strong>K/O Time</strong></td> 
                    <td align="center" rowspan="2" style="border: 1px solid black;" width="12%"><strong>Special<br/>Instructions</strong></td>
                    <td align="center" rowspan="2" style="border: 1px solid black;" width="12%"><strong>Remarks</strong></td>
                     
                </tr>      
                        <tr>
                            <td align="center"  style="border: 1px solid black;"><strong>PI%</strong></td> 
                            <td align="center"   style="border: 1px solid black;"><strong>MS%</strong></td> 
                            <td align="center"  style="border: 1px solid black;"><strong>CI Scarp<br />%</strong></td> 
                            <td align="center"  style="border: 1px solid black;"><strong>Bor<br />%</strong></td> 
                            <td align="center" style="border: 1px solid black;"><strong>FR<br />%</strong></td> 
                            <td style="border: 1px solid black;" align="center"><strong>C(%)</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Si(%)</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Mn(%)</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>P(%)</strong></td>   
                            <td style="border: 1px solid black;" align="center"><strong>S(%)</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Cu(%)</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Mg(%)</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Cr(%)</strong></td> 
                            <td style="border: 1px solid black;" align="center"><strong>Ni(%)</strong></td> 
                            <td style="border: 1px solid black;" align="center"><strong>Mo(%)</strong></td> 
                            
                             
                        </tr> 
                   </thead>     
                    <?php foreach($record_list as $i => $rec) { ?>
                        <tr id="itms">
                            <td><?php echo ($i+1); ?></td> 
                            <td><?php echo $rec['match_plate_no']; ?></td> 
                            <td><?php echo $rec['pattern_item']; ?></td> 
                            <td><?php echo $rec['grade']; ?></td> 
                            <td><?php echo $rec['no_of_cavity']; ?></td> 
                            <td><?php echo $rec['piece_weight_per_kg']; ?></td> 
                            <td><?php echo $rec['bunch_weight']; ?></td> 
                            <td><?php echo $rec['pig_iron']; ?></td> 
                            <td><?php echo $rec['ms']; ?></td> 
                            <td><?php echo $rec['CI_scrap']; ?></td> 
                            <td><?php echo $rec['boring']; ?></td> 
                            <td><?php echo $rec['foundry_return']; ?></td> 
                            <td><?php echo $rec['C']; ?></td> 
                            <td><?php echo $rec['SI']; ?></td> 
                            <td><?php echo $rec['Mn']; ?></td> 
                            <td><?php echo $rec['P']; ?></td> 
                            <td><?php echo $rec['S']; ?></td> 
                            <td><?php echo $rec['Cu']; ?></td> 
                            <td><?php echo $rec['Mg']; ?></td> 
                            <td><?php echo $rec['Cr']; ?></td> 
                            <td><?php echo $rec['ni']; ?></td> 
                            <td><?php echo $rec['mo']; ?></td>  
                            <td><?php echo $rec['poring_temp']; ?></td> 
                            <td><?php echo $rec['inoculant_percentage']; ?></td> 
                            <td><?php echo $rec['BHN']; ?></td> 
                            <td><?php echo $rec['knock_out_time']; ?></td>  
                            <td><?php echo $rec['special_instructions']; ?></td>  
                            <td></td>
                        </tr>
                    <?php } ?> 
                <tfoot> 
                <tr>
                    <td valign="bottom" style="border: 1px solid black;"  align="center" colspan="8"><strong>Prepared by/Date</strong></td>
                    <td valign="bottom" align="center" style="border: 1px solid black;" colspan="14"><strong>Approved by/Date</strong></td>
                     <td colspan="7" style=" border: 1px solid black;vertical-align: middle;font-weight: bold;" align="left" >
                        <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                    
                        <!--Rev No: 04<br />
                        Rev Date : 15/02/2023 <br />
                        Supersedes 03
                        -->
                    </td>    
                </tr>
                <tfoot>
            </table>
        </div>
    </div>
     
 
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
