<?php
class info {
    public $gui = '';
    public $pdo = '';

    function __construct() {
        $this->gui = new gui();

        if(session_id() == '' || !isset($_SESSION)) {
            // session isn't started
            session_start();
        }
        if (!isset($_SESSION['userStatus'])) {
            $_SESSION['userStatus'] = False;
            $_SESSION['admin'] = False;
            $_SESSION['username'] = "";
            $_SESSION['meldung'] = "";
            $_SESSION['warenkorb'] = [];
            $_SESSION['gesamtpreis'] = "";
        }

        try {
            $this->pdo = new PDO ('mysql:dbname=webshop;host=localhost', 'brec', 'blabla');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    function title($name) {
        $this->gui->titel = $name;
        $this->gui->createGui();
        if ($this->gui->titel != 'leer') $_SESSION['meldung'] = '';
    }

    function reload() {
        echo '<meta http-equiv=refresh content="0; url=index.php">';
    }
    function reloadw() {
        echo '<meta http-equiv=refresh content="0; url=warenkorb.php">';
    }
    function reloadu() {
        echo '<meta http-equiv=refresh content="0; url=uebersicht.php">';
    }
}

class gui {
    public $head = '';
    private $button = '';
    private $register = '';
    private $menu = '';
    public $footer = '';
    public $titel = 'leer';

    const head1 = '<!DOCTYPE html>
                        <html>
                        <head>
                            <title>';

    const h1 = '</title>
                            <meta charset="utf-8"/>
                            <script src="https://www.google.com/recaptcha/api.js"></script>
                            <link rel="shortcut icon" type="image/png" href="img/mama.ico"/>
                            <link href = "https://fonts.googleapis.com/icon?family=Material+Icons" rel = "stylesheet" >
                            <!--Compiled and minified CSS-->
                            <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" >
                            <!--<link href = "css/bootstrap.min.css" rel = "stylesheet" >
                            <link href = "css/bootstrap.min.css" rel = "stylesheet" >
                            <link href = "css/style.css" rel = "stylesheet" > -->
                            <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" >
                            <!--Compiled and minified JavaScript-->
                            <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
                            <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" ></script >
                            <style type = "text/css" >
                                *{
                                    scroll-behavior: smooth;
                                }
                                .parallax-container {
                                    height:600px;
                                }
                                .carousel {
                                    min-height: 900px;
                                }
                                .bot{
                                    right: 50px;
                                    bottom:50px;
                                }
                                #top2{
                                    right:50px;
                                    bottom:120px;
                                }
                                .tteexxtt{
                                    position:relative;
                                    z-index:10;
                                }
                                img{
                                    user-select: none !important;
                                }
                                body {
                                    display: flex;
                                    min-height: 100vh;
                                    flex-direction: column;
                                }
                                main {
                                    flex: 1 0 auto;
                                }
                                .slider .indicators .indicator-item {
                                  background-color: #666666;
                                  border: 3px solid #ffffff;
                                  -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                                  -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                                  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                                }
                                .slider .indicators .indicator-item.active {
                                  background-color: #ffffff;
                                }
                                .slider {
                                  width: 300px;
                                  margin: 0 auto;
                                }
                                .slider .indicators {
                                  bottom: 60px;
                                  z-index: 100;
                                  /* text-align: left; */
                                }
                            </style >
                        </head>
                        <body>
                        <main>
                            <a id="top"></a >
                            <div class="navbar-fixed">
                            <nav>
                                <div class="nav-wrapper blue-grey darken-3" >
                                    <a href="#" data-target="mobile-demo" class="sidenav-trigger show-on-large"><i class="material-icons">menu</i></a >
                                    <div style="margin-top:5px" class="brand-logo center"><a href="index.php">mamazon <span class="blue-text">prime</span></a></div >
                                    <ul class="right">';
    const footer = '</main>
                        <footer class="page-footer blue-grey darken-3">
                        <div class="container">
                        <div class="col l4">
                        <p>Michael Beier & Linus Dehner</p>
                        <br>
                        </div>
                        </div>
                        </footer>
                        
                        <script>
                        $(document).ready(function(){
                            $(\'#demo-carousel-indicators\').carousel({fullWidth: true});
                            });
                             $(document).ready(function(){
                              $(\'.slider\').slider();
                            });
                            </script>
                        
                        </body>
                            <script type="text/javascript">
                                document.addEventListener("DOMContentLoaded", function() {
                                    M.AutoInit();
                                });
                                
                            </script>
                        </html>';

    const head2 = '
			</ul>
		</div>
	</nav>
	</div>
    <!-- Modal Structure -->
	<div id="modal1" class="modal">
	<form action="user.php" method="post">
		<div class="modal-content">
			<h4>Anmelden</h4>
			<div class="row">
				<div class="col s3 input-field">
					<input name="username" id="username" type="text" class="validate">
					<label for="username">Benutzername</label>
				</div>
				<div class="col s3 input-field">
					<input name="pw" id="pw" type="password" class="validate">
					<label for="pw">Passwort</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<input class="modal-close waves-effect waves-green btn-flat" type="submit" value="Anmelden">
			<a href="#" class="modal-close waves-effect waves-green btn-flat">Abbrechen</a>
		</div>
	</form>
	</div>

	<ul class="sidenav right" id="mobile-demo">
	    <li><a class="waves-effect" href="index.php">Startseite</a></li>
		<li><a class="waves-effect" href="uebersicht.php">Artikelübersicht</a></li>';

    const head3 = '
	</ul>

	

    <script type="text/javascript">
    window.onscroll = function(){
        var y = document.documentElement.scrollTop;
        if (y >= 100) {
            //document.getElementById("top2").style.display = "block";
        } else {
            //document.getElementById("top2").style.display = "none";
        }
    }
    </script>';

    function createButtons() {
        //$add = '<li><a class="waves-effect" href="fehler.php?waren=1">Warenkorb</a></li>
            //<li><a class="waves-effect" href="register-gui.php">Registrieren</a></li>';
        if ($_SESSION['userStatus'] == False) {
            $this->button = '<li><a href="#modal1" class="modal-trigger"><i class="medium material-icons">exit_to_app</i></a></li>
                                <li><a href="fehler.php?waren=1"><i class="medium material-icons">shopping_cart</i></a></li>';
            $this->register = '<li><a href="register-gui.php"><i class="medium material-icons">person_add</i></a></li>';
            $this->menu = '<li><a class="waves-effect" href="fehler.php?artikel=1">Artikel anlegen</a></li>';
        } else {
            $this->button = '<li><a href="user.php?logout=1" class="modal-trigger"><i class="medium material-icons">cancel</i></a></li>
                                <li><a href="warenkorb.php"><i class="medium material-icons">shopping_cart</i></a></li>';
            $this->register = '<li><a href="fehler.php?regerror=1"><i class="medium material-icons">person_add</i></a></li>';
            if ($_SESSION['admin'] == True) {
                $this->menu = '<li><a class="waves-effect" href="addartikel.php">Artikel anlegen</a></li>';
            } else {
                $this->menu = '<li><a class="waves-effect" href="fehler.php?artikel=1">Artikel anlegen</a></li>';
            }
        }
    }

    function createGui() {
        $this->createButtons();
        if ($_SESSION['meldung'] != '') {
            $this->head = self::head1 . $this->titel . self::h1 .  $this->register . $this->button . self::head2 . $this->menu . self::head3 . "<br><div class='container red-text right-align'>Meldung: " . $_SESSION['meldung'] . '</div>';
        } else {
            $this->head = self::head1 . $this->titel . self::h1 . $this->register . $this->button . self::head2 . $this->menu . self::head3;
        }
        $this->footer = self::footer;
    }
}

$info = new info();
?>
