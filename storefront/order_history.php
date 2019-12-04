<?php
// Bruk

require_once('header.php');
require_once('utils.php');
require_once('db.php');

check_logged_in($uid);

$db = db_connect();

$query = '
  SELECT order_id, date_time, total_price
  FROM Orders
  WHERE customer_id = ?
';

$stmt = $db->prepare($query);
$stmt->bind_param('i', $uid);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="order-history-section">
  <h2>Order History</h2>
  <div>
    <?php
    if ($result->num_rows < 1) {
      ?>
      <p>No orders found.</p>
      <?php
      } else {
        while ($row = $result->fetch_array()) {
          ?>
        <div class="order-history-order">
          <span>Order #: <?php echo $row['order_id'] ?></span>
          <span>Date: <?php echo date('M d Y', strtotime($row['date_time'])) ?></span>
          <span>Total: $<?php echo $row['total_price'] ?></span>
        </div>
    <?php
      }
    }
    ?>
  </div>
</section>

<?php
require_once('footer.php');
?>
