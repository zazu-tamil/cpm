<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
 <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<style>
.ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 15px;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;
    _width: 160px;
    padding: 4px 0;
    margin: 2px 0 0 0;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
    *border-right-width: 2px;
    *border-bottom-width: 2px;
    
     
     
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    
}
.ui-state-hover, &.ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
    }
</style>
<script>
jQuery(function($) {    

    /*$( "#divsearch #srch_key" ).autocomplete({
       source: "<?php echo site_url('get-vendor');?>",
       minLength: 2 ,
       appendTo : $('#divsearch'), 
    });*/
    
    $("#add_modal #supplier_name").autocomplete({
       source: "<?php echo site_url('get-supplier');?>",
       minLength: 2 ,
       appendTo : $('#add_modal #supplier'),
       //select: function (event, ui) {   //must be cleared with function parameter
        //alert(ui.item.mobile);  //will show you the selected item 
        //$("#add_modal #mobile").val(ui.item.mobile);
       //}
       
    });
    
    
     $("#edit_modal #supplier_name").autocomplete({
       source: "<?php echo site_url('get-supplier');?>",
       minLength: 2 ,
       appendTo : $('#edit_modal #supplier'),
       //select: function (event, ui) {   //must be cleared with function parameter
        //alert(ui.item.mobile);  //will show you the selected item 
        //$("#add_modal #mobile").val(ui.item.mobile);
       //}
       
    });
	
	$("#add_modal #rejected_qty").keyup(function() {          
         $('#add_modal #accepted_qty').val($('#add_modal #supplied_qty').val() -   $('#add_modal #rejected_qty').val());
    });
    
     $("#edit_modal #rejected_qty").keyup(function() {          
         $('#edit_modal #accepted_qty').val($('#edit_modal #supplied_qty').val() -   $('#edit_modal #rejected_qty').val());
    });
    
    $(".edit_record").click(function() {  
     
     $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'purchase_inward_info', id: $(this).val() },
            success: function(d) {  
                
              $('#edit_modal #purchase_inward_id').val(d.purchase_inward_id) ;     
              $('#edit_modal #inward_date').val(d.inward_date) ;     
              $('#edit_modal #po_no').val(d.po_no) ;   
              $('#edit_modal #po_date').val(d.po_date) ;   
              $('#edit_modal #item_id').val(d.item_id) ;   
              $('#edit_modal #supplier_name').val(d.supplier_name) ;   
              $('#edit_modal #inv_no').val(d.inv_no) ;   
              $('#edit_modal #expected_date').val(d.expected_date) ;    
              $('#edit_modal #supplied_date').val(d.supplied_date) ;    
              $('#edit_modal #ordered_qty').val(d.ordered_qty) ;   
              $('#edit_modal #supplied_qty').val(d.supplied_qty) ;  
              $('#edit_modal #accepted_qty').val(d.accepted_qty) ;  
              $('#edit_modal #rejected_qty').val(d.rejected_qty) ;  
              $('#edit_modal #rework_qty').val(d.rework_qty) ;   
              $('#edit_modal #rate_per_kg').val(d.rate_per_kg) ;   
              $('#edit_modal #remarks').val(d.remarks) ;   
              $('#edit_modal input:radio[value="'+ d.status +'"]').prop('checked', true); 
              
            }
         });
                
    });
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'purchase_inward_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 