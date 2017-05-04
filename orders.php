<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        

        
        <title>Orders</title>
    </head>

<!-- show of orders by requested date -->
<?php

include_once('config.php');
include_once('dbutils.php');
$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
$storeID=$_SESSION['storeID'];

    
$query = 'SELECT count(*) from orders;';
    
$result = queryDB($query, $db);
echo $result . "dafuckis this";


?>
<div class="row">
    <div class="col-xs-12">
    
        
<!-- set up html table to show contents -->
<table class="table table-hover">
    <!-- headers for table -->
    <thead>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        
    </thead>
<?php
    
    /*
     * List all the items in the database
     *
     */
    
    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    
    // set up a query to get information on the toppings from the database
    $query = "SELECT Nam,Price,quantityInOrder from itemsInOrder join items on 
    items.ID=itemsInOrder.itemID and StoreID=$storeID;";
    
    // run the query
    $result = queryDB($query, $db);
    
    while($row = nextTuple($result)) {
        echo "\n <tr>";
        echo "<td>" . $row['Nam'] . "</td>";
        echo "<td>" . $row['Price'] . "</td>";
        echo "<td>" . $row['quantityInOrder'] . "</td>";
       
    }
?>   



    
</table>
        
    </div>
</div>



    </body>
</html>