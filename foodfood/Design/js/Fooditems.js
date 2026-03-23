// Get restaurant info from localStorage (for display purposes only)
let favRest = JSON.parse(localStorage.getItem("selected-resto")) || [];

// Initialize FoodList as an empty array
var FoodList = [];

// Fetch menu items from server when page loads
document.addEventListener('DOMContentLoaded', function() {
  fetchMenuItems();
});

// Function to fetch all menu items from the server
function fetchMenuItems() {
  fetch(`../../functions/get_menu_items.php`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.error) {
        console.error('Error fetching menu items:', data.error);
        return;
      }
      
      // Transform the fetched data to match the expected FoodList format
      FoodList = data.map(item => {
        return {
          "id": item.item_id || item.id,
          "Qty": 1,
          "TypeIcon": item.is_veg === "1" ? 
            "https://www.pngkey.com/png/detail/261-2619381_chitr-veg-symbol-svg-veg-and-non-veg.png" : 
            "https://openclipart.org/image/800px/304247",
          "Veg": item.is_veg === "1",
          "Image": item.image_url || "https://res.cloudinary.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_208,h_208,c_fit/f6e049469097915c1d1b88c89db9d20a",
          "Item": item.name || item.item_name,
          "Price": parseFloat(item.price),
          "Details": item.description || "No description available",
          "Restaurant": item.restaurant_name || "Unknown Restaurant"
        };
      });
      
      // Display the menu items
      DisplayItems(FoodList);
      
      // Update cart display
      DisplayCart();
      
      // Restore count buttons state for items in cart
      restoreCartItemState();
    })
    .catch(error => {
      console.error('Error fetching menu items:', error);
    });
}

// Function to restore the state of count buttons for items in cart
function restoreCartItemState() {
  const cartItems = JSON.parse(localStorage.getItem("CartItems")) || [];
  
  if (cartItems.length === 0) return;
  
  // Find all ADD buttons
  let addButtons = document.getElementsByClassName("xyz");
  let countButtons = document.getElementsByClassName("countmainDiv");
  let countDigits = document.querySelectorAll(".countdigit");
  
  // For each food item in the display
  FoodList.forEach((item, index) => {
    // Find if this item is in the cart
    const cartItem = cartItems.find(ci => ci.id == item.id);
    
    if (cartItem) {
      // If in cart, update count and show count buttons
      if (addButtons[index]) addButtons[index].style.display = "none";
      if (countButtons[index]) countButtons[index].style.display = "flex";
      if (countDigits[index]) countDigits[index].textContent = cartItem.Qty;
    } else {
      // If not in cart, hide count buttons and show ADD button
      if (addButtons[index]) addButtons[index].style.display = "block";
      if (countButtons[index]) countButtons[index].style.display = "none";
    }
  });
}

///////////////////Display Restaurant Name///////////////////////////
function DisplayResto(){
  let Restaurant = document.getElementsByClassName("RestName");
  for(let i=0; i<Restaurant.length; i++){
    Restaurant[i].innerText = favRest.name || "All Restaurants";
  }
  document.getElementById("type").textContent = favRest.type || "Various Cuisines";
  document.getElementById("time").textContent = favRest.time ? "Deliver in "+favRest.time+" min" : "Delivery times vary";
}
DisplayResto();
/////////////////////////end////////////////////////////////////


////////////////////Toggle Like function/////////////////////////////
let array=JSON.parse(localStorage.getItem("FavRest")) || [];
function likefunc(x) {
  array.push(favRest)
  x.classList.toggle("fa-heart-o");
  localStorage.setItem("FavRest",JSON.stringify(array));  
};
/////////////////////////End///////////////////////////////////////////// 



///////////////////Sticky Like Div/////////////////////////////
window.onscroll = function() {myFunction()};

let navbar = document.getElementById("likeDiv");
let sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
////////////////////////End//////////////////////////////////////////

/////////////////////Veg Toggle/////////////////////////////////
let toggle  = document.querySelector('.switch input');
toggle.onclick = function(){
  if(toggle.checked){
    let FilteredVeg = FoodList.filter(function(elem){
      return elem.Veg;
    });
    DisplayItems(FilteredVeg);
    restoreCartItemState();
  }
  else{
    DisplayItems(FoodList);
    restoreCartItemState();
  }
}
///////////////////////////End////////////////////////////////////

