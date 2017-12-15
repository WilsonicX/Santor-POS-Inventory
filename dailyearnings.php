<!DOCTYPE html>
<html>
<head>	
	<title>Earnings</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<script src="js/jquery-1.11.3-jquery.min.js"></script> 
	<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>	
</head>

<body>
<div class="col-md-12" style="background-color:#FFFFFF; border-style: none; border-radius:5px; box-shadow: 2px 2px 10px #bcbcbc;  margin-bottom: 2.5em;">
		<h2>Enter Date</h2>
		<form class="col-md-4" name="form2" method="post" action="dailyearningsreport.php">
			<input class="form-control" type="date" name="date" required><a class="btn btn-danger" href="history_view.php"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a><input class="btn btn-info" type="submit" name="datesubmit" value="Submit">
		</form>
</div>
</body>
</html>
