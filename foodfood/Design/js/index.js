let restoData = [];
let filteredList = [];

// Fetch restaurant data from the server
fetch('./functions/get_restaurants.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Check if we received an error object
        if (data.error) {
            throw new Error(data.error);
        }
        restoData = data; // Store the fetched data
        filteredList = restoData.slice(); // Create a copy for filtering
        showData(restoData); // Display the data
    })
    .catch(error => {
        console.error('Error fetching restaurant data:', error);
        document.getElementById("restos").innerHTML = `<p>Error loading restaurant data. Please try again later.</p>`;
    });

// var filteredList = restoData.slice()

showData(restoData)
function showData(d){
    document.getElementById("restos").textContent = ""
    document.getElementById("rcount").textContent = d.length
    document.getElementById("rcount").style.marginRight = "10px"
    d.forEach(function(elem){
        let card = document.createElement("div")
        card.setAttribute("class","card")
        card.addEventListener("click",function(){
          localStorage.setItem("selected-resto",JSON.stringify(elem))
          window.location.href = "./Fooditems.php"
        })
        let img = document.createElement("img")
        img.src = elem.img

        let p = document.createElement("p")
        p.textContent = elem.name
        p.setAttribute("class","cname")

        let type = document.createElement("p")
        type.textContent = elem.type
        type.setAttribute("class","ctype")

        let rdiv = document.createElement("div")
        let rating = document.createElement("p")
        rating.textContent = "★"+elem.rating
        let time = document.createElement("p")
        time.textContent = elem.time + " MINS"
        let forTwo = document.createElement("p")
        forTwo.textContent = "₹"+ elem.forTwo + " FOR TWO"
        rdiv.setAttribute("class","crdiv")
        rdiv.append(rating,"•",time,"•",forTwo)


        let offer = document.createElement("p")
        offer.innerHTML = '<i class="fa-solid fa-certificate"></i>'+elem.offer
        offer.setAttribute("class","coffer")

        let qvdiv = document.createElement("div")
        qvdiv.style.display = "flex"
        qvdiv.style.alignItems = "center"
        qvdiv.style.height = "100%"
        let qv = document.createElement("p")
        qv.textContent = "QUICK VIEW"
        qv.setAttribute("class","cqv")
        qvdiv.append(qv)

        card.append(img,p,type,rdiv,offer,qvdiv)
        document.getElementById("restos").append(card)
    })
}

// Carousel
const carousel = document.querySelector('.carousel');
const carouselContainer = document.querySelector('.carousel-container');
const carouselItems = document.querySelectorAll('.carousel-item');
const leftButton = document.querySelector('.carousel-button-left');
const rightButton = document.querySelector('.carousel-button-right');

let currentIndex = 0;
const itemWidth = carouselItems[0].offsetWidth + 20; // 20px margin-right
const visibleItems = 4; // show 4 items at a time

leftButton.addEventListener('click', () => {
  if (currentIndex > 0) {
    currentIndex--;
    carouselContainer.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
  }
});

rightButton.addEventListener('click', () => {
  if (currentIndex < carouselItems.length - visibleItems) {
    currentIndex++;
    carouselContainer.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
  }
});

// sliding div

let openPanelButton = document.getElementById("open-panel");
let closePanelButton = document.getElementById("close-panel");
let cartPanel = document.querySelector(".cart-panel");

openPanelButton.onclick = () => {
    cartPanel.classList.add("open");
    openPanelButton.classList.add("hide");
}
document.getElementById("open-icon").addEventListener("click",function(){
  cartPanel.classList.add("open");
  openPanelButton.classList.add("hide");
})

closePanelButton.onclick = () => {
    cartPanel.classList.remove("open");
    openPanelButton.classList.remove("hide");
}

document.getElementById("clearbtn").addEventListener("click",clearFilter)

function clearFilter(){
  let filters = document.querySelectorAll(".finput")
  for(let i=0;i<filters.length;i++){
      filters[i].checked = false;
  }
}

document.getElementById("showbtn").addEventListener("click",showFitems)

function showFitems(){
  let filters = document.querySelectorAll(".finput")
  let tags = []
  for(let i=0;i<filters.length;i++){
    if(filters[i].checked){
      tags.push(filters[i].value)
    }
  }
  if(tags.length==0){
    filteredList = restoData.slice()
    showData(filteredList)
    return
  }
  filteredList = []
  for(let i=0;i<tags.length;i++){
    for(let j=0;j<restoData.length;j++){
      if(restoData[j].type.includes(tags[i])){
        filteredList.push(restoData[j])
      }
    }
  }
  showData(filteredList)
}

// sorting and tab btm borders

let tabs = document.querySelectorAll(".tab")
for(let i=0;i<tabs.length;i++){
  tabs[i].addEventListener("click",function(){
    tabs[i].setAttribute("class","tab selected")
    tabs[i].style.color = "#3d4152"
    for(let j=0;j<tabs.length;j++){
      if(i!=j){
        tabs[j].setAttribute("class","tab")
        tabs[j].style.color = "#686b78"
      }
    }
    if(tabs[i].textContent.includes("Time")){
      let sortedList = filteredList.sort(function(a,b){
        return a.time - b.time
      })
      showData(sortedList)
    }else if(tabs[i].textContent.includes("Low To High")){
      let sortedList = filteredList.sort(function(a,b){
        return a.forTwo - b.forTwo
      })
      showData(sortedList)
    }else if(tabs[i].textContent.includes("High To Low")){
      let sortedList = filteredList.sort(function(a,b){
        return b.forTwo - a.forTwo
      })
      showData(sortedList)
    }else if(tabs[i].textContent.includes("Rating")){
      let sortedList = filteredList.sort(function(a,b){
        return b.rating - a.rating
      })
      showData(sortedList)
    }else{
      showData(restoData)
    }

  })

}