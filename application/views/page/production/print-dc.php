<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $record_list['customer']; ?>-DC-<?php echo $record_list['dc_no']; ?></title>
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
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row" style="border: 1px solid black;">
      <div class="col-xs-4 text-center"><h2>MJP</h2>
        <!--<h2 class="page-header"> 
          <i class="fa fa-globe"></i> M J P Enterprises Private Limited 
          <span class="pull-right"><b>Delivery Challan</b></span>
        </h2>-->
        
      </div>
      <div class="col-xs-4"><h2>Dispatch Advise Register</h2></div>
      <div class="col-xs-4">
        <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
      </div>
      <!-- /.col -->
    </div> 

    <!-- Table row -->
    <div class="row" style="border: 1px solid black;">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>DC No</td>
                    <td>DC Date</td>
                    <td>Customer</td>
                    <td>Transporter Name</td>
                    <td>Transporter GST</td>
                    <td>Vehicle No</td>
                    <td>Driver Name</td>
                    <td>Driver Mobile</td>
                </tr>
                <tr>
                    <td><?php echo $record_list['dc_no']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($record_list['despatch_date']));?></td>
                    <td><?php echo $record_list['customer']; ?></td>
                    <td><?php echo $record_list['transporter_name']; ?></td>
                    <td><?php echo $record_list['transporter_gst']; ?></td>
                    <td><?php echo $record_list['vehicle_no']; ?></td>
                    <td><?php echo $record_list['driver_name']; ?></td>
                    <td><?php echo $record_list['mobile']; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" style="border: 1px solid black;">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
          <tr>
            <th>S.No</th>
            <th>Item</th> 
            <th>Machining Sub-Contractor</th> 
            <th>Grinding Sub-Contractor</th> 
            <th class="text-right">No of Pcs</th>
            <th class="text-right">Weight[Pcs]</th>  
            <th class="text-right">Total Weight</th>  
            <th class="text-right">PO Info</th>  
          </tr>
          </thead>
          <tbody>
          <?php 
           foreach($bill_list as $i => $info) 
          {
              
          ?>
          <tr>
            <td><?php echo ($i + 1);?></td> 
            <td><?php echo $info['item']?></td>
            <td><?php echo $info['machining_sub_contractor']?></td>
            <td><?php echo $info['grinding_sub_contractor']?></td>
            <td class="text-right"><?php echo number_format($info['qty'],0)?></td>
            <td class="text-right"><?php echo number_format($info['piece_weight_per_kg'],3)?></td>
            <td class="text-right"><?php echo number_format($info['tot_wt'],3)?></td>
			<td class="text-right"><?php echo str_replace(',','<br>', $info['po_wise_qty']);?></td>
              
          </tr>
           <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!--<div class="row" style="border: 1px solid black;">
        <div class="col-xs-12 text-center" style="height: 120px;">
            <table class="table text-center">
                <tr>
                    <td width="50%" style="height: 120px;" valign="bottom"><br><br><br><br>Receiver's Signature</td>
                    <td valign="bottom"><br><br><br><br>For <strong>M J P ENTERPRISES PRIVATE LIMITED</strong></td>
                </tr>
            </table>
        </div>
         
    </div>-->
     <div class="row" style="border: 1px solid black;"> 
      <div class="col-xs-4"><br><br><br><br>Receiver's Signature</div>
      <div class="col-xs-4"><br><br><br><br>For <strong>M J P ENTERPRISES PRIVATE LIMITED</strong></div>
      <div class="col-xs-4 text-left ">
        <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
      </div>
      <!-- /.col -->
    </div> 
    
    <div class="text-center noprint">
        <br />
        <a href="<?php echo site_url('customer-despatch')?>" class="btn btn-info" >Back to Customer DC List</a>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
