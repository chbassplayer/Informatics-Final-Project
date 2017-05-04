<?php 
session_start();
if ($_SESSION['AccessEmployees']==null){
    header("Location: canYouChangeEmployees.php");
    exit;
}
//echo $_SESSION['AccessEmployees'];
if($_SESSION['email']==null){
    header('Location:store-login.php');
    exit;
}
    
 include_once('config.php');
include_once('dbutils.php');
?>

<html>
    <head>
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href='//fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Employees </title>
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
            <li class="active"><a href="manage-employees.php">Employees</a></li>
            <li><a href="ManageCustomers.php">Customers</a></li>
            <li><a href="customerHomeForEdits.php"  target="_blank" >Store Front</a></li>
            
        </ul>
        <ul class="nav navbar-nav navbar-right"style="font-color:#2a2a2b; font-family: 'Poppins'; padding-right:3%" >
        <li><a href="store-logout.php">Log Out </a></li>
        </ul>
        
    </div>
</nav>
<div class="container" style="padding-left:3%; padding-right:3%; width:80%;font-family: 'Poppins'; background-color:white">
    <div class ="row">
        <div class ="col-xs-12"  style="padding-left:10%;">
        <h1>Manage Employees</h1>
        <h4>Enter New Employees:</h4>
        </div>
    </div>

<!--check if button pressed and complete form -->
<?php
   
    $db=ConnectDB($DBHost, $DBUser,$DBPasswd,$DBName);
    //first i need to check if the button was pressed
    if (isset($_POST['submit'])){
    //then we process
    //get data from the form
    $fName=$_POST['fName'];
    $lName=$_POST['lName'];
    $hasAccessO=$_POST['hasAccessO'];
    $hasAccessE=$_POST['hasAccessE'];
    $hasAccessI=$_POST['hasAccessI'];
    $isComplete = true;
    $errorMessage = "";

    if(!$fName){
        $errorMessage .= "Please enter a first name .\n";
        $isComplete= false;
    }

    if(!$lName){
        $errorMessage .= "Please enter a last name .\n";
        $isComplete= false;
    }
    
    if($isComplete){
    $db=ConnectDB($DBHost, $DBUser,$DBPasswd,$DBName);
    $query="INSERT INTO employees (fName,lName,orders,employees,items) VALUES('$fName','$lName','$hasAccessO','$hasAccessE','$hasAccessI');";
    $result= queryDB($query,$db);
    unset($hasAccess);
    }
}

?>

<!-- Showing successfully entering pizza, if that actually happened -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && $isComplete==true) {
        echo '<div class="alert alert-success" role="alert">';
        echo ("Succesfully entered ". "$fName"." "."$lName");
        echo '</div>';
    }
?>            
    </div>
</div>


<!-- Showing errors, if any -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($_POST['submit']) && !$isComplete) {
        echo '<div class="alert alert-danger" role="alert">';
        echo ($errorMessage);
        echo '</div>';
    }
?>            
    </div>
</div>

<!--FORM FOR ENTERING-->
    <div class="row">
        <div class="col-xs-12"  style="padding-left:10%;padding-right:10%">
        <form action="manage-employees.php" method="post">
        <!-- First Name-->
        <div class="form-group">
            <label for="fName">First Name:</label>
            <input type="text" class="form-control" name="fName"/>
        </div>

        <!-- Last Name-->
        <div class="form-group">
            <label for="lName">Last Name:</label>
            <input type="text" class="form-control" name="lName"/>
        </div>

        <!--Has Access to orders-->
        <div class="form-group">
            <?php $hasAccessO=false?>
            <p><b>Access to Orders:</b></p>
            <label class="radio-inline"><input type="radio" name="hasAccessO" value="1"
            <?php if($hasAccessO || !isset($hasAccessO)) { echo 'checked'; } ?>>Yes</label>
            
            <label class="radio-inline"><input type="radio" name="hasAccessO" value="0"
            <?php if(!$hasAccessO && isset($hasAccessO)) { echo 'checked'; } ?>>No</label>
        </div>

        <!--Has Access to Employees-->
        <div class="form-group">
            <?php $hasAccessE=false?>
            <p><b>Access to Employees:</b></p>
            <label class="radio-inline"><input type="radio" name="hasAccessE" value="1"
            <?php if($hasAccessE || !isset($hasAccessE)) { echo 'checked'; } ?>>Yes</label>
            
            <label class="radio-inline"><input type="radio" name="hasAccessE" value="0"
            <?php if(!$hasAccessE && isset($hasAccessE)) { echo 'checked'; } ?>>No</label>
        </div>

        <!--Has Access to Items-->
        <div class="form-group">
            <?php $hasAccessI=false?>
            <p><b>Access to Items:</b></p>
            <label class="radio-inline"><input type="radio" name="hasAccessI" value="1"
            <?php if($hasAccessI || !isset($hasAccessI)) { echo 'checked'; } ?>>Yes</label>
            
            <label class="radio-inline"><input type="radio" name="hasAccessI" value="0"
            <?php if(!$hasAccessI && isset($hasAccessI)) { echo 'checked'; } ?>>No</label>
        </div>

        
        
        <!--now we need to be able to submit the information-->
        <button type="submit" class="btn btn-default" name="submit">Save</button>

        </form>
        </div>
    </div>
    

<!--here is html for table stuff-->
    <div class="row">
        <div class= "col-xs-12" style="padding-left:10%;padding-right:10%">
            <table class="table table-hover">
            <!--headers-->
            <thead>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Order Access</th>
                <th>Item Access</th>
                <th>Employee Access</th>
                <th></th>
            </thead>
             <?php
    
    //good now we need to see that data:
    //right now I just want to see Name and ID
    $query='select * from employees;';
    $result=queryDB($query,$db);
    //also need to be shown in a table format with all attributes for store
    //to show it you need to set a while loop, 
    while ($row =nextTuple($result)){
        $EmpID=$row['id'];
        echo "\n <tr>";//here tr is table row and we need to make new one for each result
        echo "<td>" . $row['id'] . "</td>";//td is table data 
        echo "<td>" .$row['fName'] . "</td>";
        echo "<td>" .$row['lName'] . "</td>";
        
        $hasAccess0=$row['orders'];
        if($row['orders']==1){
            $OrderAccess="Yes";
        }else{
            $OrderAccess="No";
        }
        echo "<td>" . $OrderAccess . "</td>";

        $hasAccessI=$row['items'];
        if($row['items']==1){
            $ItemAccess="Yes";
        }else{
            $ItemAccess="No";
        }
        echo "<td>" . $ItemAccess . "</td>";

        $hasAccessE=$row['employees'];
        if($row['employees']==1){
            $EmployeesAccess="Yes";
        }else{
            $EmployeesAccess="No";
        }
        echo "<td>" . $EmployeesAccess . "</td>";
        echo "<td><a href=deleteEmployee.php?id=$EmpID>Remove</a></td>";
        echo "<td><a href=UpdateEmployee.php?id=$EmpID>Update</a></td>";

        
    }
    ?>

            </table>
    </div>
        </div>
    </div>
    </body>
    </html>