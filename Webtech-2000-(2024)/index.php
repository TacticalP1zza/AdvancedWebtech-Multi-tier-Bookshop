<?php session_start();
 $Connection = oci_connect("x7x92", "Mudkip");
 $table = '';
 $selectcol= '';
 $search = '';

 
 // Check if a table is selected from the dropdown
// Start or resume the session


// Check if a table is selected from the dropdown
if (isset($_POST['button'])) {
$_SESSION['data']['button'] = $_POST['button'];
$_SESSION['data']['collum'] = $selectcol;
$_SESSION['data']['search'] =  $search;
}

// Check if a column is selected
if (isset($_POST['collum'])) {
$_SESSION['data']['collum'] = $_POST['collum'];
}

// Check if a search is performed
if (isset($_POST['search'])) {
$_SESSION['data']['search'] = $_POST['search'];
}
;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idea 22018575</title>
    <link rel="stylesheet" href="Styles.css">
</head>
<header><img class="mew"src="mews.png" alt=""><img class="logo" src="Idealogo.svg" alt=""></header>
<nav class="nav">

<ul>
<li>Home</li>
<li>Shop</li>
<li>Store</li>
<li>Login</li>
</ul></nav>

<body>
<div class="dropdowns">
<div class="dropdown">
    <div class="select">
        <?php
        if (isset($_POST['button'])) {
            $_SESSION['data']['button'] = $_POST['button'];
            $_SESSION['data']['collum'] = $selectcol;
            $_SESSION['data']['search'] =  $search;
        }
        $table = $table = $_SESSION['data']['button'];
        if($table !=''){
        echo "<span class='selected'>$table</span>";
        }else{echo "<span class='selected'>Select Table</span>";}
        ?>
        <div class="arrow"></div>
    </div>

    <ul class="menu">
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="Supplier" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">Suppliers</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="Customer" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">Customers</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="Product" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">Products</button>
        </form>
    </li>
        <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="Store" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">Stores</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="COrder" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">COrder</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="Employee" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">Employees</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="DeliveryDetails" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">DeliveryDetails</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="SupplierShipments" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">SupplierShipments</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="CollectedProduct" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">CollectedProduct</button>
        </form>
    </li>
    <li class="active" style="height: 100%;">
        <form method="post" style="height: 100%;">
            <button type="submit" name="button" value="DelieveredProduct" style="border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;">DelieveredProduct</button>
        </form>
    </li>
    </ul>
</div>
<div class ="search">
    <form class ="search" method="post">
    <input class ="search" type="text" name="search" placeholder="Search Database">
        <button  class ="search" type="submit">Search</button>
    </form>
    </div>
</div>
    <div>
        <p class="text" style="text-align: center; color: #26489a; margin: 0 auto; 
    padding: 5px; font-weight: bold; font-size: 20px;">Click on a column to select it, then type a search query in</p>
        <?php
// Execute SQL query only if necessary
if (!empty($_SESSION['data']['button'])) {
    $table = $_SESSION['data']['button'];
    $selectcol = isset($_SESSION['data']['collum']) ? $_SESSION['data']['collum'] : '';
    $search = isset($_SESSION['data']['search']) ? $_SESSION['data']['search'] : '';

    $sql = "SELECT * FROM $table";

    if ($table === "DeliveryDetails") {
        $sql .= " JOIN COrder ON DeliveryDetails.Order_ID = COrder.Order_ID";
    }
    if ($table === "CollectedProduct") {
        $sql .= " JOIN Product ON CollectedProduct.Product_ID = Product.Product_ID";
    }
    if ($table === "DelieveredProduct") {
        $sql .= " JOIN Product ON DelieveredProduct.Product_ID = Product.Product_ID";
    }

    // Add WHERE clause if a search is performed
    if (!empty($selectcol) && !empty($search)) {
        $sql .= " WHERE $selectcol LIKE '%$search%'";
    }
    



    $Statement = oci_parse($Connection, $sql);
    oci_execute($Statement);

    // Output table data
    $numcols = oci_num_fields($Statement);

    // Display table header
    print "<table class='table' style='background-color: #0057AD;' width=300 border=1><tr>";
    for ($i = 1; $i <= $numcols; $i++) {
        $colname = oci_field_name($Statement, $i);
        print "<td><form method='post'><button type='submit' name='collum' value='$colname' style='border: none; background: none; padding: 0; font: inherit; cursor: pointer; width: 100%; height: 100%; text-align: left;'>$colname</button></form></td>";
    }
    print "</tr>";

    // Display table rows
    while (oci_fetch($Statement)) {
        print "<tr>";
        for ($i = 1; $i <= $numcols; $i++) {
            $col = oci_result($Statement, $i);
            print "<td>$col</td>";
        }
        print "</tr>";
    }
    print "</table>";

    oci_close($Connection);
}
        ?>
    </div>

    <script>
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const select = dropdown.querySelector('.select');
        const arrow = dropdown.querySelector('.arrow');
        const menu = dropdown.querySelector('.menu');
        const options = dropdown.querySelectorAll('.menu li');
        const selected = select.querySelector('.selected'); // Select the .selected element within the current dropdown

        select.addEventListener('click', () => {
            select.classList.toggle('select-clicked');
            arrow.classList.toggle('arrow-rotate');
            menu.classList.toggle('menu-open');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                
                select.classList.remove('select-clicked');
                arrow.classList.remove('arrow-rotate');
                menu.classList.remove('menu-open');

                options.forEach(opt => {
                    opt.classList.remove('active');
                });

                option.classList.add('active');
            });
        });
    });
</script>   
</body>

</html>