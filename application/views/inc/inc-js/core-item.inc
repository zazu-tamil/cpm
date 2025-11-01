<script>
jQuery(function($) {    
    
    
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
	                    opt1.text(info.pattern_item );
	                    $('#add_modal #pattern_id').append(opt1); 
	                });
                }
         });  
     });  
     
     $('#add_modal #pattern_id').change(function() {  
            $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-pattern-info', id: $(this).val()  },
                success: function(d) {  
                    $('#add_modal #core_weight').val(d.core_weight) ;   
                    $('#add_modal #core_maker_rate').val(d.core_maker_rate) ; 
                    $('#add_modal #core_maker_id').val(d.core_maker_id) ; 
                }
         });  
     });
     
     $('#edit_modal #customer_id').change(function() {  
        $("#edit_modal #pattern_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val(),pattern_type:'' },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
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

    $(".edit_record").click(function() {  
     
     
     $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'core_item_info', id: $(this).val() },
            success: function(d) {
                //alert(d.customer_id);
                $('#edit_modal #core_item_id').val(d.core_item_id);
                $('#edit_modal #customer_id').val(d.customer_id);
                $('#edit_modal #core_weight').val(d.core_weight); 
                $('#edit_modal #core_per_box').val(d.core_per_box); 
                $('#edit_modal #core_item_name').val(d.core_item_name); 
                $('#edit_modal input:radio[value="'+ d.status +'"]').prop('checked', true);
                
                $("#edit_modal #pattern_id > option").remove();      
                $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern',id: d.customer_id, pattern_type:'Core' },
                success: function(d1) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $('#edit_modal #pattern_id').append(opt1); 
			
    				$.each(d1,function(key,info) 
	                {
	                    var opt2 = $('<option />'); 
	                    opt2.val(info.pattern_id);
	                    opt2.text(info.pattern_item);
                        if(d.pattern_id == info.pattern_id) 
                            opt2.attr('selected','selected');
	                    $('#edit_modal #pattern_id').append(opt2); 
	                });
                }
                });
                
                 
                
                
             }
                 
            });
      
                
    });
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'core-item', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 