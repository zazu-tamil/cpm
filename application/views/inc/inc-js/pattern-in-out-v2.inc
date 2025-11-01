<script>
jQuery(function($) { 
    
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
      
    $('#add_modal .customer_id').change(function() {  
        //alert($(this).attr('data'));
        //alert($(this).val());
        var tx = "#add_modal #pattern_id_" + $(this).attr('data');
       
        $("#add_modal #pattern_id_" + $(this).attr('data') + " > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val(),pattern_type:'' },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item'); 
                    $(tx).append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.match_plate_no + ' || ' + info.pattern_item ); 
                        $(tx).append(opt1); 
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
            //alert($(this).val()); 
          
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'get-pattern-in-out-v2', id: $(this).val() },
            success: function(d) {  
               //alert(d.length);
             // $('#edit_modal #pattern_in_out_id').val(d.pattern_in_out_id) ;     
              $('#edit_modal #pattern_in_out_date').val(d[0].pattern_in_out_date) ; 
              $('#edit_modal #pattern_maker_id').val(d[0].pattern_maker_id) ;  
              $('#edit_modal #dc_no').val(d[0].dc_no) ; 
              $('#edit_modal #dc_ref_no').val(d[0].dc_ref_no) ;    
              $('#edit_modal #dc_ref_date').val(d[0].dc_ref_date) ;   
              $('#edit_modal #vehicle_no').val(d[0].vehicle_no) ;   
              $('#edit_modal .pattern_in_out_type').click(); 
              $('#edit_modal input:radio[value="'+ d[0].pattern_in_out_type +'"]').prop('checked', true); 
              
                
               
                var i;
                var j=1;
                for (i = 0; i < d.length; i++) {  
                    var cx = "#edit_modal #customer_id_" + (i+1);
                    $(cx).val(d[i].customer_id)  ;  
                    $('#edit_modal #reason_' + (i+1)).val(d[i].reason) ; 
                    $('#edit_modal #pattern_in_out_id_' + (i+1)).val(d[i].pattern_in_out_id) ;  
                    
                    if(d[i].show_cavity == '1')
                        $('#edit_modal #show_cavity_' + (i+1)).prop('checked', true); 
                       
                    if(d[i].show_core_box == '1')
                        $('#edit_modal #show_core_box_' + (i+1)).prop('checked', true); 
                      
                    
                    $("#edit_modal #pattern_id_"+ j +" > option").remove(); 
                    var opt1 = $('<option />'); 
                    opt1.val('0');
                    opt1.text('Select Pattern Item');
                    var px = "#edit_modal #pattern_id_" + j ;  
                    $(px).append(opt1);
                    
                    task(d[i].pattern_id , d[i].customer_id , px);  
                    
                 j++;   
                     
                } 
              
              
            }
         });
         
     });
     
     function task(pid,cid , pi) { 
        
         $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: cid },
                success: function(d1) {   
			          
    				$.each(d1,function(key,info) 
	                { 
                        var opt1 = $('<option />'); 
                        opt1.val(info.pattern_id);
                        opt1.text(info.pattern_item);
                        if(pid == info.pattern_id) 
                            opt1.attr('selected', true);
                        $(pi).append(opt1);
	                });  
                   
                    } 
           }); 
     }
     
     
     
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
     
     
     $('#edit_modal .customer_id').change(function() {  
        var tx = "#edit_modal #pattern_id_" + $(this).attr('data');
       
        $("#edit_modal #pattern_id_" + $(this).attr('data') + " > option").remove(); 
             
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $(tx).append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item);
	                    $(tx).append(opt1); 
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