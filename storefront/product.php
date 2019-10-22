<?php
require('header.php');

// get product id from url
$id = $_GET['id'];

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

// find product
$query = "
  SELECT P.product_id, P.name, P.price, P.info, P.description, U.url, U.alt_text
  FROM Products as P LEFT JOIN ProductPictureURLs as U USING (product_id)
  WHERE P.product_id = ?
";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows != 1) {
  echo '<div class="error-wrapper">';
  echo '<p>Error: Item does not exists.<br />
    Please try again later.</p>';
  echo '</div>';
  require('footer.php');
  exit;
}

$row = $result->fetch_array();
?>

      <!-- display product -->
      <section class="product-section">
        <div class="product-image">
          <?php
          echo '<img src="'.
            htmlspecialchars($row['url'], HTML_FILTER).
            '" alt="'.
            htmlspecialchars($row['alt_text'], HTML_FILTER).
            '">';
          ?>
        </div>
        <div class="product-brief">
          <div class="product-name">
            <h2><?php
              echo htmlspecialchars($row['name'], HTML_FILTER);
            ?></h2>
          </div>
          <div class="product-price">
            <h3><?php echo '$'.
              htmlspecialchars($row['price'], HTML_FILTER); 
            ?></h3>
            <button>Add To Cart</button>
          </div>
          <div class="product-info">
            <ul>
              <?php
              $info_list = explode("\n", trim($row['info']));
              foreach ($info_list as $item) {
                echo '<li>'.
                  htmlspecialchars(trim($item), HTML_FILTER).
                  '</li>';
              }
              ?>
            </ul>
          </div>
        </div>
        <div class="product-description">
          <?php
          echo htmlspecialchars($row['description'], HTML_FILTER);
          ?>
        </div>
      </section>

<?php
require('footer.php');
$result->close();
$stmt->close();
$db->close();
?>
