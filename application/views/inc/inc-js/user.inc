<script>
jQuery(function($) {    


    $(".edit_record").click(function() {    
    
      $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'user_login', id: $(this).val() },
            success: function(d) {
              //  alert(d.user_id);
                $('#edit_modal #user_id').val(d.user_id);
                $('#edit_modal #name').val(d.name);
                $('#edit_modal #user_name').val(d.user_name); 
                $('#edit_modal #user_pwd').val(d.user_pwd); 
                $('#edit_modal #level').val(d.level); 
                $('#edit_modal input:radio[value="'+ d.status +'"]').prop('checked', true); 
                
                
             }
                 
      }); 
      }); 
    
      
});
</script> 