<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
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
     
     $("#add_modal #customer_id").change(function() {  
	   //alert($(this).val());  
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#add_modal .pattern_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Item');
                    $('#add_modal .pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item );
	                    $('#add_modal .pattern_id').append(opt1); 
	                });    
                        
                    
                }
                
            });
            
     });
     
     
     
     
       
     
     
    /* $("#edit_modal #customer_id").change(function() {  
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
            
     });*/
     
   /*  $("#edit_modal #rej_grp").change(function() {  
    
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
    });*/
    
    $(".edit_record").click(function() {   
      
     $.ajax({
                
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'ms_rework_info', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d);
                    $('#edit_modal #ms_rework_id').val(d.ms_rework_id) ; 
                    $('#edit_modal #rework_date').val(d.rework_date) ;  
                    $('#edit_modal #customer_id').val(d.customer_id) ; 
                    $('#edit_modal #sub_contractor_id').val(d.sub_contractor_id) ; 
                    $('#edit_modal #dc_info').val(d.dc_info) ; 
                    $('#edit_modal #invoice_info').val(d.invoice_info) ; 
                    $('#edit_modal #veh_reg_no').val(d.veh_reg_no) ;  
                    $('#edit_modal input:radio[value="'+ d.status +'"]').prop('checked', true);
                     
                     $.ajax({
                            url: "<?php echo site_url('get-data');?>",
                            type: "post",
                            data: { tbl : 'get-customer-pattern', id: d.customer_id },
                            success: function(d1) { 
                                //alert(d.pattern_id);
                                
                               $("#edit_modal .pattern_id > option").remove();   
                                    
                                var opt1 = $('<option />'); 
                                opt1.val('');
                                opt1.text('Select Item');
                                $('#edit_modal .pattern_id').append(opt1); 
            			
                				$.each(d1,function(key,info) 
            	                {
            	                    var opt1 = $('<option />'); 
            	                    opt1.val(info.pattern_id);
            	                    opt1.text(info.pattern_item );
            	                    $('#edit_modal .pattern_id').append(opt1); 
            	                });    
                                    
                                
                            }
                            
                        });
                    
                    
                    
                    //alert(pat);
                    for (i = 0; i < d['itm'].length; i++) {
                        //alert(d['itm'][i].pattern_id);
                        //alert(i);
                        $('#edit_modal #customer_rejection_itm_id_'+ i).val(d['itm'][i].customer_rejection_itm_id);
                        
                        //$('#pattern_id_'+ i).val(d['itm'][i].pattern_id);
                        //$('#edit_modal #pattern_id_'+ i).find('option[value="'+ d['itm'][i].pattern_id +'"]').attr('selected','selected')
                        //alert($('#pattern_id_'+ i).val());
                        //$('#edit_modal #rej_type_id_'+ i).val(d['itm'][i].rej_type_id);
                        $('#edit_modal #pat_drp_'+ i).html(d['itm'][i].pattern_item); 
                        $('#edit_modal #qty_'+ i).val(d['itm'][i].qty);
                    }
                    
                     
                }
      }); 
                
    });
    
    
    $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'ms_rework_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .master').html(ctnt) ; 
                            
                        }
              });
            
             $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'ms_rework_itm_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .child').html(ctnt) ; 
                            
                        }
              }); 
              
             
      }); 
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'ms_rework_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
     
});
</script>      