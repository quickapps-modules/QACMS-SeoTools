<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<table width="100%">
	<tr>
		<td width="50%" align="left">
			<div id="piechart_3d" style="height:400px;"></div>

			<script type="text/javascript">
				google.load("visualization", "1", {packages:["corechart"]});
				google.setOnLoadCallback(drawChart);

				function drawChart() {
					var data = google.visualization.arrayToDataTable([
					  ['Task', 'Factors'],
					  ['<?php echo __d('seo_tools', 'Passed factors'); ?>', <?php echo $results['factors']['essential'][0] + $results['factors']['very_important'][0] + $results['factors']['important'][0]; ?>],
					  ['<?php echo __d('seo_tools', 'Failed factors'); ?>', <?php echo $results['factors']['essential'][1] + $results['factors']['very_important'][1] + $results['factors']['important'][1]; ?>]
					]);

					var options = {
					  title: '<?php echo __d('seo_tools', 'Search engine ranking factors performance'); ?>',
					  is3D: true,
					  colors: ['#109618','#DC3912']
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
					chart.draw(data, options);
				}
			</script>
		</td>

		<td width="50%" align="right">
			<div id="chart_div" style="height:400px;"></div>
			<script type="text/javascript">
				google.load("visualization", "1", {packages:["corechart"]});
				google.setOnLoadCallback(drawChart);
				function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Ranking Factor Importance', '<?php echo __d('seo_tools', 'Factors Passed'); ?>', '<?php echo __d('seo_tools', 'Factors Failed'); ?>'],
					['<?php echo __d('seo_tools', 'Essential'); ?>', <?php echo $results['factors']['essential'][0]; ?>, <?php echo $results['factors']['essential'][1]; ?>],
					['<?php echo __d('seo_tools', 'Very Important'); ?>', <?php echo $results['factors']['very_important'][0]; ?>, <?php echo $results['factors']['very_important'][1]; ?>],
					['<?php echo __d('seo_tools', 'Important'); ?>', <?php echo $results['factors']['important'][0]; ?>, <?php echo $results['factors']['important'][1]; ?>]
				]);

				var options = {
				  title: 'Performance',
				  colors: ['#109618','#DC3912']
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
				chart.draw(data, options);
				}
			</script>
		</td>
	</tr>
</table>