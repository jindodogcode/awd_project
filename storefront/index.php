<?php
require("header.php");
?>

<section class="splash">
  Dynamic splash area:<br />
  If not logged in: Welcome to site / register<br />
  If logged in: recently ordered and recemendations
</section>
<section class="featured">
  <h2>Featured Items</h2>
  <div class="featured-items">
    <?php
    // connect to db
    $db = new mysqli('localhost', 'storefrontweb', 'storefrontweb', 'storefront');
    if (mysqli_connect_errno()) {
      echo '<div class="error-wrapper">';
      echo '<p>Error: Could not connect to database.<br />
        Please try again later.</p>';
      echo '</div>';
      require('footer.php');
      exit;
    }

    // select 6 random products to be featured
    $query = '
      SELECT P.product_id, P.name, P.price, U.url, U.alt_text
      FROM Products as P LEFT JOIN ProductPictureURLs as U USING (product_id)
      WHERE product_id IN
        (SELECT product_id FROM (SELECT product_id FROM Products ORDER BY RAND() LIMIT 6) t)
    ';
    $results = $db->query($query);
    // iterate through results as an associative array
    while ($row = $results->fetch_array()) {
      echo '<div class="featured-item">';
      echo '<div class="featured-item-img">';
      echo '<a href="./product.php?id='.
        htmlspecialchars($row['product_id'], HTML_FILTER).
        '">';
      echo '<img src="'.
        htmlspecialchars($row['url'], HTML_FILTER).
        '" alt="'.
        htmlspecialchars($row['alt_text'], HTML_FILTER).
        '">';
      echo '</a>';
      echo '</div>';
      echo '<a href="./product.php?id='.
        htmlspecialchars($row['product_id'], HTML_FILTER)
        .'">';
      echo '<p>'.
        htmlspecialchars($row['name'], HTML_FILTER).
        '</p>';
      echo '</a>';
      echo '<span class="featured-item-price">$'.
        htmlspecialchars($row['price'], HTML_FILTER).
        '</span>';
      echo '</div>';
    };

    $results->free();
    $db->close();
    ?>
  </div>
</section>

<?php
require("footer.php");
?>
