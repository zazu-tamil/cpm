<script src="<?php echo base_url() ?>asset/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url() ?>asset/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });  
    
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      showMeridian: false 
    })
    
    $('[data-mask]').inputmask('hh:mm:ss', { 'placeholder': 'HH:mm:ss' })

    $(".add_record").click(function() {  
        //alert($(this).closest('tr').find('td').eq(4).text());
        $('#frmadd #work_planning_id').val($(this).val());
        $('#frmadd #pattern').val($(this).closest('tr').find('td').eq(4).text());
    });    
    
    $(".edit_record").click(function() {  
     
     $.ajax({
               // url: "send-enquiry.php",
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-moulding-log-item', id: $(this).val() },
                success: function(d) {                                 
                    //alert(d.supervisor);
                    $('#edit_modal #pattern').val(d.match_plate_no + '-' + d.pattern_item) ; 
                    $('#edit_modal #moulding_log_item_id').val(d.moulding_log_item_id) ; 
                    $('#edit_modal #work_planning_id').val(d.work_planning_id) ; 
                    $('#edit_modal #pattern_change_time').val(d.pattern_change_time) ; 
                    $('#edit_modal #heat_no').val(d.heat_no) ; 
                    $('#edit_modal #pattern_prod_from_datetime').val(d.pattern_prod_from_datetime) ; 
                     
                    $('#edit_modal #pattern_prod_from_time').timepicker('setTime', d.pattern_prod_from_time);
                    $('#edit_modal #pattern_prod_to_time').timepicker('setTime', d.pattern_prod_to_time); 
                    
                    $('#edit_modal #pattern_prod_to_datetime').val(d.pattern_prod_to_datetime) ; 
                    $('#edit_modal #breakdown_from_time').val(d.breakdown_from_time) ;
                    $('#edit_modal #breakdown_remarks').val(d.breakdown_remarks) ;
                    $('#edit_modal #breakdown_to_time').val(d.breakdown_to_time).change() ; 
                    $('#edit_modal #machine_on_time').val(d.machine_on_time) ; 
                    $('#edit_modal #machine_off_time').val(d.machine_off_time) ; 
                    $('#edit_modal #produced_box').val(d.produced_box) ;  
                    $('#edit_modal #closed_mould_qty').val(d.closed_mould_qty) ;  
                    $('#edit_modal #leftout_box').val(d.leftout_box) ;  
                    $('#edit_modal #leftout_remarks').val(d.leftout_remarks) ;  
                    $('#edit_modal #knock_out_time').val(d.knock_out_time) ;  
                    $('#edit_modal #remarks').val(d.remarks) ;  
                    $('#edit_modal #modification_details').val(d.modification_details) ;  
                    $('#edit_modal #manpower_comsumption').val(d.manpower_comsumption) ;
                    
                    $('#edit_modal input:radio[value="'+ d.chk_pattern_condition +'"]').prop('checked', true); 
                    $('#edit_modal input:radio[value="'+ d.chk_logo_identify +'"]').prop('checked', true); 
                    $('#edit_modal input:radio[value="'+ d.chk_gating_sys_identify +'"]').prop('checked', true); 
                    $('#edit_modal input:radio[value="'+ d.chk_mold_closing_status +'"]').prop('checked', true); 
                      
                    $('#edit_modal #bottom_moulding_machine_operator').val(d.bottom_moulding_machine_operator) ;  
                    $('#edit_modal #top_moulding_machine_operator').val(d.top_moulding_machine_operator) ;  
                    $('#edit_modal #core_setter_name').val(d.core_setter_name) ;  
                    $('#edit_modal #mould_closer_name').val(d.mould_closer_name) ;  
                    $('#edit_modal #mullar_operator_name').val(d.mullar_operator_name) ;  
                    $('#edit_modal #addt_other_operators').val(d.addt_other_operators) ;  
                    $('#edit_modal #supervisor').val(d.supervisor) ;  
                    $('#edit_modal #moulding_hrd_top').val(d.moulding_hrd_top) ;  
                    $('#edit_modal #moulding_hrd_bottom').val(d.moulding_hrd_bottom) ;  

                     

                   
                }
      }); 
       
                
    });
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'moulding-log-item', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});

$(document).ready(function() {

    function calculateBreakdownHours(containerId) {
      let container = $('#' + containerId);

      let from = container.find('[name="breakdown_from_time"]').val();
      let to = container.find('[name="breakdown_to_time"]').val();

      if (from && to) {
          let fromParts = from.split(':');
          let toParts = to.split(':');

          let fromDate = new Date(0, 0, 0, fromParts[0], fromParts[1], fromParts[2] || 0);
          let toDate = new Date(0, 0, 0, toParts[0], toParts[1], toParts[2] || 0);

          // If crosses midnight
          if (toDate < fromDate) {
              toDate.setDate(toDate.getDate() + 1);
          }

          let diffMs = toDate - fromDate;
          let diffHrs = Math.floor(diffMs / 1000 / 60 / 60);
          let diffMins = Math.floor((diffMs / 1000 / 60) % 60);
          let diffSecs = Math.floor((diffMs / 1000) % 60);

          let total = 
              String(diffHrs).padStart(2, '0') + ":" + 
              String(diffMins).padStart(2, '0') + ":" + 
              String(diffSecs).padStart(2, '0');

          container.find('[name="breakdown_hrs"]').val(total);
      }
  }

    // Trigger on time change
    $('#add_modal [name="breakdown_from_time"], #add_modal [name="breakdown_to_time"]').on('change keyup', function() {
        calculateBreakdownHours('add_modal');
    });

    $('#edit_modal [name="breakdown_from_time"], #edit_modal [name="breakdown_to_time"]').on('change keyup', function() {
        calculateBreakdownHours('edit_modal');
    });
});

</script> 
