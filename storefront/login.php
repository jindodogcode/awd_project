<?php
require('header.php');
?>

      <section class="login-section">
        <h2>Login</h2>
        <div class="login-wrapper">
          <form action="./login_process.php" method="post">
            <div class="text-input-wrapper">
              <label for="email">Email:</label>
              <input
                id="email"
                type="email"
                name="email"
                placeholder="Email Address"
                minlength="6"
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
                autocomplete="current-password"
                required
              />
            </div>
            <input type="submit" value="Login" />
          </form>
        </div>
      </section>

<?php
require('footer.php');
?>
