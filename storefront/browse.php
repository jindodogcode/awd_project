<?php
// Bruk

require_once('header.php');

// Get query, will be one of the categories
$q = $_GET['q']; 

// Connect to to database
require_once('db.php');
$db = db_connect();

// find all products in category
$query = '
SELECT P.product_id, P.name, P.price, P.info, U.url, U.alt_text
FROM Products as P LEFT JOIN ProductPictureURLs as U USING (product_id)
WHERE
  P.product_id IN (
    SELECT product_id
    FROM CategorizedProducts as CP LEFT JOIN ProductCategories as PC USING (category_id)
    WHERE PC.name = ?)
';
$stmt = $db->prepare($query);
$stmt->bind_param('s', $q);
$stmt->execute();
$result = $stmt->get_result();
?>

      <section class="browse-section">
      <?php
      echo '<h2>'.ucfirst($q).'</h2>';
      ?>
        <div class="browse-wrapper">
          <?php
          // iterate through results as an associative array
          while ($row = $result->fetch_array()) {
            echo '<div class="browse-item">';
            echo '<div class="browse-item-img">';
            echo '<a href="product.php?id='.
              htmlspecialchars($row['product_id'], HTML_FILTER).
              '">';
            echo '<img src="'.
              htmlspecialchars($row['url'], HTML_FILTER).
              '" alt="'.
              htmlspecialchars($row['alt_text'], HTML_FILTER).
              '">';
            echo '</a>';
            echo '</div>';
            echo '<a href="product.php?id='.
              htmlspecialchars($row['product_id'], HTML_FILTER).
              '">';
            echo '<p><strong>'.
              htmlspecialchars($row['name'], HTML_FILTER).
              '</strong></p>';
            echo '</a>';
            echo '<span class="browse-item-price">$'.
              htmlspecialchars($row['price'], HTML_FILTER).
              '</span>';
            echo '</div>';
          }
          ?>
        </div>
      </section>

<?php
$result->close();
$stmt->close();
$db->close();
require_once('footer.php');
?>
