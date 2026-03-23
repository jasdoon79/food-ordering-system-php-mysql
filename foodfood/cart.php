<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./Design/css/navbar1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./Design/css/login1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="./Design/css/index.css">

    <script
      src="https://kit.fontawesome.com/a692ebc57f.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="./Design/css/cart.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  </head>
  <body>
    
  <?php include './componentt/header.php'; ?>

    <div class="main-container-cart">
      <div class="left">
          <div class="one">
              <h2 style="font-size: 20px !important; font-weight: 500;">Logged In</h2>
              <p><span id="cart-UserName" style="font-size: 20px !important; font-weight: 500;"></span>|<span id="number" style="font-size: 20px !important; font-weight: 500;"></span></p>
          </div>
          <div class="address-enter">

          <h1 style="font-size: 30px !important; font-weight: 800;">Address Information</h1>

          <div class="container-y">
            <form id="address-submit">
              <div class="form-group">
                <label for="flat-no">Flat No:</label>
                <input type="text" id="flat-no" name="flat-no" placeholder="Enter flat no">
              </div>
              <div class="form-group">
                <label for="door-no">Door No:</label>
                <input type="text" id="door-no" name="door-no" placeholder="Enter door no">
              </div>
              <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter address">
              </div>
              <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type">
                  <option value="home">Home</option>
                  <option value="work">Work</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <button type="submit">Submit</button>
            </form>
          </div>
        </div>




          <div class="final-address">
            <h1 style="font-size: 30px !important; font-weight: 800;">Address Information</h1>
	<div class="container-x">
		<div class="address">
			<p><strong>Flat No:</strong> <span id="f-n">123</span> </p>
			<p><strong>Door No:</strong> <span id="d-n">456</span> </p>
			<p><strong>Address:</strong> <span id="ad"> 789 Main Street</span></p>
			<p><strong>Type:</strong> <span id="typ">Home</span> </p>
		</div>
	</div>
          </div>




          <div class="three">
            <h1 style="font-size: 30px !important; font-weight: 800;">Payment Form</h1>
	<form method="post" id="payment-submit">
		<label for="payment-method">Payment Method:</label>
		<select name="payment-method" id="payment-method">
			<option value="card">Credit Card</option>
			<option value="debit-card">Debit Card</option>
			<option value="cod" id="cod"> Cash on Delivery</option>
		</select>
      <div id="card">
		<label for="card-number">Card Number:</label>
		<input type="text" name="card-number" id="card-number">

		<label for="expiry-date">Expiry Date:</label>
		<input type="text" name="expiry-date" id="expiry-date">

		<label for="cvv">CVV:</label>
		<input type="text" name="cvv" id="cvv">
  </div>

		<button type="submit" id="submit-final">Submit Payment</button>
	</form>
          </div>
      </div>






      <div class="right">


      </div>
    </div>


      <!-- //footer -->
      <?php include './componentt/footer.php'; ?>

   
  </body>
  <script src="./Design/js/login1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/977289aa03.js" crossorigin="anonymous"></script>
<script src="./Design/js/index.js" type=""></script>
 
<script src="./Design/js/cart.js" type=""></script>

</html>