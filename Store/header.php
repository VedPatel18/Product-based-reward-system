<?php session_start();
if (isset($_SESSION["s_loggedin"]) && $_SESSION["s_loggedin"] === true) {
    $login_status = $_SESSION["s_loggedin"];
    $username = $_SESSION["s_username"];
    $s_id = $_SESSION["s_id"];
} else {
    // header("location: login.php");
    // exit;
} ?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/loginStyle.css">

    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">


    <!-- 
      - google font link
    -->
    <link rel="preconnect" href="https:d//fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- 
      - preload banner
    -->
    <link rel="preload" href="./assets/images/hero-banner.png" as="image">

    <!-- Popup Modal -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/../store/footcap-master/popup-new/css/tailwind.css">
    <!-- 
      - custom css link
    -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- Popup Modal -->
    <div class="fixed bottom-12 left-12 z-20">
        <div class="modal relative bottom-8">
            <div class="modal-wrapper modal-transition rounded-lg">
                <div class="modal-wrapper-inner relative">
                    <div class="modal-header rounded-t-lg z-10">
                        <button class="modal-close modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 icon-close icon text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div class="modal-heading text-white px-6 pt-8 pb-12">
                            <div style=" display: flex; justify-content: space-between; " class="px-8">

                                <!-- Customised -->
                                <p class="text-lg pb-2" id="point">Welcome to</p>
                                <!-- Customised -->
                                <p class="text-lg pb-2" id="premium"></p>
                            </div>
                            <div style=" display: flex; justify-content: space-between; " class="px-8">
                                <!-- Customised -->
                                <h2 class="text-4xl font-semibold pb-4" id="points">Rewardify!</h2>
                                <!-- Customised -->
                                <h2 class="text-4xl font-semibold pb-4" id="premiumLeft"></h2>
                            </div>
                        </div>
                    </div>
                    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
                    <div class="modal-body rounded-b-lg p-4">
                        <div class="modal-content rounded-b-lg">
                            <!--Start 01-->
                            <?php if (!isset($login_status)) {
                                ?>
                                <!--Stop 01 -->
                                <div class="bg-white shadow shadow-xl px-4 py-8 rounded-lg -mt-12 z-10 relative">
                                    <h2 class="text-base font-bold text-center text-xl">Become a member</h2>
                                    <p class="text-lg text-[#637381] text-center py-2">With more ways to unlock exciting
                                        perks,
                                        this
                                        is your all access pass to exclusive rewards.</p>
                                    <div class="w-fit mx-auto pt-2">
                                        <!-- Customised --><button
                                            class="py-4 px-8 bg-[#a853d6] text-white rounded-lg text-lg "
                                            onclick="window.location.href = 'signup.php'">
                                            Join now
                                        </button>
                                    </div>
                                    <!-- Customised -->
                                    <p class="text-lg text-[#637381] text-center py-2">Already have an account? <a
                                            href="login.php" class="text-[#a853d6] underline"> Sign in</a></p>
                                </div>
                                <!--Start 02 -->
                                <?php
                            } else { ?>
                                <script>
                                    var s_id = <?php echo $s_id; ?>;
                                </script>
                                <!--Stop 02 -->
                                <div class="bg-white shadow shadow-xl px-4 py-8 rounded-lg -mt-12 z-10 relative">
                                    <!-- Customised -->
                                    <h2 class="text-base font-bold text-center text-xl" id="nextSpin">Daily Spin</h2>
                                    <!-- Customised -->
                                    <p class="text-lg text-[#637381] text-center py-2" id="won">"Spin, Win, Repeat! Daily
                                        rewards
                                        await. Spin now and claim your daily prize!"</p>
                                    <!-- Customised -->
                                    <div id="chart"></div>
                                </div>
                            <?php } ?>
                            <div class="bg-white shadow shadow-xl px-4 py-8 rounded-lg z-50 relative mt-4">
                                <h2 class="text-base font-bold text-center text-xl">Points</h2>
                                <p class="text-lg text-[#637381] text-center py-2 nt1">Earn more Points for different
                                    actions,
                                    and
                                    turn those Points into awesome rewards!</p>
                                <div>
                                    <div
                                        class="mb-2 relative after:absolute after:bg-[#637381] after:w-[calc(100%-3rem)] after:h-px after:content-[''] after:-bottom-2 after:right-0">
                                        <a href="#"
                                            class="earn-more-points text-[#637381] text-lg flex justify-between items-center px-2 py-4 hover:bg-gray-50 rounded-lg duration-300 ease-in-out">
                                            <div class="flex items-center gap-4">
                                                <img src="/../store/footcap-master/popup-new/img/earn-more-points.svg"
                                                    alt="">
                                                <span>Ways to earn</span>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="pt-2">
                                        <a href="#"
                                            class="spend-your-points text-[#637381] text-lg flex justify-between items-center px-2 py-4 hover:bg-gray-50 rounded-lg duration-300 ease-in-out">
                                            <div class="flex items-center gap-4">
                                                <img src="/../store/footcap-master/popup-new/img/spend-your-points.svg"
                                                    alt="">
                                                <span>Ways to redeem</span>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white shadow shadow-xl px-4 py-8 rounded-lg z-50 relative mt-4">
                                <h2 class="text-base font-bold text-center text-xl">Referrals</h2>
                                <p class="text-lg text-[#637381] text-center py-2">Give your friends a reward and claim
                                    your
                                    own
                                    when they make a purchase.</p>
                                <div>
                                    <div class="px-2 py-4">
                                        <div class="flex items-center gap-4 pb-8">
                                            <img src="/../store/footcap-master/popup-new/img/fixed-amount.svg" alt="">
                                            <div class="text-lg">
                                                <p>They get</p>
                                                <!-- Customised -->
                                                <p class="text-[#637381]" id="ten">$10 off coupon</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <img src="/../store/footcap-master/popup-new/img/fixed-amount.svg" alt="">
                                            <div class="text-lg">
                                                <p>You get</p>
                                                <!-- Customised -->
                                                <p class="text-[#637381]" id="eleven">$10 off coupon</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white shadow shadow-xl px-4 py-8 rounded-lg z-50 relative mt-4">
                                <h2 class="text-base font-bold text-center text-xl">Premium & Expiry</h2>
                                <!-- Customised -->
                                <p class="text-lg text-[#637381] text-center py-2" id="premiumLeft">Premium users earn
                                    higher rewards and
                                    enjoy longer-lasting points.</p>
                                <div>
                                    <div class="px-2 py-4">
                                        <div class="flex items-center gap-4 pb-8">
                                            <img src="/../store/footcap-master/popup-new/img/fixed-amount.svg" alt="">
                                            <div class="text-lg">
                                                <p>They enjoy an extra </p>
                                                <!-- Customised -->
                                                <p class="text-[#637381]" id="pReward">30% in rewards</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <img src="/../store/footcap-master/popup-new/img/fixed-amount.svg" alt="">
                                            <div class="text-lg">
                                                <!-- Customised -->
                                                <p id="pExpiry">Only 100% of points expires after 90 days</p>
                                                <!-- Customised -->
                                                <p class="text-[#637381]" id="expiry">While 40% for Normal User</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sticky bottom-0 bg-white shadow w-full z-50 left-0 p-4 text-center">
                        <p>
                            We reward with Smile
                        </p>
                    </div>
                </div>
                <div class="spend-your-points-body">
                    <div class="bg-[#a853d6] rounded-t-lg z-10">
                        <div class="modal-heading text-white p-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 spend-your-points hover:cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                                <p class="text-lg">Treat Bucks!</p>
                            </div>
                            <button class="modal-close modal-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 icon-close icon text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-6 rounded-lg z-50 relative">
                        <h2 class="text-base font-bold">Redeem</h2>
                        <div>
                            <!-- Customised -->
                            <div class="px-2 py-8" id="modal_data2">
                            </div>
                        </div>
                    </div>

                    <!--Start 03 -->
                    <?php if (!isset($login_status)) { ?>
                        <div class="sticky bottom-0 bg-white shadow w-full z-50 left-0 p-4 text-center">
                            <div class="w-full mx-auto pt-2">
                                <!-- Customised --><button
                                    class="py-4 px-8 bg-[#a853d6] text-white rounded-lg text-lg w-full"
                                    onclick="window.location.href = 'signup.php'">
                                    Join now
                                </button>
                            </div>
                            <!-- Customised -->
                            <p class="text-lg text-[#637381] text-center py-2">Already have an account? <a href="login.php"
                                    class="text-[#a853d6] underline"> Sign in</a></p>
                        </div>
                        <!--Stop 03 -->
                    <?php } ?>
                </div>
                <div class="earn-more-points-body">
                    <div>
                        <div class="bg-[#a853d6] rounded-t-lg z-10">
                            <div class="modal-heading text-white p-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 earn-more-points hover:cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>

                                    <p class="text-lg">Treat Bucks!</p>
                                </div>
                                <button class="modal-close modal-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 icon-close icon text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="p-6 rounded-lg z-50 relative">
                            <h2 class="text-base font-bold">Ways to earn</h2>
                            <div>
                                <!-- Customised -->
                                <div class="px-2 py-8" id="modal_data">
                                </div>

                            </div>
                        </div>
                        <!--Start 04 -->
                        <?php if (!isset($login_status)) { ?>
                            <div class="sticky bottom-0 bg-white shadow w-full z-50 left-0 p-4 text-center">
                                <div class="w-full mx-auto pt-2">
                                    <button class="py-4 px-8 bg-[#a853d6] text-white rounded-lg text-lg w-full">
                                        Join now
                                    </button>
                                </div>
                                <!-- Customised -->
                                <p class="text-lg text-[#637381] text-center py-2">Already have an account? <a
                                        href="login.php" class="text-[#a853d6] underline"> Sign in</a></p>
                            </div>
                        <?php } ?>
                        <!--Stop 04 -->
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>

        <div class="w-fit">
            <button
                class="modal-toggle reward-btn bg-[#a853d6] text-white py-3 px-6 rounded-full block hover:cursor-pointer">
                <div class="flex items-center gap-2 rewards">
                    <i class="fa-solid fa-gift text-3xl"></i>
                    <span class="text-base">Rewards</span>
                </div>
                <div class="close hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 icon-close icon text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </button>
        </div>
    </div>


    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="/../store/footcap-master/popup-new/custom.js"></script>

    <script>
        $(document).ready(function () {
          <?php if (isset($login_status)) { ?> getData(); <?php } ?>
            const container = document.getElementById("modal_data");
            $.ajax({
                url: '/../reward_system/modal.php',
                type: 'get',
                data: { name: 1 },
                dataType: 'JSON',
                success: function (response) {
                    // console.log(response);
                    var len = response.length;
                    // console.log(len);
                    for (var i = 0; i < len; i++) {
                        var name = response[i].name;
                        var points = response[i].points;
                        // Create the new div element
                        const newDiv = document.createElement('div');
                        newDiv.className = 'flex items-center gap-4 pb-8 relative after:absolute after:bg-[#637381] after:w-[calc(100%-3rem)] after:h-px after:content-[""] after:bottom-4 after:right-0';

                        // Create the image element
                        const newImg = document.createElement('img');
                        newImg.src = '/../store/footcap-master/popup-new/img/signup.svg';
                        newImg.alt = '';

                        // Create the inner div element
                        const newInnerDiv = document.createElement('div');
                        newInnerDiv.className = 'text-lg';

                        // Create the title paragraph element
                        const newTitleP = document.createElement('p');
                        newTitleP.textContent = name;

                        // Create the points paragraph element
                        const newPointsP = document.createElement('p');
                        newPointsP.className = 'text-[#637381]';
                        newPointsP.textContent = points + " Points";

                        // Append the elements to the respective parents
                        newInnerDiv.appendChild(newTitleP);
                        newInnerDiv.appendChild(newPointsP);
                        newDiv.appendChild(newImg);
                        newDiv.appendChild(newInnerDiv);
                        container.appendChild(newDiv);
                    }
                }
            });
            const container2 = document.getElementById("modal_data2");

            $.ajax({
                url: '/../reward_system/modal.php',
                type: 'get',
                data: { name: 2 },
                dataType: 'JSON',
                success: function (response) {
                    var len = response.length;
                    // console.log(response);
                    for (var i = 0; i < len; i++) {
                        const newDiv = document.createElement('div');
                        newDiv.className = 'flex items-center gap-4 pb-8 relative after:absolute after:bg-[#637381] after:w-[calc(100%-3rem)] after:h-px after:content-[""] after:bottom-4 after:right-0';

                        // Create a new img element
                        const newImg = document.createElement('img');
                        newImg.src = '/../store/footcap-master/popup-new/img/fixed-amount.svg';
                        newImg.alt = '';

                        // Create a new div element for text content
                        const newTextDiv = document.createElement('div');
                        newTextDiv.className = 'text-lg';

                        // Create a new p element for the coupon
                        const newCouponP = document.createElement('p');
                        newCouponP.textContent = response[i];

                        // Append the elements to their respective parents
                        newTextDiv.appendChild(newCouponP);
                        newDiv.appendChild(newImg);
                        newDiv.appendChild(newTextDiv);
                        container2.appendChild(newDiv);
                    }
                }
            });

            $.ajax({
                url: '/../reward_system/modal.php',
                type: 'get',
                data: { name: 3 },
                dataType: 'JSON',
                success: function (response) {
                    document.getElementById("ten").innerHTML = response[0] + " Points"
                    document.getElementById("eleven").innerHTML = response[1] + " Points"
                }
            });

            $.ajax({
                url: '/../reward_system/modal.php',
                type: 'get',
                data: { name: 4 },
                dataType: 'JSON',
                success: function (response) {
                    document.getElementById("pReward").innerHTML = response[2] + "% in rewards"
                    document.getElementById("pExpiry").innerHTML = "Only " + response[3] + "% of points expires after " + response[0] + "days"
                    document.getElementById("expiry").innerHTML = "While  " + response[1] + "% for Normal User"
                }
            });

        });
        function getData() {
            <?php if (isset($s_id)) { ?>
                var s_id = <?php echo $s_id; ?>;
            <?php } ?>
            // ajax to fetch points from db
            $.ajax({
                url: '/../../reward_system/ajax_bill.php',
                type: 'get',
                data: { s_id: s_id, order_value: 0, option: 3 },
                success: function (response) {
                    document.getElementById("points").innerHTML = response.replace(/[^0-9]/g, "")
                    document.getElementById("point").innerHTML = "Points"
                }
            });
            $.ajax({
                url: '/../../reward_system/ajax_bill.php',
                type: 'get',
                data: { s_id: s_id, order_value: 0, option: 4 },
                success: function (response) {
                    var givenDate = new Date(response.replace(/"/g, ''));
                    var currentDate = new Date();

                    // Calculate the time difference in milliseconds
                    var timeDiff = givenDate - currentDate;
                    if (isNaN(timeDiff) || timeDiff < 0) {
                        document.getElementById("premium").innerHTML = "Premium"
                        document.getElementById("premiumLeft").innerHTML = "Inactive"
                    }
                    else {
                        var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        document.getElementById("premium").innerHTML = "Premium Left"
                        document.getElementById("premiumLeft").innerHTML = daysDiff + "Days"
                    }
                }
            });
            $.ajax({
                url: '/../../reward_system/ajax_bill.php',
                type: 'get',
                data: { s_id: s_id, order_value: 0, option: 6 },
                success: function (response) {
                    if (response >= 0) {
                        console.log(response + "POS");
                    }
                    else {
                        document.getElementById("chart").style.display = "none";
                        document.getElementById("nextSpin").innerHTML = "Next Spin in " + Math.abs(parseInt(response / 60)) + " Hours " + Math.abs(parseInt(response % 60)) + " Minutes";
                    }
                }
            });
        }
    </script>

    <!-- Popup Modal Ends -->
    <!-- 
    - #HEADER
  -->

    <header class="header" data-header>
        <div class="container">

            <div class="overlay" data-overlay></div>

            <a href="index.php" class="logo">
                <img src="./assets/images/logo.svg" width="160" height="50" alt="Footcap logo">
            </a>

            <button class="nav-open-btn" data-nav-open-btn aria-label="Open Menu">
                <ion-icon name="menu-outline"></ion-icon>
            </button>

            <nav class="navbar" data-navbar>

                <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
                    <ion-icon name="close-outline"></ion-icon>
                </button>

                <a href="#" class="logo">
                    <img src="./assets/images/logo.svg" width="190" height="50" alt="Footcap logo">
                </a>

                <ul class="navbar-list">

                    <li class="navbar-item">
                        <a href="index.php" class="navbar-link">Home</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#" class="navbar-link">About</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#" class="navbar-link">Products</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#" class="navbar-link">Shop</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#footer-list" class="navbar-link">Blog</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#footer-list" class="navbar-link">Review</a>
                    </li>

                </ul>

                <ul class="nav-action-list">

                    <!-- <li>   
            <button class="nav-action-btn">
              <ion-icon name="search-outline" aria-hidden="true"></ion-icon>

              <span class="nav-action-text">Search</span>
            </button>
          </li> -->

                    <li>
                        <a href="login.php" class="nav-action-btn">
                            <?php if (isset($login_status)) {
                                echo $username;
                            } else { ?>
                                <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
                            <?php } ?>
                            <span class="nav-action-text">Login / Register</span>
                        </a>
                    </li>

                    <li>
                        <a href="logout.php" class="nav-action-btn">
                            <ion-icon name="log-out-outline" aria-hidden="true"></ion-icon>
                            <span class="nav-action-text">Wishlist</span>
                        </a>
                    </li>

                    <li>
                        <button class="nav-action-btn" onclick="window.location.href='cart.php'">
                            <ion-icon name="bag-outline" aria-hidden="true"></ion-icon>

                            <data class="nav-action-text" value="318.00">Basket: <strong>$318.00</strong></data>

                            <data class="nav-action-badge" value="4" aria-hidden="true">4</data>
                        </button>
                    </li>

                </ul>

            </nav>

        </div>
    </header>