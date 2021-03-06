<html>
<head>
   <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href='//fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
<title>Manager Home</title>
</head>
<body style="background-color:#afd8d1">
    <?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();

    if($_SESSION['email']==null){
        header('Location: store-login.php');
    }
    ?>
    <?php 
    //get store Name
    $storeID=$_SESSION['storeID'];
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $query="SELECT storeName from stores where id=$storeID;";
    $result = queryDB($query, $db);
    $row = nextTuple($result);
    $storeName=$row['storeName'];
    ?>
    
     <div class="heading">
		<h1 style="color:#656b6a; font-family: 'Poppins';"><?php echo $storeName;?></h1>
        
	</div>

    <nav class="navbar navbar-default" style=" border-color:white">
        <div class="container-fluid">
            
            <ul class="nav navbar-nav" style="font-color:#2a2a2b; font-family: 'Poppins';">
			    <li class="active"><a href="Manager_Home.php">Home</a></li>
			    <li><a href="categories.php">Categories</a></li>
                <li><a href="items.php">Items</a></li>
			    <li><a href="ManageOrders.php">Orders</a></li>
                <li><a href="ManageStore.php">Store</a></li>
                <li><a href="manage-employees.php">Employees</a></li>
                <li><a href="ManageCustomers.php">Customers</a></li>
                <li><a href="customerHomeForEdits.php"  target="_blank" >Store Front</a></li>
                
		    </ul>
            <ul class="nav navbar-nav navbar-right"style="font-color:#2a2a2b; font-family: 'Poppins'; padding-right:3%" >
            <li><a href="store-logout.php">Log Out </a></li>
            </ul>
            
        </div>
    </nav>
    <!--card button to get to the Order Managment-->
<div class="jumbotron" style ="padding-top:3%;background-color:#acefef">
    <div class="container" style ="padding-top:3%;background-color:#acefef">
    <div class="row">
        <div class="col-xs-5" style="padding-left:10%; padding-right:5%">
            <a style="text-decoration:none; color:#6B6867" href="ManageOrders.php">
            <div class="card text-center" style="background-color:white;">
            <div class="card-block" style="padding-left:5%; padding-right:5%;">
                <blockquote class="card-blockquote">
                <h1 style="color:#656b6a">Orders</h1>
                </blockquote>
            </div>
            </div>
            </a>
        </div>
        <div class="col-xs-1">
        </div>
        <div class="col-xs-5" style="padding-left:10%; padding-right:5%">
            <a style="text-decoration:none; color:#6B6867;" href="items.php">
            <div class="card text-center" style="background-color:white">
            <div class="card-block">
                <blockquote class="card-blockquote">
                <h1 style="color:#656b6a">Items</h1>
                </blockquote>
            </div>
            </div>
            </a>
        </div>
    </div>
    </div>
</div>
    
</body>
<footer>
    <b style="color:#656b6a">Admin: </b>
    jessica-lu@uiowa.edu
</footer>
</html>
