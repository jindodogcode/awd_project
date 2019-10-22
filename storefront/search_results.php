<?php
require('header.php');

// get search term, trim white space off it, escape LIKE wildcard characters
$q = preg_replace('/(?<!\\\)([%_])/', '\\\$1', trim($_POST['q'])); 

// connect to database
$db = new mysqli('localhost', 'storefrontweb', 'storefrontweb', 'storefront');
if (mysqli_connect_errno()) {
  echo '<div class="error-wrapper">';
  echo '<p>Error: Could not connect to database.<br />
    Please try again later.</p>';
  echo '</div>';
  require('footer.php');
  exit;
}

// search for term in Manufacturer name, category name, product name, product info, or product description
$query = '
SELECT P.product_id, P.name, P.price, P.info, U.url, U.alt_text
FROM Products as P LEFT JOIN ProductPictureURLs as U USING (product_id)
WHERE
  P.product_id IN (
    SELECT product_id
    FROM Manufacturers AS M INNER JOIN Products as P2 USING (manufacturer_id)
    WHERE M.name LIKE CONCAT("%", ?, "%")
  ) ||
  P.product_id IN (
    SELECT product_id
    FROM CategorizedProducts as CP LEFT JOIN ProductCategories as PC USING (category_id)
    WHERE PC.name LIKE CONCAT("%", ?, "%")
  ) ||
	P.name LIKE CONCAT("%", ?, "%") ||
  P.info LIKE CONCAT("%", ?, "%") ||
  P.description LIKE CONCAT("%", ?, "%")
';
$stmt = $db->prepare($query);
$stmt->bind_param('sssss', $q, $q, $q, $q, $q);
$stmt->execute();
$result = $stmt->get_result();

?>

      <section class="search-results-section">
        <h2>Search Results</h2>
        <?php
        echo '<h3>"'.$q.'"</h3>';
        if (!$result || $result->num_rows < 1) {
          echo '<div class="error-wrapper">';
          echo '<p>No results found.</p>';
          echo '</div>';
          require('footer.php');
          exit;
        }
        ?>
        <div class="search-results-wrapper">
        <?php
        // iterate and display results
        while ($row = $result->fetch_array()) {
          echo '<div class="search-result">';
          echo '<div class="search-result-img">';
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
          echo '<span class="search-result-price">$'.
            htmlspecialchars($row['price'], HTML_FILTER).
            '</span>';
          echo '</div>';
        }
        ?>
        </div>
      </section>

<?php
require('footer.php');
$result->close();
$stmt->close();
$db->close();
?>
