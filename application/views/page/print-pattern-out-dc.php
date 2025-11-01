<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MJP DC</title>
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

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    @media print{
       .noprint{
           display:none;
       }
    }
  </style>  
</head>
<body onload="window.print1();">
<?php 
/* echo "<pre>";
print_r($record_list);
echo "</pre>"; */
?>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-condensed table-bordered">
                <tr>
                    <td width="50%" class="text-center"><strong>GSTIN : 33AAICM4962E1Z1</strong></td>
                    <td class="text-center"><strong>Returnable Delivery Challan</strong></td>
                </tr> 
                <tr>
                    <td colspan="2" class="text-center">
                        <h3>M J P ENTERPRISES PRIVATE LIMITED </h3>
                        <p>SF No.7/2, Door No. 19D/1, Kovilpalayam, S.S Kulam Town Panchayat,<br />
                            Sathy Main Road, Coimbatore - 641 107, Tamilnadu, India. <br />
                            Phone : 94875 17952  &nbsp;&nbsp;&nbsp;Email : mjfoundry@gmail.com.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td><strong>DC No : <?php echo $record_list[0]['dc_no']?></strong></td>
                    <td><strong>Date : <?php echo date('d-m-Y', strtotime($record_list[0]['pattern_in_out_date']))?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="p-2">
                        To, <br />
                        <?php echo $record_list[0]['pattern_maker']?>,<br />
                        <?php echo $record_list[0]['contact_person']?>,<br />
                        <?php echo $record_list[0]['address_line']?>,<?php echo $record_list[0]['area']?>,<?php echo $record_list[0]['city']?>-<?php echo $record_list[0]['pincode']?><br />
                        <?php echo $record_list[0]['mobile']?>.<br />
                        <?php echo "GST: " . $record_list[0]['gst_no']?>.
                        <p>
                        <strong>Vehicle No : <?php echo $record_list[0]['vehicle_no']?></strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> 
                        Dear Sir, <br />
                        <span style="padding-left: 60px;">Please receive the following pattern in good condition and return the duplicate copy duly signed</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0px;">
                        <table class="table table-condensed">
                          <thead>
                          <tr>
                            <th width="5%" >S.No</th>
                            <th>Item</th> 
                            <th>No Of Cavity</th>   
                            <th>No Of Core Box</th>  
                            <th>Reason</th>  
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                           foreach($record_list as $i => $info)  { 
                          ?>
                          <tr>
                            <td class="text-center"><?php echo ($i + 1);?></td> 
                            <td><?php echo $info['pattern_item']?></td>
                            <?php if($record_list[0]['show_cavity'] == '1') {?>
                            <td><?php echo $info['no_of_cavity']?></td>   
                            <?php } else { ?>
                            <td>-</td>   
                            <?php } ?>
                            <?php if($record_list[0]['show_core_box'] == '1') {?>
                            <td><?php echo $info['no_of_core_box']?></td>   
                            <?php } else { ?>
                            <td>-</td>   
                            <?php } ?>
                            <td><?php echo $info['reason']?></td>   
                          </tr>
                           <?php } ?>
                          <?php  for($k=1 ; $k<= (8 - count($record_list));$k++) {   ?>
                            <tr>
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td>  
                                <td>&nbsp;</td> 
                            </tr>
                          <?php } ?>
                             
                          </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="height: 100px;" valign="bottom" class="text-center">Receiver's Signature</td>
                    <td valign="top" class="text-center">For <strong>M J P ENTERPRISES PRIVATE LIMITED</strong></td>
                </tr>
            </table>
        </div>
    </div>
     

     
    <div class="text-center noprint">
        <a href="<?php echo site_url('pattern-in-out-list-v2')?>" class="btn btn-info" >Back to Pattern In/Out List</a>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
