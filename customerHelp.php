<?php
    session_start();
    $Search=$_GET['search'];

?>
<div class="heading">
		<h1 style="color:gray">Store Name</h1>
</div>
	
<?php
include_once('config.php');
include_once('dbutils.php');
$_SESSION['StoreID']=1;
$storeID=$_SESSION['StoreID'];

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
        echo "<div class='producttitle'>" . "<left>" . $row['Brand'] . " " . $row['Nam']  . "</a></div>";
        echo "<div class='productprice'><div class='pricetext'>" . "$" . "<strong>" . $row['Price'] . "</strong>" . "</div></div>";
        echo "<form action='addToCart.php?id=$productID&search=$Search' method='post'>";
        echo "<div class='form-inline'>";
        echo "<label for='Quantity'>Quantity:</label>";
        echo "<input type='number' class='form-control' name='Quantity' style= 'width:25%' value='1'/>";
        echo "</div>";
        echo "<button type='submit' class='btn btn-default' name='AddToCart'>Add To Cart</button>";
        echo "</form>";

        echo "</div> \n ";
    }
    header("Location: customerHomeForEdits.php?search=$search");
    exit;
}
?>


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

 .jumbotron {
      background-color: #87CEFA;
      color: #000080;
      padding: 100px 25px;
      font-family: Montserrat, sans-serif;
  }
</style>
    
    <title>Customer Home</title>
    
</head>
<body>
	
	
<?php
//include Nav Bar
include_once('myNav.php');
?>
</div>
<?php
if(isset($_SESSION['Cemail'])){
    $email=$_SESSION['Cemail'];
    echo "<h1>Welcome, $email</h1>";
}
?>

    
<h1>For assistance please email: <span class="label label-info"> <span class=" glyphicon glyphicon-envelope"></span> dominic-fosco@uiowa.edu</span></h1>
<h1>For assistance please email: <span class="label label-info"> <span class=" glyphicon glyphicon-envelope"></span> jessica-lu@uiowa.edu</span></h1>

<h1>For immediate assistance please call: <span class="label label-info"> <span class=" glyphicon glyphicon-earphone"></span> (888) 123-6789</span></h1>








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

