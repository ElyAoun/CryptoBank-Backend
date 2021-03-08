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
    <link rel="stylesheet" href="/cryptoBank/css/users.css" />
    </head>
    <body>
        <div class="main__cards">
            <div class="card">
              <i
                class="fa fa-user-o fa-2x text-lightblue"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Users</p>
                <span class="font-bold text-title"><?php echo $_SESSION["nbrOfUsers"]; ?></span>
              </div>
            </div>
        
            <div class="card">
              <i class="fa fa-user-o fa-2x text-red" aria-hidden="true"></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Admins</p>
                <span class="font-bold text-title"><?php echo $_SESSION["nbrOfAdmins"]; ?></span>
              </div>
            </div>
        
            <div class="card">
              <i
                class="fa fa-bitcoin fa-2x text-yellow"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Currencies</p>
                <span class="font-bold text-title"><?php echo $_SESSION["nbrOfCurrencies"]; ?></span>
              </div>
            </div>
        
            <div class="card">
              <i
                class="fa fa-envelope fa-2x text-green"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Messages</p>
                <span class="font-bold text-title"><?php echo $_SESSION["nbrOfRepliedMessages"]."/".$_SESSION["nbrOfMessages"]; ?></span>
              </div>
            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
          <script src="/cryptoBank/javascript/admin.js"></script>
    </body>
</html>
