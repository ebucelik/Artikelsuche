<?php 
session_start();
session_destroy(); 
?>

<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marzek Suche</title>

    <link rel="stylesheet" href="css/index.css" />

    <!-- Latest compiled and minified CSS -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    />

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="scripts/script.js"></script>
    <script src="scripts/scriptmed.js"></script>
  </head>
  <body>
    <header>
      <a href="index.php"><img src="Bilder/ArtikelsucheKundensuche.png" title="Marzek Suche" alt="Marzek Suche Bild" width="300"/></a>
    </header>

    <nav>
      <div
        class="jumbotron jumbotron-fluid row"
        style="background-color: transparent">
        <div class="container col">
          <h1 class="display-4 fading" id="title">Marzek Suche</h1>
          <p class="lead fading">
            Suche in der hausinternen Marzek Etiketten+Packaging Datenbank nach
            Artikeln und Kunden
          </p>
        </div>
      </div>
      <button
        type="button"
        id="toItemSearch"
        class="btn btn-outline-light fading"
      >
        <h4>Weiter zur Artikelsuche</h4>
      </button>
      <button
        type="button"
        id="toCustomerSearch"
        class="btn btn-outline-light fading"
      >
        <h4>Weiter zur Kundensuche</h4>
      </button>
    </nav>
  </body>
</html>