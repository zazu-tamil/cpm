<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/iCheck/all.css"> 
<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- bootstrap datepicker -->
<script src="<?php echo base_url() ?>asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/iCheck/icheck.min.js"></script>
<script>
jQuery(function($) { 
   
     
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
    
    
    
    
    
    $(".add_row").click(function(){ 
  	   var t = $('#inv_itm');
        var clone = t.find('#clone-row').clone(true);
        clone.attr('id', ''); 
        t.append(clone); 
        
        var ind = $(this).closest("tr").index();
        //alert($(this).closest("tr").index()); 
        $("#inv_itm .qty:eq("+ (ind +1 ) +")").val(0);
         
         
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
	                   // opt1.text(info.match_plate_no + ' || ' + info.pattern_item );
	                    opt1.text(info.pattern_item );
	                    $('#inv_itm .pattern_id').append(opt1); 
	                });    
                        
                    
                }
                
            });
            
     });
     
      
     
     
      $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'sub_contractor_despatch_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .master').html(ctnt) ; 
                            
                        }
              });
            
             $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'sub_contractor_despatch_item_info', id: $(this).val() ,edit_mode : 0, del_mode : 1},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .child').html(ctnt) ; 
                            
                        }
              }); 
             
      }); 
      
     
     $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'sub_contractor_despatch_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
     
     
     $('#add_modal .status').click(function() {  
      //alert($(this).val());
      if($(this).val() == 'Inward')
      {
        $('#add_modal .inward_row').removeClass('hide');
      } else {
        $('#add_modal .inward_row').addClass('hide');
      }
     });  
     
      $('#edit_modal .status').click(function() {  
      //alert($(this).val());
      if($(this).val() == 'Inward')
      {
        $('#edit_modal .inward_row').removeClass('hide');
      } else {
        $('#edit_modal .inward_row').addClass('hide');
      }
     });  
     
      $(document).on('click','#view_modal .btn_chld_del', function () {
        //alert('hi' + $(this).val());     
        
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'sub_contractor_despatch_item_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
            
     });
});
</script> 