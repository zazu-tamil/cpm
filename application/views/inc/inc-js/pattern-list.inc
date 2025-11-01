<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo base_url() ?>asset/bower_components/select2/dist/js/select2.full.min.js"></script>
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #0080FF;
    border: 1px solid #000;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #000;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px;
}
</style>
<script>
jQuery(function($) { 
     
     $('.select2').select2();

     
     $("#add_modal #piece_weight_per_kg").keyup(function() {  
        var cast_wt = $('#add_modal #no_of_cavity').val() * $('#add_modal #piece_weight_per_kg').val();
        var cast_wt1 = $('#add_modal #child_pattern_1_cavity').val() * $('#add_modal #child_pattern_1_pt_wt').val();
        var cast_wt2 = $('#add_modal #child_pattern_2_cavity').val() * $('#add_modal #child_pattern_2_pt_wt').val();
        var cast_wt3 = $('#add_modal #child_pattern_3_cavity').val() * $('#add_modal #child_pattern_3_pt_wt').val();
        var cast_wt4 = $('#add_modal #child_pattern_4_cavity').val() * $('#add_modal #child_pattern_4_pt_wt').val();
        var cast_wt5 = $('#add_modal #child_pattern_5_cavity').val() * $('#add_modal #child_pattern_5_pt_wt').val();
        var cast_wt6 = $('#add_modal #child_pattern_6_cavity').val() * $('#add_modal #child_pattern_6_pt_wt').val();
        var cast_wt7 = $('#add_modal #child_pattern_7_cavity').val() * $('#add_modal #child_pattern_7_pt_wt').val();
        $('#add_modal #casting_weight').val(cast_wt + cast_wt1 + cast_wt2 + cast_wt3 + cast_wt4 + cast_wt5 + cast_wt6 + cast_wt7);
     });  
     
     $("#add_modal #piece_weight_per_kg").change(function() {  
        var cast_wt = $('#add_modal #no_of_cavity').val() * $('#add_modal #piece_weight_per_kg').val();
        var cast_wt1 = $('#add_modal #child_pattern_1_cavity').val() * $('#add_modal #child_pattern_1_pt_wt').val();
        var cast_wt2 = $('#add_modal #child_pattern_2_cavity').val() * $('#add_modal #child_pattern_2_pt_wt').val();
        var cast_wt3 = $('#add_modal #child_pattern_3_cavity').val() * $('#add_modal #child_pattern_3_pt_wt').val();
        var cast_wt4 = $('#add_modal #child_pattern_4_cavity').val() * $('#add_modal #child_pattern_4_pt_wt').val();
        var cast_wt5 = $('#add_modal #child_pattern_5_cavity').val() * $('#add_modal #child_pattern_5_pt_wt').val();
        var cast_wt6 = $('#add_modal #child_pattern_6_cavity').val() * $('#add_modal #child_pattern_6_pt_wt').val();
        var cast_wt7 = $('#add_modal #child_pattern_7_cavity').val() * $('#add_modal #child_pattern_7_pt_wt').val();
        $('#add_modal #casting_weight').val(cast_wt + cast_wt1 + cast_wt2 + cast_wt3 + cast_wt4 + cast_wt5 + cast_wt6 + cast_wt7);
     });    
     
     $("#edit_modal #piece_weight_per_kg").keyup(function() {  
        var cast_wt = $('#edit_modal #no_of_cavity').val() * $('#edit_modal #piece_weight_per_kg').val();
        var cast_wt1 = $('#edit_modal #child_pattern_1_cavity').val() * $('#edit_modal #child_pattern_1_pt_wt').val();
        var cast_wt2 = $('#edit_modal #child_pattern_2_cavity').val() * $('#edit_modal #child_pattern_2_pt_wt').val();
        var cast_wt3 = $('#edit_modal #child_pattern_3_cavity').val() * $('#edit_modal #child_pattern_3_pt_wt').val();
        var cast_wt4 = $('#edit_modal #child_pattern_4_cavity').val() * $('#edit_modal #child_pattern_4_pt_wt').val();
        var cast_wt5 = $('#edit_modal #child_pattern_5_cavity').val() * $('#edit_modal #child_pattern_5_pt_wt').val();
        var cast_wt6 = $('#edit_modal #child_pattern_6_cavity').val() * $('#edit_modal #child_pattern_6_pt_wt').val();
        var cast_wt7 = $('#edit_modal #child_pattern_7_cavity').val() * $('#edit_modal #child_pattern_7_pt_wt').val();
        $('#edit_modal #casting_weight').val(cast_wt + cast_wt1 + cast_wt2 + cast_wt3 + cast_wt4 + cast_wt5 + cast_wt6 + cast_wt7);
     });
     
     $("#edit_modal #piece_weight_per_kg").change(function() {  
        var cast_wt = $('#edit_modal #no_of_cavity').val() * $('#edit_modal #piece_weight_per_kg').val();
        var cast_wt1 = $('#edit_modal #child_pattern_1_cavity').val() * $('#edit_modal #child_pattern_1_pt_wt').val();
        var cast_wt2 = $('#edit_modal #child_pattern_2_cavity').val() * $('#edit_modal #child_pattern_2_pt_wt').val();
        var cast_wt3 = $('#edit_modal #child_pattern_3_cavity').val() * $('#edit_modal #child_pattern_3_pt_wt').val();
        var cast_wt4 = $('#edit_modal #child_pattern_4_cavity').val() * $('#edit_modal #child_pattern_4_pt_wt').val();
        var cast_wt5 = $('#edit_modal #child_pattern_5_cavity').val() * $('#edit_modal #child_pattern_5_pt_wt').val();
        var cast_wt6 = $('#edit_modal #child_pattern_6_cavity').val() * $('#edit_modal #child_pattern_6_pt_wt').val();
        var cast_wt7 = $('#edit_modal #child_pattern_7_cavity').val() * $('#edit_modal #child_pattern_7_pt_wt').val();
        $('#edit_modal #casting_weight').val(cast_wt + cast_wt1 + cast_wt2 + cast_wt3 + cast_wt4 + cast_wt5 + cast_wt6 + cast_wt7);
     });
     
     
     $("#add_modal .pw_calc").change(function() {    
        $("#add_modal #piece_weight_per_kg").change();
     });
     
     $("#edit_modal .pw_calc").change(function() {    
        $("#edit_modal #piece_weight_per_kg").change();
     });
     
     
     $("#add_modal .yeild_calc").keyup(function() {  
        
        var yeil =(($('#add_modal #bunch_weight').val() - ($('#add_modal #bunch_weight').val() - $('#add_modal #casting_weight').val())) * 100  / $('#add_modal #bunch_weight').val());
        //alert(yeil);
        $('#add_modal #yeild').val(yeil.toFixed(2));
     });
     
     $("#edit_modal .yeild_calc").keyup(function() {  
        
        //var yeil =(($('#edit_modal #bunch_weight').val() - ($('#edit_modal #bunch_weight').val() - $('#edit_modal #casting_weight').val())) * 100  / $('#edit_modal #bunch_weight').val());
        var yeil =(($('#edit_modal #bunch_weight').val() - ($('#edit_modal #bunch_weight').val() - $('#edit_modal #casting_weight').val())) * 100  / $('#edit_modal #bunch_weight').val());
        //alert(yeil);
        $('#edit_modal #yeild').val(yeil.toFixed(2));
     });
     
     
     
     
     $(".item_type").click(function() {  
        if($(this).val() == 'Parent') {
            $('.child_itm').addClass('show').removeClass('hide');
        } else {
            $('.child_itm').addClass('hide').removeClass('show');
        }
     });  
        
     $(".edit_record").click(function() {  
            //alert($(this).val());
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'get-pattern', id: $(this).val() },
            success: function(d) {  
              // alert(d.child_pattern_5_pt_wt);  
                 
              $('#edit_modal #pattern_id').val(d.pattern_id) ;   
              $('#edit_modal #customer_id').val(d.customer_id.split(',')).trigger('change'); ;    
              $('#edit_modal #pattern_item').val(d.pattern_item) ;   
              //$('#edit_modal #pattern_code').val(d.pattern_code) ;   
              $('#edit_modal #no_of_core').val(d.no_of_core) ;   
              $('#edit_modal #match_plate_no').val(d.match_plate_no) ;   
              $('#edit_modal #item_description').val(d.item_description) ;   
              $('#edit_modal #grade').val(d.grade) ;   
              $('#edit_modal #no_of_cavity').val(d.no_of_cavity) ;   
              $('#edit_modal #pattern_material').val(d.pattern_material) ;   
              $('#edit_modal #no_of_core_box').val(d.no_of_core_box) ;   
              $('#edit_modal #no_of_core_per_box').val(d.no_of_core_per_box) ;   
              $('#edit_modal #corebox_material').val(d.corebox_material) ;   
              $('#edit_modal #pattern_maker_id').val(d.pattern_maker_id) ;   
              $('#edit_modal #piece_weight_per_kg').val(d.piece_weight_per_kg) ;   
              $('#edit_modal #bunch_weight').val(d.bunch_weight) ;   
              $('#edit_modal #core_maker_rate').val(d.core_maker_rate) ;   
              $('#edit_modal #grinding_rate').val(d.grinding_rate) ;   
              $('#edit_modal #box_size').val(d.box_size) ;   
              $('#edit_modal #core_weight').val(d.core_weight) ;   
              $('#edit_modal #casting_weight').val(d.casting_weight) ;   
              $('#edit_modal #rate_per_kg').val(d.rate_per_kg) ;   
              $('#edit_modal #rate_per_piece').val(d.rate_per_piece) ; 
              $('#edit_modal #yeild').val(d.yeild) ; 
              $('#edit_modal #type_of_core').val(d.type_of_core) ; 
              
              $('#edit_modal #C').val(d.C) ; 
              $('#edit_modal #SI').val(d.SI) ; 
              $('#edit_modal #Mn').val(d.Mn) ; 
              $('#edit_modal #P').val(d.P) ; 
              $('#edit_modal #S').val(d.S) ; 
              $('#edit_modal #Cr').val(d.Cr) ;  
              $('#edit_modal #Cu').val(d.Cu) ;  
              $('#edit_modal #Mg').val(d.Mg) ;  
              $('#edit_modal #ni').val(d.ni) ;  
              $('#edit_modal #mo').val(d.mo) ;  
              $('#edit_modal #BHN').val(d.BHN) ;  
              $('#edit_modal #tensile').val(d.tensile) ;  
              $('#edit_modal #elongation').val(d.elongation) ;  
              $('#edit_modal #yeild_strength').val(d.yeild_strength) ;  
              $('#edit_modal #poring_temp').val(d.poring_temp) ;  
              $('#edit_modal #inoculant_percentage').val(d.inoculant_percentage) ;  
              $('#edit_modal #knock_out_time').val(d.knock_out_time) ;  
              $('#edit_modal #boring').val(d.boring) ;  
              $('#edit_modal #ms').val(d.ms) ;  
              $('#edit_modal #foundry_return').val(d.foundry_return) ;  
              $('#edit_modal #CI_scrap').val(d.CI_scrap) ;  
              $('#edit_modal #pig_iron').val(d.pig_iron) ;  
              $('#edit_modal #chaplet_size').val(d.chaplet_size) ;  
              $('#edit_modal #core_reinforcement').val(d.core_reinforcement) ;  
              $('#edit_modal #special_instructions').val(d.special_instructions) ; 
              $('#edit_modal #moulding_instruction').val(d.moulding_instruction) ; 
               
              $('#edit_modal input:checkbox[value="'+ d.core_box +'"]').prop('checked', true);  
              $('#edit_modal input:radio[value="'+ d.with_transportation +'"]').prop('checked', true);  
              $('#edit_modal input:radio[value="'+ d.supplied_by +'"]').prop('checked', true);  
              $('#edit_modal input:radio[value="'+ d.pattern_type +'"]').prop('checked', true);  
              $('#edit_modal input:radio[value="'+ d.status +'"]').prop('checked', true); 
              $('#edit_modal input:radio[value="'+ d.item_type +'"]').prop('checked', true);
              
              $('#edit_modal #child_pattern_1').val(d.child_pattern_1) ; 
              $('#edit_modal #child_pattern_2').val(d.child_pattern_2) ; 
              $('#edit_modal #child_pattern_3').val(d.child_pattern_3) ; 
              $('#edit_modal #child_pattern_4').val(d.child_pattern_4) ; 
              $('#edit_modal #child_pattern_5').val(d.child_pattern_5) ; 
              $('#edit_modal #child_pattern_6').val(d.child_pattern_6) ; 
              $('#edit_modal #child_pattern_7').val(d.child_pattern_7) ; 
              $('#edit_modal #child_pattern_1_cavity').val(d.child_pattern_1_cavity) ; 
              $('#edit_modal #child_pattern_2_cavity').val(d.child_pattern_2_cavity) ; 
              $('#edit_modal #child_pattern_3_cavity').val(d.child_pattern_3_cavity) ; 
              $('#edit_modal #child_pattern_4_cavity').val(d.child_pattern_4_cavity) ; 
              $('#edit_modal #child_pattern_5_cavity').val(d.child_pattern_5_cavity) ; 
              $('#edit_modal #child_pattern_6_cavity').val(d.child_pattern_6_cavity) ; 
              $('#edit_modal #child_pattern_7_cavity').val(d.child_pattern_7_cavity) ; 
              $('#edit_modal #child_pattern_1_pt_wt').val(d.child_pattern_1_pt_wt) ; 
              $('#edit_modal #child_pattern_2_pt_wt').val(d.child_pattern_2_pt_wt) ; 
              $('#edit_modal #child_pattern_3_pt_wt').val(d.child_pattern_3_pt_wt) ;  
              $('#edit_modal #child_pattern_4_pt_wt').val(d.child_pattern_4_pt_wt) ;  
              $('#edit_modal #child_pattern_5_pt_wt').val(d.child_pattern_5_pt_wt) ;  
              $('#edit_modal #child_pattern_6_pt_wt').val(d.child_pattern_6_pt_wt) ;  
              $('#edit_modal #child_pattern_7_pt_wt').val(d.child_pattern_7_pt_wt) ;  
              
              /*
              $("#edit_modal .child_pattern > option").remove();      
              
              $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: d.customer_id,pattern_type:'' },
                success: function(d1) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Child Pattern Item');
                    $('#edit_modal .child_pattern').append(opt1);
                    
                    $.each(d1,function(key,info) 
	                {
	                      if(d.child_pattern_1 == info.pattern_id) {  
	                           var newOption = new Option(info.pattern_item , info.pattern_id, false, true);
	                      } else {
                               var newOption = new Option(info.pattern_item , info.pattern_id, false, false);
                          }
                         $('#edit_modal #child_pattern_1').append(newOption).trigger('change')  ;
                         
                         if(d.child_pattern_2 == info.pattern_id) {  
	                           var newOption = new Option(info.pattern_item , info.pattern_id, false, true);
	                      } else {
                               var newOption = new Option(info.pattern_item , info.pattern_id, false, false);
                          }
                         $('#edit_modal #child_pattern_2').append(newOption).trigger('change')  ;
                         
                         if(d.child_pattern_3 == info.pattern_id) {  
	                           var newOption = new Option(info.pattern_item , info.pattern_id, false, true);
	                      } else {
                               var newOption = new Option(info.pattern_item , info.pattern_id, false, false);
                          }
                         $('#edit_modal #child_pattern_3').append(newOption).trigger('change')  ;
                         
	                });  
			
    				 
                }
         });  */
              
              
            }
         });
         
     });
     
     
     $('#add_modal #child_pattern_1').change(function() { 
       var f =  $("#add_modal #child_pattern_1 option:selected").text().split(" || "); 
       //alert(f[1]);
       //alert($("#add_modal #child_pattern_1 option:selected").text());
       $("#add_modal #child_pattern_1_pt_wt").val(f[1]);
     });
     
     $('#add_modal #child_pattern_2').change(function() { 
       var f =  $("#add_modal #child_pattern_2 option:selected").text().split(" || ");  
       $("#add_modal #child_pattern_2_pt_wt").val(f[1]);
     });
     $('#add_modal #child_pattern_3').change(function() { 
       var f =  $("#add_modal #child_pattern_3 option:selected").text().split(" || ");  
       $("#add_modal #child_pattern_3_pt_wt").val(f[1]);
     });
     $('#add_modal #child_pattern_4').change(function() { 
       var f =  $("#add_modal #child_pattern_4 option:selected").text().split(" || ");  
       $("#add_modal #child_pattern_4_pt_wt").val(f[1]);
     });
     $('#add_modal #child_pattern_5').change(function() { 
       var f =  $("#add_modal #child_pattern_5 option:selected").text().split(" || ");  
       $("#add_modal #child_pattern_5_pt_wt").val(f[1]);
     });
     $('#add_modal #child_pattern_6').change(function() { 
       var f =  $("#add_modal #child_pattern_6 option:selected").text().split(" || ");  
       $("#add_modal #child_pattern_6_pt_wt").val(f[1]);
     });
      $('#add_modal #child_pattern_7').change(function() { 
       var f =  $("#add_modal #child_pattern_7 option:selected").text().split(" || ");  
       $("#add_modal #child_pattern_7_pt_wt").val(f[1]);
     });
     
     $('#add_modal #grade').change(function() {   
        
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-grade', id: $(this).val(),  },
                success: function(d) {       
              
                      $('#add_modal #C').val(d.C) ; 
                      $('#add_modal #SI').val(d.SI) ; 
                      $('#add_modal #Mn').val(d.Mn) ; 
                      $('#add_modal #P').val(d.P) ; 
                      $('#add_modal #S').val(d.S) ; 
                      $('#add_modal #Cr').val(d.Cr) ;  
                      $('#add_modal #Cu').val(d.Cu) ;  
                      $('#add_modal #Mg').val(d.Mg) ;  
                      $('#add_modal #BHN').val(d.BHM) ;  
                      $('#add_modal #tensile').val(d.tensile) ;  
                      $('#add_modal #elongation').val(d.elongation) ;  
                      $('#add_modal #yeild_strength').val(d.yeild_strength) ;  
                      
                }
         });  
      
     });
     
     
     
   /*  $('#add_modal #customer_id').change(function() {  
        $("#add_modal .child_pattern > option").remove();      
          $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val(),pattern_type:'' },
                success: function(d) {  
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('Select Pattern Item');
                    $('#add_modal .child_pattern').append(opt1); 
			
    				$.each(d,function(key,info) 
	                {
	                    var opt1 = $('<option />'); 
	                    opt1.val(info.pattern_id);
	                    opt1.text(info.match_plate_no + ' || ' + info.pattern_item );
	                    $('#add_modal .child_pattern').append(opt1); 
	                });
                }
         });  
     });*/
      
     
    /* $(".user_record").click(function() {  
        $('#user_modal #franchise_id').val($(this).val());
        $.ajax({
                url: "<?php echo site_url('get-content');?>",
                type: "post",
                data: { tbl : 'franchises_users', id: $(this).val() ,edit_mode : 1, del_mode : 1},
                success: function(ctnt) {                                 
                     //alert(ctnt);
                    $('#user_modal .user_list').html(ctnt) ; 
                    // #FC6705
                }
        }); 
        
     });*/   
     
    /* $(document).on('click','#user_modal .btn_chld_edit', function () {
        //alert('hi' + $(this).val());
        //alert($('#user_modal #franchise_id').val());
        $('#user_modal #user_id').val($(this).val());
        $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-franchise-user', id: $(this).val() },
                success: function(d) {                                 
                     //alert(ctnt);
                    $('#user_modal #mode').val('Edit User') ;  
                    $('#user_modal #first_name').val(d.first_name) ;  
                    $('#user_modal #user_name').val(d.user_name) ;  
                    $('#user_modal #pwd').val(d.pwd) ;  
                    $('#user_modal #email').val(d.email) ;  
                    $('#user_modal #mobile').val(d.mobile) ;  
                    $('#user_modal input:radio[value="'+ d.status +'"]').prop('checked', true); 
                    $('#user_modal #first_name').focus();
                }
        }); 
     }); */
     
     
     $(".view_record").click(function() {  
            //alert($(this).val());
            $.ajax({
                        url: "<?php echo site_url('get-content');?>",
                        type: "post",
                        data: { tbl : 'pattern_info', id: $(this).val() ,edit_mode : 0, del_mode : 0},
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
                    data: { tbl : 'pattern_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     }); 
        
     
});
</script>