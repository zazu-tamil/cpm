<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
     
     
         

    $(".edit_record").click(function() {   
      
     $.ajax({
                
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'core-plan', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d);
                    $('#edit_modal #core_plan_id').val(d.core_plan_id) ; 
                    $('#edit_modal #core_plan_date').val(d.core_plan_date) ; 
                    $('#edit_modal #customer_id').val(d.customer_id) ; 
                    
                     
                    
                     
                    $('#edit_modal #produced_qty').val(d.produced_qty) ; 
                    $('#edit_modal #damage_qty').val(d.damage_qty) ; 
                    $('#edit_modal #core_maker_rate').val(d.core_maker_rate) ;  
                     
                }
      }); 
                
    });
    
    
     
     
      $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'op_pur_itm_stock_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     }); 
     
      

});
</script> 