////////////////// Display Function //////////////////////////////////
function DisplayItems(FoodList){
  mainItemContainer.innerText = "";
  FoodList.map(function(elem, index){

    let itemCard = document.createElement("div");
    itemCard.setAttribute("class","ItemContainer");

    let DetailDiv = document.createElement("div");
    DetailDiv.setAttribute("class","item-detailDiv");

    let Icon = document.createElement("img");
    Icon.setAttribute("class","vegIcon");
    Icon.src = elem.TypeIcon;
    
    let Name = document.createElement("h2");
    Name.textContent = elem.Item;
    
    // Add restaurant name if available
    let RestaurantName = document.createElement("small");
    RestaurantName.textContent = elem.Restaurant ? `From: ${elem.Restaurant}` : "";
    RestaurantName.style.color = "#666";
    RestaurantName.style.display = "block";
    RestaurantName.style.marginTop = "4px";
    
    let Price = document.createElement("h3");
    Price.textContent = "₹ " + elem.Price;
    
    let foodDetails = document.createElement("p");
    foodDetails.textContent = elem.Details;
    foodDetails.setAttribute("class","Foodpara");
    
    let imgDiv = document.createElement("div");

    let Image = document.createElement("img");
    Image.setAttribute("class","itemImg");
    Image.src = elem.Image;
   
    let AddButton = document.createElement("button");
    AddButton.setAttribute("class", "xyz");
    AddButton.textContent = "ADD";
    AddButton.addEventListener("click", function(){AddtoCart(elem.id, index)});
  
    /////////////Count/////////////////////
    let countmaindiv = document.createElement("div");
    countmaindiv.setAttribute("class","countmainDiv");
    let negDiv = document.createElement("div");
    negDiv.setAttribute("class", "negDiv");
    negDiv.innerText = "-";
    negDiv.addEventListener("click", function(){decrement(elem.id, index)});
    
    let countDiv = document.createElement("div");
    countDiv.setAttribute("class","countDiv");

    let countdigit = document.createElement("p");
    countdigit.setAttribute("class","countdigit");
    countdigit.innerText = "0";
    
    countDiv.append(countdigit);
    
    let posDiv = document.createElement("div");
    posDiv.setAttribute("class","posDiv");
    posDiv.innerText = "+";
    posDiv.addEventListener("click", function(){increment(elem.id, index)});

    countmaindiv.append(negDiv, countDiv, posDiv);
    countmaindiv.style.display = "none"; // Hide by default
    ///////////////////////////////////////

    DetailDiv.append(Icon, Name, RestaurantName, Price, foodDetails);
    imgDiv.append(Image, AddButton, countmaindiv);
    itemCard.append(DetailDiv, imgDiv);
    mainItemContainer.append(itemCard);
  });
}
////////////////////////End/////////////////////////////////////

function AddtoCart(x, index){
  let cartArr = JSON.parse(localStorage.getItem("CartItems")) || [];
  let query = document.querySelectorAll(".countdigit");
  query[index].textContent = 1;
  
  let Addbtn = document.getElementsByClassName("xyz");
  Addbtn[index].style.display = "none";
  
  let countbtn = document.getElementsByClassName("countmainDiv");
  countbtn[index].style.display = "flex";
  
  let cartProduct = FoodList.filter(function(elem){
    return elem.id == x;
  });
  
  if (cartProduct.length > 0) {
    cartArr.push(cartProduct[0]);
    nOfItems(cartArr);
    localStorage.setItem("CartItems", JSON.stringify(cartArr));
    DisplayCart();
  }
}


/////// increment function////////
function increment(elemId, index) {
  let cartArr = JSON.parse(localStorage.getItem("CartItems")) || [];

  let NewCartArr = cartArr.map(function(item) {
    if(item.id == elemId){ 
      item.Qty++;
    }
    return item;
  });
  
  nOfItems(NewCartArr);
  localStorage.setItem("CartItems", JSON.stringify(NewCartArr));

  let query = document.querySelectorAll(".countdigit");
  if (query[index]) {
    let data = Number(query[index].innerHTML);
    data = data + 1;
    query[index].innerText = data;
  }
  
  DisplayCart();
}

///////// decrement function///////
function decrement(elemId, index) {
  let cartArr = JSON.parse(localStorage.getItem("CartItems")) || [];

  let NewCartArr = cartArr.map(function(item) {
    if(item.id == elemId && item.Qty > 0){ 
      item.Qty--;
    }
    return item;
  });
  
  let NewCartArr1 = NewCartArr.filter(function(element){
    return !(element.id == elemId && element.Qty == 0);
  });
  
  nOfItems(NewCartArr1);
  localStorage.setItem("CartItems", JSON.stringify(NewCartArr1));
  
  let query = document.querySelectorAll(".countdigit");
  if (query[index]) {
    let data = Number(query[index].innerHTML);
    data = data - 1;
    query[index].innerText = data;
    
    if(data < 1){
      let btn = document.getElementsByClassName("countmainDiv");
      if (btn[index]) btn[index].style.display = "none";
      
      let Addbtn = document.getElementsByClassName("xyz");
      if (Addbtn[index]) Addbtn[index].style.display = "block";
    }
  }
  
  DisplayCart();
}

////////////////////NoOFitems Display/////////////////
function nOfItems(CartData){
  let sum = 0;
  let count = 0;
  
  for(let i = 0; i < CartData.length; i++){
    sum = sum + (CartData[i].Qty * CartData[i].Price);
    count += CartData[i].Qty;
  }
  
  document.getElementById("noOfItems").innerText = CartData.length;
  document.getElementById("Total").innerText = sum.toFixed(2);
}

// Initialize cart display
let cartArrX = JSON.parse(localStorage.getItem("CartItems")) || [];
nOfItems(cartArrX);

let x = document.querySelector(".fixed");
x.style.display = "none";

function DisplayCart(){
  if(parseInt(document.getElementById("noOfItems").innerText) > 0){
    x.style.display = "flex";
  } else {
    x.style.display = "none";
  }
}