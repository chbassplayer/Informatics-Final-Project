<!-- This file will enable you to enter new toppings, and see existing toppings in the database -->
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

        
        <title>Store Items</title>
    </head>
    
   <body style="background-color:#afd8d1">
    <?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();

    if($_SESSION['email']==null){
        header('Location: store-login.php');
    }
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
            <ul class="nav navbar-nav navbar-right" style="font-color:#2a2a2b; font-family: 'Poppins'; padding-right:3%" >
            <li><a href="store-logout.php">Log Out </a></li>
            </ul>
        </div>
    </nav>

    
    


<?php
// check if form data needs to be processed

// include config and utils files

    

if (isset($_POST['submit'])) {
    // if we are here, it means that the form was submitted and we need to process form data
    

    // get data from form
    $Nam = $_POST['Nam'];
    $Categor= $_POST['SubCats-id'];
    $Brand = $_POST['Brand'];
    $ByWeight = $_POST['ByWeight'];
    $KindOfWeight=$_POST['KindOfWeight-ID'];
    $Price = $_POST['Price'];
    $KeepCold = $_POST['KeepCold'];
    $KeepFrozen = $_POST['KeepFrozen'];
    $Perishable = $_POST['Perishable'];
    $AgeRestrict = $_POST['AgeRestrict'];
    $AgeCanBuy = $_POST['AgeCanBuy'];
    $Stock = $_POST['Stock'];
    
    // variable to keep track if the form is complete (set to false if there are any issues with data)
    $isComplete = true;
    
    // error message we'll give user in case there are issues with data
    $errorMessage = "";
    
    // check each of the required variables in the table
    if (!$Nam) {
        $errorMessage .= "Please enter a name for the item.\n";
        $isComplete = false;
    } 
    if (!$Brand){
        $errorMessage .= "Please enter a Brand for the item.\n";
        $isComplete = false;

    }
    
    else {
        // if there's a name specified, make sure it's not already in the database for 
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);

        if(!$AgeCanBuy){
            $AgeCanBuy=0;
        }
        
        // set up query to check if the name is already used
        $query = "SELECT Nam FROM items WHERE Nam='$Nam' and StoreID=$storeID;";
        
        // run the query
        $result = queryDB($query, $db);
        
        // check if we got any records returned
        if (nTuples($result) > 0) {
            // this means the name is already in use and we need to generate an error
            $isComplete = false;
            $errorMessage .= "The item $Nam is already in the database.\n";
        }
    }
    // Stop execution and show error if the form is not complete
    if($isComplete) {
    
        // put together SQL statement to insert new record
        $query = "INSERT INTO items (StoreID,Categor, Nam, Brand, ByWeight,KindOfWeight, Price, KeepCold, KeepFrozen, Perishable, AgeRestrict, AgeCanBuy, Stock)
        VALUES ($storeID,'$Categor', '$Nam', '$Brand', $ByWeight ,$KindOfWeight, $Price, $KeepCold, $KeepFrozen, $Perishable, $AgeRestrict, $AgeCanBuy,$Stock);";

        // run the insert statement
        $result = queryDB($query, $db);
        $itemID=mysqli_insert_id($db);
        //echo $itemID;


        //check if there is a picture
        if($_FILES['picture']['size']>0){
    
            //if there is a picture
            //copy images to directory
            $tmpName=$_FILES['picture']['tmp_name'];
            $fileName=$_FILES['picture']['name'];
            $newFileName=$imageDir . $itemID . $fileName;
            if(move_uploaded_file($tmpName,$newFileName)){
                $query="UPDATE items set image='$newFileName' where ID=$itemID;";
                queryDB($query,$db);
            }else{
                echo "error copying image";
            }
        }
        // we have successfully entered the data
        echo ("Successfully entered new Item: " . $Nam);
        
        // reset variables so we can reset the form since we've successfully added a record
        unset($isComplete, $errorMessage, $Nam, $Categor, $Brand,$KindOfWeight, $ByWeight, $Price, $KeepCold, $KeepFrozen, $Perishable, $AgeCanBuy, $Stock);
    }
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
<!-- Title -->
    <h1>Insert New Items</h1> 

    <!-- form to enter new toppings -->
    <div class="row">
        <div class="col-xs-12">
        
                <form action="insertItems.php" method="post" enctype="multipart/form-data">

                <!-- name -->
                <div class="form-group">
                    <label for="Nam">Name:</label>
                    <input type="text" class="form-control" name="Nam" value="<?php if($Nam) { echo $Nam; } ?>"/>
                </div>

                <!-- Brand -->
                <div class="form-group">
                    <label for="Brand">Brand:</label>
                    <input type="text" class="form-control" name="Brand" value="<?php if($Brand) { echo $Brand; } ?>"/>
                </div>



                <!--ByWeight-->
                <div class="form-group">
                    <label for="ByWeight">By Weight:</label>
                    <label class="radio-inline">
                        <input type="radio" name="ByWeight" value="1" <?php if($ByWeight && isset($ByWeight)) { echo 'checked'; } ?>> Yes
                    </label>    
                    <label class="radio-inline">
                        <input type="radio" name="ByWeight" value="0" <?php if(!$ByWeight || !isset($ByWeight)) { echo 'checked'; } ?>> No
                    </label>    
                </div>
                <!--Kind of Weight-->
                <div class="form-inline">
                    <p><b>Kind Of Weight</b><p> <label  for "KindOfWeight"></label>

                    <?php
                    // connect to the database
                    if (!isset($db)) {
                        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
                    }
                    echo (generateDropdown2($db, "KindOfWeight", "Description", "ID", 5));        
                    ?>
                    </div>

                <!--KeepCold-->
                <div class="form-group">
                    <label for="KeepCold">Keep Cold:</label>
                    <label class="radio-inline">
                        <input type="radio" name="KeepCold" value="1" <?php if($KeepCold && isset($KeepCold)) { echo 'checked'; } ?>> Yes
                    </label>    
                    <label class="radio-inline">
                        <input type="radio" name="KeepCold" value="0" <?php if(!$KeepCold || !isset($KeepCold)) { echo 'checked'; } ?>> No
                    </label>    
                </div>

                <!--KeepFrozen-->
                <div class="form-group">
                    <label for="KeepFrozen">Keep Frozen:</label>
                    <label class="radio-inline">
                        <input type="radio" name="KeepFrozen" value="1" <?php if($KeepFrozen && isset($KeepFrozen)) { echo 'checked'; } ?>> Yes
                    </label>    
                    <label class="radio-inline">
                        <input type="radio" name="KeepFrozen" value="0" <?php if(!$KeepFrozen || !isset($KeepFrozen)) { echo 'checked'; } ?>> No
                    </label>    
                </div>

                <!--Perishable-->
                <div class="form-group">
                    <label for="Perishable">Perishable:</label>
                    <label class="radio-inline">
                        <input type="radio" name="Perishable" value="1" <?php if($Perishable && isset($Perishable)) { echo 'checked'; } ?>> Yes
                    </label>    
                    <label class="radio-inline">
                        <input type="radio" name="Perishable" value="0" <?php if(!$Perishable || !isset($Perishable)) { echo 'checked'; } ?>> No
                    </label>    
                </div>

                <!--AgeRestrict-->
                <div class="form-group">
                    <label for="AgeRestrict">Age Restrict:</label>
                    <label class="radio-inline">
                        <input type="radio" name="AgeRestrict" value="1" <?php if($AgeRestrict && isset($AgeRestrict)) { echo 'checked'; } ?>> Yes
                    </label>    
                    <label class="radio-inline">
                        <input type="radio" name="AgeRestrict" value="0" <?php if(!$AgeRestrict || !isset($AgeRestrict)) { echo 'checked'; } ?>> No
                    </label>    
                </div>

                <!-- Category -->
                <div class="form-inline">
                    <p><b>Category</b><p> <label  for "Categor"></label>
                    
                <?php
                    // connect to the database
                    if (!isset($db)) {
                        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
                    }
                    echo (generateDropdown3($db, "SubCats", "subName", "id", $Categor,"StoreID=$storeID"));
                ?>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label for="Price">Price:</label>
                    <input type="float" class="form-control" name="Price" value="<?php if($Price) { echo $Price; } ?>"/>
                </div>

                <!-- AgeCanBuy -->
                <div class="form-group">
                    <label for="AgeCanBuy">Age Can Buy:</label>
                    <input type="number" class="form-control" name="AgeCanBuy" value="<?php if($AgeCanBuy) { echo $AgeCanBuy; } ?>"/>
                </div>

                <!--Stock-->
                <div class="form-group">
                    <label for="Stock">Stock:</label>
                    <input type="number" class="form-control" name="Stock" value="<?php if($Stock) { echo $Stock; } ?>"/>
                </div>
                <!--upload picture-->
                <div class="form-group">
                    <label for="picture">Item Image</label>
                    <input type="file" class ="form-control" name="picture"/>
                </div>

                <button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>
</div>
    </body>
</html>