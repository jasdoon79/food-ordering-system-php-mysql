<header class="text-gray-600 body-font" id="nav-body">
    <!-- Header content will be dynamically inserted here via AJAX -->
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
          <a href="./index.php" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0" >
              <img src="https://logosandtypes.com/wp-content/uploads/2021/01/Swiggy.png" alt="" id="logo"  >
      
            <span class="ml-3 text-xl" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <div id="nav-location">
                      <span id="other">
                          <span class="other">Other</span>
                      </span>
                      <span id="town">
                          Berhampur,Ganjam,Odisha
                      </span>
                      <span >
                          <i id="nav-down" class="fa-solid fa-chevron-down"></i>
                      </span>
                  </div>
            </span>
            
      <!-- offcanvas for location -->
            <div class="offcanvas offcanvas-start location-canvas" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <!-- <i class="fa-solid fa-xmark"></i> -->
                <button class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" ></button>
              </div>
              <div class="offcanvas-body">
                <div class="location-input">
                  <div class="location-input2">
                    <input type="text" id="location-input" placeholder="Search for City">
                  </div>
                </div>     
                <div class="location-input">
                  <div class="location-input3">
                        <div class="gps" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                          <div class="icon-location-crosshair _13AY4"></div>
                          <div class="_3eFzL" >
                            <div class="Ku2oK" >Get current location</div>
                            <div class="_1joFh">Using GPS</div>
                          </div>
                        </div>
                  </div>
                </div>    
                <div class="recent-search">
                  <div class="recent-search-text">RECENT SEARCH</div>
      
                  <!-- recen search city of your system -->
                  <div id="recent-search-container">
                   
                  
                  </div>
                         
                  
                </div>
      
              </div>
            </div>
      
          
          </a>
          <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
            <a class="mr-5 " href="./search.php">
               <i class="fa-solid fa-magnifying-glass"></i>
                <span id="search-text" style="margin-left: 7px;">Search</span>
            </a>
            
            <a href="../Blog/" class="mr-5 ">
              <i class="fa-solid fa-circle-info"></i>
              <span id="help-text" style="margin-left: 7px;" >Blog</span>
            </a>
            <div class="UserName dropdown">
            <a class="mr-5 dropbtn">
              <i class="fa-solid fa-user-plus"></i>
               <span id="Profile" style="margin-left: 7px;">UserName</span>
           </a>
           <div class="dropdown-content">
            <a href="./profileEdit.php">Profile</a>
            <a href="#" id="logout">Logout</a>
          </div> 
          </div>
      
               <a class="mr-5 signin-nav" href="./auth.php">
            <i class="fa-solid fa-user-plus"></i>
            <span id="signin-text" style="margin-left: 7px;">Sign in</span>
          </a>
          
            <a class="mr-5 " href="./cart.php">
              <i class="fa-solid fa-cart-shopping"></i>
              <span id="cart-text" style="margin-left: 7px;" >Cart</span>
            </a>
          </nav>
        </div>
      
        <!-- toast alert -->
        <div class="toast-container position-fixed top-10 end-10 p-3" >
          <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close">Ok</button>
            </div>
            <div class="toast-body">
              Hello, world! This is a example of toast message.
            </div>
          </div>
        </div>
</header>