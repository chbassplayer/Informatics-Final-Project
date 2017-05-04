
<html lang="en">
<head>
    
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
<style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}
</style>
    
    <title>Customer Home</title>
    
</head>
<body>
	
	<?php
		
    //get categories for drop down and start a session with a stream_wrapper_restore
    // for every page for this store it will have a consistent Store ID 
    //for now we hard code
    include_once('config.php');
    include_once('dbutils.php');
    session_start();
    //echo $_SESSION['startedOrder'];
    $_SESSION['StoreID']=1;
    $storeID=$_SESSION['StoreID'];
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $conf=$_GET['conf'];
    ?>
	<div class="heading">
		<h1 style="color:gray">Store Name</h1>
	</div>
	
<?php
include_once('myNav.php');
?>
</div>
<div class ="row">
    <div class= "col-xs-12">
    <h1>Enter Confirmation Number to View Status</h1>
    </div>  
</div>
<!--form for entering number-->
<div class ="row">
    <div class= "col-xs-12">
    <form action="checkStatus.php" method="post">

<!-- Confirmation Number -->
    <div class="form-group">
        <label for="cNum">Confirmation Number</label>
        <input type="number" class="form-control" name="cNum"/>
    </div>

    <button type="submit" class="btn btn-success" name="submit">Submit</button>
</form>
    </div>  
</div>
<?php
//does the query when searched
if(isset($_POST['completedsearch'])){
    $search = $_POST['query'];
    $_SESSION['query']=$search;
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    $query = "SELECT * FROM items WHERE (StoreID=$storeID) and (Nam LIKE '%$search%' OR Brand LIKE '%$search%');"; 
    $result=queryDB($query,$db);
        while($row = nextTuple($result)) {
        $productID=$row['ID'];
        echo "\n <div class='col-md-3 column productbox'>";
        if($row['image']){
            $imageLocation=$row['image'];
            echo "<img src=$imageLocation class='img-responsive' width='150' height='150'>";
        }
        else{
        echo "<img src='http://placehold.it/460x250/e67e22/ffffff&text=ITEMS TEST' class='img-responsive' width='150' height='150'>";
            }
        echo "<div class='producttitle'><a href='showItems.php?id=$subName'>" . "<left>" . $row['Brand'] . " " . $row['Nam']  . "</a></div>";
        echo "<div class='productprice'><div class='pricetext'>" . "$" . "<strong>" . $row['Price'] . "</strong>" . "</div></div>";
        echo "<form action='addToCart.php?id=$productID' method='post'>";
        echo "<div class='form-inline'>";
        echo "<label for='Quantity'>Quantity:</label>";
        echo "<input type='number' class='form-control' name='Quantity' style= width:25% value='<?php if($quantity) { echo $quantity; } ?>'/>";
        echo "</div>";
        echo "<button type='submit' class='btn btn-default' name='AddToCart'>Add To Cart</button>";
        echo "</form>";

        echo "</div> \n ";
    }
    exit;
}
?>
 <?php
    if(isset($_POST['submit'])){
        $Cnum=$_POST['cNum'];
        //echo $Cnum;
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        $query="SELECT description from orderStatus join orders on orderStatus.id=orders.orderStatus where orders.id=$Cnum;";
        $result = queryDB($query, $db);
        while($row = nextTuple($result)) {
            $status=$row['description'];
            echo "<div class= 'row' style='margin:auto; width:80%'>";
                echo "<div class ='col-xs-12'>";
                    //echo "<p style='text-align:center'>$Cnum</p>";
                    echo "<h2 'text-align:center'>$Cnum, Your Order is $status</h2>";
                echo "</div>";
            echo "</div>";     
        }
    }
    ?>
	

<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>
</body>
</html>