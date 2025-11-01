<?php
  include_once("../include/dbcommon.php");

if (!isset($_SESSION['UserID']))
{
    $_SESSION["MyURL"] = "printing/Invoice-List.php";
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

	$monate = array(
                 4=>"April",
                 5=>"May",
                 6=>"June",
                 7=>"July",
                 8=>"August",
                 9=>"September",
                 10=>"October",
                 11=>"November",
                 12=>"December",
                 1=>"January",
                 2=>"February",
                 3=>"March");
  
  
 // print_r($monate);
	
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice List</title>
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css"/> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<script type="text/javascript" src="js/jquery.validate.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!--<script type="text/javascript" src="http://fancybox.net/js/fancybox-1.3.4/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="http://fancybox.net/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" /> -->
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
-->
<style>
	body {font-family: verdana; font-size: 11px;}
    .brd-lft {border-left:1px solid black;}
	.rept td{padding-right:10px;text-align:left;border-right:1px solid black; border-bottom:1px solid black;text-align: right;}
	.rept th{padding-right:10px;text-align:left;border-right:1px solid black;border-bottom:1px solid black;text-align: right;}
	.error {color:red;}
	.noborder {border:0px;}
	.tot th{ border-top:1px solid black;}
	strong {font-size:14px;} 
    fieldset {border:1px solid black;margin-top: 10px;} 
</style>
<style media="print">
#srch ,#prnt_btn , .asebtn{ display:none;}
fieldset {border:0px;} 
body {font-family: verdana; font-size: 11px;}
.brd-lft {border-left:1px solid black;}
	.rept td{padding-right:10px;text-align:left;border-right:1px solid black; border-bottom:1px solid black;text-align: right;}
	.rept th{padding-right:10px;text-align:left;border-right:1px solid black;border-bottom:1px solid black;text-align: right;}
/*.rept td {border-bottom:1px solid black;border-left:1px solid black;padding-left:5px;}
.rept th {border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;}*/
/* body {font-size: 6pt;line-height: 12pt; font-weight:bold; font-family:'MS Serif',"Calibri","Terminal","Times New Roman"; letter-spacing:0.5em; }*/

</style>
 
<script>


jQuery(function($) {    
    
$(".btn_add_credit").click(function(){
   // alert($(this).attr('data'));
    $('#add_modal #project_invoice_id').val($(this).attr('data'));
    //$('#add_modal').modal("show");
 }); 
 
 $("#add_modal #btn_save").click(function(){ 
    //alert('hi' + $('#add_modal #credit_note_date').val());
        $.ajax({
                url: "/mobile_office/index.php/insert-data",
                type: "post",
                data: { tbl:'project_credit_note_info',project_invoice_id: $('#add_modal #project_invoice_id').val(),credit_note_date: $('#add_modal #credit_note_date').val() },
                success: function(d) {  
                    alert(d);
                    location.reload();
                }
             }); 
     //alert('hi' + $('#add_modal #project_invoice_id').val());        
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
 /*
 $(".fancy").fancybox({
        'titleShow'     : true,
        'titlePosition'  : 'inside',
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
		'easingIn'      : 'easeOutBack',
		'easingOut'     : 'easeInBack'
 });
 
*/


 
 
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
			<table align="center" border="1" cellpadding="5" cellspacing="0" width="60%" >
				<tr>
					<th colspan="2"><center><b>Invoice List</b></center></th>
				</tr>
                <tr>
					<td width="50%" align="right">Financial Year Wise</td>
					<td>
						<select name="fyr" class="" id="fyr">
							<option value="">Select Financial Year</option>
							<?php 
								$sql_op = "	select  fiscal_year(q.invoice_date) as f_yr  from project_invoice as q group by  fiscal_year(q.invoice_date) order by  fiscal_year(q.invoice_date) desc ";
							  $res= mysql_query($sql_op);
							  $num_rows = mysql_num_rows($res);

							while($row = mysql_fetch_assoc($res)){
								 echo '<option value="'.$row["f_yr"].'"';
								 if((isset($_POST['fyr'])) && ($_POST['fyr'] == $row["f_yr"]))
									echo ' selected ';						
								 echo '>'.$row["f_yr"].'</option>';
							}
							?>
						</select>
                         
					</td>
				</tr>
                <tr>
                    <td align="right">Company</td>
                    <td>
                        <select name="company_id" class="">
                            <option value="">All Company</option>
                		 <?php 
                            $sql_op = " select a.company_id , a.company_name , a.GST from company as a where a.status='Active' and a.company_id not in (6,7) order by a.company_name asc ";
                            $res = mysql_query($sql_op);
                            $num_rows = mysql_num_rows($res);
                            
                            while ($row = mysql_fetch_assoc($res))
                            {
                                echo '<option value="' . $row["company_id"] . '"';
                                if ((isset($_POST['company_id'])) && ($_POST['company_id'] == $row["company_id"]))
                                    echo ' selected ';
                                echo '>' . $row["company_name"]   . '</option>';
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
					<td width="50%" align="right" >Customer</td>
					<td>
						<select name="customer_id" class="" id="customer_id">
							<option value="">All customer</option>
							<?php 
								$sql_op = "	select customer_id, company_name from customer_master where status = 'Active' order by company_name asc	";
							  $res= mysql_query($sql_op);
							  $num_rows = mysql_num_rows($res);

							while($row = mysql_fetch_assoc($res)){
								 echo '<option value="'.$row["customer_id"].'"';
								 if((isset($_POST['customer_id'])) && ($_POST['customer_id'] == $row["customer_id"]))
									echo ' selected ';						
								 echo '>'.$row["company_name"].'</option>';
							}
							?>
						</select> 
					</td>
				</tr>
                <?php /*
                <tr>
                    <td align="right">Month</td>
                    <td align="left">
                        <select name="f_month">
                            <option value="">All Month</option> 
                            <?php 
                            foreach ($monate as $key => $mon)
                            {
                                echo ' <option value="'. $mon.'"';
                                if(isset($_POST['f_month']) && $_POST['f_month'] == $mon)
                                  echo ' selected ';
                                echo ' >'. $mon .'</option> ';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                */ ?>
                <tr>
					<td align="right">GST Invoice</td>
					<td align="left"><input type="checkbox" name="GST" value="1" <?php if($_POST['GST'] == '1') echo " Checked "; else echo " Checked ";  ?> /></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="Report" value="Show Report"></td>
				</tr>	
			</table>
		</td>
	</tr>
</table>

</form>
<br>
</div>
<?php
if(isset($_POST['Report'])) {
    
    $whr = $whr1 =  " ";
    
    if($_POST['company_id'] != '') 
    {
        $whr .= " and  a.company_id = '". $_POST['company_id'] ."'";
        $whr1 .= " and q.company = '". $_POST['company_id'] ."'"; 
    }
    /*if($_POST['f_month'] != '') 
    {
        $whr .= " and  date_format(a.invoice_date,'%M') = '". $_POST['f_month'] ."'";
        $whr1 .= " and date_format(q.invoice_date,'%M') = '". $_POST['f_month'] ."'"; 
    }*/
    
    if($_POST['from_date'] != '') 
    {
        $whr .= " and a.invoice_date between '". $_POST['from_date'] ."' and '". $_POST['to_date'] ."'";
        $whr1 .= " and q.invoice_date between '". $_POST['from_date'] ."' and '". $_POST['to_date'] ."'"; 
    }
        
        
    
  $sql_op = "    
         select 
            invoice_id,
            module,
            invoice_date,
            inv.company,
            heading,
            invoice_no,
            CEILING(invoice_amount) as  invoice_amount,
            gst,
            inv.bank_id,
            h.account_no,
            credit_note_no,
            credit_note_date
            from  (
            (
            select 
            a.invoice_id,
            'ERP' as module,
            a.invoice_date,
            b.company_name as company,
            get_order_head(a.order_id) as heading, 
            a.invoice_no,
            a.invoice_amount,
            0 as gst,
            a.bank_id,
            '' as credit_note_no,
            '' as credit_note_date
            from erp_invoice as a
            left join company as b on b.company_id = a.company_id
            where fiscal_year(a.invoice_date) = '". $_POST['fyr'] ."' 
            and a.print_withtax_group = '". ($_POST['GST'] == '1'? 1: 0)."' 
            ". $whr ."
            and (". ( (isset($_POST['customer_id']) and ($_POST['customer_id'] != '') ) ? ' a.customer_id = "'. $_POST['customer_id'] .'"' : '1') ." )
            order by a.company_id, a.invoice_no asc ) 
            union all (
            select 
            q.project_invoice_id as invoice_id,
            'Project' as module,
            q.invoice_date,
            w.company_name as company,
            get_project_det(q.project) as heading,
            q.invoice_no,
            q.total_cost as invoice_amount,
            b.gst,
            q.bank_id,
            z.credit_note_no,
            z.credit_note_date
            from project_invoice as q
            left join company as w on w.company_id = q.company
            left join project_master as f on f.project_id = q.project
            left join ( select q.project_id , sum( q.amount_with_tax -  q.amount ) as gst from project_specification as q where 1=1 group by q.project_id ) as b on b.project_id = q.project
            left join project_credit_note_info as z on z.project_invoice_id = q.project_invoice_id
            where fiscal_year(q.invoice_date) = '". $_POST['fyr'] ."' 
            and q.print_tax_group = '". ($_POST['GST'] == '1'? 1: 0)."'
             ". $whr1 ."
            and (". ( (isset($_POST['customer_id']) and ($_POST['customer_id'] != '') ) ? ' q.customer = "'. $_POST['customer_id'] .'"' : '1') ." ) 
            and f.status not in( 14 )
            order by q.company, q.invoice_no asc )
            
            union all (
            select 
            a.project_merge_invoice_id as invoice_id, 
            'Project Merge' as module,
            a.invoice_date,
            w.company_name  as company,
            concat(a.project_merge_invoice_id,' => ',get_customer(a.customer_id),' => ', a.project_id) as heading,
            a.invoice_no,
            a.invoice_amount ,
            0 as gst,
            a.bank_id,
            '' as credit_note_no,
            '' as credit_note_date
            from project_merge_invoice_info as a
            left join company as w on w.company_id = a.company_id
            where fiscal_year(a.invoice_date) = '". $_POST['fyr'] ."'  
             ". $whr ."
            and (". ( (isset($_POST['customer_id']) and ($_POST['customer_id'] != '') ) ? ' a.customer_id = "'. $_POST['customer_id'] .'"' : '1') ." )
            order by a.company_id, a.invoice_no asc )
            union all (
            
            select 
            a.quick_invoice_id as invoice_id, 
            'Direct Invoice' as module,
            a.invoice_date,
            w.company_name  as company,
            concat(a.quick_invoice_id,' => ',get_customer(a.customer_id),' => ', a.your_ref_no , ' => ' , a.remarks) as heading,
            a.invoice_no,
            sum(b.amount) invoice_amount ,
            0 as gst,
            0 as bank_id,
            '' as credit_note_no,
            '' as credit_note_date
            from quick_invoice as a
            left join company as w on w.company_id = a.company_id
            left join quick_invoice_item as b on b.quick_invoice_id = a.quick_invoice_id
            where fiscal_year(a.invoice_date) = '". $_POST['fyr'] ."'  
            ". $whr ."
            and a.invoice_date >= '2018-02-15'
            and (". ( (isset($_POST['customer_id']) and ($_POST['customer_id'] != '') ) ? ' a.customer_id = "'. $_POST['customer_id'] .'"' : '1') ." )
            group by a.quick_invoice_id
            order by a.company_id, a.invoice_no asc
            )
            
            ) as inv
            left join bank_master as h on h.bank_id = inv.bank_id
            order by inv.company asc, inv.invoice_no desc
  
            
        ";
   
   /*
    union all (
            select 
            a.project_merge_invoice_id as invoice_id, 
            'Project Merge' as module,
            a.invoice_date,
            w.company_name  as company,
            concat(a.project_merge_invoice_id,' => ',get_customer(a.customer_id),' => ', a.project_id) as heading,
            a.invoice_no,
            a.invoice_amount 
            from project_merge_invoice_info as a
            left join company as w on w.company_id = a.company_id
            where fiscal_year(a.invoice_date) = '". $_POST['fyr'] ."'  
            and ". $whr ."
            order by a.company_id, a.invoice_no asc )
            
             
   */
	/*echo "<pre>";
	echo $sql_op;	
    echo "</pre>";*/
		
    $res= mysql_query($sql_op);
    //$data_field['Staff Attendance'][]=  mysql_field_name($sql_op);
	$num_rows = mysql_num_rows($res);
    
    $total_inv = array();
    if($num_rows > 0) {
	while($row = mysql_fetch_assoc($res)){
		$data[$row['company']][] = $row;	 	
		$total_inv[$row['company']] += $row['invoice_amount'];	 	
	}
    /*echo "<pre>";
    print_r($total_inv);
    echo "</pre>";
    
    echo max($total_inv);*/
    ?>
    
     
    <center><h3>Invoice List For Financial Year <?php echo  $_POST['fyr'] ; ?></h3></center>
    <?php 
     
    foreach($data as $company=> $vat_info) {
    
   ?>
            <table align="center" cellpadding="3" cellspacing="0" width="98%" border="0" class="rept">
               <thead>
                   <tr>
                        <th colspan="14" style="text-align: left;border-bottom:1px solid black;border-right:0px; "> <?php echo  " Company : ". $company  ; ?></th>
                   </tr>
                   <tr> 
                     <th class="brd-lft">Invoice No</th>
                     <th>Invoice Date</th>
                     <th>Module</th>
                     <th>Heading</th> 
                     <th>Invoice Value</th>                    
                     <th>GST Value</th>                    
                     <th>Bank A/c</th>                    
                     <th class="asebtn" colspan="2">Action</th>
                     <th>Credit<br />Note</th>
                   </tr>
               </thead> 
               <tbody>
                <?php  
                    $tot =array();
                foreach($vat_info as $k => $vat_det) {  ?> 
                    <tr>
                        <td class="brd-lft"><?php echo $vat_det['invoice_no'] ;?></td>
                        <td><?php echo date('d-m-Y', strtotime($vat_det['invoice_date']));?></td>
                        <td><?php echo $vat_det['module'] ;?></td>
                        <td style="text-align: left;"><?php echo $vat_det['heading'] ;?></td> 
                        <td><?php echo number_format($vat_det['invoice_amount'],2); $tot['bill_amount'] += $vat_det['invoice_amount']; ?></td>
                        <td><?php echo number_format($vat_det['gst'],2); $tot['gst'] += $vat_det['gst']; ?></td>
                        <td><?php echo $vat_det['account_no'] ;?></td>
                        <td class="asebtn">
                            <a href="../../<?php 
                                if($vat_det['module'] == 'ERP') 
                                    echo "erp/erp_invoice_edit.php?editid1=".$vat_det['invoice_id'] ; 
                                elseif ($vat_det['module'] == 'Project' ) 
                                    echo "project/project_invoice_edit.php?editid1=".$vat_det['invoice_id'] ; 
                                elseif ($vat_det['module'] == 'Direct Invoice' ) 
                                    echo "direct/quick_invoice_edit.php?editid1=".$vat_det['invoice_id'] ;
                                    
                                ?>" target="_blank" ><?php if ($vat_det['module'] == 'Project Merge' ) echo ""; else echo "Edit" ?>
                            </a>                         
                        </td>
                        <td class="asebtn">
                            <a href="../../<?php
                                if($vat_det['module'] == 'ERP') 
                                    echo "erp/erp_invoice_view.php?editid1=".$vat_det['invoice_id'] ; 
                                elseif ($vat_det['module'] == 'Project' ) 
                                    echo "project/printing/inv_com.php?id=".$vat_det['invoice_id'] ; 
                                elseif ($vat_det['module'] == 'Project Merge' ) 
                                    echo "project/printing/print_invoice.php?id=".$vat_det['invoice_id'] ;
                                elseif ($vat_det['module'] == 'Direct Invoice' )     
                                    echo "direct/print/invoice.php?id=" .$vat_det['invoice_id']
                                    
                                ?>" target="_blank" >View
                            </a>                         
                        </td>
                        <td>
                            <?php if($vat_det['credit_note_no']== '') {?>
                            <a href="" class="btn-link btn_add_credit" data-toggle="modal" data-target="#add_modal" data="<?php echo $vat_det['invoice_id'] ;?>">Add</a></td>
                            <?php } else { ?>
                                <?php echo $vat_det['credit_note_no'] ;?><br /><?php echo $vat_det['credit_note_date'] ;?>
                            <?php } ?>
                    </tr>
                <?php  }  ?>
                <tr>
                    <th colspan="4" class="brd-lft">Total</th>
                    <th><?php echo number_format($tot['bill_amount'],2) ;?></th>                     
                    <th><?php echo number_format($tot['gst'],2) ;?></th>                     
                    <th class="asebtn"></th> 
                    <th class="asebtn"></th> 
                    <th class="asebtn"></th> 
                    <th class="asebtn"></th> 
                </tr>
               </tbody>         
            </table>
            <br />
            <br />
            
 <?php }  ?> 
 <?php if($_POST['company_id'] == '') { ?> 
            <table align="center" cellpadding="3" cellspacing="0" width="98%" border="1">
               <thead> 
                   <tr> 
                     <th align="right">Company</th>
                     <th align="right">Invoice Amount</th>
                     <th align="right">Difference</th> 
                   </tr>
               </thead> 
               <tbody>
                <?php 
                $summ = 0;
                foreach($total_inv as $com => $amt) { 
                $summ += $amt;    
                ?>
                    <tr>
                        <td align="right"><b><?php echo $com; ?></b></td>
                        <td align="right"><?php echo number_format($amt ,2); ?></td>
                        <td align="right"><?php echo number_format(($amt - max($total_inv)) ,2); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th align="right">Total</th>
                    <th align="right"><?php echo number_format($summ ,2); ?></th>
                    <th></th>
                </tr>
               </tbody>
             </table> 
    <?php }  ?>  
 <?php } ?>
    <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form method="post" action="" id="frmadd">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Add Credit Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <input type="hidden" name="mode" value="Add Credit Note" />
                    <input type="hidden" name="project_invoice_id" id="project_invoice_id" value="" />
                </div>
                <div class="modal-body">
                     <div class="form-group">
                        <label>Credit Note Date</label>
                        <input class="form-control" type="date" name="credit_note_date" id="credit_note_date" value="">                                             
                     </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                    <input type="button" name="Save" value="Save"  class="btn btn-primary " id="btn_save" />
                </div> 
                </form>
            </div>
        </div>
    </div> 
 <?php } ?>
 </body>
 </html>