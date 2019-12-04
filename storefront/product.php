<?php
// Bruk

require_once('header.php');

// get product id from url
$id = $_GET['id'];

// connect to db
require_once('db.php');
$db = db_connect();

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
  require_once('footer.php');
  exit;
}

$row = $result->fetch_array();
?>

<!-- display product -->
<section class="product-section">
  <div class="product-image">
    <?php
    echo '<img src="' .
      htmlspecialchars($row['url'], HTML_FILTER) .
      '" alt="' .
      htmlspecialchars($row['alt_text'], HTML_FILTER) .
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
      <h3><?php echo '$' .
            htmlspecialchars($row['price'], HTML_FILTER);
          ?></h3>
      <button onclick="utils.cartButtonAction(
<?php
echo "{$row['product_id']}, '{$row['name']}', 'add'"
?>
)">Add To Cart</button>
    </div>
    <div class="product-info">
      <ul>
        <?php
        $info_list = explode("\n", trim($row['info']));
        foreach ($info_list as $item) {
          echo '<li>' .
            htmlspecialchars(trim($item), HTML_FILTER) .
            '</li>';
        }
        ?>
      </ul>
    </div>
  </div>
  <div class="product-description">
    <?php
    echo $row['description'];
    ?>
  </div>
</section>
<form method="get" action="./cart_process.php" id="hidden-form">
  <input type="hidden" name="pid" value="<?php echo $row['product_id']; ?>">
  <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
  <input type="hidden" name="act" value="add">
</form>

<?php
require_once('footer.php');
$result->close();
$stmt->close();
$db->close();
?>
