<html>
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="/cryptoBank/css/admin.css"/>
    </head>
    <body>
        <div id="sidebar">
            <div class="sidebar__title">
              <div class="sidebar__img">
               <a href="/cryptoBank/app/views/adminDashBoard.php" class="CryptoBank"><h1>CRYPTOBANK</h1></a>
              </div>
              <i
                onclick="closeSidebar()"
                class="fa fa-times"
                id="sidebarIcon"
                aria-hidden="true"
              ></i>
            </div>
        
            <div class="sidebar__menu">
              <div class="sidebar__link">
                <i class="fa fa-home"></i>
                <a href="/cryptoBank/app/views/adminDashboard.php">Dashboard</a>
              </div>
              <div class="sidebar__link">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <a href="/cryptoBank/public/AdminController/displayAdmins">Manage Admins</a>
              </div>
              <div class="sidebar__link">
                <i class="fa fa-user" aria-hidden="true"></i>
                <a href="/cryptoBank/public/UserController/displayUsers">Manage Users</a>
              </div>
              <div class="sidebar__link">
                <i class="fa fa-money" aria-hidden="true"></i>
                <a href="/cryptoBank/public/Wallet_TypeController/displayCurrencies">Currencies</a>
              </div>
              <div class="sidebar__link">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <a href="/cryptoBank/public/MessageController/displayMessages">Messages</a>
              </div>
              <div class="sidebar__link">
                <i class="fa fa-pencil" aria-hidden="true"></i>
                <a href="/cryptoBank/app/views/UpdateAdmin.php">Change Password</a>
              </div>
              <a href="/cryptoBank/public/AdminController/logOut"><Button class="LogOutBtn">Log out</Button></a>
            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
          <script src="/cryptoBank/javascript/admin.js"></script>
    </body>
</html>

