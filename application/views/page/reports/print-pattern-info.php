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
  <title>MJP Moulding Master List</title>
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
    #content-table th{border:1px solid black;} 
    #content-table td{border:1px solid black;} 
    
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
                    <th colspan="2" class="text-center"><h1>MJP</h1></td>
                    <th colspan="4" class="text-center">
                        <h1>Pattern List  </h1> 
                    </th>
                    <th colspan="3">
                       <?php if(isset($iso_label['iso_label_ctnt'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt']); ?>
                       
                    </th>
                </tr>  
                <tr>
                    <th colspan="9">Customer Name: <?php echo $record_list[0]['customer']?></th>
                </tr> 
                
                <tr>
                    <th>S.No</th>  
                    <th>Pattern Code</th>  
                    <th>Item Description</th>  
                    <th>Type</th>  
                    <th>Grade</th> 
                    <th>No of Cavity</th>  
                    <th>Core Per Cavity</th>  
                    <th>Box Wt</th> 
                    <th>Remarks</th>  
                </tr>      
                         
                   </thead>     
                    <?php foreach($record_list as $i => $rec) { ?>
                        <tr id="itms">
                            <td><?php echo ($i+1); ?></td> 
                            <td><?php echo $rec['match_plate_no']; ?></td> 
                            <td><?php echo $rec['pattern_item']; ?></td> 
                            <td><?php echo $rec['pattern_type']; ?></td> 
                            <td><?php echo $rec['grade']; ?></td> 
                            <td><?php echo $rec['no_of_cavity']; ?></td>  
                            <td><?php echo $rec['no_of_core']; ?></td>
                            <td><?php echo $rec['bunch_weight']; ?></td>  
                            <td></td>
                        </tr>
                    <?php } ?> 
                <tfoot> 
                
                <tr>
                    <th colspan="3">Prepared by</th>
                    <th colspan="3">Approved by/Date</th>
                    <th colspan="3">
                         <?php if(isset($iso_label['iso_label_ctnt_footer'])) echo  str_replace("\n","<br>",$iso_label['iso_label_ctnt_footer']); ?>
                     </th>
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
