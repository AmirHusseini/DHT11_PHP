<?php
//connect to the database
include "condb.php";

//select the last 20 data from database
$sql = "SELECT ID, humidity, temperature, date FROM dht11 ORDER BY id DESC LIMIT 20";

// create PHP array
$php_data_arra = Array(); 

//make a table
echo '<table class="fixed_header">
	<thead>	
      <tr> 
        <th>ID</th> 
        <th>Humidity</th> 
        <th>Temperature</th>
        <th>Date and Time</th> 
      </tr>
	  </thead>';
	  
 if ($result = $conn->query($sql)) {
	 

	 //fetch the data and put them in the table
    while ($row = $result->fetch_row()) 
	{
        $row_id = $row[0];
        $row_humidity = $row[1];
        $row_temperature = $row[2];
        $row_reading_time = $row[3];

        echo '<tbody>
			<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_humidity . '%</td> 
                <td>' . $row_temperature . ' °C</td>
                <td>' . $row_reading_time . '</td> 
				
			  </tr>
			  </tbody>';
		$php_data_arra[] = $row; // Adding to array
		$php_data_array = array_reverse($php_data_arra); // reverse the array for chart
	}
 echo '</table>';
 }
else{
echo $connection->error;
}
  

// Transfor PHP array to JavaScript two dimensional array 
echo "<script>
        var my_2d = ".json_encode($php_data_array)."
</script>";
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">


      // Load the Visualization API and the corechart package.
      google.charts.load('current', {packages: ['corechart']});
      google.charts.setOnLoadCallback(drawChart);
	  
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
       data.addColumn('string', 'date');
		data.addColumn('number', 'temperature');
		
        for(i = 0; i < my_2d.length; i++)
			data.addRow([my_2d[i][3], parseInt(my_2d[i][2])]);
		
		//setting for the chart
		var options = {
          title: 'Hemma Temperature',
        curveType: 'function',
		width: 800,
        height: 500,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
		
		 var button = document.getElementById('change');

        button.onclick = function () {

          // change the table to humidity
          var data = new google.visualization.DataTable();
			data.addColumn('string', 'date');
			data.addColumn('number', 'humidity');
		
        for(i = 0; i < my_2d.length; i++)
			data.addRow([my_2d[i][3], parseInt(my_2d[i][1])]);
			
var options = {
          title: 'Hemma Humidity',
        curveType: 'function',
		width: 800,
        height: 500,
		colors:['red','#004411','Black'],
        legend: { position: 'bottom' }
        };
          chart.draw(data, options);
        };
       }
	
</script>
