<?php
  include_once("../include/dbcommon.php");
  include_once("inttoword/wordsClass.php");
  $obj = new intToWord();
  $link = mysql_connect($host, $user, $pwd);
	if (!$link) {
	   die('Not connected : ' . mysql_error());
	}
	
	// make foo the current db
	$db_selected = mysql_select_db($sys_dbname, $link);
	if (!$db_selected) {
	   die ('Can\'t use foo : ' . mysql_error());
	}
 
  $sql =" 
		select 
		DATE_FORMAT(a.domain_bill_date,'%d-%m-%Y') as domain_bill_date,
		a.bill_no,
		b.client_company,
		b.address ,
        b.state,
        b.gst_no,
		a.domain_ids,
		c.bill_description,
		DATE_FORMAT(c.validity,'%d-%m-%Y')as validity,
		c.amount
		from domain_bill_info as a
		left join client_info as b on b.client_id = a.client_id
		left join domain_bill_details as c on c.domain_bill_id = a.domain_bill_id
 ";
  
		 
  if(isset($_GET['id']))
  {
    	$sql.= " where a.domain_bill_id = " . $_GET['id'];
		$sql.= " order by c.domain_bill_det_id asc ";		
				 
  
  $res= mysql_query($sql);
  $data = array();  
  while($row = mysql_fetch_assoc($res))
  {
  	$data[] = $row;
  }
  
  $sql_tax  = "select GROUP_CONCAT(a.domain_name) as domains , a.renewal_date from domain_info as a where a.domain_id in (". $data[0]['domain_ids'].") ";
  $res_tax = mysql_query($sql_tax);
  $tax= array();
  while($row_tax = mysql_fetch_assoc($res_tax))
  {
  	$tax[] = $row_tax;
  } 
  
  //$data[0]['gst_no'] = '';
  
  //print_r($tax);
  
  //echo '<pre>';
	//print_r($data);
  //echo '</pre>';
 ?>
<?php 
if(!empty($data))
{
//$words =  $obj->getAmountInWords(round($data[0]['amount'])) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ZaZu Tech Invoice</title>
<link rel="stylesheet" href="print.css" type="text/css" media="print" />
<style>
	.main .chld td,th { border-bottom:1px solid black; border-right:1px dotted black; border-left:1px dotted black; }
	.acc {padding-left:10px; border-top:0px;}	
	.brlft {border-bottom:0px}
	.topbrd{border-top:1px solid black;}
	.main  {border:0px;}
	html { 
	  background: url("zazu.jpg") no-repeat top center; 
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	}
	.noborder {border:0px;}
</style>

</head>
<body>
<?php 
if(!empty($data))
{
//$words =  $obj->getAmountInWords(round($data[0]['amount'])) ;
?>  
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="main">
	 <tr>
		<td style="height:120px;" align="left"><?php if(!empty($data[0]['gst_no'])){?><b>&nbsp;GST : 33AOBPS9291N3Z6</b><?php } ?></td>  
		<td style="height:120px;" align="left"><b>INVOICE</b></td>  
	 </tr>
   <tr>
    <td style="padding-left:10px;height:100px;" valign="top">
    	<label>To</label> 
		<p style="padding-left:50px;"><b>M/s. <?php echo $data[0]['client_company'];?></b>,<br />
		<?php echo $data[0]['address'];?>  
        <?php if(!empty($data[0]['gst_no']) && $data[0]['gst_no'] != 'NO GST'){?>
		<br /><strong>GST : <?php echo $data[0]['gst_no'];?> </strong> 
        <?php } ?>
		</p>
    </td>
	<td valign="bottom" width="50%" class="noborder">
		<table width="100%" cellpadding=5 cellspacing=2 border=0>
		 <tr>
			<td width="30%">Invoice No :  </td>
			<td align="left"><?php echo $data[0]['bill_no'];?></td>
		 </tr>
		 <tr>
			<td>Invoice Date : </td>
			<td align="left"><?php echo $data[0]['domain_bill_date'];?></td>
		 </tr>	
		</table>
	 </td>
  </tr>
  <tr>
	<td colspan="2" style="height:30px;">&nbsp;</td>
  </tr>
  <!--<tr>
	<td colspan="2" align="center">Reg: <b> Domain Renewal for <?php echo str_replace(',',' , ',$tax[0]['domains']); ?></b></td>
  </tr> --> 
  <tr>
    <td colspan="2" class=""><table width="100%" border="1" cellspacing="0" cellpadding="4" class="chld">
        <tr>
          <th width="10%"><b>S.No</b></th>
          <th width="50%"><b>Particulars</b></th>
          <?php if(!empty($data[0]['gst_no'])){?>
          <th width="10%"><b>SAC Code</b></th>
          <?php } ?>
          <th width="20%"><b>Validity Upto</b></th> 
          <th width="10%"><b>Amount</b></th>
        </tr>
       <?php 
       	$tax = $tot =0;
       	for($i=0;$i<count($data);$i++) {
       		$tot+=$data[$i]['amount']; 
       	?> 
        <tr>
          <td align="center"><?php echo $i+1; ?></td>
          <td><?php echo $data[$i]['bill_description'];?></td>
          <?php if(!empty($data[0]['gst_no'])){?>
          <td align="center">998315</td>
          <?php } ?>
          <td align="center"><?php echo $data[$i]['validity'];?></td> 
          <td align="right"><?php echo number_format($data[$i]['amount'],2,'.',',');?></td>
        </tr>
        <?php }  
        ?>
       <?php  for($j=0;$j<(15 - count($data));$j++) { ?>
         <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
            <?php if(!empty($data[0]['gst_no'])){?>
		    <td>&nbsp;</td> 
            <?php } ?>
		    <td>&nbsp;</td> 
		    <td>&nbsp;</td> 
		  </tr>
		<?php } ?> 
        <?php if(!empty($data[0]['gst_no'])){ ?>
        <tr>
        	<td colspan="4" align="right" ><label>Sub Total</label></td>
        	<td align="right"><?php echo number_format($tot,2,'.',','); ?></td>
        </tr>
        <?php 
        //if(!empty($data[0]['gst_no'])){ 
        if($data[0]['state'] == 'Tamilnadu'){?>
        <tr>
        	<td colspan="4" align="right" ><label>CSGT : 9%</label></td>
        	<td align="right"><?php echo number_format(($tot * 9 /100) ,2,'.',','); ?></td>
        </tr>
        
        <tr>
        	<td colspan="4" align="right" ><label>SGST : 9%</label></td>
        	<td align="right"><?php echo number_format(($tot * 9 /100),2,'.',','); ?></td>
        </tr>
        <?php } else { ?>
        <tr>
        	<td colspan="4" align="right" ><label>IGST : 18%</label></td>
        	<td align="right"><?php echo number_format(($tot * 18 /100),2,'.',','); ?></td>
        </tr>
        <?php }   ?>
		 <tr>
        	<td colspan="4" align="right" ><label>Net Total</label></td>
        	<td align="right"><?php echo number_format(($tot + ($tot * 18 /100)),2,'.',','); ?></td>
        </tr>
        <?php 
         $tot_1 = ($tot + ($tot * 18 /100));
        } else {  
			//$tot_1 = $tot; 
			$tot_1 = ($tot + ($tot * 18 /100));
		?>
         <tr>
        	<td colspan="3" align="right" ><label>Net Total</label></td>
        	<td align="right"><?php echo number_format(($tot),2,'.',','); ?></td>
        </tr>
        <?php } ?>
      </table></td>
  </tr>
  <tr>
    <td colspan="3" style="padding-left:40px;"> <br />
    	<b>Rupees In Words : <?php echo $obj->getAmountInWords($tot_1) ; ?></b>
    </td> 	
  </tr>  
	<tr>
    <td colspan="2">
    	 &nbsp;
    </td> 	
  </tr>   
  <tr>    
    <td align="left"  valign="top" style="height:60px;border:0px;">
    <table>
        <tr>
            <td>Company :	Zazu Technologies </td>
        </tr>
        <tr>        
            <td>Bank Name :	Syndicate Bank </td>
        </tr>
        <tr>
            <td>Branch : Pankaja mill</td>
        </tr>
        <tr>
            <td>Account No :61381010002091 </td>
        </tr>
        <tr>    
            <td>IFSC Code :	SYNB0006138 </td>
        </tr>
         
    </table>   
    <table style="display: none;">
        <tr>
            <td>Name :	Tamilselvan.S  </td>
        </tr>
        <tr>        
            <td>Bank Name :	Indian Overseas Bank </td>
        </tr>
        <tr>
            <td>Branch : Saravanampatti Branch </td>
        </tr>
        <tr>
            <td>Account No :192101000009889</td>
        </tr>
        <tr>    
            <td>IFSC Code :	IOBA0001921 </td>
        </tr>
         
    </table>   
      
    
    
    </td>
    <td valign="top" align="center" style="padding-right:20px;border:0px;">
		<!--<img src="SD-sign.png" border=0 width="130"><br> 
		<img src="sts-sign1.png" border=0 width="130"><br>-  ->
        <br>
        <br>
        <br>
	   For <b>Zazu Technologies</b>-->
	   </td>
  </tr>
   <tr>
		<td colspan="2" style="height:100px;border:0px;">Note:- <em>This is computer generated invoice no signature required</em></td>  
	 </tr>
</table>
<?php } } ?>
</body>
</html>
<?php } ?>