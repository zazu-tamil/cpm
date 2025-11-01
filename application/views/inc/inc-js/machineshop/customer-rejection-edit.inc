<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
    


     
     $("#frm #customer_id").change(function() {  
	   //alert($(this).val());  
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#frm .pattern_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Item');
                    $('#frm .pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item );
	                    $('#frm .pattern_id').append(opt1); 
	                });    
                        
                    
                }
                
            });
            
     });
     
     
     
     
      $("#frm #rej_grp").change(function() {  
    
        $("#frm .rej_type_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-rejection-type', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Rejection Type');
                    $('#frm .rej_type_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.rejection_type_id);
	                    opt1.text(info.rejection_type_name );
	                    $('#frm .rej_type_id').append(opt1); 
	                });
                }
         });
    }); 
     
     
      $("#edit_modal #customer_id").change(function() {  
	   //alert($(this).val());  
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#edit_modal #pattern_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Item');
                    $('#edit_modal #pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item );
	                    $('#edit_modal #pattern_id').append(opt1); 
	                });    
                        
                    
                }
                
            });
            
     }); 
     
      $("#edit_modal #rej_grp").change(function() {  
    
        $("#edit_modal .rej_type_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-rejection-type', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Rejection Type');
                    $('#edit_modal .rej_type_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.rejection_type_id);
	                    opt1.text(info.rejection_type_name );
	                    $('#edit_modal .rej_type_id').append(opt1); 
	                });
                }
         });
    }); 
    
     
    
    
    
    
     
});
</script>      