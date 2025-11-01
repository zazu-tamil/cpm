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
                data: { tbl : 'get-customer-pattern', id: $(this).val()  },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $('#add_modal #pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item);
	                    $('#add_modal #pattern_id').append(opt1); 
	                });
                }
         });  
     }); 
     
     
    $('#add_modal #pattern_id').change(function() {    
        $("#add_modal #core_item_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-pattern-core-item', id: $(this).val()  },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Core Item');
                    $('#add_modal #core_item_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.core_item_id);
	                    opt1.text(info.core_item_name);
                        //opt1.attr('data-rate',info.core_maker_rate);
	                    $('#add_modal #core_item_id').append(opt1); 
	                });
                }
         });  
     }); 
     
         

    $(".edit_record").click(function() {   
      
     $.ajax({
                
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'core-plan', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d);
                    $('#edit_modal #core_plan_id').val(d.core_plan_id) ; 
                    $('#edit_modal #core_plan_date').val(d.core_plan_date) ; 
                    $('#edit_modal #customer_id').val(d.customer_id) ; 
                    
                    $("#edit_modal #pattern_id > option").remove();      
                      $.ajax({
                            url: "<?php echo site_url('get-data');?>",
                            type: "post",
                            data: { tbl : 'get-customer-pattern', id: d.customer_id,  pattern_type:"Core" },
                            success: function(d1) {  
                                var opt1 = $('<option />'); 
                                opt1.val('');
                                opt1.text('Select  Item');
                                $('#edit_modal #pattern_id').append(opt1); 
            			
                				$.each(d1,function(key,info) 
            	                {
            	                    var opt1 = $('<option />'); 
            	                    opt1.val(info.pattern_id);
            	                    opt1.text(info.pattern_item);
                                    if(d.pattern_id == info.pattern_id)
                                        opt1.attr('selected','selected');
            	                    $('#edit_modal #pattern_id').append(opt1); 
            	                });
                            }
                     });  
                   
                   
                    $("#edit_modal #core_item_id > option").remove();      
                      $.ajax({
                            url: "<?php echo site_url('get-data');?>",
                            type: "post",
                            data: { tbl : 'get-pattern-core-item', id: d.pattern_id ,core_maker_id: d.core_maker_id },
                            success: function(d2) {  
                                var opt1 = $('<option />'); 
                                opt1.val('');
                                opt1.text('Select Core Item');
                                $('#edit_modal #core_item_id').append(opt1); 
            			
                				$.each(d2,function(key,info2) 
            	                {
            	                    var opt12 = $('<option />'); 
            	                    opt12.val(info2.core_item_id);
            	                    opt12.text(info2.core_item_name);
                                    opt12.attr('data-rate',info2.core_maker_rate);
                                    if(d.core_item_id == info2.core_item_id)
                                        opt12.attr('selected','selected');
            	                    $('#edit_modal #core_item_id').append(opt12); 
            	                });
                            }
                     });  
                    
                     
                    $('#edit_modal #produced_qty').val(d.produced_qty) ; 
                    $('#edit_modal #damage_qty').val(d.damage_qty) ; 
                    $('#edit_modal #core_maker_rate').val(d.core_maker_rate) ;  
                     
                }
      }); 
                
    });
    
    
     
     
      $('.del_record_cfs').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'floor-stock', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     }); 
     
      

});
</script> 