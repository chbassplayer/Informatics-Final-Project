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
    $storeSearch=$_GET['itemSearch'];

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


    <!-- show contents of toppings table -->
    
<div class="row">
    <div class="col-xs-12" style="padding-left:10%; padding-right:10%">
    
        
<!-- set up html table to show contents -->
<table class="table table-hover" style="background-color:white; padding-left:10%;padding-right:10%">
    <!-- headers for table -->
    <thead>
        <th>Brand</th>
        <th>Name</th>
        <th>Type of Weight</th>
        <th>Price</th>
        <th>Stock</th>
        <th></th>
        <th></th>
        <th></th>

    </thead>
    
<div class ="row">
    <div class ="col-xs-12" style="padding-left:2%;">
        <h2> Store Items</h2>
    </div>
</div>
<div class ="row">
<div class ="col-xs-12" style ="padding-top:2%; padding-bottom:1%; padding-left:2%;">
<h4>
    <form method="post" action=<?php echo "items.php";?>>
        <input type="text" placeholder="Search Items..." name="query" />
        <input type="submit" value="Find" name="completedsearch" />
    </form>
    <a href="insertItems.php"  style= "padding-left:4%">Insert More Items</a>
</h4>
</div>
</div>

<?php
//is there a previous query... yes
if($_GET['itemSearch']!=""){
    $search=$_GET['itemSearch'];
    //echo "$search";
    $query = "SELECT * FROM items join SubCats on items.Categor=SubCats.id join categories 
    on SubCats.MainCatID=categories.id WHERE (items.StoreID=$storeID) and (items.Nam LIKE '%$search%' OR items.Brand LIKE '%$search%'
    OR SubCats.subName LIKE '%$search%' OR categories.CatName LIKE '%$search%');"; 
    $result=queryDB($query,$db);
        while($row = nextTuple($result)) {
        $productID=$row['ID'];
        echo "\n <tr>";
        echo "<td>" . $row['Brand'] . "</td>";
        echo "<td><a href='showItemDetail.php?id=$productID'>" . $row['Nam'] . "</td>";
        $Description= $row['Description'];
        if($row['Description']==""){
            $Description="N/A";
        }

        echo "<td>" . $Description. "</td>";
        echo "<td>" . $row['Price'] . "</td>";
        echo "<td>" . $row['Stock'] . "</td>";
        //picture
        echo "<td>";
        if($row['image']){
            $imageLocation=$row['image'];
            echo "<img src=$imageLocation width='150'>";
        }

        echo "</td>";
        echo "</tr> \n";
    }
    //header("Location:items.php?itemSearch=$search");
    exit;
}
?>
<?php
    /*
     * List all the items in the database
     *
     */
    
    // connect to the database
    if($_GET['itemSearch']==""){
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    // set up a query to get information on the toppings from the database
    $query = "SELECT items.ID as theID,Brand,Nam,Description,Price,Stock,image FROM items left join KindOfWeight on
    items.KindOfWeight=KindOfWeight.ID where StoreID=$storeID ORDER BY Nam;";
    
    // run the query
    $result = queryDB($query, $db);
    
    while($row = nextTuple($result)) {
        $itemID=$row['theID'];
        echo "\n <tr>";
        echo "<td>" . $row['Brand'] . "</td>";
        echo "<td><a href='showItemDetail.php?id=$itemID'>" . $row['Nam'] . "</td>";
        $Description= $row['Description'];
        if($row['Description']==""){
            $Description="N/A";
        }

        echo "<td>" . $Description. "</td>";
        echo "<td>" . $row['Price'] . "</td>";
        echo "<td>" . $row['Stock'] . "</td>";
        //picture
        echo "<td>";
        if($row['image']){
            $imageLocation=$row['image'];
            echo "<img src=$imageLocation width='150'>";
        }

        echo "</td>";
        echo "</tr> \n";
    }
    }
?>   
<?php
    //does the query when searched
if(isset($_POST['completedsearch'])){
    $search = $_POST['query'];
    $_SESSION['query']=$search;
    header("Location:items.php?itemSearch=$search");
    exit;
}
?>



    
</table>
        
    </div>
</div>



    </body>
</html>