<!-- ChartJS -->
<script src="<?php echo base_url() ?>asset/bower_components/chart.js/Chart.js"></script> 
<script>
jQuery(function($) {    
    
    $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });  
    
     $("#srch_customer_id").change(function() {  
	   //alert($(this).val());  
       $.ajax({
                url: "<?php echo site_url('get-data');?>",
                type: "post",
                data: { tbl : 'get-customer-pattern', id: $(this).val() },
                success: function(d) { 
                    //alert(d.pattern_id);
                   $("#srch_pattern_id > option").remove();   
                        
                    var opt1 = $('<option />'); 
                    opt1.val('');
                    opt1.text('All Item');
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
            
     });
    
    
    <?php if(isset($record_list)) {   //echo $tot_prod_wt; ?>
    
     var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    
     
    
   
    
   var pieChartCanvas2 = $('#pieChart_grp').get(0).getContext('2d')
    var pieChart_grp       = new Chart(pieChartCanvas2)
    
    var PieData2        = [ 
        <?php foreach($rej_group as $grp => $info) {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];    
        ?>
          {
            value    : '<?php echo array_sum($info['qty']); ?>',
            color    : '<?php echo $color; ?>',
            highlight: '<?php echo $color; ?>',
            label    : '<?php echo $grp; ?>'
          },
        <?php } ?>
    ]
    
     pieChart_grp.Doughnut(PieData2, pieOptions);
     
     
     
     
    
    
     
     
    
  
   <?php } ?>
});
</script>     