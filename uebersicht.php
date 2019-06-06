<?php
include_once('open.php');
$info->title('Artikelübersicht');
echo $info->gui->head;
$min = '';
$max = '';
$such = "";
$s = False;
$select = "select * from Artikel";
$sql = "select * from Artikel";
$ver = false;
if (isset($_POST['min'])) {
    if ($_POST['min'] != '') {
        $min = $_POST['min'];
    } else {
        $min = 0;
    }
}

if (isset($_POST['such'])) {
    $such = $_POST['such'];
    $s = True;
}
if (isset($_POST['max'])) {
    if ($_POST['max'] != 0 && $_POST['max'] != ''){
        $max = $_POST['max'];
        if ($s) {
            $select = "SELECT * FROM artikel WHERE abez LIKE '%" . $such .  "%' AND preis >= " . $min . " AND preis <= " . $max;
        } else {
            $select = "SELECT * FROM artikel WHERE preis >= " . $min . " AND preis =< " . $max;
        }
    } else {
        if ($s) {
            $select = "SELECT * FROM artikel WHERE abez LIKE '%" . $such .  "%' AND preis >= " . $min;
        } else {
            $select = "SELECT * FROM artikel WHERE preis >= " . $min;
        }
    }
}
if (isset($_POST['ver'])) {
    if ($_POST['ver'] == 'VerJa') {
        $select .= " AND verfuegbar=1";
    } else {
        if ($_POST['ver'] ==  'VerNein') {
            $select .= " AND verfuegbar=0";
        }
    }
}

$sql = $select;
$sort = "Sortieren nach";
if (isset($_GET['preis'])) {
    if ($_GET['preis'] == 1) {
        $sql = $select . " order by preis DESC";
        $sort = "Preis absteigend";
    } else {
        $sql = $select .  " order by preis ASC";
        $sort = "Preis aufsteigend";
    }
} else {
    if (isset($_GET['ver'])) {
        if ($_GET['ver'] == 1) {
            $sql = $select . " order by anzVer DESC";
            $sort = "Stückzahl absteigend";
        } else {
            $sql = $select . " order by anzVer ASC";
            $sort = "Stückzahl aufsteigend";
        }
    }
}
?>

<div class="container"><h1>Artikelübersicht</h1></div>
<div class="container hoverable z-depth-3">
    <div class="row"><div class="col s4 offset-s1"><br><h5>Filter</h5></div></div>
    <form action="uebersicht.php" method="post">
        <div class="row">
            <div class="col s2 input-field offset-s1">
                <input value="<?php echo $such ?>" id="search" type="text" name="such" class="validate">
                <label for="search">Suchbegriff</label>
            </div>
            <div class="col s2 input-field">
                <input value="<?php echo $min ?>"type="number" id="anz" name="min" step="0.01" min="0" class="validate">
                <label for="anz">min. Preis</label>
            </div>
            <div class="col s2 input-field">
                <input value="<?php echo $max ?>"type="number" id="anz" name="max" step="0.01" min="0" class="validate">
                <label for="anz">max. Preis</label>
            </div>
            <div class="col s3 input-field offset-s1">
                <p>
                    <label>
                        <input name="ver" value="VerJa" type="radio" />
                        <span>Verfügbar</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input name="ver" value="VerNein" type="radio" />
                        <span>Nicht verfügbar</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input name="ver" value="VerAll" type="radio" checked />
                        <span>Alle</span>
                    </label>
                </p>
            </div>

            <!--<div class="col s2 input-field">
                <select>
                    <option value="" disabled selected>Preis pro Tag</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="col s2 input-field">
                <select>
                    <option value="" disabled selected>Kapazität</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>-->

        </div>
        <div class="row">
            <div class="col s4 offset-s1">
                <br>
                <button class="btn waves-effect waves-light center" type="submit" name="action">Filtern
                    <i class="material-icons right">filter_list</i>
                </button>
            </div>
        </div>
    </form>
    <div class="row">
    <div class="col s4 offset-s1">
        <button value="uebersicht.php" class="btn waves-effect waves-light center" onclick="location = this.value;" name="reset">Reset
            <i class="material-icons right">replay</i>
        </button>
    </div>
    </div>
    <br><br><br>
</div>
<br>

