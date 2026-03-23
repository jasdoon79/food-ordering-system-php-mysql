<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Design/css/Fooditems.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Food Items</title>


    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./Design/css/navbar1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./Design/css/login1.css">
    <link rel="stylesheet" href="./Design/css/index.css">
</head>
<body>

    <?php include './componentt/header.php'; ?>

      <br>
      <br>
      <br><br>
      <div id="main--container">

    <div id="likeDiv">
        <div style="font-family:'Montserrat', sans-serif ;"><span id="Addres">Coremangla</span>  / <span class="city">Banglore</span> / <span class="RestName">Restaurant</span>  </div>
        <div>
            <i class="fa-solid fa-heart" id="heart" onclick="likefunc(this)"></i>
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div> 
    <br>
    <div id="ratingDiv">
        <div id="detailsDiv" >
            <h1 class="RestName" style="font-size: 30px; font-weight: inherit; font-family:'Montserrat', sans-serif ;">Restaurant Name</h1>
            <p id="type" style="font-family:'Montserrat', sans-serif ;">Details</p>
            <p id="time">Time</p>
        </div>
        <button id="rating" > 
            <span class="colorG"><i class="fa-solid fa-star"></i> <strong> 4.3</strong></span>
            <br> <hr><strong>1K+Ratings</strong> 
        </button>
    </div>
    <div id="deliverycharge"><span class="color" ><i class="fa-solid fa-motorcycle"></i> </span>2.0 km | ₹ 42 Delivery fee will Apply</div>
    <br>
    <div id="offers">
    <button class="offer-btn">   <span class="colorR"> <i  class="fa-solid fa-bell-concierge"></i> <strong style="font-size: larger;">50% OFF UPTO 500 </strong> </span> <br><hr> USE <strong> MASAI50</strong> | ABOVE 5000</button>
    <button class="offer-btn">   <span class="color"> <i class="fa-solid fa-bell-concierge"></i> <strong style="font-size: larger;">5% OFF UPTO 100 </strong></span>  <br><hr> USE <strong> COMEBACK</strong> | ABOVE 100</button>
    <button class="offer-btn">   <span class="colorG"> <i class="fa-solid fa-suitcase"></i> <strong style="font-size: larger;">10% OFF UPTO 100 </strong></span> <br><hr> USE <strong> MASAIOFFERS</strong> | ABOVE 159</button>
    <button class="offer-btn">   <span class="colorY"> <i class="fa-solid fa-bell-concierge"></i> <strong style="font-size: larger;">12% OFF UPTO 100 </strong> </span>  <br><hr> USE <strong> SWIGGY12</strong> | ABOVE 250</button>
    <button class="offer-btn">   <span class="colorR"> <i class="fa-solid fa-bell-concierge"></i> <strong style="font-size: larger;">13% OFF UPTO 100 </strong> </span>  <br><hr> USE <strong> TODAY13</strong> | ABOVE 400</button>
    <button class="offer-btn">   <span class="colorG"> <i  class="fa-solid fa-bell-concierge"></i> <strong style="font-size: larger;">15% OFF UPTO 100 </strong> </span> <br><hr> USE <strong> MASAI15</strong> | ABOVE 500</button>
   
</div>
<br><br>
<div id="vegfilter" ><Strong style="font-size: larger;">Veg Only</Strong> 
    <label class="switch">
    <input type="checkbox">
    <span class="slider"></span>
  </label>
  </div>
  <br>
  <hr style="width: 60%; margin: auto;" >
  <i class="styles_icon__m6Ujp styles_itemIcon__1LXTw icon-Veg styles_iconVeg__shLxJ" role="presentation" aria-hidden="true" style="line-height: 1.2;"></i>

<!-- CartPopup -->
<a href="./cart">
<div class="fixed">
<div><h3><span id="noOfItems">0</span> | Items ₹ <span id="Total"></span></h3> </div>
<div><h3>VIEW CART <i class="fa-solid fa-bag-shopping"></i></h3></div>
</div>
</a>
 <!--  -->
 <div id="mainItemContainer">
 <!-- <div class="ItemContainer">
    <div class="item-detailDiv">
        <img src="https://www.pngkey.com/png/detail/261-2619381_chitr-veg-symbol-svg-veg-and-non-veg.png" alt="" class="vegIcon">
        <h2>Item Name</h2>
        <h3>₹ 345.00</h3><br>
        <p>Specification</p>
    </div>
    <div>
     <img src="https://res.cloudinary.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_208,h_208,c_fit/f6e049469097915c1d1b88c89db9d20a" alt="" class="itemImg" >
    <button class="xyz">ADD</button>
    </div> 
      </div>-->
 </div>
</div>




    <!-- //footer -->
    <?php include './componentt/footer.php'; ?>
 
</body>
<script src="./Design/js/login1.js" type=""></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a46e040db2.js" crossorigin="anonymous"></script>
<script src="./Design/js/Fooditems.js"></script>

</html>


