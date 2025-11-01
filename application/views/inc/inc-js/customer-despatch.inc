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
        $("#inv_itm .qty:eq("+ (ind +1 ) +")").val(10);
         
         
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
      /* $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-WO', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#inv_itm .work_order_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select PO');
                    $('#inv_itm .work_order_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.work_order_id);
	                    opt1.text(info.customer_PO_No + '||' + info.order_date );
	                    $('#inv_itm .work_order_id').append(opt1); 
	                });  
                }
                
            }); */
           
          // var indx = $(this).closest("tr").index(); 
           $.ajax({
                    url: "<?php echo site_url('get-data');?>",
                    type: "post",
                   
                    data: { tbl : 'get-customer-pattern-stock', id: $(this).val() }, 
                    success: function(d) {  
                       // $('.sts').html(d['sql']);
                        //alert(d['sql']);
                        
                        $("#inv_itm .pattern_id > option").remove();  
                        
                        var opt1 = $('<option />'); 
                        opt1.val('');
                        opt1.text('Select Item');
                        $('#inv_itm .pattern_id').append(opt1); 
    			
        				$.each(d,function(key,info) 
    	                {
    	                    var opt1 = $('<option />'); 
    	                    opt1.val(info.pattern_id);
    	                    opt1.text(info.pattern_item + ' || Qty: ' + info.closing_stock);
                            opt1.attr('data',info.closing_stock);
    	                    $("#inv_itm .pattern_id").append(opt1); 
    	                }); 
                    }
             });   
            
           /* $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-sub-contractor', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#sub_contractor_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Sub-Contractor');
                    $('#sub_contractor_id').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.sub_contractor_id);
	                    opt1.text(info.company_name);
	                    $('#sub_contractor_id').append(opt1); 
	                });    
                        
                    
                }
                
            });*/
            
     });
     
     //get_items_PO_bal_qty
     
     $("#inv_itm .pattern_id").change(function() {  
	  // alert($(this).val());  
	   //alert($('#inv_itm .pattern_id :selected').attr('data'));  
       //$('#add_modal #core_maker_rate').val($("#add_modal #core_item_id :selected").attr('data-rate'));
        var indx = $(this).closest("tr").index();
        //alert(indx);
        $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get_items_PO_bal_qty', id: $(this).val() },
                success: function(d) { 
                     
                     
                    $("#inv_itm .work_order_id_"+ indx +" > option").remove();  
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select PO');
                    $('#inv_itm .work_order_id_' + indx).append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.work_order_id);
	                    opt1.text(info.customer_PO_No + " || " + info.order_date + " BQ: " + info.bal_qty );
	                    $("#inv_itm .work_order_id_"+ indx +"").append(opt1); 
	                }); 
                }
                
            }); 
        });
    
    /* 
     
     $("#inv_itm .work_order_id").change(function() {  
	   //alert($(this).val());  
        var indx = $(this).closest("tr").index();
        //alert(indx);
        $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-WO-item', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                    
                     
                    $("#inv_itm .pattern_id_"+ indx +" > option").remove();  
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Item');
                    $('#inv_itm .pattern_id_' + indx).append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.item );
	                    $("#inv_itm .pattern_id_"+ indx +"").append(opt1); 
	                }); 
                }
                
            }); 
        });
     */
     
     $(".edit_record").click(function() {  
          //  alert($(this).val());
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'get-customer-despatch', id: $(this).val() },
            success: function(d) {  
              // alert(d['dc'].transporter_id);
              $('#edit_modal #customer_id').val(d['dc'].customer_id) ;     
              $('#edit_modal #customer_despatch_id').val(d['dc'].customer_despatch_id) ;     
              $('#edit_modal #dc_no').val(d['dc'].dc_no) ;     
              $('#edit_modal #invoice_no').val(d['dc'].invoice_no) ;     
              $('#edit_modal #despatch_date').val(d['dc'].despatch_date) ;   
              $('#edit_modal #vehicle_no').val(d['dc'].vehicle_no) ;   
              $('#edit_modal #driver_name').val(d['dc'].driver_name) ; 
              $('#edit_modal #mobile').val(d['dc'].mobile) ;   
              $('#edit_modal #remarks').val(d['dc'].remarks) ; 
              $('#edit_modal #dc_type').val(d['dc'].dc_type) ; 
              $('#edit_modal #transporter_id').val(d['dc'].transporter_id) ; 
              $('#edit_modal input:radio[value="'+ d['dc'].status +'"]').prop('checked', true);  
              
              
              
              $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'customer_despatch_item_info', id: d['dc'].customer_despatch_id ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#edit_modal .modal-body .child').html(ctnt) ; 
                            
                        }
              }); 
              
              $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'heatcode_despatch_info', id: d['dc'].customer_despatch_id ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#edit_modal .modal-body .child1').html(ctnt) ; 
                            
                        }
              });  
              
              
            }
         }); 
         
     });
     
     
      $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'customer_despatch_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .master').html(ctnt) ; 
                            
                        }
              });
            
             $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'customer_despatch_item_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .child').html(ctnt) ; 
                            
                        }
              }); 
              
              $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'heatcode_despatch_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .child1').html(ctnt) ; 
                            
                        }
              });  
             
      }); 
     
     $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'customer_despatch_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
     
     
        
      
     
});
</script> 