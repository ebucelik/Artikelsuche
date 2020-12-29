<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Marzek Kundensuche</title>

    <link rel="stylesheet" href="css/searching.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

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
        <a href="index.html" ><img src="Bilder/Version3.png" id="headerImg" title="Marzek Kundensuche" alt="Marzek Kundensuche Bild" width="400"></a>
    </header>

    <nav>
        <div class="container" id="inputFields">
            <form action="" method="POST">
                <div class="form-group fading searchForm">
                    <label for="kNumber" class="align-self-center labelTxt">Kundennummer:</label>
                    <input type="number" class="form-control searchInput" id="kNumber" placeholder="Kundennummer eingeben" name="kNumber" min="4">
                    <span class="kNumberalert"></span>
                </div>
                <div class="form-group fading searchForm">
                    <label for="kName" class="align-self-center labelTxt">Kundenname:</label>
                    <input type="text" class="form-control searchInput" id="kName" placeholder="Kundenname eingeben" name="kName">
                </div>
                <div class="form-group fading searchForm">
                    <label for="kPLZ" class="align-self-center labelTxt">PLZ:</label>
                    <input type="number" class="form-control searchInput" id="kPLZ" placeholder="PLZ eingeben" name="kPLZ">
                    <span class="kPLZalert"></span>
                </div>
                <div class="form-group fading searchForm">
                    <label for="street" class="align-self-center labelTxt">Straße:</label>
                    <input type="text" class="form-control searchInput" id="street" placeholder="Straße eingeben" name="street">
                </div>
                <div class="form-group fading searchForm">
                    <label for="place" class="align-self-center labelTxt">Ort:</label>
                    <input type="text" class="form-control searchInput" id="place" placeholder="Ort eingeben" name="place">
                </div>
                <div class="form-group fading searchForm">
                    <label for="tNumber" class="align-self-center labelTxt">Telefonnummer:</label>
                    <input type="text" class="form-control searchInput" id="tNumber" placeholder="Telefonnummer eingeben" name="tNumber">
                    <span class="tNumberalert"></span>
                </div>             
                <div class="form-group fading searchForm">
                    <label for="email" class="align-self-center labelTxt">E-Mail:</label>
                    <input type="text" class="form-control searchInput" id="email" placeholder="E-Mail eingeben" name="email">
                </div>
                <button type="submit" class="btn btn-outline-light fading" id="articlesearch">SUCHEN</button>   
            </form>
        </div>
    </nav>
</html> 