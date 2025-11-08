<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });  

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
                data: { tbl : 'get-melting-log', id: $(this).val() },
                success: function(d) {                                 
                    // alert(d.helper_name);                     
                    $('#edit_modal #melting_heat_log_id').val(d.melting_heat_log_id) ;  
                    $('#edit_modal #planning_date').val(d.planning_date) ; 
                    $('#edit_modal #shift').val(d.shift) ; 
                    $('#edit_modal #melting_date').val(d.melting_date) ; 
                    $('#edit_modal #lining_heat_no').val(d.lining_heat_no) ; 
                    $('#edit_modal #heat_code').val(d.heat_code) ;  
                    $('#edit_modal #helper_name').val(d.helper_name) ;
                    $('#edit_modal #days_heat_no').val(d.days_heat_no) ;  
                    $('#edit_modal #furnace_on_time').val(d.furnace_on_time) ;  
                    $('#edit_modal #furnace_off_time').val(d.furnace_off_time) ;  
                    $('#edit_modal #tapp_temp').val(d.tapp_temp) ;  
                  //  $('#edit_modal #pour_temp').val(d.pour_temp) ;  
                    $('#edit_modal #ladle_1_first_box_pour_temp').val(d.ladle_1_first_box_pour_temp) ;  
                    $('#edit_modal #ladle_2_first_box_pour_temp').val(d.ladle_2_first_box_pour_temp) ;  
                    $('#edit_modal #start_units').val(d.start_units) ;  
                    $('#edit_modal #end_units').val(d.end_units) ;  
                    $('#edit_modal #boring').val(d.boring) ;  
                    $('#edit_modal #ms').val(d.ms) ;  
                    $('#edit_modal #foundry_return').val(d.foundry_return) ;  
                    $('#edit_modal #CI_scrap').val(d.CI_scrap) ;  
                    $('#edit_modal #pig_iron').val(d.pig_iron) ;  
                    $('#edit_modal #C').val(d.C) ;  
                    $('#edit_modal #SI').val(d.SI) ;  
                    $('#edit_modal #Mn').val(d.Mn) ;  
                    $('#edit_modal #S').val(d.S) ;  
                    $('#edit_modal #Cu').val(d.Cu) ;  
                    $('#edit_modal #Cr').val(d.Cr) ;  
                    $('#edit_modal #graphite_coke').val(d.graphite_coke) ;  
                    $('#edit_modal #spillage').val(d.spillage) ;  
                    $('#edit_modal #fe_si_mg').val(d.fe_si_mg) ;  
                    $('#edit_modal #ideal_hrs_from').val(d.ideal_hrs_from) ;  
                    $('#edit_modal #ideal_hrs_to').val(d.ideal_hrs_to).change() ;   
                    $('#edit_modal #remarks').val(d.remarks) ;                      
                    $('#edit_modal #pouring_start_time').val(d.pouring_start_time) ;  
                    $('#edit_modal #pouring_finish_time').val(d.pouring_finish_time) ;  
                    $('#edit_modal #total_time').val(d.total_time) ;  
                    $('#edit_modal #fe_sulphur').val(d.fe_sulphur) ;  
                    $('#edit_modal #inoculant').val(d.inoculant) ;  
                    $('#edit_modal #pyrometer_tip').val(d.pyrometer_tip) ;  
                    $('#edit_modal #fc_operator').val(d.fc_operator) ;  
                    $('#edit_modal #pouring_person_name_1').val(d.pouring_person_name_1) ;  
                    $('#edit_modal #pouring_person_name_2').val(d.pouring_person_name_2) ;  
                    $('#edit_modal #pouring_person_name_3').val(d.pouring_person_name_3) ;  
                    $('#edit_modal #helper_name').val(d.helper_name) ;  
                    $('#edit_modal #supervisor').val(d.supervisor) ;  
                    $('#edit_modal #b_c').val(d.b_c) ;  
                    $('#edit_modal #b_si').val(d.b_si) ;  
                    $('#edit_modal #b_mn').val(d.b_mn) ;  
                    $('#edit_modal #b_p').val(d.b_p) ;  
                    $('#edit_modal #b_s').val(d.b_s) ;  
                    $('#edit_modal #b_cr').val(d.b_cr) ;  
                    $('#edit_modal #b_cu').val(d.b_cu) ;  
                    $('#edit_modal #b_mg').val(d.b_mg) ;  
                    $('#edit_modal #b_bmn').val(d.b_bmn) ; 
                    
                    $('#edit_modal #f_c').val(d.f_c) ;  
                    $('#edit_modal #f_si').val(d.f_si) ;  
                    $('#edit_modal #f_mn').val(d.f_mn) ;  
                    $('#edit_modal #f_p').val(d.f_p) ;  
                    $('#edit_modal #f_s').val(d.f_s) ;  
                    $('#edit_modal #f_cr').val(d.f_cr) ;  
                    $('#edit_modal #f_cu').val(d.f_cu) ;  
                    $('#edit_modal #f_mg').val(d.f_mg) ;  
                    $('#edit_modal #f_bmn').val(d.f_bmn) ;
                    $('#edit_modal #tensile').val(d.tensile) ;
                    $('#edit_modal #elongation').val(d.elongation) ;
                    $('#edit_modal #yield_strength').val(d.yield_strength) ;
                    $('#edit_modal #ni').val(d.ni) ;
                    $('#edit_modal #mo').val(d.mo) ;
                    
                     $('#edit_modal .edit_input').val(0); 
                    
                    $.each(d['itm'], function(index, value) {
                       
                      $("#edit_modal input[name='ed_cf_melting_heat_log_id["+ value.work_planning_id+"]']").val(value.cf_melting_heat_log_id);
                      $("#edit_modal input[name='work_plan_id["+ value.work_planning_id+"]']").val(value.pouring_box);
                      $("#edit_modal input[name='leftout_box["+ value.work_planning_id+"]']").val(value.leftout_box);
                      if(value.leftout_box_close == 1 )
                        $("#edit_modal input[name='leftout_box_close["+ value.work_planning_id+"]']").attr('checked', 'checked');
                    });
                    
                }
      }); 
       
                
    });
    
    
    $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'melting_heat_log_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
                        success: function(ctnt) {                                 
                             
                            $('#view_modal .modal-body .master').html(ctnt) ; 
                            
                        }
              });
              
              $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'melting_item_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
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
                    data: { tbl : 'melting-log', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     }); 

     
	/* $('.btninfo').click(function() {   alert($(this).attr('data'));
             $.ajax({
                    url: "<?php echo site_url('get-content');?>",
                    type: "post",
                    data: { tbl : 'pattern-chem-compo', id: $(this).attr('data') },
                    success: function(d) {  
                        alert(d);
                          //$(this).attr('data-content',d);
						  $('[data-toggle="popover"]').popover({
							html: true,
							content : d,		
						  }); 
                    }
             });
         
        
     }); */
	 
	 $('.btninfo').popover({
		html: true,
		trigger: 'manual',
		content: function() {
		  return $.ajax({url: "<?php echo site_url('get-content');?>",
						 dataType: 'html',
						 type: "post",
						 data: { tbl : 'pattern-chem-compo', id: $(this).attr('data') },
						 async: false}).responseText;
		}
	  }).click(function(e) {
		$(this).popover('toggle');
	  });
      
      
      $(".add_chemical_log").click(function() {  

            //alert($(this).val());
            
            $('#add_modal_chemical #btn_reset').click();
            
            $('#add_modal_chemical #melting_heat_log_id').val($(this).val()) ;  
            
            
            
           /* $('#add_modal_chemical #m_c').val('') ;  
            $('#add_modal_chemical #m_si').val('') ;  
            $('#add_modal_chemical #m_mn').val('') ;  
            $('#add_modal_chemical #m_p').val('') ;  
            $('#add_modal_chemical #m_s').val('') ;  
            $('#add_modal_chemical #m_cr').val('') ;  
            $('#add_modal_chemical #m_cu').val('') ;  
            $('#add_modal_chemical #m_mg').val('') ;  
            $('#add_modal_chemical #m_bmn').val('') ; 
            $('#add_modal_chemical #m_tensile').val('') ; 
            $('#add_modal_chemical #m_elongation').val('') ; 
            $('#add_modal_chemical #m_yield_strength').val('') ;*/
            
            
            
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'melting_items_list', id: $(this).val() },
            success: function(d) {  
              //  alert(d.company_name);
                    $("#add_modal_chemical #melting_item_id > option").remove(); 
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item'); 
                    $("#add_modal_chemical #melting_item_id").append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.melting_item_id);
	                    opt1.text(info.pattern_item + ' || ' + info.pouring_box ); 
                        opt1.attr('data',info.pattern_id);
                        $("#add_modal_chemical #melting_item_id").append(opt1); 
	                });    
              
              
            }
         });
         
             $.ajax({
                url: "<?php echo site_url('get-content');?>",
                type: "post",
                data: { tbl : 'melting_item_chemical_info', id: $(this).val() ,edit_mode : 1, del_mode : 1},
                success: function(ctnt) {                                 
                     
                    $('#add_modal_chemical .modal-body .melting_item_chemical_list').html(ctnt) ; 
                    
                }
            });  
         
     });
     
     $("#add_modal_chemical #melting_item_id").change(function() {  
         //   alert($(this).find(':selected').attr('data'));
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'get-pattern-info', id: $(this).find(':selected').attr('data') },
            success: function(d) {  
                    $('#add_modal_chemical #m_c').val(d.C) ;  
                    $('#add_modal_chemical #m_si').val(d.SI) ;  
                    $('#add_modal_chemical #m_mn').val(d.Mn) ;  
                    $('#add_modal_chemical #m_p').val(d.P) ;  
                    $('#add_modal_chemical #m_s').val(d.S) ;  
                    $('#add_modal_chemical #m_cr').val(d.Cr) ;  
                    $('#add_modal_chemical #m_cu').val(d.Cu) ;  
                    $('#add_modal_chemical #m_mg').val(d.Mg) ;  
                    $('#add_modal_chemical #m_bmn').val(d.BHN) ; 
                    $('#add_modal_chemical #m_tensile').val(d.tensile) ; 
                    $('#add_modal_chemical #m_elongation').val(d.elongation) ; 
                    $('#add_modal_chemical #m_yield_strength').val(d.yeild_strength) ; 
                    $('#add_modal_chemical #m_ni').val(d.ni) ; 
                    $('#add_modal_chemical #m_mo').val(d.mo) ; 
              
            }
         }); 
         
     });
      
    $("#add_modal_chemical #btn_chm_save").click(function() {  
        var fx = $("#frmaddchem").serializeArray();
        //  alert(fx); 
        
        $.ajax({
            url: "<?php echo site_url('insert-data');?>",
            type: "post",
            data: fx,
            success: function(d) {  
               alert(d);
               location.reload(); 
            }
        });    
        
    });  
    
    
     $(document).on('click','#add_modal_chemical .btn_chld_edit', function () {
        
        $('#add_modal_chemical #melting_item_chemical_id').val($(this).val());
        $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'melting_item_chemical_info', id: $(this).val() },
                success: function(d) {                                 
                     //alert(ctnt);
                   /* $('#user_modal #mode').val('Edit User') ;  
                    $('#user_modal #first_name').val(d.first_name) ;  
                    $('#user_modal #user_name').val(d.user_name) ;  
                    $('#user_modal #pwd').val(d.pwd) ;  
                    $('#user_modal #email').val(d.email) ;  
                    $('#user_modal #mobile').val(d.mobile) ;  
                    $('#user_modal input:radio[value="'+ d.status +'"]').prop('checked', true); 
                    $('#user_modal #first_name').focus();*/
                    
                    $('#add_modal_chemical #mode').val('Edit Chemical Log') ;
                    
                    $.each(d, function (key, data) {
                        //console.log(key , data)
                        var tx = "#add_modal_chemical #" + key;
                        $(tx).val(data) ; 
                         
                    })
                    
                    $('#add_modal_chemical #melting_item_id').focus();
                }
        }); 
     }); 
     
     $(document).on('click','#add_modal_chemical .btn_chld_del', function () {
        //alert('hi' + $(this).val());     
        
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'melting_item_chemical_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
            
     }); 


   	 $(document).ready(function() {

        function calculateBreakdownHours(containerId) {
          let container = $('#' + containerId);

          let from = container.find('[name="ideal_hrs_from"]').val();
          let to = container.find('[name="ideal_hrs_to"]').val();

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

              container.find('[name="total_hrs"]').val(total);
          }
      }

        // Trigger on time change
        $('#add_modal [name="ideal_hrs_from"], #add_modal [name="ideal_hrs_to"]').on('change keyup', function() {
            calculateBreakdownHours('add_modal');
        });

        $('#edit_modal [name="ideal_hrs_from"], #edit_modal [name="ideal_hrs_to"]').on('change keyup', function() {
            calculateBreakdownHours('edit_modal');
        });
    });

});
</script> 