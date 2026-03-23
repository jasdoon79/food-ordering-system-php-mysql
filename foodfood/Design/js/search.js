// Global variables to store restaurant data
let restoData = [];
let filteredList = [];

// Create a restaurant list item element
function createRestaurantListItem(restaurant) {
    const listItem = document.createElement('li');
    listItem.className = 'p-4 hover:bg-gray-50 cursor-pointer transition-colors';
    
    // Create restaurant image using the same property name as index.js
    const imageUrl = restaurant.img || './Design/images/default-restaurant.jpg';
    
    // Generate HTML for the restaurant list item
    listItem.innerHTML = `
        <div class="flex items-center">
            <img src="${imageUrl}" alt="${restaurant.name}" class="w-16 h-16 object-cover rounded-full mr-4">
            <div class="flex-grow">
                <h3 class="font-bold text-lg">${restaurant.name}</h3>
                <div class="flex flex-wrap text-sm text-gray-600">
                    ${restaurant.type ? `<span class="mr-3">Type: ${restaurant.type}</span>` : ''}
                    ${restaurant.location ? `<span class="mr-3">Location: ${restaurant.location}</span>` : ''}
                </div>
                ${restaurant.rating ? `
                    <div class="flex items-center mt-1">
                        <span class="text-yellow-500 mr-1">★</span>
                        <span class="text-sm">${restaurant.rating}</span>
                        ${restaurant.time ? `<span class="ml-3">${restaurant.time} MINS</span>` : ''}
                        ${restaurant.forTwo ? `<span class="ml-3">₹${restaurant.forTwo} FOR TWO</span>` : ''}
                    </div>` : ''}
                ${restaurant.offer ? `
                    <div class="mt-1 text-sm text-green-600">
                        <i class="fa-solid fa-certificate"></i> ${restaurant.offer}
                    </div>` : ''}
            </div>
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    `;
    
    // Add click event using the same approach as index.js
    listItem.addEventListener('click', function() {
        localStorage.setItem("selected-resto", JSON.stringify(restaurant));
        window.location.href = "./Fooditems.php";
    });
    
    return listItem;
}

// Run when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize search elements
    const searchInput = document.getElementById('searchText');
    const searchIcon = document.getElementById('showSearch');
    const closeIcon = document.getElementById('showClose');
    
    // Hide close icon initially
    if (closeIcon) closeIcon.style.display = 'none';
    
    // Load restaurants on page load
    fetchRestaurants();
    
    // Add event listener for search icon click
    if (searchIcon) {
        searchIcon.addEventListener('click', function() {
            searchBtn();
        });
    }
    
    // Add event listener for close icon click
    if (closeIcon) {
        closeIcon.addEventListener('click', function() {
            searchInput.value = '';
            closeIcon.style.display = 'none';
            searchIcon.style.display = 'inline';
            document.getElementById('showRestaurants').innerHTML = '';
            document.getElementById('popular').style.display = 'block';
        });
    }
    
    // Add event listener for search input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchBtn();
        });
    }
});

// Fetch restaurant data from the server - using the same endpoint as index.js
function fetchRestaurants() {
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
            displayPopularRestaurants(restoData); // Display popular restaurants
        })
        .catch(error => {
            console.error('Error fetching restaurant data:', error);
            document.getElementById("displayRestaurants").innerHTML = 
                `<p class="text-center text-red-500">Error loading restaurant data. Please try again later.</p>`;
        });
}

// Display popular restaurants in the popular section
function displayPopularRestaurants(restaurants) {
    // Sort by rating like in index.js
    const sortedRestaurants = restaurants.slice().sort(function(a, b) {
        return b.rating - a.rating;
    });
    
    // Display top 6 restaurants
    const popularRestaurants = sortedRestaurants.slice(0, 6);
    
    const restaurantContainer = document.getElementById('displayRestaurants');
    restaurantContainer.innerHTML = '';
    
    if (popularRestaurants.length === 0) {
        restaurantContainer.innerHTML = '<p class="text-center">No restaurants available.</p>';
        return;
    }
    
    // Create a list container for popular restaurants
    const popularList = document.createElement('ul');
    popularList.className = 'list-none divide-y divide-gray-200 bg-white rounded-lg shadow';
    
    // Loop through and display each restaurant as a list item
    popularRestaurants.forEach(restaurant => {
        popularList.appendChild(createRestaurantListItem(restaurant));
    });
    
    restaurantContainer.appendChild(popularList);
}

