<?php
ini_set('session.use_only_cookies', 1);
session_name("UserSession");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order food online from India's best food delivery service. Order from restaurants near you</title>
    <link rel="icon" sizes="192x192" href="https://res.cloudinary.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_192,h_192/portal/c/logo_2022.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Design/css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./Design/css/navbar1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./Design/css/login1.css">
</head>
<body>
    <!-- header section -->
    <?php include './componentt/header.php'; ?>

    <div id="offers">
        <div class="carousel">
            <div class="carousel-container">
              <div class="carousel-item"><button style="color:#d7d7d7;" class="offer-btn"><span > <i  class="fa-solid fa-bell-concierge"></i> <strong style="font-size: large;">50% OFF UPTO 500 </strong> </span> <br><hr> USE <strong style="font-size: large;"> MASAI50</strong> | ABOVE 5000</button></div>
              <div class="carousel-item"><button style="color:#d7d7d7;" class="offer-btn"><span > <i class="fa-solid fa-bell-concierge"></i> <strong style="font-size: large;">5% OFF UPTO 100 </strong></span>  <br><hr> USE <strong style="font-size: large;"> COMEBACK</strong> | ABOVE 100</button></div>
              <div class="carousel-item"><button style="color:#d7d7d7;" class="offer-btn"><span > <i class="fa-solid fa-suitcase"></i> <strong style="font-size: large;">10% OFF UPTO 100 </strong></span> <br><hr> USE <strong style="font-size: large;"> MASAIOFFERS</strong> | ABOVE 159</button></div>
              <div class="carousel-item"><button style="color:#d7d7d7;" class="offer-btn"><span > <i class="fa-solid fa-bell-concierge"></i> <strong style="font-size: large;">12% OFF UPTO 100 </strong> </span>  <br><hr> USE <strong style="font-size: large;"> SWIGGY12</strong> | ABOVE 250</button></div>
              <div class="carousel-item"><button style="color:#d7d7d7;" class="offer-btn"><span > <i  class="fa-solid fa-bell-concierge"></i> <strong style="font-size: large;">15% OFF UPTO 100 </strong> </span> <br><hr> USE <strong style="font-size: large;"> MASAI15</strong> | ABOVE 500</button></div>
              <div class="carousel-item"><button style="color:#d7d7d7;" class="offer-btn"><span > <i class="fa-solid fa-bell-concierge"></i> <strong style="font-size: large;">13% OFF UPTO 100 </strong> </span>  <br><hr> USE <strong style="font-size: large;"> TODAY13</strong> | ABOVE 400</button></div>
            </div>
            
            <button class="carousel-button carousel-button-left"><i class="fa-solid fa-arrow-left"></i></button>
            <button class="carousel-button carousel-button-right"><i class="fa-solid fa-arrow-right"></i></button>
          </div>   
    </div>
    <div id="main">
        <div id="restobar">
            <div><span id="rcount"></span> restaurants</div>
            <div>
                <p class="tab selected">Relevance</p>
                <p class="tab">Delivery Time</p>
                <p class="tab">Rating</p>
                <p class="tab">Cost: Low To High</p>
                <p class="tab">Cost: High To Low</p>
                <p id="open-panel">Filters</p>
                <i id="open-icon" class="fa-solid fa-sliders"></i>
            </div>
        </div>
        <div id="restos">
            
        </div>
    </div>
    <div class="cart-panel" id="ccpanel">
        <div id="carttop">
            <button id="close-panel">
                <svg focusable="false" width="14" height="14"   class="icon icon--close" viewBox="0 0 14 14">
                    <path d="M13 13L1 1M13 1L1 13" stroke="currentColor" stroke-width="2" fill="none"></path>
                </svg>
            </button>
            <p>Filters</p>
        </div>
        <div class="cart-content" id="cc">
            <div>
                <p>Cuisines</p>
                <div class="fters">
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Afghani">
                        <label for="finput">Afgani</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Asian">
                        <label for="finput">Asian</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="American">
                        <label for="finput">American</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Bengali">
                        <label for="finput">Bengali</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Beverages">
                        <label for="finput">Bevarages</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Chinese">
                        <label for="finput">Chinese</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Cafe">
                        <label for="finput">Cafe</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Burgers">
                        <label for="finput">Burgers</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Chaat">
                        <label for="finput">Chaat</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Combo">
                        <label for="finput">Combo</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Desserts">
                        <label for="finput">Desserts</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Fast">
                        <label for="finput">Fast</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Fast Food">
                        <label for="finput">Fast Food</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Grill">
                        <label for="finput">Grill</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Andhra">
                        <label for="finput">Andhra</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Pizzas">
                        <label for="finput">Pizzas</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Indian">
                        <label for="finput">Indian</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="South Indian">
                        <label for="finput">South Indian</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="North Indian">
                        <label for="finput">North Indian</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Thalis">
                        <label for="finput">Thalis</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Kerala">
                        <label for="finput">Kerala</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Mughlai">
                        <label for="finput">Mughlai</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Italian">
                        <label for="finput">Italian</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Bakery">
                        <label for="finput">Bakery</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Snacks">
                        <label for="finput">Snacks</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Continental">
                        <label for="finput">Continental</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Pastas">
                        <label for="finput">Pastas</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Kebabs">
                        <label for="finput">Kebabs</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Punjabi">
                        <label for="finput">Punjabi</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Street Food">
                        <label for="finput">Street Food</label>
                    </span>
                    <span>
                        <input type="checkbox" name="CUISINES" class="finput" value="Turkish">
                        <label for="finput">Turkish</label>
                    </span>
                </div>
            </div>
        </div>
        <div id="cctotal">
            <button id="clearbtn">CLEAR</button>
            <button id="showbtn">SHOW RESTAURANTS</button>
        </div>
    </div>

    <!-- //footer -->
    <?php include './componentt/footer.php'; ?>
</body>
</html>

<script src="./Design/js/login1.js" type=""></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="./Design/js/index.js" type=""></script>
<script src="https://kit.fontawesome.com/4d1e521af4.js" crossorigin="anonymous"></script>