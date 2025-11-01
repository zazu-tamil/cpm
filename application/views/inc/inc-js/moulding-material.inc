<script>
jQuery(function($) {    
        
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });    

    $(".edit_record").click(function() {  
     
      
      
       $.ajax({
               // url: "send-enquiry.php",
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-moulding-material', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d);
                    //$('#edit_modal #moulding_date').val(d.moulding_date) ; 
                    $('#edit_modal #moulding_material_log_id').val(d.moulding_material_log_id) ; 
                    $('#edit_modal #new_sand').val(d.new_sand) ; 
                    $('#edit_modal #green_sand').val(d.green_sand) ; 
                    $('#edit_modal #water').val(d.water) ;  
                    $('#edit_modal #bentonite').val(d.bentonite) ;  
                    $('#edit_modal #bentokol').val(d.bentokol) ;  
                    $('#edit_modal #total_mix').val(d.total_mix) ;  
                    $('#edit_modal #cum_bentonite').val(d.cum_bentonite) ;  
                    $('#edit_modal #cum_bentokol').val(d.cum_bentokol) ;  
                    $('#edit_modal #total_mix_bento').val(d.total_mix_bento) ;  
                    $('#edit_modal #remarks').val(d.remarks) ;  
                }
      }); 
      
       
                
    });
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'moulding-material', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
     
     
     
     
});
</script> 