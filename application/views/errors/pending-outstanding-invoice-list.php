<?php
  include_once("../include/dbcommon.php");

if (!isset($_SESSION['UserID']))
{
    $_SESSION["MyURL"] = "printing/pending-outstanding-invoice-list.php";
    header('Location: ../login.php');
}

  //include_once("inttoword/wordsClass.php");
  //$obj = new intToWord();
  $link = mysql_connect($host, $user, $pwd);
	if (!$link) {
	   die('Not connected : ' . mysql_error());
	}
	
	// make foo the current db
	$db_selected = mysql_select_db($sys_dbname, $link);
	if (!$db_selected) {
	   die ('Can\'t use foo : ' . mysql_error());
	}

  
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Payment Outstanding Invoice List</title>
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css"/> 
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<script type="text/javascript" src="js/jquery.validate.js"></script>  
<script type="text/javascript" src="http://fancybox.net/js/fancybox-1.3.4/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="http://fancybox.net/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" /> 

<style>
	body {font-family: verdana; font-size: 11px;}
    .brd-lft {border-left:1px solid black;}
	.rept td{padding-right:10px;text-align:left;border-right:1px solid black; border-bottom:1px solid black;text-align: right;}
	.rept th{padding-right:10px;text-align:left;border-right:1px solid black;border-bottom:1px solid black;text-align: center;}
	.error {color:red;}
	.noborder {border:0px;}
	.tot th{ border-top:1px solid black;}
	strong {font-size:14px;} 
    fieldset {border:1px solid black;margin-top: 10px;}  
    
    .btn-mail {
      background-color: #008000;
      color: #FFF;
      border-radius: 5px;
      padding: 10px;
      font-weight: bolder;
       
    }
</style>
<style media="print">
#srch ,#prnt_btn , .asebtn{ display:none;}
.sh_prnt {width:250px; }
fieldset {border:0px;} 
body {font-family: verdana; font-size: 11px;}
.brd-lft {border-left:1px solid black;}
	.rept td{padding-right:10px;text-align:left;border-right:1px solid black; border-bottom:1px solid black;text-align: right;}
	.rept th{padding-right:10px;text-align:left;border-right:1px solid black;border-bottom:1px solid black;text-align: right;}
/*.rept td {border-bottom:1px solid black;border-left:1px solid black;padding-left:5px;}
.rept th {border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;}*/
/* body {font-size: 6pt;line-height: 12pt; font-weight:bold; font-family:'MS Serif',"Calibri","Terminal","Times New Roman"; letter-spacing:0.5em; }*/

</style>
 
<script type="text/javascript">


$(function(){
    
 var $rows = $('#rept1 tbody tr');
	$('.keyword').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});    
    
    
$( "input[name=from_date]" ).datepicker({
changeMonth: true,
changeYear: true,
dateFormat: "yy-mm-dd",
yearRange: "-5:+5"
});

$( "input[name=to_date]" ).datepicker({
changeMonth: true,
changeYear: true,
dateFormat: "yy-mm-dd",
yearRange: "-5:+5"
});

 $("#frm").validate({});
 
/*$(".fancy").fancybox({
        'titleShow'     : true,
        'titlePosition'  : 'inside',
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
		'easingIn'      : 'easeOutBack',
		'easingOut'     : 'easeInBack'
 });*/
 
 
 

 
 
 $("#prnt_btn").click(function(){
 	//alert($('.chkrec').val());
 	$("#srch").hide();
 	//$("#frm").hide();
 	$("#prnt_btn").hide();
 	window.print();
 	//$this.submit();
 });
 


});
</script> 
</head>
<body>
 <div class="src_frm">
<form action="" method="POST" id="frm">
<table width="100%" border="0" id="srch">
	<tr>
	
		<td align="center">
			<table align="center" border="1" cellpadding="5" cellspacing="5" width="60%" >
				<tr>
					<th colspan="2"><center><b>Customer Outstanding  Invoice Report </b></center></th>
				</tr>
				 
				<tr>
					<td align="right" width="50%">Customer</td>
					<td>
						<select name="customer_id" class="customer_id required">
							<option value="">Select Customer</option>
							<?php
                                 $sql_op = "    
                                    select  
                                    a.customer as customer_id, 
                                    get_customer(a.customer) as customer  
                                    from project_invoice as a 
                                    left join project_master as c on c.project_id = a.project
                                    left join project_receipt as e on e.project_id = a.project
                                    where (c.`status` != '12'  and c.`status` != '14' and c.`status` != '15')
                                    and (a.total_cost - (ifnull(e.amount,0) + ifnull(e.TDS_Amount,0) + ifnull(e.WCT_amount,0))) > 0
                                    group by a.customer 
                                    order by a.customer asc 
                                        
                                    ";
                                $res = mysql_query($sql_op);
                                $num_rows = mysql_num_rows($res);
                                
                                while ($row = mysql_fetch_assoc($res))
                                {
                                    echo '<option value="' . $row["customer_id"] . '"';
                                    if ((isset($_POST['customer_id'])) && ($_POST['customer_id'] == $row["customer_id"]))
                                        echo ' selected ';
                                    echo '>' . $row["customer"] . '</option>';
                                }

                            ?>
						</select>
					</td>
				</tr>
                <tr>
            		<td align="right" width="50%">From Date</td>
            		<td>
            		<input type="text" name="from_date" value="<?php echo $_POST['from_date'];?>" id="from_date"   readonly>
            		</td>
                </tr>
                <tr>   
            		<td align="right" width="50%">To Date</td>
            		<td>
            		<input type="text" name="to_date" value="<?php echo $_POST['to_date'];?>" id="to_date"   readonly>
            		</td>
            	</tr>  
   	            <tr>
					<td align="center" colspan="2">
                    <input type="submit" name="Report" value="Show Report">       
				</tr>	
                <!--<tr>
                    <td align="center" colspan="2">Search Keyword: <input type="text" name="keyword" value="" class="keyword" /></td>
                </tr>--> 	
			</table>
		</td>
	</tr>
