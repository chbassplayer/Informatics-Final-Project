<!-- This file enables users to login to the system -->
<!-- It also lists the contents of the table -->
<!-- It uses bootstrap for formatting -->


<?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();
    if($_SESSION['email']==null){
        header('Location:store-login.php');
        exit;
    }
    if($_SESSION['AccessItems']==1){
        header("Location: showItemDetail.php?id=".$_GET['id']);
        exit;
    }
    
  
    ?>


<html>
    <head>

<title> Orders Permissions</title>

<!-- This is the code from bootstrap -->        
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href='//fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
    </head>
    
    <body style="background-color:#afd8d1">
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
            <li><a href="Manager_Home.php">Home</a></li>
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


<!-- Processing form input -->        
        <div class="row">
            <div class="col-xs-12">
<?php
$ItemID=$_GET['id'];
//echo $ItemID;




// Code to handle input from form
//

if (isset($_POST['submit'])) {

    // only run if the form was submitted
    
    // get data from form
    $empID = $_POST['employeeID'];

   // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
    
    // check for required fields
    $isComplete = true;
    $errorMessage = "";
    
    if (!$empID) {
        $errorMessage .= " Please enter your ID number.";
        $isComplete = false;
    }

    if (!$isComplete) {
        punt($errorMessage);
    }
   
    
    // get the hashed password from the user with the email that got entered
    $query = "SELECT items FROM employees WHERE id=$empID;";
    $result = queryDB($query, $db);
    if (nTuples($result) > 0) {
        // then that account number exists
		$row =nextTuple($result);
        $answer = $row['items'];
		
		// compare entered password to the password on the database
		if ($answer=true) {
			header("Location:showItemDetail.php?id=".$_GET['id']);
            $_SESSION['AccessItems']=1;
            exit;
            
			
			} else {
			// wrong password
			punt("Access Denied. <a href='canYouChangeItems.php'>Try again</a>.");
            }
    }
}
?>
            </div>
        </div>

<!-- form for inputting data -->
    <div class="container" style="padding-left:3%; padding-right:3%; width:80%;font-family: 'Poppins'; background-color:white">
    <!-- Visible title -->
        <div class="row">
            <div class="col-xs-12">
                <h1>Do you have Access to Items</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <?php //cho "canYouChangeOrders.php?id="."$orderiD";?>
                <form action=<?php echo "canYouChangeItems.php?id=".$ItemID;?> method="post">
                <!-- ID -->
                    <div class="form-group">
                        <label for="employeeID">Enter Your Employee ID please: </label>
                        <input type="text" class="form-control" name="employeeID"/>
                    </div>

                    <button type="submit" class="btn btn-default" name="submit">Enter</button>
                </form>
                        
            </div>
        </div>
    </div>
</div>        

        
    </body>
    
</html>