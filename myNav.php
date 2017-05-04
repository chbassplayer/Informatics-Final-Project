<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="customerHomeForEdits.php">Store Name</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li style ="padding-top:2%; padding-bottom:1%">
                    <form method="post" action=<?php echo "customerHomeForEdits.php";?>>
                        <input type="text" value="Search..." name="query" />
                        <input type="submit" value="Find" name="completedsearch" />
                    </form>
                </li>
                
                <li><a href="checkStatus.php">My Order Status <span class="glyphicon glyphicon-ok"</span> </a></li>
                <li><a href="customerCart.php">Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                <li><a href="customerSettings.php">Settings <span class="glyphicon glyphicon-cog"></span></a></li>
                <li><a href="customerHelp.php">Help <span class="glyphicon glyphicon-question-sign"></span></a></li>
                <?php
                if($_SESSION['Cemail']==""){
                    echo "<li><a href='login-customer.php'>Login<span class='glyphicon glyphicon-user'></span></a></li>";
                }
                else{
                    echo "<li><a href='customer-logout.php'>Logout:". $_SESSION['Cemail']."<span class='glyphicon glyphicon-user'></span></a></li>";
                }
                ?>
                
            </ul>
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php    
                            $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
                            $query="SELECT * from categories where StoreID=$storeID order by catName;";
                            $result = queryDB($query, $db);
                            while($row = nextTuple($result)) {
                            $categoryID=$row['id'];
                            $catName=$row['catName'];
                            echo "<li class='dropdown-submenu'>";
                            echo "<a class='test' tabindex='-1' href='customerShowBigCategory.php?id=$categoryID'>$catName<span class='caret'></span></a>";
                            echo "<ul class ='dropdown-menu'>";
                            $query1="SELECT id,subName from SubCats where StoreID=$storeID and MainCatID=$categoryID;";
                            $result1 = queryDB($query1, $db);
                            echo  "<li><a tabindex='-1' href='customerShowBigCategory.php?id=$categoryID'>All $catName</a></li>";
                            while($row1 = nextTuple($result1)) {
                            $subName=$row1['subName'];
                            $subID=$row1['id'];

                            echo"<li><a tabindex='-1' href='customerItemsViewForEdits.php?id=$subID'>$subName</a></li>";

                            }
                        echo"</ul>";
                    echo "</li>";
                            }
                            ?>
            </div>
        </div>   
    </nav>