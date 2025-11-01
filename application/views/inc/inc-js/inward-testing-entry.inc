<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    }); 
    
     
  $(".add_record").click(function() {  
    //alert($(this).val());
    //alert($(this).attr('data'));
    $('#add_modal .ref').html($(this).attr('data'));
    $('#add_modal #purchase_inward_id').val($(this).val());
  }); 
  
  
  $(".edit_record").click(function() {  
           // alert($(this).val());
           
          $('#edit_modal .ref').html($(this).attr('data')); 
          
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'purchase_inward_testing_info', id: $(this).val() },
            success: function(d) {   //alert(d.result);
              $('#edit_modal #purchase_inward_testing_id').val(d.purchase_inward_testing_id) ;     
              $('#edit_modal #purchase_inward_id').val(d.purchase_inward_id) ;     
              $('#edit_modal #result').val(d.result) ;     
              $('#edit_modal #remarks').val(d.remarks) ;    
              $('#edit_modal input:radio[value="'+ d.tc_received +'"]').prop('checked', true);  
              $('#edit_modal input:radio[value="'+ d.criteria +'"]').prop('checked', true);   
              
            }
         }); 
         
     });  
  
    
  $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'purchase_inward_testing_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script>    