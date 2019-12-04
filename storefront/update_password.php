<?php
// Bruk

require_once('header.php');
require_once('utils.php');

check_logged_in($uid);
?>

<section class="registration-form-section">
  <h2>Update Password</h2>
  <form method="post" action="./update_password_process.php">
    <div class="text-input-wrapper">
      <label for="password">New Password</label>
      <input
        id="password"
        type="password"
        name="password"
        placeholder="New Password"
        minlength="8"
        maxlength="64"
        pattern="^\S{8,64}$"
        title="Enter a password of 8-64 characters, no spaces"
        autocomplete="new-password"
        oninput="utils.checkPasswordMatch(this)"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="password_confirm">Confirm New Password</label>
      <input
        id="password_confirm"
        type="password"
        name="password_confirm"
        placeholder="Confirm New Password"
        minlength="8"
        maxlength="64"
        pattern="^\S{8,64}$"
        title="Must match password"
        autocomplete="new-password"
        oninput="utils.checkPasswordMatch(this)"
        required
      />
    </div>
    <div class="text-input-wrapper">
      <label for="old_password">Old Password</label>
      <input
        id="old_password"
        type="password"
        name="old_password"
        placeholder="Enter Old Password"
        minlength="8"
        maxlength="64"
        pattern="^\S{8,64}$"
        title="Enter a password of 8-64 characters, no spaces"
        autocomplete="new-password"
        required
      />
    </div>
    <input type="submit" value="Submit" />
  </form>
</section>

<?php
require_once('footer.php');
?>
