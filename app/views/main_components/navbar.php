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
        <nav class="navbar">
            <div class="nav_icon" onclick="toggleSidebar()">
              <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="navbar__left">
              <a class="active_link" href="#">Admin</a>
            </div>
            <div class="navbar__right">
              <?php echo "<p style='font-weight:bolder;margin-right:5px;color: #265acc;border-bottom: 3px solid #265acc;padding-bottom: 5px;'> 
                          Welcome, ".$_SESSION["user-name"]."</p>"; ?>
              <img  width="30" height="30" src="../../images/blueAvatar.png" alt=""/> 
        </nav>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="/cryptoBank/javascript/admin.js"></script>
    </body>
</html>

