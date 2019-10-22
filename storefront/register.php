<?php
require('header.php');
?>

      <section class="registration-form-section">
        <h2>Register</h2>
        <form method="post" action="./register_process.php">
          <div class="text-input-wrapper">
            <label for="first_name">First Name</label>
            <input
              id="first_name"
              type="text"
              name="first_name"
              placeholder="First Name"
              required
            />
          </div>
          <div class="text-input-wrapper">
            <label for="last_name">Last Name</label>
            <input
              id="last_name"
              type="text"
              name="last_name"
              placeholder="Last Name"
              required
            />
          </div>
          <div class="text-input-wrapper">
            <label for="email">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              placeholder="Email Address"
              minlength="6"
              oninput="utils.checkEmailMatch(this)"
              required
            />
          </div>
          <div class="text-input-wrapper">
            <label for="email_confirm">Confirm Email</label>
            <input
              id="email_confirm"
              type="email"
              name="email_confirm"
              placeholder="Confirm Email"
              minlength="6"
              oninput="utils.checkEmailMatch(this)"
              required
            />
          </div>
          <div class="text-input-wrapper">
            <label for="password">Password</label>
            <input
              id="password"
              type="password"
              name="password"
              placeholder="Password"
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
            <label for="password_confirm">Confirm Password</label>
            <input
              id="password_confirm"
              type="password"
              name="password_confirm"
              placeholder="Confirm Password"
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
            <label for="address_1">Address Line 1</label>
            <input
              id="address_1"
              type="text"
              name="address_1"
              placeholder="Address Line 1"
              required
            />
          </div>
          <div class="text-input-wrapper">
            <label for="address_2">Addres Line 2</label>
            <input
              id="address_2"
              type="text"
              name="address_2"
              placeholder="Address Line 2"
            />
          </div>
          <div class="text-input-wrapper">
            <label for="city">City</label>
            <input
              id="city"
              type="text"
              name="city"
              placeholder="City"
              required
            />
          </div>
          <div class="text-input-wrapper">
            <label for="state">State</label>
            <input
              id="state"
              type="text"
              name="state"
              placeholder="State"
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
              placeholder="State"
              minlength="5"
              maxlength="5"
              required
            />
          </div>
          <input type="submit" value="Submit" />
        </form>
      </section>
      <script src="./static/js/utils.js"></script>

<?php
require('footer.php');
?>