// Search function triggered by input or button click
function searchBtn() {
    const searchText = document.getElementById('searchText').value.toLowerCase().trim();
    const searchResultsDiv = document.getElementById('showRestaurants');
    const popularSection = document.getElementById('popular');
    const searchIcon = document.getElementById('showSearch');
    const closeIcon = document.getElementById('showClose');
    
    // Toggle search/close icons based on search text
    if (searchText.length > 0) {
        searchIcon.style.display = 'none';
        closeIcon.style.display = 'inline';
        popularSection.style.display = 'none'; // Hide popular section during search
    } else {
        searchIcon.style.display = 'inline';
        closeIcon.style.display = 'none';
        popularSection.style.display = 'block'; // Show popular section when search is empty
        searchResultsDiv.innerHTML = ''; // Clear search results
        return;
    }
    
    // Filter restaurants based on search text - using same properties as index.js
    filteredList = restoData.filter(restaurant => {
        return restaurant.name.toLowerCase().includes(searchText) || 
               (restaurant.type && restaurant.type.toLowerCase().includes(searchText)) ||
               (restaurant.location && restaurant.location.toLowerCase().includes(searchText));
    });
    
    // Display search results
    displaySearchResults(filteredList);
}

// Display search results
function displaySearchResults(restaurants) {
    const searchResultsDiv = document.getElementById('showRestaurants');
    searchResultsDiv.innerHTML = '';
    
    if (restaurants.length === 0) {
        searchResultsDiv.innerHTML = '<p class="text-center my-4">No restaurants found matching your search.</p>';
        return;
    }
    
    // Update count element like in index.js, if it exists
    const countElement = document.getElementById('rcount');
    if (countElement) {
        countElement.textContent = restaurants.length;
        countElement.style.marginRight = "10px";
    }
    
    // Create a list container for search results
    const resultsList = document.createElement('ul');
    resultsList.className = 'list-none divide-y divide-gray-200 mt-4 bg-white rounded-lg shadow';
    
    // Loop through and display each restaurant as a list item
    restaurants.forEach(restaurant => {
        resultsList.appendChild(createRestaurantListItem(restaurant));
    });
    
    searchResultsDiv.appendChild(resultsList);
    
    // Add sorting functionality like in index.js
    addSortingFunctionality(restaurants, searchResultsDiv);
}

// Add sorting functionality similar to index.js
function addSortingFunctionality(restaurants, container) {
    // Check if sorting tabs container exists
    const sortingTabs = document.getElementById('sorting-tabs');
    if (!sortingTabs) return;
    
    // Clear existing tabs
    sortingTabs.innerHTML = '';
    
    // Create sorting tabs like in index.js
    const tabs = [
        { text: "Relevance", selected: true },
        { text: "Delivery Time", selected: false },
        { text: "Rating", selected: false },
        { text: "Cost: Low To High", selected: false },
        { text: "Cost: High To Low", selected: false }
    ];
    
    // Create and append tabs
    tabs.forEach(tab => {
        const tabElement = document.createElement('div');
        tabElement.className = `tab ${tab.selected ? 'selected' : ''}`;
        tabElement.style.color = tab.selected ? "#3d4152" : "#686b78";
        tabElement.textContent = tab.text;
        
        tabElement.addEventListener('click', function() {
            // Update tab styling
            document.querySelectorAll('.tab').forEach(t => {
                t.className = 'tab';
                t.style.color = "#686b78";
            });
            tabElement.className = 'tab selected';
            tabElement.style.color = "#3d4152";
            
            // Sort restaurants based on selected tab
            let sortedList = filteredList.slice();
            
            if (tab.text.includes("Time")) {
                sortedList.sort(function(a, b) {
                    return a.time - b.time;
                });
            } else if (tab.text.includes("Low To High")) {
                sortedList.sort(function(a, b) {
                    return a.forTwo - b.forTwo;
                });
            } else if (tab.text.includes("High To Low")) {
                sortedList.sort(function(a, b) {
                    return b.forTwo - a.forTwo;
                });
            } else if (tab.text.includes("Rating")) {
                sortedList.sort(function(a, b) {
                    return b.rating - a.rating;
                });
            }
            
            // Re-display the sorted results
            displaySearchResults(sortedList);
        });
        
        sortingTabs.appendChild(tabElement);
    });
}