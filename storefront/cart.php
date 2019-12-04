<?php
// Bruk

require_once('header.php');
require_once('db.php');

$db = db_connect();
$query = "
  SELECT product_id, name, price
  FROM Products
  WHERE product_id = ?
";
$stmt = $db->prepare($query);

$result_arr = [];
foreach ($cart as $id => $quant) {
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();

  $row = $result->fetch_array();
  $row['quant'] = $quant;

  $result_arr[] = $row;
  $result->close();
}

unset($id);
unset($quant);

$total = 0;
?>

<section class="cart-section">
  <?php if (count($result_arr) < 1) {
    echo '<h2 style="text-align: center">Your Cart is Empty</h2>';
    require_once('footer.php');
    exit;
  }
  ?>
  <div class="cart-header">
    <h2>Your Cart</h2>
    <form method="get" action="./checkout.php">
    <input class="checkout-button" type="submit" value="Checkout" />
    </form>
  </div>
  <?php foreach ($result_arr as $result) { ?>
    <div class="cart-items-wrapper">
      <div class="cart-item">
        <h3><?php echo $result['name']; ?></h3>
        <div class="cart-item-price-buttons">
          <p>
            <?php
              $prod_total = $result['price'] * $result['quant'];
              $total += $prod_total;
              echo '$' . $result['price'] . " X " . $result['quant'] . " = "
                . '$' . $prod_total;
              ?>
          </p>
          <div class="cart-item-buttons">
            <button onclick="utils.cartButtonAction(
<?php echo "{$result['product_id']}, '{$result['name']}', 'add'"; ?>)">+</button
><button onclick="utils.cartButtonAction(
<?php echo "{$result['product_id']}, '{$result['name']}', 'sub'"; ?>)">-</button
><button onclick="utils.cartButtonAction(
<?php echo "{$result['product_id']}, '{$result['name']}', 'rem'" ?>)">X</button>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="cart-total-wrapper">
    <p><?php $_SESSION['cart_total'] = $total; echo '$' . $total ?></p>
    <form method="get" action="./checkout.php">
    <input class="checkout-button" type="submit" value="Checkout" />
    </form>
  </div>
</section>

<?php
require_once('footer.php');
$stmt->close();
$db->close();
?>
