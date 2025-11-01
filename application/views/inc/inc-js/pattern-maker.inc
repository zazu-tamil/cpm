<script>
jQuery(function($) { 
      
     
      
      

     $(".edit_record").click(function() {  
          //  alert($(this).val());
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'get-pattern-maker', id: $(this).val() },
            success: function(d) {  
              //  alert(d.company_name);
              $('#edit_modal #pattern_maker_id').val(d.pattern_maker_id) ;     
              $('#edit_modal #company_name').val(d.company_name) ;     
              $('#edit_modal #contact_person').val(d.contact_person) ;     
              $('#edit_modal #address_line').val(d.address_line) ;   
              $('#edit_modal #area').val(d.area) ;   
              $('#edit_modal #city').val(d.city) ; 
              $('#edit_modal #pincode').val(d.pincode) ;
              $('#edit_modal #state').val(d.state) ;       
              $('#edit_modal #country').val(d.country) ;       
              $('#edit_modal #phone').val(d.phone) ;   
              $('#edit_modal #mobile').val(d.mobile) ;   
              $('#edit_modal #email').val(d.email) ;      
              $('#edit_modal #gst_no').val(d.gst_no) ;  
              $('#edit_modal #bank_name').val(d.bank_name) ;    
              $('#edit_modal #branch').val(d.branch) ;    
              $('#edit_modal #ac_holder_name').val(d.ac_holder_name) ;    
              $('#edit_modal #ac_no').val(d.ac_no) ;    
              $('#edit_modal #ifsc_code').val(d.ifsc_code) ;
              $('#edit_modal input:radio[value="'+ d.status +'"]').prop('checked', true);  
              
              
            }
         }); 
         
     }); 
      
    
        
     $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'pattern_maker_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body').html(ctnt) ; 
                            
                        }
              });
              
             
      }); 
        
      $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'pattern_maker_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     }); 
      
     
});
</script>