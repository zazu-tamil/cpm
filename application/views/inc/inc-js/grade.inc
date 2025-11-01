<script>
jQuery(function($) {    


    $(".edit_record").click(function() {  
     
     // alert($(this).closest('tr').find('td').eq(1).text());
      
      var grade_name = $(this).closest('tr').find('td').eq(1).text();
      var C = $(this).closest('tr').find('td').eq(2).text();  
      var SI = $(this).closest('tr').find('td').eq(3).text();  
      var Mn = $(this).closest('tr').find('td').eq(4).text();  
      var P = $(this).closest('tr').find('td').eq(5).text();  
      var S = $(this).closest('tr').find('td').eq(6).text();  
      var Cr = $(this).closest('tr').find('td').eq(7).text();  
      var Cu = $(this).closest('tr').find('td').eq(8).text();   
      var Mg = $(this).closest('tr').find('td').eq(9).text();  
      var BHM = $(this).closest('tr').find('td').eq(10).text();  
      var tensile = $(this).closest('tr').find('td').eq(11).text();  
      var elongation = $(this).closest('tr').find('td').eq(12).text();  
      var yeild_strength = $(this).closest('tr').find('td').eq(13).text();  
      var c_status = $(this).closest('tr').find('td').eq(14).text();  
      
      $('#edit_modal #grade_id').val($(this).val()) ; 
      $('#edit_modal #grade_name').val(grade_name) ; 
      $('#edit_modal #C').val(C) ; 
      $('#edit_modal #SI').val(SI) ; 
      $('#edit_modal #Mn').val(Mn) ; 
      $('#edit_modal #P').val(P) ; 
      $('#edit_modal #S').val(S) ; 
      $('#edit_modal #Cr').val(Cr) ;  
      $('#edit_modal #Cu').val(Cu) ;  
      $('#edit_modal #Mg').val(Mg) ;  
      $('#edit_modal #BHM').val(BHM) ;  
      $('#edit_modal #tensile').val(tensile) ;  
      $('#edit_modal #elongation').val(elongation) ;  
      $('#edit_modal #yeild_strength').val(yeild_strength) ; 
      $('#edit_modal input:radio[value='+ c_status +']').prop('checked', true);  
    });
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'grade', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  

});
</script> 