<?php
session_start();

// Pastikan keranjang selalu berupa array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Daftar produk yang tersedia
$products = array("apples", "bananas");

foreach ($products as $item) {
    if (isset($_POST[$item])) {
        $input = trim($_POST[$item]);

        if ($input == "Remove") {
            // Tombol Remove: kurangi kuantitas 1
            if (isset($_SESSION['cart'][$item])) {
                $_SESSION['cart'][$item] -= 1;

                // Jika kuantitas 0 atau kurang, hapus item dari keranjang
                if ($_SESSION['cart'][$item] <= 0) {
                    unset($_SESSION['cart'][$item]);
                }
            }
        } elseif (is_numeric($input) && $input > 0) {
            // Input valid (angka > 0): TAMBAHKAN ke kuantitas lama
            $qty = (int)$input;

            if (isset($_SESSION['cart'][$item])) {
                $_SESSION['cart'][$item] += $qty;
            } else {
                $_SESSION['cart'][$item] = $qty;
            }
        }
        // Input kosong atau tidak valid diabaikan
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart Test</title>
</head>
<body>
    <h1>Items available</h1>
    <form action="" method="post">
        <table>
            <tr><th>Item</th><th>Quantity</th></tr>
            <tr><td>Apples</td><td><input type="text" name="apples" size="2"></td></tr>
            <tr><td>Bananas</td><td><input type="text" name="bananas" size="2"></td></tr>
        </table>
        <input type="submit" value="Click to add to cart">
    </form>
    <br>
    <fieldset style="width:300px">
        <legend>Your Shopping Cart</legend>
        <?php
        if (empty($_SESSION['cart'])) {
            echo "Your shopping cart is empty\n";
        } else {
            echo "<form action=\"\" method=\"post\">\n";
            echo "<table>\n";
            echo "<tr><th>Item</th><th>Quantity</th><th></th></tr>\n";
            foreach ($_SESSION['cart'] as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td>\n";
                echo "<td><input type=\"submit\" name=\"$key\" value=\"Remove\"></td></tr>\n";
            }
            echo "</table>\n";
            echo "</form>\n";
        }
        ?>
    </fieldset>
</body>
</html>