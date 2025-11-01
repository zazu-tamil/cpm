<!-- ChartJS -->
<script src="<?php echo base_url() ?>asset/bower_components/chart.js/Chart.js"></script> 
<script>
jQuery(function($) {  
    
     

    var areaChartData = {
      labels  : [ <?php foreach($moulding as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($moulding as $k => $info) { echo "'" . $mrm_target[1]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($moulding as $k => $info) { echo  $info['produced_box'] . ","; }?>]
        }
      ]
    }

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

    
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart_1').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData, lineChartOptions);
    
    
    var areaChartData_2 = {
      labels  : [ <?php foreach($melting as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($melting as $k => $info) { echo "'" . $mrm_target[2]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($melting as $k => $info) { echo  number_format(($info['liquid_metal']/1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_2          = $('#lineChart_2').get(0).getContext('2d')
    var lineChart_2                = new Chart(lineChartCanvas_2)
    var lineChartOptions_2         = areaChartOptions
    lineChartOptions_2.datasetFill = false
    lineChart_2.Line(areaChartData_2, lineChartOptions_2);
    
    
    
    var areaChartData_3 = {
      labels  : [ <?php foreach($melting as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($melting as $k => $info) { echo "'" . $mrm_target[3]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($melting as $k => $info) { echo  number_format(($info['poured_casting_wt']/1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_3          = $('#lineChart_3').get(0).getContext('2d')
    var lineChart_3                = new Chart(lineChartCanvas_3)
    var lineChartOptions_3         = areaChartOptions
    lineChartOptions_3.datasetFill = false
    lineChart_3.Line(areaChartData_3, lineChartOptions_3);
    
    
    
    var areaChartData_4 = {
      labels  : [ <?php foreach($melting as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($melting as $k => $info) { echo "'" . $mrm_target[4]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($melting as $k => $info) { echo  number_format((($info['poured_casting_wt'] -  $rejection[$k]['rej_wt'])/1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_4          = $('#lineChart_4').get(0).getContext('2d')
    var lineChart_4                = new Chart(lineChartCanvas_4)
    var lineChartOptions_4         = areaChartOptions
    lineChartOptions_4.datasetFill = false
    lineChart_4.Line(areaChartData_4, lineChartOptions_4);
    
    
     var areaChartData_5 = {
      labels  : [ <?php foreach($melting as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($melting as $k => $info) { echo "'" . $mrm_target[5]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($melting as $k => $info) { echo  number_format(($info['yield']),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_5          = $('#lineChart_5').get(0).getContext('2d')
    var lineChart_5                = new Chart(lineChartCanvas_5)
    var lineChartOptions_5         = areaChartOptions
    lineChartOptions_5.datasetFill = false
    lineChart_5.Line(areaChartData_5, lineChartOptions_5);
    
    
    
    var areaChartData_6 = {
      labels  : [ <?php foreach($production as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($production as $k => $info) { echo "'" . $mrm_target[6]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($production as $k => $info) { echo  number_format(($info['production_wt'] / 1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_6          = $('#lineChart_6').get(0).getContext('2d')
    var lineChart_6                = new Chart(lineChartCanvas_6)
    var lineChartOptions_6         = areaChartOptions
    lineChartOptions_6.datasetFill = false
    lineChart_6.Line(areaChartData_6, lineChartOptions_6);
    
    
    var areaChartData_7 = {
      labels  : [ <?php foreach($rejection as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($rejection as $k => $info) { echo "'" . $mrm_target[7]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($rejection as $k => $info) { echo  number_format(($info['rej_wt'] / 1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_7          = $('#lineChart_7').get(0).getContext('2d')
    var lineChart_7                = new Chart(lineChartCanvas_7)
    var lineChartOptions_7         = areaChartOptions
    lineChartOptions_7.datasetFill = false
    lineChart_7.Line(areaChartData_7, lineChartOptions_7);
    
    
    var areaChartData_8 = {
      labels  : [ <?php foreach($rejection as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($rejection as $k => $info) { echo "'" . $mrm_target[8]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($production as $k => $info) { echo  number_format((($rejection[$k]['rej_wt'] * 100) / $info['production_wt']),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_8          = $('#lineChart_8').get(0).getContext('2d')
    var lineChart_8                = new Chart(lineChartCanvas_8)
    var lineChartOptions_8         = areaChartOptions
    lineChartOptions_8.datasetFill = false
    lineChart_8.Line(areaChartData_8, lineChartOptions_8);
    
    
     var areaChartData_9 = {
      labels  : [ <?php foreach($moulding_rej as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($moulding_rej as $k => $info) { echo "'" . $mrm_target[9]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($moulding_rej as $k => $info) { echo  number_format(($info['rej_wt'] * 100 / $production[$k]['production_wt']),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_9          = $('#lineChart_9').get(0).getContext('2d')
    var lineChart_9                = new Chart(lineChartCanvas_9)
    var lineChartOptions_9         = areaChartOptions
    lineChartOptions_9.datasetFill = false
    lineChart_9.Line(areaChartData_9, lineChartOptions_9);
    
    
    var areaChartData_10 = {
      labels  : [ <?php foreach($melting_rej as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($melting_rej as $k => $info) { echo "'" . $mrm_target[10]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($melting_rej as $k => $info) { echo  number_format(($info['rej_wt'] * 100 / $production[$k]['production_wt']),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_10          = $('#lineChart_10').get(0).getContext('2d')
    var lineChart_10                = new Chart(lineChartCanvas_10)
    var lineChartOptions_10         = areaChartOptions
    lineChartOptions_10.datasetFill = false
    lineChart_10.Line(areaChartData_10, lineChartOptions_10);
    
    
    var areaChartData_11 = {
      labels  : [ <?php foreach($fettling_rej as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($fettling_rej as $k => $info) { echo "'" . $mrm_target[11]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($fettling_rej as $k => $info) { echo  number_format(($info['rej_wt'] * 100 / $production[$k]['production_wt']),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_11          = $('#lineChart_11').get(0).getContext('2d')
    var lineChart_11                = new Chart(lineChartCanvas_11)
    var lineChartOptions_11         = areaChartOptions
    lineChartOptions_11.datasetFill = false
    lineChart_11.Line(areaChartData_11, lineChartOptions_11);
    
    
     var areaChartData_12 = {
      labels  : [ <?php foreach($power as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($power as $k => $info) { echo "'" . $mrm_target[12]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($power as $k => $info) { echo  number_format((($info['unit'] / $melting[$k]['liquid_metal']) * 1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_12          = $('#lineChart_12').get(0).getContext('2d')
    var lineChart_12                = new Chart(lineChartCanvas_12)
    var lineChartOptions_12         = areaChartOptions
    lineChartOptions_12.datasetFill = false
    lineChart_12.Line(areaChartData_12, lineChartOptions_12);
    
    
     var areaChartData_13 = {
      labels  : [ <?php foreach($despatch as $k => $info) { echo "'" . $info['al_month'] . "',"; }?>],
      datasets: [
        {
          label               : 'Target',
          fillColor           : 'rgba(199, 54, 12, 1)',
          strokeColor         : 'rgba(199, 54, 12, 1)',
          pointColor          : 'rgba(199, 54, 12, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php foreach($despatch as $k => $info) { echo "'" . $mrm_target[13]['mrm_target_value'] . "',"; }?>]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php foreach($despatch as $k => $info) { echo  number_format(($info['despatch_wt'] /1000),2) . ","; }?>]
        }
      ]
    }
    
    
    var lineChartCanvas_13          = $('#lineChart_13').get(0).getContext('2d')
    var lineChart_13                = new Chart(lineChartCanvas_13)
    var lineChartOptions_13         = areaChartOptions
    lineChartOptions_13.datasetFill = false
    lineChart_13.Line(areaChartData_13, lineChartOptions_13);
    
    
});
</script>       