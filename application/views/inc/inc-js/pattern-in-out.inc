<script>
jQuery(function($) { 
    
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
      
    $('#add_modal #customer_id').change(function() {  
        $("#add_modal #pattern_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val(),pattern_type:'' },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $('#add_modal #pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.match_plate_no + ' || ' + info.pattern_item );
	                    $('#add_modal #pattern_id').append(opt1); 
	                });
                }
         });  
     });  
     
     $('#add_modal .pattern_in_out_type').click(function() {  
       // alert($(this).val());
        if($(this).val() == 'Outward')
        {
            $('#add_modal .out_dc').removeClass('hide');
            $('#add_modal .ref_dc_no').removeClass('hide').addClass('hide');
        } else {
            $('#add_modal .out_dc').removeClass('hide').addClass('hide');
            $('#add_modal .ref_dc_no').removeClass('hide');
        }
     }); 
     /*
     
     $('#add_modal #city_code').change(function() {  
        $("#add_modal #servicable_pincode > option").remove();    
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'city-serv-pincode', id: $(this).val() },
                success: function(d) {  
                   /* var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pincode');
                    $('#servicable_pincode').append(opt1);* / 
			
    				 $.each(d,function(key,info) 
    	                {
    	                    //var opt1 = $('<option />'); 
    	                    //opt1.val(info.pincode);
    	                    //opt1.text(info.pincode);
    	                    //$('#servicable_pincode').append(opt1); 
                            var newOption = new Option(info.pincode, info.pincode, false, false);
                            $('#add_modal #servicable_pincode').append(newOption).trigger('change');
    	                });  
                        
                       /* $(".servicable_pincode").select2({
                          data: d
                        })* /
                        
                        
                }
         });
          
     }); */

     $(".edit_record").click(function() {  
           // alert($(this).val());
          
          
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'get-pattern-in-out', id: $(this).val() },
            success: function(d) {  
              //  alert(d.customer_id);
              $('#edit_modal #pattern_in_out_id').val(d.pattern_in_out_id) ;     
              $('#edit_modal #pattern_in_out_date').val(d.pattern_in_out_date) ;   
              $('#edit_modal #dc_no').val(d.dc_no) ;   
              $('#edit_modal #customer_id').val(d.customer_id).change() ;   
              $('#edit_modal #pattern_maker_id').val(d.pattern_maker_id) ;   
              $('#edit_modal #reason').val(d.reason) ;   
              $('#edit_modal #dc_ref_no').val(d.dc_ref_no) ;    
              $('#edit_modal #dc_ref_date').val(d.dc_ref_date) ;   
              $('#edit_modal .pattern_in_out_type').click(); 
              $('#edit_modal input:radio[value="'+ d.pattern_in_out_type +'"]').prop('checked', true); 
              
               
             
              $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: d.customer_id },
                success: function(d1) {  
                    $("#edit_modal #pattern_id > option").remove(); 
                    var opt1 = $('<option />'); 
                    opt1.val('0');
                    opt1.text('Select Pattern Item');
                    $('#edit_modal #pattern_id').append(opt1); 
			
    				$.each(d1,function(key,info) 
	                {
	                      if(d.pattern_id == info.pattern_id) {  
	                           var newOption1 = new Option(info.pattern_item , info.pattern_id, false, true);
	                      } else {
                               var newOption1 = new Option(info.pattern_item , info.pattern_id, false, false);
                          }
                         $('#edit_modal #pattern_id').append(newOption1).trigger('change')  ;
	                }); 
                   
                    }
                });  
                
                
              
              
            }
         });
         
     });
     
     $('#edit_modal .pattern_in_out_type').click(function() {  
       // alert($(this).val());
        if($(this).val() == 'Outward')
        {
            $('#edit_modal .out_dc').removeClass('hide');
            $('#edit_modal .ref_dc_no').removeClass('hide').addClass('hide');
        } else {
            $('#edit_modal .out_dc').removeClass('hide').addClass('hide');
            $('#edit_modal .ref_dc_no').removeClass('hide');
        }
     }); 
     
     
     $('#edit_modal #customer_id').change(function() {  
        $("#edit_modal #pattern_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $('#edit_modal #pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item);
	                    $('#edit_modal #pattern_id').append(opt1); 
	                });
                }
         });  
     });
     
     
     
     //pattern_in_out_ward_info
      $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'pattern_in_out_ward_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
          
      
     
});
</script>