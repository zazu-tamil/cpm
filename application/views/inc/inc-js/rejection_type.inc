<script>
jQuery(function($) {    


    $(".edit_record").click(function() {  
     
     // alert($(this).closest('tr').find('td').eq(1).text());
      
      var rejection_group = $(this).closest('tr').find('td').eq(1).text();
      var rejection_type_name = $(this).closest('tr').find('td').eq(2).text();  
      var rej_code = $(this).closest('tr').find('td').eq(3).text(); 
      var c_status = $(this).closest('tr').find('td').eq(4).text(); 
      
      $('#edit_modal #rejection_type_id').val($(this).val()) ; 
      $('#edit_modal #rejection_group').val(rejection_group) ; 
      $('#edit_modal #rejection_type_name').val(rejection_type_name) ; 
      $('#edit_modal #rej_code').val(rej_code) ; 
      $('#edit_modal input:radio[value='+ c_status +']').prop('checked', true);  
       
                
    });
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'rejection_type_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 