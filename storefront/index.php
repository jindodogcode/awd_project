<?php
// Ekene

require_once("header.php");
require_once("db.php");
require_once('utils.php');
?>

<section class="splash">
  <?php
  // connect to db
  $db = db_connect();
  if (isset($uid)) {
    $query = '
      SELECT P.product_id AS product_id, name, url
      FROM Products P
      INNER JOIN ProductPictureURLs PPU ON P.product_id = PPU.product_id
      INNER JOIN OrderProducts OP ON P.product_id = OP.product_id
      INNER JOIN Orders O ON OP.order_id = O.order_id
      WHERE O.customer_id = ?
      ORDER BY O.date_time DESC
      LIMIT 3;
    ';

    $stmt = $db->prepare($query);
    $stmt->bind_param('d', intval($uid));
    $stmt->execute();
    $results = $stmt->get_result();

    echo '<h2>Welcome Back</h2>';
    if ($results && $results->num_rows > 0) {
      echo '<h3>Recent Orders</h3>';
      echo '<div class="recent-orders">';
      while($row = $results->fetch_array()) {
        echo '<div class="recent-order">';
        echo '<a href="./product.php?id='.$row['product_id'].'">';
        echo '<img src="'.$row['url'].'" alt="'.$row['name'].'">';
        echo '</a>';
        echo '</div>';
      }
      echo '</div>';
    } else {
      echo '<h3>No recent orders</h3>';
      echo '<p>Explore the featured items to get started.</p>';
    }
      $results->free();
      $stmt->close();
  } else {
    echo '<h2>Welcome to '. site_name().'!</h2>';
    echo '<p>Explore the featured items to get started.</p>';
  }
  ?>
</section>
<section class="featured">
  <h2>Featured Items</h2>
  <div class="featured-items">
    <?php
    // select 6 random products to be featured
    $query = '
      SELECT P.product_id, P.name, P.price, U.url, U.alt_text
      FROM Products as P LEFT JOIN ProductPictureURLs as U USING (product_id)
      WHERE product_id IN (
        SELECT product_id
        FROM (
          SELECT product_id FROM Products ORDER BY RAND() LIMIT 6
        ) t)
    ';
    $results = $db->query($query);
    // iterate through results as an associative array
    while ($row = $results->fetch_array()) {
      echo '<div class="featured-item">';
      echo '<div class="featured-item-img">';
      echo '<a href="./product.php?id=' .
        htmlspecialchars($row['product_id'], HTML_FILTER) .
        '">';
      echo '<img src="' .
        htmlspecialchars($row['url'], HTML_FILTER) .
        '" alt="' .
        htmlspecialchars($row['alt_text'], HTML_FILTER) .
        '">';
      echo '</a>';
      echo '</div>';
      echo '<a href="./product.php?id=' .
        htmlspecialchars($row['product_id'], HTML_FILTER)
        . '">';
      echo '<p>' .
        htmlspecialchars($row['name'], HTML_FILTER) .
        '</p>';
      echo '</a>';
      echo '<span class="featured-item-price">$' .
        htmlspecialchars($row['price'], HTML_FILTER) .
        '</span>';
      echo '</div>';
    };

    $results->free();
    $db->close();
    ?>
  </div>
</section>

<?php
require_once("footer.php");
?>
