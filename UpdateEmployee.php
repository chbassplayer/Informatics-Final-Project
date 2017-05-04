<?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();

    if($_SESSION['email']==null){
        header('Location: store-login.php');
    }
    //$_SESSION['AccessOrders']=1;//this makes it so you can see orders the rest of the time :)
    $storeID=$_SESSION['storeID'];

    
    
    
?>

<?php
/*
 *First I want to get all the information that will go into the forms
 
 *
 */
    
    $EmpID=$_GET['id'];
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $queryinfo="SELECT * from employees where id=$EmpID;";
    $resultinfo=queryDB($queryinfo,$db);
    while($row = nextTuple($resultinfo)) {
        $fName=$row['fName'];
        $lName=$row['lName'];
        $orders=$row['orders'];
        $employees=$row['employees'];
        $items=$row['items'];
    }
    
?>

<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href='//fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        
        
        <title>Update Order #<?php echo $orderID; ?></title>
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
    <!-- Processing form input -->        
        <div class="row">
            <div class="col-xs-12">
                <?php
                //
                // Code to handle input from form
                //

                if (isset($_POST['submit'])) {
                    // connect to the database
                    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
                    // only run if the form was submitted
                    
                    // get data from form
                    $NfName=$_POST['fName'];
                    $NlName = $_POST['lName'];
                    $Norders=$_POST['orders'];
                    $Nemployees=$_POST['employees'];
                    $Nitems=$_POST['items'];

                // connect to the database
                    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
                    
                    // check for required fields
                    $isComplete = true;
                    $errorMessage = "";

                    if(!$NfName){
                        $isComplete=false;
                        $errorMessage="need a first name";
                    }
                    if(!$NlName){
                        $isComplete=false;
                        $errorMessage="need a last name ";
                    }
                        
                    if ($isComplete) {
                    
                        // check if there's a user with the same email
                        $query = "UPDATE employees set fName='$NfName', lName='$NlName',orders=
                        $Norders,employees=$Nemployees,items=$Nitems where id=$EmpID;";
                        $result = queryDB($query, $db);
                        header("Location: manage-employees.php");
                        exit;
                        
                        }
                    
                }
                ?>
            </div>
        </div>
        
<!-- Visible title -->
<div class="container" style="padding-left:3%; padding-right:3%; width:80%;font-family: 'Poppins'; background-color:white">
<div class="row">
    <div class="col-xs-12">
        <h1>Update  <?php echo $fName. " ".$lName; ?></h1>
    </div>
</div>

<!-- form to ask what should be changed about the employee -->
<div class="row">
    <div class="col-xs-12">
        <form action= <?php echo "UpdateEmployee.php?id=$EmpID"?> method="post">
        <!-- First Name-->
        <div class="form-group">
            <label for="fName">First Name:</label>
            <input type="text" class="form-control" name="fName" value="<?php echo $fName;?>"/>
        </div>

        <!-- Last Name-->
        <div class="form-group">
            <label for="lName">Last Name:</label>
            <input type="text" class="form-control" name="lName" value="<?php echo $lName; ?>"/>
        </div>

        <!--Has Access to orders-->
        <div class="form-group">
            <?php $hasAccessO=false?>
            <p><b>Access to Orders:</b></p>
            <label class="radio-inline"><input type="radio" name="orders" value="1"
            <?php if($orders || !isset($orders)) { echo 'checked'; } ?>>Yes</label>
            
            <label class="radio-inline"><input type="radio" name="orders" value="0"
            <?php if(!$orders && isset($orders)) { echo 'checked'; } ?>>No</label>
        </div>

        <!--Has Access to Employees-->
        <div class="form-group">
            <?php $hasAccessE=false?>
            <p><b>Access to Employees:</b></p>
            <label class="radio-inline"><input type="radio" name="employees" value="1"
            <?php if($employees || !isset($employees)) { echo 'checked'; } ?>>Yes</label>
            
            <label class="radio-inline"><input type="radio" name="employees" value="0"
            <?php if(!$employees && isset($employees)) { echo 'checked'; } ?>>No</label>
        </div>

        <!--Has Access to Items-->
        <div class="form-group">
            <?php $hasAccessI=false?>
            <p><b>Access to Items:</b></p>
            <label class="radio-inline"><input type="radio" name="items" value="1"
            <?php if($items || !isset($items)) { echo 'checked'; } ?>>Yes</label>
            
            <label class="radio-inline"><input type="radio" name="items" value="0"
            <?php if(!$items && isset($items)) { echo 'checked'; } ?>>No</label>
        </div>

        
        
        <!--now we need to be able to submit the information-->
        <button type="submit" class="btn btn-default" name="submit">Update</button>

        </form>

    </div>
</div>
</div>
        
    </body>
</html>