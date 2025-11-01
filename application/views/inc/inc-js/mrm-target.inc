<script>
jQuery(function($) {   
    
    $(".edit_record").click(function() {  
          //  alert($(this).val());
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'mrm_target_info', id: $(this).val() },
            success: function(d) {  
                //alert(d.length);
               // alert(d[0].frm_date);
                /*$.each( d, function( key, value ) {
                  alert( key + ": " + value.mrm_target_name );
                }); */
                  
              $('#edit_modal #grp_id').val(d[0].grp_id) ;     
              $('#edit_modal #frm_date').val(d[0].frm_date) ;     
              $('#edit_modal #to_date').val(d[0].to_date) ;  
              $.each( d, function( key, value ) {
                  $('#edit_modal #mrm_text_'+ (key+1)).html(value.mrm_target_name) ;
                  $('#edit_modal #mrm_target_name_'+ (key+1)).val(value.mrm_target_name) ;
                  $('#edit_modal #mrm_target_value'+ (key+1)).val(value.mrm_target_value) ;
              });   
                 
              
              
            }
         }); 
         
     }); 
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'iso_label_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 