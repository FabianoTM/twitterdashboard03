<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

	<div id="chartContainer" style="height:400px; width:100%;"></div>

	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="canvasjs.min.js"></script>
	<script type="text/javascript">

		$.ajax({
			url: 'client.php',			
			success: function(data) {

				var json = JSON.parse(data);

				var tweets = "tweets: " + json.total_rows;

				var dps = [		
					{label: "Falando Bem", y: json.good_tweets},
					{label: "Falando Mal", y: json.bad_tweets}				
				];

				var chart = new CanvasJS.Chart("chartContainer",{
					theme: "theme2",
					title:{ 
						text: "O que estão falando da Fiap?"
					},
					legend:{
						verticalAlign: "top",
						horizontalAlign: "centre",
						fontSize: 18

					},
					data : [{
						type: "column",
						showInLegend: true,
						legendMarkerType: "none",				
						legendText: tweets,
						indexLabel: "{y}",
						dataPoints: dps
					}]
				});

				chart.render();

				var connection = new WebSocket('wss://socket-server03.mybluemix.net');
				connection.onopen = function () {
				  connection.send('Ping');
				};
				
				connection.onerror = function (error) {
				  console.log('WebSocket Error ' + error);
				};

				connection.onmessage = function (e) {				  	
				  	var json = JSON.parse(e.data);	

				  	dps[0].y = json.good_tweets;
					dps[1].y = json.bad_tweets;					
					totalEmployees = "tweets: " + json.total_rows;			
					chart.options.data[0].legendText = totalEmployees;	

					chart.render();
				  
				};

			}
		});

		</script>
</body>

