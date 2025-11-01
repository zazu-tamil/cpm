 <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- bootstrap datepicker -->
<script src="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.js"></script> 
<script>
jQuery(function($) { 
   
     
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
    
    
    $('.work_planning_id').click(function() {  
        
        if($(this).is(':checked')){        
            //alert($(this).attr('data-cnt'));
            //alert($(this).val());
            
            $(".qty_" + $(this).attr('data-cnt')).attr('readonly',false);
            $(".qty_" + $(this).attr('data-cnt')).attr('disabled',false);
            
            $(".work_order_id_" + $(this).attr('data-cnt')).attr('disabled',false);
            $(".pattern_id_" + $(this).attr('data-cnt')).attr('disabled',false);
            $(".melting_heat_log_id_" + $(this).attr('data-cnt')).attr('disabled',false);
            $(".heat_code_" + $(this).attr('data-cnt')).attr('disabled',false);
            $(".customer_PO_No_" + $(this).attr('data-cnt')).attr('disabled',false);
            
            
            $(".qty_" + $(this).attr('data-cnt')).val($(this).attr('data-qty'));
            $(".qty_" + $(this).attr('data-cnt')).focus();
        
        } else {
            $(".qty_" + $(this).attr('data-cnt')).attr('readonly',true);
            $(".qty_" + $(this).attr('data-cnt')).attr('disabled',true);
            
            $(".work_order_id_" + $(this).attr('data-cnt')).attr('disabled',true);
            $(".pattern_id_" + $(this).attr('data-cnt')).attr('disabled',true);
            $(".melting_heat_log_id_" + $(this).attr('data-cnt')).attr('disabled',true);
            $(".heat_code_" + $(this).attr('data-cnt')).attr('disabled',true);
            $(".customer_PO_No_" + $(this).attr('data-cnt')).attr('disabled',true);
            
            $(".qty_" + $(this).attr('data-cnt')).val(0);
        }
    }); 
     
        
      
     
});
</script> 