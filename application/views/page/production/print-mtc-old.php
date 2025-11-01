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
  <script src="http://mjp-server/mjp/asset/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>asset/bower_components/jquery.excelexportjs.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    @media print{
       .noprint{
           display:none;
       }
    }
    i{font-size: 12px;}
    #sts tr {border: 1px solid black;}
  </style>  
<script>
jQuery(function($) {  
 
 
 $(".btnexp").click(function(){
    
   
   alert($(this).attr('id'));
   $("#mtc").excelexportjs({
                containerid: "mtc"
               , datatype: 'table'
               , worksheetName: 'MJP Test Cerificate'
   });
   
 }); 

});
</script> 
</head>
<body onload="window.print1();" style="font-size: 12px;">
<?php 
/*echo "<pre>";
print_r($record_list);
print_r($tc_list);
echo "</pre>";*/
?>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12" id="mtc">
            <table class="table table-condensed table-bordered"> 
                <tr>
                    <td colspan="2" class="text-center brlabel" style="border: 1px solid black;">
                        <h3>M J P ENTERPRISES PRIVATE LIMITED </h3>
                        <p>SF No.7/2, Door No. 19D/1, Kovilpalayam, S.S Kulam Town Panchayat,<br />
                            Sathy Main Road, Coimbatore - 641 107, Tamilnadu, India.  <br />
                            Phone : 94875 17952 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email : mjfoundary@gmail.com.
                        </p>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" class="text-center" style="border: 1px solid black;"><strong style="font-size: 18px;">Material Test Certificate</strong></td>
                </tr> 
                <tr>
                    <td style="border: 1px solid black;"><strong>MTC No : MJP/<?php echo $record_list[0]['dc_no']?></strong></td>
                    <td style="border: 1px solid black;"><strong>Date : <?php echo date('d-m-Y', strtotime($record_list[0]['despatch_date'])) ?></strong></td>
                   
                </tr>
                <tr>
                     <td style="border: 1px solid black;"><strong>Customer : <?php echo $record_list[0]['customer']?></strong></td>
                    <td style="border: 1px solid black;"><strong>Invoice No : MJP/<?php echo $record_list[0]['invoice_no']?></strong></td> 
                </tr>
                 
                <tr>
                    <td colspan="2" class="table-responsive" style="border: 1px solid black;">    
                      <table class="table  table-condensed " id="sts"> 
                        <tr>
                            <td rowspan="2" style="border: 1px solid black;"></td>
                            <td class="text-center" rowspan="2" style="border: 1px solid black;">Heat Code & No's</td>
                            <td class="text-center" rowspan="2" style="border: 1px solid black;">Item</td>
                            <td class="text-center" rowspan="2" style="border: 1px solid black;">PO</td>
                            <td class="text-center" rowspan="2" style="border: 1px solid black;">Qty</td>
                            <td colspan="7" class="text-center" style="border: 1px solid black;"><strong>Chemical Composition</strong></td>
                            <td colspan="4" class="text-center" style="border: 1px solid black;"><strong>Mechanical Property</strong></td>
                            <td colspan="2" class="text-center" style="border: 1px solid black;"><strong>Micro Structure</strong></td>
                            <td colspan="4" class="text-center" style="border: 1px solid black;"><strong>Matrix Distribution</strong></td>
                        </tr>
                        <tr>
                            
                            <td style="border: 1px solid black;">C(%)</td>
                            <td style="border: 1px solid black;">Si(%)</td>
                            <td style="border: 1px solid black;">Mn(%)</td>
                            <td style="border: 1px solid black;">P(%)</td>
                            <td style="border: 1px solid black;">S(%)</td>
                            <td style="border: 1px solid black;">Cu(%)</td>
                            <td style="border: 1px solid black;">Mg(%)</td>
                            <td style="border: 1px solid black;" class="text-center">Tensile<br />Strength N/MM<sup>2</sup></td>
                            <td style="border: 1px solid black;">Yield<br />Strength N/MM<sup>2</sup></td>
                            <td style="border: 1px solid black;">Elo(%)</td>
                            <td style="border: 1px solid black;">Hardness<br />BHN</td>
                            <td style="border: 1px solid black;" colspan="2">Magnification 100X</td>
                            <td style="border: 1px solid black;">Nodule Conut</td>
                            <td style="border: 1px solid black;">Ferrite(%)</td>
                            <td style="border: 1px solid black;">Pearlite(%)</td>
                            <td style="border: 1px solid black;">Carbide(%)</td>
                        </tr> 
                        <?php foreach($tc_list as $grade => $rec) {?>
                        <tr>
                            <td style="border: 1px solid black;">Specified Value</td>
                            <td colspan="4" style="border: 1px solid black;">Grade : <strong><?php echo $grade; ?></strong></td>
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['C']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['SI']; ?></i></td> 
                            <td style="border: 1px solid black;"><i><?php echo $rec[0]['Mn']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['P']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['S']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['Cu']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['Mg']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['tensile']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['yeild_strength']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['elongation']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i><?php echo $rec[0]['BHN']; ?></i></td> 
                            <td class="text-center" style="border: 1px solid black;"><i>Type A</i></td>  
                            <td class="text-center" style="border: 1px solid black;"><i> > 90%</i></td>
                            <td class="text-center" style="border: 1px solid black;"><i>150-400</i></td>
                            <td class="text-center" style="border: 1px solid black;"><i>40-80%</i></td>
                            <td class="text-center" style="border: 1px solid black;"><i>20-80%</i></td>
                            <td class="text-center" style="border: 1px solid black;"><i>Nil</i></td>
                        </tr>
                        <?php foreach($rec as $j => $info) {?>
                        <tr>
                            <td class="text-center" style="border: 1px solid black;"><?php echo ($j == 0 ? 'Tested Value' : ''); ?></td> 
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['heat_code']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['item']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['customer_PO_No']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['d_qty']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_c']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_si']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_mn']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_p']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_s']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_cu']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_mg']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"><?php echo $info['f_mg']; ?></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td>
                            <td class="text-center" style="border: 1px solid black;"></td> 
                        </tr> 
                        <?php } ?>
                        <?php } ?>
                        
                      </table>  
                    </td>
                </tr>
                 
                <tr>
                    <td style="height: 100px;border: 1px solid black;"  class="text-center" ><strong>QC Engineer</strong></td>
                    <td valign="bottom" class="text-center" style="border: 1px solid black;"><strong>QC Manager</strong></td>
                </tr>
            </table>
        </div>
    </div>
     

     
    <div class="row text-center noprint">
        <div class="col-md-6">
            <a href="<?php echo site_url('customer-despatch')?>" class="btn btn-info" >Back to Customer DC</a> 
        </div>
        <div class="col-md-6">
            <button class="btn btn-info btnexp" id="aqua" >Export To Excel File</button>
        </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
