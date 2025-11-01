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
        
        
        $("#add_modal #melting_heat_log_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get_work_plan_headcode', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Heat Code');
                    $('#add_modal #melting_heat_log_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.melting_heat_log_id);
	                    opt1.text(info.heat_code + ' || QTY : ' + info.produced_qty );
	                    $('#add_modal #melting_heat_log_id').append(opt1); 
	                });
                }
         });
        
    });    
    
    $("#add_modal #rejection_group").change(function() {  
    
        $("#add_modal #rejection_type_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-rejection-type', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Type');
                    $('#add_modal #rejection_type_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.rejection_type_id);
	                    opt1.text(info.rejection_type_name );
	                    $('#add_modal #rejection_type_id').append(opt1); 
	                });
                }
         });
    });  
    
    
    $("#edit_modal #rejection_group").change(function() {  
    
        $("#edit_modal #rejection_type_id > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-rejection-type', id: $(this).val() },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Type');
                    $('#edit_modal #rejection_type_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.rejection_type_id);
	                    opt1.text(info.rejection_type_name );
	                    $('#edit_modal #rejection_type_id').append(opt1); 
	                });
                }
         });
    });   
    
    $(".edit_record").click(function() {  
     
     $.ajax({
               // url: "send-enquiry.php",
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-qc-inspection-info', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d);
                    $('#edit_modal #pattern').val(d.match_plate_no + '-' + d.pattern_item) ; 
                    $('#edit_modal #qc_inspection_id').val(d.qc_inspection_id) ; 
                    $('#edit_modal #work_planning_id').val(d.work_planning_id) ; 
                    $('#edit_modal #qc_date').val(d.qc_date) ; 
                    $('#edit_modal #rejection_group').val(d.rejection_group)  ; 
                    $('#edit_modal #rejection_qty').val(d.rejection_qty) ;  
                    $('#edit_modal #shift_supervisor').val(d.shift_supervisor) ;  
                    $('#edit_modal #tumblast_machine_operator').val(d.tumblast_machine_operator) ;  
                    $('#edit_modal #shot_blastng_machine_operator').val(d.shot_blastng_machine_operator) ;  
                    $('#edit_modal #ag4_machine_operator').val(d.ag4_machine_operator) ;  
                    $('#edit_modal #contractor_grinding_machine_operator').val(d.contractor_grinding_machine_operator) ;  
                    $('#edit_modal #company_grinding_machine_operator').val(d.company_grinding_machine_operator) ;  
                    $('#edit_modal #painting_person').val(d.painting_person) ;  
                    $('#edit_modal #factory_manager').val(d.factory_manager) ;  
                     
                    
                    
                    $("#edit_modal #rejection_type_id > option").remove();  
                    $.ajax({
                            url: "<?php echo site_url('get-data');?>",
                            type: "post",
                            data: { tbl : 'get-rejection-type', id: d.rejection_group },
                            success: function(d1) {  
                                var opt1 = $('<option />'); 
                                opt1.val('');
                                opt1.text('Select Type');
                                $('#edit_modal #rejection_type_id').append(opt1); 
            			
                				$.each(d1,function(key,info) 
            	                {
            	                      
                                      /*
                                      if(d.rejection_type_id = info.rejection_type_id) {  
            	                           var newOption = new Option(info.rejection_type_name , info.rejection_type_id, false, true);
            	                      } else {
                                           var newOption = new Option(info.rejection_type_name , info.rejection_type_id, false, false);
                                      }
                                      $('#edit_modal #rejection_type_id').append(newOption).trigger('change')  ;
                                      */
                                     
                                     
                                     var opt2 = $('<option />'); 
            	                     opt2.val(info.rejection_type_id);
            	                     opt2.text(info.rejection_type_name );
                                     if(d.rejection_type_id == info.rejection_type_id)
                                        opt2.attr('selected','selected');
           	                         $('#edit_modal #rejection_type_id').append(opt2);
                                     
                                     
                                     
            	                }); 
                            }
                     });
                     
                    
                    $("#edit_modal #melting_heat_log_id > option").remove();      
                      $.ajax({
                            url: "<?php echo site_url('get-data');?>",
                            type: "post",
                            data: { tbl : 'get_work_plan_headcode', id: d.work_planning_id },
                            success: function(d11) {  
                                var opt1 = $('<option />'); 
                                opt1.val('');
                                opt1.text('Select Heat Code');
                                $('#edit_modal #melting_heat_log_id').append(opt1); 
            			
                				$.each(d11,function(key,info) 
            	                {
            	                    var opt1 = $('<option />'); 
            	                    opt1.val(info.melting_heat_log_id);
            	                    opt1.text(info.heat_code + ' || QTY : ' + info.produced_qty );
                                    if(d.melting_heat_log_id == info.melting_heat_log_id)
                                        opt1.attr('selected','selected');
            	                    $('#edit_modal #melting_heat_log_id').append(opt1); 
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
                    data: { tbl : 'qc_inspection_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 