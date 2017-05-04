<!-- updates information into the system-->
<!-- It also lists the contents of the table -->
<!-- It uses bootstrap for formatting -->
<!-- from usernames they are recognized as store or customer eventually.....-->


<?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();

    if($_SESSION['email']==null){
        header('Location: store-login.php');
    
    }
    $email=$_SESSION['email'];
    //get previous info:
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $query="SELECT * from stores where email='$email';";
    $result=queryDB($query,$db);
    while($row=nextTuple($result)){
        $storeName=$row['storeName'];
        $stateID=$row['stateID'];
        $address=$row['address'];
        $zip=$row['zip'];
        //echo "zip:" . "$zip";
        $MaxDelDis=$row['MaxDelDis'];
        $MaxDaysInAdvance=$row['MaxDaysInAdvance'];
        $TimeRestricts1=$row['TimeRestricts1'];
        //echo "hello". "$TimeRestrict1";
        $TimeRestricts2=$row['TimeRestricts2'];
    }

    if (isset($_POST['submit'])) {
        $NstoreName=$_POST['storeName'];
        $NstateID=$_POST['states-id'];
        $Naddress=$_POST['address'];
        $Nzip=$_POST['zip'];
        $NMaxDelDis=$_POST['MaxDelDis'];
        $NMaxDaysInAdvance=$_POST['MaxDaysInAdvance'];
        $NTimeRestricts1=$_POST['DeliveryTime-id'];
        //echo "T1: $NTimeRestricts1";
        $NTimeRestricts2=$_POST['DeliveryTime2-id'];
        //$NPass=$_POST['password'];
        //$NPass2=$_POST['password2'];
        $isComplete=true;
        $errorMessage="";
        if(!$NstoreName){
            $isComplete=false;
            $erroMessage="must have store Name ";
        }
        if(!$Naddress){
            $isComplete=false;
            $erroMessage="must have address";
        }
        if(!$Nzip){
            $isComplete=false;
            $erroMessage="must have zip code ";
        }
        if(!$NMaxDelDis){
            $isComplete=false;
            $erroMessage="must have Max Delivery distance set ";
        }
        if(!$NMaxDaysInAdvance){
            $isComplete=false;
            $erroMessage="must have max days in advance set ";
        }
        if($isComplete){
            $email = makeStringSafe($db, $email);
            //echo "true";
            $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
            $queryUpdate="UPDATE stores SET storeName='$NstoreName', stateID=$NstateID, address='$Naddress',zip=$Nzip
            where email='$email';";
            //echo $queryUpdate;
            $result=queryDB($queryUpdate,$db);

        }
        
    }
    
?>

<html>
    <head>

<title>Manage Store <?php echo $_SESSION['email'];?></title>

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
    
<!-- Showing successfully update, if that actually happened -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && $isComplete) {
        echo '<div class="alert alert-success" role="alert">';
        echo ("success in entering " ."$storeName");
        $storeName=$NstoreName;
        $address=$Naddress;
        $stateID=$NstateID;
        $zip=$Nzip;
        $MaxDelDis=$NMaxDelDis;
        $MaxDaysInAdvance=$NMaxDaysInAdvance;
        $TimeRestrict1=$NTimeRestricts1;
        $TimeRestrict2=$NTimeRestricts2;

        //unset($storeName, $address, $stateID, $zip,$MaxDelDis,$MaxDaysInAdvance,$TimeRestrict1,$TimeRestrict2);
        echo '</div>';
        
    }
?>            	
		
<!-- Showing errors, if any -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && !$isComplete) {
        echo '<div class="alert alert-danger" role="alert">';
        echo ($errorMessage);
        echo '</div>';
    }
?>            
    </div>
</div>
<div class="container" style="padding-left:3%; padding-right:3%; width:80%;font-family: 'Poppins'; background-color:white">
<!-- form for inputting data -->
<div class="row">
    <div class ="col-xs-12" style="padding-left:10%">
    <h1> Store Settings</h1>
    </div>
</div>

        <div class="row">
            <div class="col-xs-12" style="padding-left:10%; padding-right:10%;">
                
<form action="ManageStore.php" method="post">

<!--StoreName-->
    <div class="form-group">
        <label for "storeName">Store Name</label>
        <input type="text" class="form-control" name="storeName" value="<?php if($storeName) { echo $storeName; } ?>"/>
    </div>

<!--Street Address-->
    <div class="form-group">
        <label for "address">Street Address</label>
        <input type="text" class="form-control" name="address" value="<?php if($address) { echo $address; } ?>"/>
    </div>

<!--State this should be from dropown-->
    <div class="form-group">
        <label for "stateID">State</label>
    <?php
    // connect to the database
    if (!isset($db)) {
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    }
    echo (generateDropdown($db, "states", "stateName", "id", $stateID));        
    ?>
    </div>

<!--ZipCode-->
    <div class="form-group">
        <label for "zip">Zip Code</label>
        <input type="number" class="form-control" name="zip" value="<?php if($zip) { echo $zip; } ?>"/>
    </div>
<!--Delivery Radius-->
    <div class="form-group">
        <label for "MaxDelDis">Deleivery Radius (Miles)</label>
        <input type="number" class="form-control" name="MaxDelDis" value="<?php if($MaxDelDis) { echo $MaxDelDis; } ?>"/>
    </div>
<!--Max Days in Advance-->
    <div class="form-group">
        <label for "MaxDaysInAdvance">Maximum Days in Advance an Order Can be Taken</label>
        <input type="number" class="form-control" name="MaxDaysInAdvance" value="<?php if($MaxDaysInAdvance) { echo $MaxDaysInAdvance; } ?>"/>
    </div>
<!--Start of Available Delivery Times (from dropdown)-->
    <div class="form-inline">
    <p><b>Available Delivery Window</b><p> <label  for "TimeRestrict1">Start</label>

    <?php
    // connect to the database
    if (!isset($db)) {
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    }
    echo (generateDropdown2($db, "DeliveryTime", "clock", "id", "$TimeRestricts1"));        
    ?>
    </div>
    
 <!--End of Available Delivery Times (from Dropdown)-->
    <div class="form-inline">
        <label for "TimeRestrict2">End</label>
    <?php
    // connect to the database
    if (!isset($db)) {
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    }
    echo (generateDropdown2($db, "DeliveryTime2", "clock", "id", "$TimeRestricts2"));        
    ?>
    </div>


    <button type="submit" class="btn btn-default" name="submit">Update!</button>
</form>
                
            </div>
        </div>
    </div>
</div>        

        
    </body>
    
</html>