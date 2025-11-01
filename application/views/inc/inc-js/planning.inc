<script>
jQuery(function($) { 
   
   
   
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
     
    $('[data-toggle="popover"]').popover(); 
     
     
    $('.chk_work_order_item_id').click(function() {
        
        if($(this).is(':checked'))
        {
            //alert($(this).val());
            $('input[name="plan_qty['+ $(this).val() +']"]').val(0);
            $('input[name="plan_qty['+ $(this).val() +']"]').attr('disabled',false).focus();
            $('input[name="plan_qty['+ $(this).val() +']"]').attr('required',false);
			
			$('input[name="customer_id['+ $(this).val() +']"]').attr('disabled',false);
			$('input[name="pattern_id['+ $(this).val() +']"]').attr('disabled',false);
			$('input[name="work_order_id['+ $(this).val() +']"]').attr('disabled',false);
			$('input[name="box_wt['+ $(this).val() +']"]').attr('disabled',false);
			
        } else {
            $('input[name="plan_qty['+ $(this).val() +']"]').attr('required',true);
            $('input[name="plan_qty['+ $(this).val() +']"]').attr('disabled',true);
			
			$('input[name="customer_id['+ $(this).val() +']"]').attr('disabled',true);
			$('input[name="pattern_id['+ $(this).val() +']"]').attr('disabled',true);
			$('input[name="work_order_id['+ $(this).val() +']"]').attr('disabled',true);
			$('input[name="box_wt['+ $(this).val() +']"]').attr('disabled',true);
        }
     
    });  
        
    
    $('.plan_qty').keyup(function() { //alert($(this).attr('data'));
    
        var total = 0;
        var total_wt = 0;
        
        $('.plan_qty').each(function() {
            total += parseFloat($(this).val());
            total_wt += ( parseFloat($(this).val()) * parseFloat($(this).attr('data')));
        }); 
        
        $('.tot_box_planned').html(parseFloat(total));
        $('.tot_box_wt_planned').html(parseFloat(total_wt).toFixed(3));
    });
       
    $('.edit_record').click(function() {
        //alert($(this).val());
        //alert($(".box_" + $(this).val()).val()); 
            $.ajax({
                    url: "<?php echo site_url('update-data');?>",
                    type: "post",
                    data: { tbl : 'work_planning_info', id: $(this).val(), planned_box:$(".box_" + $(this).val()).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             }); 
        
    });
    
    
    
    $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'planning-moulding-melting', id: $(this).val() ,edit_mode : 0, del_mode : 0},
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
                    data: { tbl : 'work_planning_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     }); 
    
});
</script> 