<?php    
  /*	echo "<pre>";
    print_r($mtc_list);
    
    echo "<hr>";
    print_r($master_range);
    //print_r($record_list);
	echo "</pre>"; */          
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP MTC</title>
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
print_r($tc_list);
echo "</pre>";*/
?>
<div class="wrapper1">
  <!-- Main content -->
  <section class="invoice V2">
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12" id="mtc">
            <table class="table table-condensed table-bordered " id="content-table"> 
                <tr>
                    <td colspan="2" align="center" style="border: 1px solid black;"><h1>MJP</h1> 
                    
                </td>
                    <td colspan="13" align="center" style="border: 1px solid black;">
                        <h3><strong>M J P ENTERPRISES PRIVATE LIMITED</strong> </h3>
                        <p><strong>SF No.7/2, Door No. 19D/1, Kovilpalayam, S.S Kulam Town Panchayat,<br />
                            Sathy Main Road, Coimbatore - 641 107, Tamilnadu, India.  <br />
                            Phone : 94875 17952 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email : mjfoundry@gmail.com.</strong>
                        </p>
                    </td>
                    <td colspan="2" style="border: 1px solid black;padding: 5px;font-weight: bold; text-align:center; "> 
                         <div style="display:flex;justify-content:center;align-item:center; margin:10px 0 0 0; ">
                            <img src="<?php echo base_url('asset\images\BIS.png'); ?>" alt="" class="img-md"> 
                            
                         </div>
                        <span >6500110494</span>
                         
                    </td>
                    <td colspan="2" align="left" style="border: 1px solid black;padding: 5px;font-weight: bold;">
                        <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                        <!--<table class="table no-border " style="border: 0px;height: 100%;">
                            <tr><td class="col-md-12">Document Level 4</td></tr> 
                            <tr><td class="col-md-12">Doc Ref No: MJP/FT/QA/006</td></tr> 
                            <tr><td class="col-md-12">Issue Date : 10/09/19</td></tr> 
                            <tr><td class="col-md-12">Page 1 of 1</td></tr> 
                        </table>-->
                    </td>
                </tr>
                
                <tr>
                    <td colspan="19" align="center" style="border: 1px solid black;">
						<strong style="font-size: 18px;">Material Test Certificate</strong>
						<!-- <span style="font-weight:bold;float: right !important;font-size: 18px;">BIS CML No : 6500110494</span> -->
					</td>
                </tr> 
                <tr>
                    <td style="border: 1px solid black;" width="50%" colspan="10"><strong>MTC No : MJP/<?php echo $record_list[0]['dc_no']?></strong></td>
                    <td style="border: 1px solid black;" colspan="9"><strong>Date : <?php echo date('d-m-Y', strtotime($record_list[0]['despatch_date'])) ?></strong></td>
                   
                </tr>
                <tr>
                     <td style="border: 1px solid black;" colspan="10"><strong>Customer : <?php echo $record_list[0]['customer']?></strong></td>
                    <td style="border: 1px solid black;" colspan="9"><strong>Invoice No : <?php if($record_list[0]['invoice_no'] > 0) echo "MJP/" . $record_list[0]['invoice_no']?></strong></td> 
                </tr>
                 
                 
                        <tr>
                            <td rowspan="2" style="border: 1px solid black;"></td>
                            <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Heat Code</strong></td>
                            <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Description</strong></td> 
                            <td align="center" rowspan="2" style="border: 1px solid black;"><strong>Qty</strong></td> 
                            <td colspan="10" align="center" style="border: 1px solid black;"><strong>Chemical Composition</strong></td>
                            <td align="center" style="border: 1px solid black;"><strong>Physical <br />Property</strong></td> 
                            <td colspan="3" align="center" style="border: 1px solid black;"><strong>Mechanical Properties</strong></td>
							<td align="center" rowspan="2" style="border: 1px solid black;" width="12%"><strong>Remarks</strong></td>
                             
                        </tr>      
                        <tr>
                            
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
                            <td style="border: 1px solid black;" align="center"><strong>Hardness<br />BHN</strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Tensile<br />Strength <br>N/MM<sup>2</strong></sup></td> 
                            <td style="border: 1px solid black;" align="center"><strong>Yield Strength<br>N/MM<sup>2</sup></strong></td>
                            <td style="border: 1px solid black;" align="center"><strong>Elongation<br>%</strong></td>
                            
                            
                            
                             
                        </tr> 
                        
                
                    <?php foreach($mtc_list as $item => $rec) { ?>
                        <tr style="font-weight: bolder;">
                            <td style="border: 1px solid black;">Specified Value</td>

                            <td colspan="2" style="border: 1px solid black;">Grade : <strong><?php echo $master_range['grade_name']; ?></strong></td>
                            <td align="center" style="border: 1px solid black;"> </td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['C']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['SI']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['Mn']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['P']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['S']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['Cu']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['Mg']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['Cr']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['ni']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['mo']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['BHM']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['tensile']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['yeild_strength']; ?></i></td> 
							<td align="center" style="border: 1px solid black;"><i><?php echo $master_range['elongation']; ?></i></td>
                            
                            <?php 
                            /*
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_c']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_si']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_mn']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_p']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_s']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_cu']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_mg']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_cr']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_bmn']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_tensile']; ?></i></td> 
                            <td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_yield_strength']; ?></i></td> 
							<td align="center" style="border: 1px solid black;"><i><?php echo $master_range['m_elongation']; ?></i></td>
                            */
                            ?>
							
							<td align="center" style="border: 1px solid black;">&nbsp;</td>
                             
                        </tr>
                        <?php 
                        $itm = '';                                     
                        $po = '';
                        $tot_qty = 0;
                        foreach($rec as $j => $info) {
                            $tot_qty += $info['d_qty'];    
                        ?>                                     
                        <tr>
                            <td align="center" style="border: 1px solid black;"><?php echo ($j == 0 ? 'Tested Value' : ''); ?></td> 
                            <td align="center" style="border: 1px solid black;"><?php echo $info['heat_code']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php if($itm != $info['item']) echo $info['item']; else echo '&nbsp;' ?></td>
                             
                            <td align="center" style="border: 1px solid black;"><?php echo number_format($info['d_qty'],0); ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_c']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_si']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_mn']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_p']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_s']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_cu']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_mg']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_cr']; ?></td> 
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_ni']; ?></td> 
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_mo']; ?></td> 
                            <td align="center" style="border: 1px solid black;"><?php echo $info['f_bmn']; ?></td> 
                            <td align="center" style="border: 1px solid black;"><?php echo $info['tensile']; ?></td>
                            <td align="center" style="border: 1px solid black;"><?php echo $info['yield_strength']; ?></td>  
                            <td align="center" style="border: 1px solid black;"><?php echo $info['elongation']; ?></td> 
                            
                            <td align="center" style="border: 1px solid black;">&nbsp;</td> 
                              
                        </tr> 
                        <?php 
                        if($itm != $info['item']) $itm = $info['item'];
                        if($po != $info['customer_PO_No']) $po = $info['customer_PO_No'];
                        } 
                        ?>
                        <tr> 
                             <td  style="border: 1px solid black;" colspan="3" align="right">Total</td>
                             <td  style=" border: 1px solid black;text-align: center;" > <?php echo number_format($tot_qty,0); ?> </td>
                             <td  style=" border: 1px solid black;" colspan="15"></td>
                        </td>     
                        <?php } ?>
                 
                <tr> 
                    <td style=" border: 1px solid black;height: 10px; vertical-align: middle;font-weight: bold;"  align="center" colspan="14">
                        We hereby certify that the above material was tested and inspected in accordance with IS 210 :2009 and found to meet the Customer Requirement.<br>Yield strength and Elongation not applicable for Grey Iron Castings
                    </td>
                    <td colspan="5" style=" border: 1px solid black;vertical-align: left;font-weight: bold;" align="left" >
                    <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                        <!--<table class="table table-condensed no-border " style="border:0px;height: 100%;">
                            <tr><td class="col-md-12">Rev No: 00</td></tr> 
                            <tr><td class="col-md-12">Rev Date : 01/09/2019</td></tr> 
                            <tr><td class="col-md-12">Suoersedes 00</td></tr> 
                        </table>-->
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 70px;border: 1px solid black;"  align="center" colspan="9"><strong>Prepared By</strong></td>
                    <td valign="bottom" align="center" style="border: 1px solid black;" colspan="10"><strong>Approved By</strong></td>
                </tr>
            </table>
        </div>
    </div>
     

     
    <div class="row text-center noprint">
        <div class="col-md-6">
            <a href="<?php echo site_url('customer-despatch')?>" class="btn btn-info" >Back to Customer DC</a> 
        </div>
        <div class="col-md-6">
            <button class="btn btn-info btnexp" >Export To Excel File</button>
        </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
