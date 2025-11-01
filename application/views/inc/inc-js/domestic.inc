<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/iCheck/all.css">
<script src="<?php echo base_url() ?>asset/plugins/iCheck/icheck.min.js"></script>
<script>
jQuery(function($) { 
    
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-green',
      radioClass   : 'iradio_minimal-green'
    });
    
     $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    });
    
    
    $(".edit_record").click(function() {  
     
      var c_1 = $(this).closest('tr').find('td').eq(2).text().toString();
	  var c_2 = $(this).closest('tr').find('td').eq(3).text();  
	  var c_3 = $(this).closest('tr').find('td').eq(4).text();  
	  var c_4 = $(this).closest('tr').find('td').eq(5).text();  
	  var c_5 = $(this).closest('tr').find('td').eq(6).text();  
	  var c_6 = $(this).closest('tr').find('td').eq(7).text();  
	   
      //alert($(this).attr('data')); 
      
      if(c_1 == 1)  { 
        $("#edit_modal #flg_state").prop('checked',true).iCheck('update');  
      
      } else {
        $("#edit_modal #flg_state").prop('checked',false).iCheck('update');  
      }
        
       if(c_2 == 1){ 
        $("#edit_modal #flg_city").prop('checked',true).iCheck('update');       
      
      } else {
        $("#edit_modal #flg_city").prop('checked',false).iCheck('update'); 
      }
        
    
      
          $('#edit_modal #min_weight').val(c_3) ; 
          $('#edit_modal #min_charges').val(c_4) ; 
          $('#edit_modal #addt_weight').val(c_5) ; 
          $('#edit_modal #addt_charges').val(c_6) ;
          $('#edit_modal #domestic_rate_id').val($(this).val()) ;  
          $('#edit_modal #c_type').val($(this).attr('data')) ;  
         // alert($(this).attr('data')) ;  
       
       
                
    });
    

});

</script>