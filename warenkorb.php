<?php
include_once('open.php');
$info->title('Warenkorb');
echo $info->gui->head;
$select = "select * from auswahl";
$sql = "select * from auswahl";
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
<div class="container"><h1>Warenkorb</h1>
</div>
<div class="container hoverable z-depth-3">
    <div class="row">
        <br>
        <div class="col s3 right">
            <select onchange="location = this.value;">
                <option value="" disabled selected><?php echo $sort ?></option>
                <option value="warenkorb.php?preis=1">Preis absteigend</option>
                <option value="warenkorb.php?preis=2">Preis aufsteigend</option>
                <option value="warenkorb.php?ver=1">Stückzahl absteigend</option>
                <option value="warenkorb.php?ver=2">Stückzahl aufsteigend</option>
            </select>
        </div>
    </div>
    <?php
    //Auslesen der Artikel aus der Datenbank
    $sql = "SELECT * FROM auswahl where user='" . $_SESSION['username'] . "'";
    $anzahl_art = 0;
    try{
        $artikel = $info->pdo->query($sql);
        if($artikel === false){
            $_SESSION['meldung'] = "Artikel konnten nicht abgerufen werden";
        } else {
            $anzahl_art = $artikel -> rowCount () ;
        }
    } catch (PDOException $e){
        echo $e->getMessage();
    }

    if ($anzahl_art > 0) {
        foreach ($info->pdo->query($sql) as $row) {
            $i = $row['id'];
            $link = "artikel.php?delb=1&nr=$i";
            echo '<div class="row">';
            /* <div class="center col s3 offset-s1">
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
        $files = scandir($row['pathPic']);
        $files_count = count($files)-2; // Minus zwei wegen "." und ".."
        for ($i = 0; $i<$files_count; $i++) {
            echo '<li>
                        <img src = "'. $row['pathPic'] . '/1CHIT.png" > <!--random image-->
                        <div class="caption center-align" >
                          <h3 > ' . $row['abez'] .' </h3 >
                        </div >
                      </li >';
        }
        echo '</ul>
                  </div>*/
            echo '
            <div class="col s3 offset-s1">
                <a href="#"><b>' . $row['abez'] . '</b></a>';
            //<p>' . $row['abes'] . '</p>
            echo '<p><b>Preis:</b> ' . $row['preis'] . ' €</p>
                <p><b>Anzahl:</b> ' . $row['aanz'] . '</p>
            </div>
                <form method="post" action="' . $link . '">
                    <input class="modal-close waves-effect waves-green btn-flat" type="submit" value="Artikel aus dem Warenkorb entfernen">
                </form>
            <div class="col s1"><br><br></div>
        </div>';
            echo '<div class="row"><br></div>';
        }
    } else {
        echo
        '<div class="row">
            <div class="center col s5 offset-s1">
            <h4>Keine Artikel im Warenkorb</h4>
            </div>
         </div>';
    }

    ?>
    <div class="row">
        <br>
    </div>
</div>
<?php
echo $info->gui->footer;
?>