</table>

</form>
<br>
</div>
<?php
 

if(isset($_POST['Report'])) 
{
    
  $where = "";   
  if($_POST['customer_id'] != 'All') $where .= " and a.customer = " .  $_POST['customer_id']; 
  if($_POST['from_date'] != ''){ 
    $where .= " and a.invoice_date between '" .  $_POST['from_date']."' and '" .$_POST['to_date']."'" ; 
  }
       
    
    
    
   
    
    
   $sql_op = "    
        select 
        a.project as project_id,
        a.project_invoice_id as invoice_id,
        a.invoice_date,
        a.invoice_no,
        get_company(a.company) as company,
        get_customer(a.customer) as customer, 
        c.work_name , 
        c.work_place,
        a.total_cost as invoice_amount,
        (e.amount + ifnull(e.TDS_Amount,0) + ifnull(e.WCT_amount,0)) as receipt_amount,
        (a.total_cost - (ifnull(e.amount,0) + ifnull(e.TDS_Amount,0) + ifnull(e.WCT_amount,0))) as outstanding, 
        'Project' as module
        from project_invoice as a
        left join project_master as c on c.project_id = a.project 
        left join project_receipt as e on e.project_id = a.project 
        where 1
        $where
        and (c.`status` != '12'  and c.`status` != '14' and c.`status` != '15')
        group by a.project 
        order by a.invoice_date asc 
            
        ";
   
   
	/*echo "<pre>";
	echo $sql_op;	
    echo "</pre>";*/
		
    $res= mysql_query($sql_op);
    //$data_field['Staff Attendance'][]=  mysql_field_name($sql_op);
	$num_rows = mysql_num_rows($res);
    
    $total_inv = array();
    $data = array();
    if($num_rows > 0) {
	while($row = mysql_fetch_assoc($res)){
	  // if($row['outstanding'] > 0 ) 
       {
		$data[$row['company']][] = $row;	 	
		//$total_inv[$row['company']] += $row['invoice_amount'];
        }	 	
	}
    /*echo "<pre>";
    print_r($data);
    echo "</pre>";*/
    
    //echo max($total_inv);*/
    ?>
    
    <div class="pending_list"> 
    <center><h3>Payment Outstanding Invoice List : </h3></center>
    <?php 
     
    foreach($data as $company=> $vat_info) {
    
   ?>
            <table align="center" cellpadding="3" cellspacing="0" width="98%" border="1" id="rept1" class="rept">
               <thead>
                   <tr>
                        <th colspan="6" style="text-align: left;border-bottom:1px solid black;border-right:0px; "> <?php echo  " Company : ". $company  ; ?></th>
                   </tr>
                   <tr> 
                     <th class="brd-lft">S.No</th> 
                     <th>Invoice No</th> 
                     <th>Invoice Date</th> 
                     <th>Project ID</th> 
                     <th>Heading</th> 
                     <th>Invoice Amount</th>   
                   </tr>
               </thead> 
               <tbody>
                <?php  
                    $tot =array();
                foreach($vat_info as $k => $vat_det) {  ?> 
                    <tr>
                        <td class="brd-lft" align="center"><?php echo ($k + 1) ;?></td>
                        <td align="center"><?php echo $vat_det['invoice_no'] ;?></td>
                        <td><?php echo date('d-m-Y', strtotime($vat_det['invoice_date']));?></td> 
                        <td style="text-align: left;"><?php echo $vat_det['project_id'] ;?></td> 
                        <td style="text-align: left;"><?php echo $vat_det['work_name'] ;?>@<?php echo $vat_det['work_place'] ;?></td> 
                       <td style="text-align: right;"><?php echo number_format($vat_det['invoice_amount'],2); $tot['bill_amount'] += $vat_det['invoice_amount']; ?></td>
                    </tr>
                <?php  }  ?>
                <tr>
                    <th colspan="5" class="brd-lft">Total</th>
                    <th style="text-align: right;"><?php echo number_format($tot['bill_amount'],2) ;?></th>  
                </tr>
               </tbody>         
            </table>
            <br />
            <br />
            
 <?php }  ?> 
    </div> 
  
 <?php } ?>
 
 <?php } ?>
 </body>
 </html>