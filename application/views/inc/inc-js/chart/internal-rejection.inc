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
    //var randomColor = Math.floor(Math.random()*16777215).toString(16);
    
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    
    var PieData        = [
        <?php foreach($record_list as $info) {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];    
        ?>
          {
            value    : '<?php echo $info['rej_wt']; ?>',
            color    : '<?php echo $color; ?>',
            highlight: '<?php echo $color; ?>',
            label    : '<?php echo $info['item']; ?>'
          },
        <?php } ?>
    ]
    
     
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
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)
    
    
    var pieChartCanvas1 = $('#pieChart_qty').get(0).getContext('2d')
    var pieChart_qty       = new Chart(pieChartCanvas1)
    
    var PieData1        = [
        <?php foreach($record_list as $info) {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];    
        ?>
          {
            value    : '<?php echo $info['rejection_qty']; ?>',
            color    : '<?php echo $color; ?>',
            highlight: '<?php echo $color; ?>',
            label    : '<?php echo $info['item']; ?>'
          },
        <?php } ?>
    ]
    
     pieChart_qty.Doughnut(PieData1, pieOptions)
    
   
    
    var pieChartCanvas1 = $('#pieChart_tot').get(0).getContext('2d')
    var pieChart_tot       = new Chart(pieChartCanvas1)
    
    var PieData1        = [ 
          {
            value    : '<?php echo $tot_prod_wt;?>',
            color    : '#008000',
            highlight: '#008000',
            label    : 'Production'
          }, 
          {
            value    : '<?php echo $tot_rej_wt; ?>',
            color    : '#FF0000',
            highlight: '#FF0000',
            label    : 'Rejection'
          }, 
    ]
    
     pieChart_tot.Doughnut(PieData1, pieOptions);
     
     
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
     
     
    var pieChartCanvas3 = $('#pieChart_grp_wt').get(0).getContext('2d')
    var pieChart_grp_wt       = new Chart(pieChartCanvas3)
    
    var PieData3        = [ 
        <?php foreach($rej_group as $grp => $info) {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];    
        ?>
          {
            value    : '<?php echo array_sum($info['wt']); ?>',
            color    : '<?php echo $color; ?>',
            highlight: '<?php echo $color; ?>',
            label    : '<?php echo $grp; ?>'
          },
        <?php } ?>
    ]
    
     pieChart_grp_wt.Doughnut(PieData3, pieOptions);
     
     
    <?php foreach($rej_type_group as $grp => $info1) { ?> 
     
    var pieChartCanvas_<?php echo $grp; ?> = $('#pieChart_<?php echo $grp; ?>').get(0).getContext('2d')
    var pieChart_<?php echo $grp; ?>  = new Chart(pieChartCanvas_<?php echo $grp; ?>)
    
    var PieData_<?php echo $grp; ?>        = [ 
        <?php foreach($info1 as $typ => $info) {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];    
        ?>
          {
            value    : '<?php echo array_sum($info['qty']); ?>',
            color    : '<?php echo $color; ?>',
            highlight: '<?php echo $color; ?>',
            label    : '<?php echo $typ; ?>'
          },
        <?php } ?>
    ]
    
     pieChart_<?php echo $grp; ?>.Doughnut(PieData_<?php echo $grp; ?>, pieOptions);
    
    <?php } ?>
    
    <?php foreach($rej_type_group as $grp => $info1) { ?> 
     
    var pieChartCanvas_wt_<?php echo $grp; ?> = $('#pieChart_wt_<?php echo $grp; ?>').get(0).getContext('2d')
    var pieChart_wt_<?php echo $grp; ?>  = new Chart(pieChartCanvas_wt_<?php echo $grp; ?>)
    
    var PieData_wt_<?php echo $grp; ?>        = [ 
        <?php foreach($info1 as $typ => $info) {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];    
        ?>
          {
            value    : '<?php echo array_sum($info['wt']); ?>',
            color    : '<?php echo $color; ?>',
            highlight: '<?php echo $color; ?>',
            label    : '<?php echo $typ; ?>'
          },
        <?php } ?>
    ]
    
     pieChart_wt_<?php echo $grp; ?>.Doughnut(PieData_wt_<?php echo $grp; ?>, pieOptions);
    
    <?php } ?>
    
     
     
    
  
   <?php } ?>
});
</script>     