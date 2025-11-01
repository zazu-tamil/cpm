<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/iCheck/all.css"> 
<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.css">
<style>
   #tbl_prt {margin-bottom: 15px;}
   #tbl_prt  th{ border: 1px solid black;}
   #tbl_prt  td{ border: 1px solid black;}
</style>  
<!-- bootstrap datepicker -->
<script src="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url() ?>asset/bower_components/jquery.excelexportjs.js"></script>
<script src="<?php echo base_url() ?>asset/bower_components/jquery.stickyTableHeader.js"></script>
<!--<script src="https://www.jquery-az.com/jquery/js/jquery-stickyTableHeader/jquery.stickyTableHeader.js"></script>-->
<script>
jQuery(function($) {  
    
    $('.sticky-table-demo').stickyTableHeader();
    
    
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
    
    
   
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-green',
      radioClass   : 'iradio_minimal-green'
    });
    
     $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    }); 
    
    $('.select_all').on('ifChecked', function(event) {
    	$('.booking_id').iCheck('check');
    });
    $('.select_all').on('ifUnchecked', function(event) {
    	$('.booking_id').iCheck('uncheck');
    }); 
    
    
    $(".btnexp").click(function(){ 
       
       //alert($(this).attr('id'));
       $("#mjp").excelexportjs({
                    containerid: "mjp",
                    datatype: 'table',
                    worksheetName: $(this).attr('id')
       });
       
     });
    
    
    $("#srch_customer_id").change(function() {  
	   //alert($(this).val());  
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#srch_pattern_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('All Item');
                    $('#srch_pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item );
	                    $('#srch_pattern_id').append(opt1); 
	                });    
                        
                    
                }
                
            });
            
     });
     
     $("#srch_rej_grp").change(function() {  
    
        $("#srch_rej_type_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-rejection-type', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('All Rejection Type');
                    $('#srch_rej_type_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.rejection_type_id);
	                    opt1.text(info.rejection_type_name );
	                    $('#srch_rej_type_id').append(opt1); 
	                });
                }
         });
    });  
       
    
});
</script> 