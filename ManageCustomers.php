<?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();

    if($_SESSION['email']==null){
        header('Location: store-login.php');
    }
    
    $storeID=$_SESSION['storeID'];    
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
<?php 
    include_once("config.php");
    include_once("dbutils.php");
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $queryGTotal="SELECT sum(quantityInOrder*Price) as Total from itemsInOrder
    join items on items.id=itemsInOrder.itemID join orders on orders.id=itemsInOrder.orderID where orders.storeID=$storeID
    and orderStatus!=6;";
    $resultGTotal=queryDB($queryGTotal,$db);
    while($row=nextTuple($resultGTotal)){
        $GTotal=$row['Total'];
        }
?>
        
        <title>Loyal Customers</title>
    </head>
    <body style="background-color:#afd8d1">
    <?php
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $query="SELECT storeName from stores where id=$storeID;";
    $result = queryDB($query, $db);
    $row = nextTuple($result);
    $storeName=$row['storeName'];
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
            <li><a href="Manager_Home.php">Home</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="items.php">Items</a></li>
            <li><a href="ManageOrders.php">Orders</a></li>
            <li><a href="ManageStore.php">Store</a></li>
            <li><a href="manage-employees.php">Employees</a></li>
            <li class="active"><a href="ManageCustomers.php">Customers</a></li>
            <li><a href="customerHomeForEdits.php"  target="_blank" >Store Front</a></li>
            
        </ul>
        <ul class="nav navbar-nav navbar-right"style="font-color:#2a2a2b; font-family: 'Poppins'; padding-right:3%" >
        <li><a href="store-logout.php">Log Out </a></li>
        </ul>
        
    </div>
</nav>
<!-- show customers by most orders -->
<div class="container" style="padding-left:3%; padding-right:3%; width:80%;font-family: 'Poppins'; background-color:white">
<div class="row">
    <div class="col-xs-12">
        <h1>Loyal Customers</h1>

    </div>
</div>

<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th>Total Orders </th>
        <th>Address</th>
        <th>Zip</th>
        <th>State</th>
        
        
    </thead>


       
<?php

$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
$query1 = "SELECT count(*)as TotOrd,address, stateName,zip from customers join states on states.id=customers.stateID join orders
on orders.customerID=customers.id
where storeID=$storeID
group by customers.id
order by TotOrd desc;";
$result1 = queryDB($query1, $db);

    while($row = nextTuple($result1)) {
        $orderID=$row['id'];
        $TotOrd=$row['TotOrd'];
        echo "\n <tr>";
        echo "<td>".$row['TotOrd']." </td>";
        echo "<td>".$row['address']." </td>";
        echo "<td>" . $row['zip'] . "</td>";
        echo "<td>" . $row['stateName'] . "</td>";
        echo "\n <tr>";
        

}
?>
        </table>
    <div>
</div>
</div>



    </body>
</html>