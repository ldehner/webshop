<?php
include_once('open.php');


class artikel {
    private $info;

    function __construct($info) {
        $this->info = $info;
    }

    function getVer($artikel) {
        $sql = "SELECT anzVer from artikel where abez='" . $artikel . "'";
        try{
            $wert = $this->info->pdo->query($sql);
            $ver = $wert->fetch();
        } catch (PDOException $e){
            $_SESSION['meldung'] = $e->getMessage();
        }
        return $ver['anzVer'];
    }

    function updateVer($artikel, $ver, $z) {
        if ($z == '-') {
            $neu = $this->getVer($artikel) - $ver;
        } else {
            $neu = $this->getVer($artikel) + $ver;
        }
        $sql = "UPDATE artikel SET anzVer=" . $neu . " WHERE abez='" . $artikel . "'";
        $sql1 = "UPDATE artikel SET verfuegbar=FALSE WHERE abez='" . $artikel . "'";
        try{
            $this->info->pdo->query($sql);
            if ($neu == 0) $this->info->pdo->query($sql1);
        } catch (PDOException $e){
            $_SESSION['meldung'] = $e->getMessage();
        }
    }

    function add() {
        //Die eingegebenen Artikeldaten werden gespeichert
        $name = $_POST['artname'];
        $bes = $_POST['beschreibung'];
        $preis = $_POST['price'];
        $anz = $_POST['anz'];
        $ver = 'FALSE';
        if ($anz > 0) $ver = 'True';

        //Artikel wird in die Datenbank eingefügt
        $path = "uploads/" . $name . "/";
        $sql = "INSERT into artikel VALUES('$name', '$bes', $preis, $ver, $anz, '$path')";
        if($this->info->pdo->exec($sql) === false){
            $_SESSION['meldung'] = 'Der Artikel konnte nicht hinzugefügt werden.';
        }else {
            $_SESSION['meldung'] = 'Der Artikel wurde zur Übersicht hinzugefügt.';
        }

        mkdir($path, 0700);
        $countfiles = count($_FILES["fileToUpload"]["name"]);
        // Looping all files
        for($i=0;$i<$countfiles;$i++) {
            $target_file = $path . basename($_FILES["fileToUpload"]["name"][$i]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
                if ($check !== false) {
                    $_SESSION['meldung'] = "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $_SESSION['meldung'] = "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $_SESSION['meldung'] = "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            /*
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            */

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $_SESSION['meldung'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['meldung'] = "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                } else {
                    $SESSION_['meldung'] = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    function addb() {
        $sql = "SELECT * FROM artikel";
        $sql1 = "SELECT max(id) as \"max\" from auswahl where user='" . $_SESSION['username'] . "'";
        $id = 0;
        try{
            $wert = $this->info->pdo->query($sql1);
            $id = $wert->fetch();
        } catch (PDOException $e){
            $_SESSION['meldung'] = $e->getMessage();
        }

        $i = $id['max']+1;
        $j = 0;

        foreach ( $this->info->pdo -> query ( $sql ) as $row ) {
            if (isset($_POST['hinzu+'.$j])) {
                if ($this->getVer($row['abez']) >= $_POST['anz+'.$j]) {
                    $preis = $row['preis'];
                    $preisG = $preis * $_POST['anz+'.$j];
                    //Artikel zusammenfassen
                    $isEnthalten = false;
                    //jede Zeile der Userdaten wird durchloopd
                    $sql = "SELECT * FROM auswahl WHERE abez='" . $row['abez'] . "'";
                    try{
                        $aus = $this->info->pdo->query($sql);
                        $art = $aus->fetch();
                        if($art === false){
                            $_SESSION['meldung'] = "Auswahl konnte nicht abgerufen werden";
                        } else {
                            $anzahl = $aus -> rowCount () ;
                            if ($anzahl == 1) $isEnthalten=true;
                        }
                    }catch (PDOException $e){
                        $_SESSION['meldung'] = $e->getMessage();
                    }
                    if ($isEnthalten) {
                        $prtemp = $art['preisG'] + $preisG;
                        $anztemp = $art['aanz'] + $_POST['anz+'.$j];
                        $sql = "UPDATE auswahl SET aanz=" . $anztemp . ", preisG=" . $prtemp;
                        try{
                            $this->info->pdo->query($sql);
                            $_SESSION['meldung'] = 'Der Artikel wurde zum Warenkorb hinzugefügt.';
                        } catch (PDOException $e){
                            $_SESSION['meldung'] = $e->getMessage();
                        }
                        $this->updateVer($row['abez'], $_POST['anz+'.$j], "-");
                    } else {
                        $in = "INSERT into auswahl VALUES($i, '" . $_SESSION['username'] . "', '" . $row['abez'] . "', " . $_POST['anz+'.$j] . ", $preis, $preisG)";
                        if($this->info->pdo->exec($in) === false){
                            $_SESSION['meldung'] = 'Der Artikel konnte nicht hinzugefügt werden.';
                        }else {
                            $_SESSION['meldung'] = 'Der Artikel wurde zum Warenkorb hinzugefügt.';
                        }
                        $i++;
                        $this->updateVer($row['abez'], $_POST['anz+'.$j], "-");
                    }
                } else {
                    $_SESSION['meldung'] = "Es sind nicht mehr genug Artikel verfügbar! Artikel: " . $row['abez'];
                }
            }
            $j++;
        }
    }

    function delb() {
        $sql = "SELECT * from auswahl where id=" . $_GET['nr'];
        try{
            $wert = $this->info->pdo->query($sql);
            $ver = $wert->fetch();
        } catch (PDOException $e){
            $_SESSION['meldung'] = $e->getMessage();
        }

        $nr = $_GET['nr'];
        $sql = "DELETE FROM auswahl WHERE id=$nr AND user='" . $_SESSION['username'] ."'";
        if($this->info->pdo->exec($sql) === false){
            $_SESSION['meldung'] = 'Der Artikel konnte nicht aus dem Warenkorb gelöscht werden.';
        }else {
            $_SESSION['meldung'] = 'Der Artikel wurde aus dem Warenkorb gelöscht.';
        }
        $this->updateVer($ver['abez'], $ver['aanz'], "+");
    }
}

$artikel = new artikel($info);
if (isset($_GET['add'])) {
    $artikel->add();
    $info->reload();
}
if (isset($_GET['addb'])) {
    $artikel->addb();
    $info->reloadu();
}
if (isset($_GET['delb'])) {
    $artikel->delb();
    $info->reloadw();
}
?>