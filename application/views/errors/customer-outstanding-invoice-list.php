<?php
  include_once("../include/dbcommon.php");

if (!isset($_SESSION['UserID']))
{
    $_SESSION["MyURL"] = "printing/customer-outstanding-invoice-list.php";
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
 
 
 

 $(".btn-mail").click(function(){ 
      // alert('Sending mail to ' + $('.mailid').val() + '. \nPlease Wait.....!!' );  
       
       var mailid = $("input[name='mailid']:checked").map(function() {
                return this.value;
            }).get().join(', ');
            
      alert('Sending mail to ' + mailid + '. \nPlease Wait.....!!' );     
      
     if($('.mailid').val() != '') {  
      $.ajax({
                url: "/mobile_office/index.php/send-mail",
                type: "post",
                data: { to : mailid, subject: 'Payment Pending Invoice List' , message : $('.pending_list').html(), customer_id : $('.customer_id').val()},
                //data: { to : 'aserjco@gmail.com', subject: 'Payment Pending Invoice List' , message : $('.pending_list').html(),customer_id : $('.customer_id').val() },
                success: function(d) {                      
                    if(d = 1) {  
                    alert('Mail Successfully Send');   
                    }
                    
                }
         });  
      }  
      
       
 });
 
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
					<th colspan="2"><center><b>Customer Outstanding  Invoice Report With Mail Send Option </b></center></th>
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
                                    where (a.payment_by = 'Head Office' or  a.payment_by = 'Local' )  
                                    and (c.`status` != '12'  and c.`status` != '14' and c.`status` != '15')
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
                    <td align="right"> Payment By</td>
                    <td align="left">
                        <input type="radio" name="pay_by" class="required" value="Head Office" <?php  if ((isset($_POST['pay_by'])) && ($_POST['pay_by'] == 'Head Office')) echo 'checked="true"'   ?> /> Head Office 
                        <input type="radio" name="pay_by" value="Local" <?php  if ((isset($_POST['pay_by'])) && ($_POST['pay_by'] == 'Local')) echo 'checked="true"'   ?> /> Local 
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
       
  $where .= " and a.payment_by = '" .  $_POST['pay_by']. "'";      
    // a.payment_by = 'Head Office'
  
  $sql = "
           select 
           a.contact_id,
           a.contact_person , 
           a.email , 
           a.mobile   
           from contact_details as a 
           where a.status = 'Active'
           and a.customer_id = '". $_POST['customer_id'] ."' 
           order by a.contact_id asc  
  ";  
  
  $res1 = mysql_query($sql);
  
  $mail_list = array();
  
  while($row1 = mysql_fetch_assoc($res1)){	   
		$mail_list[] = $row1; 
	}
    
    
  $sql = "
           select 
           a.mail_ids,
           a.send_time  
           from crit_outstanding_mailsend_info as a 
           where  a.customer_id = '". $_POST['customer_id'] ."' 
           order by a.send_time desc limit 5  
  ";  
  
  $res1 = mysql_query($sql);
  
  $mailsend_list = array();
  
  while($row1 = mysql_fetch_assoc($res1)){	   
		$mailsend_list[] = $row1; 
	}
      
    
    
  $sql_op = "    
         select 
        a.project as project_id,
        a.project_invoice_id as invoice_id,
        a.invoice_date,
        a.invoice_no,
        get_company(a.company) as company,
        get_customer(a.customer) as customer,
        d.branch_name as branch_name,
        a.address_to as customer_branch_address,
        f.complaint_contact_person,
        f.complaint_contact_no,
        a.total_cost as invoice_amount,
        (e.amount + ifnull(e.TDS_Amount,0) + ifnull(e.WCT_amount,0)) as receipt_amount,
        (a.total_cost - (ifnull(e.amount,0) + ifnull(e.TDS_Amount,0) + ifnull(e.WCT_amount,0))) as outstanding, 
        'Project' as module
        from project_invoice as a
        left join project_master as c on c.project_id = a.project
        left join customer_branch_office_info as d on d.customer_branch_id = a.customer_branch_id
        left join project_receipt as e on e.project_id = a.project
        left join complaint_ticket_info as f on f.project_id = a.project   
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
	   if($row['outstanding'] > 0 ) 
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
    <center><h3><?php echo ($_POST['pay_by'] == 'Local' ? 'Branch' : $_POST['pay_by'] ); ?> Payment Outstanding Invoice List : </h3></center>
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
                     <th>Branch</th> 
                     <th>Branch Address</th> 
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
                        <td style="text-align: left;"><?php echo $vat_det['branch_name'] ;?></td> 
                        <td style="text-align: left;"><?php echo $vat_det['customer_branch_address'] ;?></td> 
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
    <div style="text-align: center;"> 
        <table align="center" cellpadding="5" cellspacing="0" width="98%" border="1">
            <tr>
                <th>S.No</th>
                <th>Contact Person</th>
                <th>Mobile</th>
                <th>Email</th>
                <th colspan="2">Action</th>
            </tr>
            <?php   
                if(!empty($mail_list)) {
                foreach($mail_list as $k => $det) {  ?> 
                    <tr>
                        <td class="brd-lft"><?php echo ($k+1) ;?></td> 
                        <td style="text-align: left;"><?php echo $det['contact_person'] ;?></td> 
                        <td style="text-align: left;"><?php echo $det['mobile'] ;?></td> 
                        <td style="text-align: left;">
                            <?php echo $det['email'] ;?> 
                        </td> 
                        <td>
                            <!--<a href="/erp/contact_details_edit.php?editid1=<?php echo $det['contact_id'] ;?>" target="_blank">Edit</a>-->
                            <a href="/erp/contact_details_add.php" target="_blank">Add New</a>
                        </td>
                        <td>
                            <input type="checkbox" name="mailid" class="mailid" value="<?php echo $det['email'] ;?>" />
                        </td>
                    </tr>
                <?php  }  ?>
                <?php  }  else { ?>
                <tr style="background-color: red; color: #FFF;">
                    <th colspan="4">No Record!! <br> Please Add Contact Person <a href="/erp/contact_details_add.php" target="_blank">Click Here</a></th>
                </tr>
                <?php  }   ?>
        </table> <br />
        <div style="text-align: center;">  <h3>Last 5 Mail Send List</h3>
        <table align="center" cellpadding="5" cellspacing="0" width="98%" border="1">
            <tr>
                <th>S.No</th>
                <th>Mail ID</th>
                <th>Send Time</th> 
            </tr>
            <?php   
                if(!empty($mailsend_list)) {
                foreach($mailsend_list as $k => $det) {  ?> 
                    <tr>
                        <td class="brd-lft"><?php echo ($k+1) ;?></td> 
                        <td style="text-align: left;"><?php echo $det['mail_ids'] ;?></td> 
                        <td style="text-align: left;"><?php echo $det['send_time'] ;?></td>  
                    </tr>
                <?php  }  ?>
                <?php  }  else { ?>
                <tr style="background-color: red; color: #FFF;">
                    <th colspan="3">No Record!!  </th>
                </tr>
                <?php  }   ?>
        </table> <br />
        
        <button class="btn btn-mail" type="button">Send Mail</button>
    </div>
  
 <?php } ?>
 
 <?php } ?>
 </body>
 </html>