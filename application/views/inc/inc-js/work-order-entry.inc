<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- bootstrap datepicker -->
<script src="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.js"></script> 
<script>
jQuery(function($) { 
   
      
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
    
    $('body').on('focus',".delivery_date", function(){
      $(this).datepicker({
          autoclose: true, 
          format : 'yyyy-mm-dd' 
        });
    });
    
    
     
     
   /* $('.timepicker').timepicker({
      showInputs: false
    }); */
    
    
    $(".add_row").click(function(){ 
  	   var t = $('#inv_itm');
        var clone = t.find('#clone-row').clone(true);
        clone.attr('id', ''); 
        t.append(clone); 
        
        var ind = $(this).closest("tr").index();
        //alert($(this).closest("tr").index()); 
        $("#inv_itm .qty:eq("+ (ind +1 ) +")").val(0);
        $("#inv_itm .weight_per_piece:eq("+ (ind +1 ) +")").val(0);
        $("#inv_itm .total_weight:eq("+ (ind +1 ) +")").val(0);
        $("#inv_itm .delivery_date:eq("+ (ind +1 ) +")").val(''); 
        $("#inv_itm .uom:eq("+ (ind +1 ) +")").val(''); 
         
    });    
    
    $(".remove_row").click(function(){ 
  	    $(this).closest("tr").remove();
    }); 
   
   /* $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-green',
      radioClass   : 'iradio_minimal-green'
    });
    
     $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    }); */
    
    $("#customer_id").change(function() {  
	   //alert($(this).val());  
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#inv_itm .pattern_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $('#inv_itm .pattern_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.match_plate_no + ' || ' + info.pattern_item  + ' [ ' + info.item_type + ' ]');
	                    $('#inv_itm .pattern_id').append(opt1); 
	                });    
                        
                    
                }
                
            });
            
     });
     
     $("#inv_itm .pattern_id").change(function() {  
	   //alert($(this).val());  
       //alert($(this).closest("tr").index()); 
       var rowind = $(this).closest("tr").index(); 
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-pattern-info', id: $(this).val() },
                success: function(d) { 
                    //alert(d.piece_weight_per_kg);                     
                    $("#inv_itm .weight_per_piece:eq("+ (rowind  ) +")").val(d.piece_weight_per_kg);
                     
                }
            });
            
     });
     
     $("#inv_itm .qty").keyup(function(){ 
            
                var wt = $("#inv_itm .weight_per_piece:eq("+ $(this).closest("tr").index() +")").val();
                 
                var qty = $(this).val();
                var tot =  (qty * wt) ;
                
                 $("#inv_itm .total_weight:eq("+ $(this).closest("tr").index() +")").val(tot);             
     }); 
     
     $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'work-order-item', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
     
     
        
      
     
});
</script> 