<div class="container hoverable z-depth-3">
    <div class="row">
        <div class="col s4 offset-s1">
            <br><h3>Ergebnisse</h3>
        </div>
        <div class="col s3 offset-s1">
            <br>
            <br>
            <?php
                if ($_SESSION['admin'] == True) {
                    echo '<a href="addartikel.php" class="waves-effect waves-light btn"><i class="material-icons left">add_circle</i>Artikel hinzufügen</a>';
                }
            ?>
        </div>
    </div>
        <div class="row">
            <div class="col s3 right">
                <select onchange="location = this.value;">
                    <option value="" disabled selected><?php echo $sort ?></option>
                    <option value="uebersicht.php?preis=1">Preis absteigend</option>
                    <option value="uebersicht.php?preis=2">Preis aufsteigend</option>
                    <option value="uebersicht.php?ver=1">Stückzahl absteigend</option>
                    <option value="uebersicht.php?ver=2">Stückzahl aufsteigend</option>
                </select>
            </div>
        </div>
    <?php
    //Auslesen der Artikel aus der Datenbank
    $anzahl_art = 0;
    try{
        $artikel = $info->pdo->query($sql);
        if($artikel === false){
        } else {
            $anzahl_art = $artikel -> rowCount () ;
        }
    } catch (PDOException $e){
        echo $e->getMessage();
    }

    echo '<form method="post" action="artikel.php?addb=1&anz=' . $anzahl_art . '">';

    $i = 0;
    if ($anzahl_art > 0) {
        foreach ($info->pdo->query($sql) as $row) {
            echo '<div class="row">
            <div class="center col s3 offset-s1">
                <!-- Slider-Teil
                <img class="responsive-img" style="height: auto; width: auto" src="https://picsum.photos/300/150">
                <div class="carousel carousel-slider" id="demo-carousel-indicators" data-indicators="true">
                    <a class="carousel-item" href="#one!"><img src="https://picsum.photos/50/100"></a>
                    <a class="carousel-item" href="#two!"><img src="https://picsum.photos/50/100"></a>
                    <a class="carousel-item" href="#three!"><img src="https://picsum.photos/50/100"></a>
                    <a class="carousel-item" href="#four!"><img src="https://picsum.photos/50/100"></a>
                    <a class="carousel-item" href="#five!"><img src="https://picsum.photos/50/100"></a>
                </div>
                -->
                 <div class="slider">
                    <ul class="slides">';
            if (is_dir($row['pathPic'])) {
                // öffnen des Verzeichnisses
                if ($handle = opendir($row['pathPic'])) {
                    // einlesen der Verzeichnisses
                    while (($file = readdir($handle)) !== false) {
                        if ($file != "." && $file != "..") {
                            echo '<li>
                                    <img src = "' . $row['pathPic'] . '/' . $file . '">
                                    <div class="caption center-align" >
                                      
                                    </div >
                                  </li >';
                            //echo $file;
                        }
                    }
                    closedir($handle);
                }


            }
            echo '</ul>
                  </div>
            </div>
            <div class="col s3 offset-s1">
                <a href="#"><b>' . $row['abez'] . '</b></a>
                <p>' . $row['abes'] . '</p>
                <p><b>Preis:</b> ' . $row['preis'] . ' €</p>
                <p><b>Verfügbar:</b> ' . $row['anzVer'] . '</p>
            </div>';
            if ($_SESSION['userStatus'] == True) echo '<div class="col s2 offset-s1">
                <div class="input-field">
                        <input type="number" id="anz" name="' . "anz+" . $i . '" step="1" min="0" max="10" class="validate">
                        <label for="anz">Anzahl</label>
                </div>
                <label>
                        <input class="with-gap" name="' . "hinzu+" . $i . '" type="checkbox"/>
                        <span>Zum Warenkorb hinzufügen</span>
                </label>
            </div>
            <div class="col s1"><br><br></div>
        </div>';
            echo '<div class="row"><br></div>';
            $i++;
        }
    } else {
        echo
        '<div class="row">
            <div class="center col s5 offset-s1">
            <h4>Keine Suchergebnisse</h4>
            </div>
         </div>';
    }
    ?>
        <div class="row">
            <div class="col s1 offset-s7">
                <input class="modal-close waves-effect waves-green btn-flat" type="submit" value="Artikel zum Warenkorb hinzufügen">
            </div>
            <br>
            <br>
            <br>
        </div>
    </form>
</div>

<?php
echo $info->gui->footer;
?>
