 <script src="<?php echo base_url() ?>asset/bower_components/chart.js/Chart.js"></script> 
<script>
jQuery(function($) {  
    
    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : true,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    } 
   
   <?php
    if($submit_flg) {  
        foreach($mrm_target as $grp => $det) {  
    ?>   

    var areaChartData_<?php echo $grp;?> = {
      labels  : ['<?php  echo implode("','", $actual_data[$grp]['month']) ?>'],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($det['chart_data'] as $k => $info) { echo "'" . $mrm_target[$grp]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : '<?php echo $det['mrm_target_name'];?>',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php  echo implode(',', $actual_data[$grp]['data']) ?>]
        }
      ]
    }

     
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas_<?php echo $grp;?>          = $('#lineChart_<?php echo $grp;?>').get(0).getContext('2d')
    var lineChart_<?php echo $grp;?>                = new Chart(lineChartCanvas_<?php echo $grp;?>)
    var lineChartOptions_<?php echo $grp;?>         = areaChartOptions
    lineChartOptions_<?php echo $grp;?>.datasetFill = false
    lineChart_<?php echo $grp;?>.Line(areaChartData_<?php echo $grp;?>, lineChartOptions_<?php echo $grp;?>);
    
    
    <?php } ?> 
<?php } ?>    
    
    
});
</script>  