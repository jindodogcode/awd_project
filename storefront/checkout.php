<?php
// Ekene

require_once('header.php');
require_once('utils.php');
require_once('db.php');

$db = db_connect();
$query = '
  SELECT 
    CA.address_id AS address_id,
    first_name,
    last_name,
    line_one,
    line_two,
    city,
    state,
    zipcode
  FROM Customers AS C
  NATURAL JOIN CustomerAddresses AS CA
  INNER JOIN Addresses AS A ON CA.address_id = A.address_id
  WHERE C.customer_id = ?
    AND CA.is_primary = TRUE
';
$stmt = $db->prepare($query);
$stmt->bind_param('i', $uid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);
$_SESSION['address'] = $row;
?>

<section class="registration-form-section">
  <h2>Checkout</h2>
  <form method="post" action="./checkout_process.php">
    <div class="text-input-wrapper">
      <label for="first_name">First Name</label>
      <input
        id="first_name"
        type="text"
        name="first_name"
        value="<?php echo $row['first_name']; ?>"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="last_name">Last Name</label>
      <input
        id="last_name"
        type="text"
        name="last_name"
        value="<?php echo $row['last_name']; ?>"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="address_1">Address Line 1</label>
      <input
        id="address_1"
        type="text"
        name="line_one"
        value="<?php echo $row['line_one']; ?>"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="address_2">Addres Line 2</label>
      <input
        id="address_2"
        type="text"
        name="line_two"
        value="<?php echo $row['line_two']; ?>"
      />
    </div>
    <div class="text-input-wrapper">
      <label for="city">City</label>
      <input
        id="city"
        type="text"
        name="city"
        value="<?php echo $row['city']; ?>"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="state">State</label>
      <input
        id="state"
        type="text"
        name="state"
        value="<?php echo $row['state']; ?>"
        minlength="2"
        maxlength="2"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="state">Zipcode</label>
      <input
        id="zipcode"
        type="text"
        name="zipcode"
        value="<?php 
          if (isset($uid)) {
          echo intval($row['zipcode']); 
          }
        ?>"
        minlength="5"
        maxlength="5"
        required
      />
    </div>
    <input type="submit" value="Pay" />
  </form>
</section>
<?php
$result->free();
$stmt->close();
$db->close();
require_once('footer.php');
?>
