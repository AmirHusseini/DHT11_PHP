<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="style.css">
	<title>Hemma</title>
	<meta charset="UTF-8">
</head>
<body>

<header> 
<h1> Welcome to my home weather station! </h1>
<p> Here we can see the temperature and Humidity directly from Database. </p>
</header>


<aside>

<div id="table-scroll">
<?php
include 'tabledata.php';
?> 
</div>

</aside>

<section>

<button id="change">Click to see the Humidity chart</button>
<div id="curve_chart"></div>

</section>

</body>
</html>