<?php
require('header.php');
?>

      <section class="cart-section">
        <div class="cart-header">
          <h2>Your Cart</h2>
          <button class="checkout-button">Checkout</button>
        </div>
        <div class="cart-items-wrapper">
          <div class="cart-item">
            <h3>Item 1</h3>
            <div class="cart-item-price-buttons">
              <p>
                Item price X <input type="number" value="1" /> = total price
              </p>
              <div class="cart-item-buttons">
                <button>Update</button><button>Remove</button>
              </div>
            </div>
          </div>
          <div class="cart-item">
            <h3>Item 2</h3>
            <div class="cart-item-price-buttons">
              <p>
                Item price X <input type="number" value="1" /> = total price
              </p>
              <div class="cart-item-buttons">
                <button>Update</button><button>Remove</button>
              </div>
            </div>
          </div>
          <div class="cart-item">
            <h3>Item 3</h3>
            <div class="cart-item-price-buttons">
              <p>
                Item price X <input type="number" value="1" /> = total price
              </p>
              <div class="cart-item-buttons">
                <button>Update</button><button>Remove</button>
              </div>
            </div>
          </div>
          <div class="cart-item">
            <h3>Item 4</h3>
            <div class="cart-item-price-buttons">
              <p>
                Item price X <input type="number" value="1" /> = total price
              </p>
              <div class="cart-item-buttons">
                <button>Update</button><button>Remove</button>
              </div>
            </div>
          </div>
        </div>
        <div class="cart-total-wrapper">
          <p>Total = $00.00</p>
          <button class="checkout-button">Checkout</button>
        </div>
      </section>

<?php
require('footer.php');
?>
