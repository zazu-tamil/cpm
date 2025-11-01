<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    }); 


    $("#srch_shift , #srch_date").change(function() {  
        load_pattern_items();
    });  

   
    
 });  

  function load_pattern_items()
  {
        let srch_date = $("#srch_date").val(); 
        let shift = $("#srch_shift").val(); 
        if(shift != '' && srch_date != '')
        {

          $("#srch_pattern_id > option").remove();  
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { 
                        tbl : 'get-shift-itms-list', 
                        shift_date: srch_date,
                        shift: shift,
                      },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Item');
                    $('#srch_pattern_id').append(opt1); 
			
    				      $.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.pattern_item );
	                    $('#srch_pattern_id').append(opt1); 
	                });
                }
          });
        }
    }
  
 
</script>   
