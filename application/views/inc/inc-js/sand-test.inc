<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });  

    $(".add_record").click(function() {  
        //alert($(this).closest('tr').find('td').eq(4).text());
        $('#frmadd #work_planning_id').val($(this).val());
        $('#frmadd #pattern').val($(this).closest('tr').find('td').eq(3).text());
    });    
    
    $("#add_modal #customer_id").change(function() {  
    
        $("#add_modal #pattern_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get_customer_plan_item', id: $(this).val() , planning_date : $('#add_modal #planning_date').val(), shift: $('#add_modal #shift').val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Item');
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
    
    
    $("#edit_modal #customer_id").change(function() {  
    
        $("#edit_modal #pattern_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get_customer_plan_item', id: $(this).val() , planning_date : $('#edit_modal #planning_date').val(), shift: $('#edit_modal #shift').val() },
                success: function(d) {  
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
    
      
    
    $(".edit_record").click(function() {  
     
     $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'system_sand_register_info', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d);
                    $('#edit_modal #system_sand_register_id').val(d.system_sand_register_id) ; 
                    $('#edit_modal #planning_date').val(d.planning_date) ; 
                    $('#edit_modal #shift').val(d.shift) ; 
                    $('#edit_modal #test_time').val(d.test_time) ; 
                    $('#edit_modal #customer_id').val(d.customer_id)  ; 
                    $('#edit_modal #temp').val(d.temp) ;  
                    $('#edit_modal #com').val(d.com) ;  
                    $('#edit_modal #moi').val(d.moi) ;  
                    $('#edit_modal #permeability').val(d.permeability) ;  
                    $('#edit_modal #green_comp_strength').val(d.green_comp_strength) ;  
                    $('#edit_modal #volatile_matter').val(d.volatile_matter) ;  
                    $('#edit_modal #loss_on_ignition').val(d.loss_on_ignition) ;  
                    $('#edit_modal #active_clay').val(d.active_clay) ;  
                    $('#edit_modal #total_clay').val(d.total_clay) ;  
                    $('#edit_modal #dead_clay').val(d.dead_clay) ;  
                    $('#edit_modal #new_sand').val(d.new_sand) ;  
                    $('#edit_modal #bentonite').val(d.bentonite) ;  
                    $('#edit_modal #coal_dust').val(d.coal_dust) ;  
                    $('#edit_modal #remarks').val(d.remarks) ;  
                     
                    $("#edit_modal #pattern_id > option").remove();      
                      $.ajax({
                            url: "<?php echo site_url('get-data');?>",
                            type: "post",
                            data: { tbl : 'get_customer_plan_item', id: d.customer_id , planning_date : d.planning_date, shift: d.shift },
                            success: function(d1) {  
                                var opt1 = $('<option />'); 
                                opt1.val('');
                                opt1.text('Select Item');
                                $('#edit_modal #pattern_id').append(opt1); 
            			
                				$.each(d1,function(key,info) 
            	                {
            	                    var opt1 = $('<option />'); 
            	                    opt1.val(info.pattern_id);
            	                    opt1.text(info.pattern_item );
                                    if(d.pattern_id == info.pattern_id)
                                    opt1.attr('selected','selected');
            	                    $('#edit_modal #pattern_id').append(opt1); 
            	                });
                            }
                     });
                    
                    
                    
                    
                }
      }); 
       
                
    });
    
    
    /*$(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'melting_log_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body').html(ctnt) ; 
                            
                        }
              });
              
             
      });*/ 
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'system_sand_register_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 