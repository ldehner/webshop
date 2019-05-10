<?php
include_once('open.php');
class user {
    private $info;

    function __construct($info) {
        $this->info = $info;
    }

    function login() {
        //der eingegebene Nutzername wird ausgelesen
        $name = $_POST['username'];
        //das eingegebene Passwort wird ausgelesen
        $pw = $_POST['pw'];
        //Variable um festzustellen, ob der User im File vorhanden ist
        $isUser = false;
        //jede Zeile der Userdaten wird durchloopd

        $sql = "SELECT * FROM user WHERE uname='$name' AND password='$pw'";
        try{
            $user = $this->info->pdo->query($sql);
            $admin = $user->fetch();
            if($user === false){
                echo "Benutzer konnten nicht abgerufen werden";
            } else {
                $anzahl_user = $user -> rowCount () ;
                if ($anzahl_user == 1) $isUser=true;
                if ($admin['admin'] == 1) {
                    $_SESSION['admin'] = True;
                } else {
                    $_SESSION['admin'] = False;
                }
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        //wenn der User in der DB vorkommt, wird sein Status auf true (angemeldet) gesetzt
        if($isUser == true){
            $_SESSION['username'] = $name;
            $_SESSION['userStatus'] = true;
        }else{
            //andernfalls wird eine Fehlermeldung ausgegeben
            $_SESSION['meldung'] = 'Inkorrekte Anmeldedaten!';
        }
    }

    function logout() {
        if ($_SESSION['userStatus'] == True) {
            $_SESSION['userStatus'] = False;
        } else {
            $__SESSION['userStatus'] = True;
        }
    }

    function register() {
        //Die eingegebenen Userdaten werden gespeichert
        $username = $_POST['username'];
        $pw = $_POST['pw'];
        $vName = $_POST['first_name'];
        $nName = $_POST['last_name'];
        //$sex = $_POST['sex'];
        //$geb = $_POST['gebdat'];
        $email = $_POST['email'];
        //$newsLetter = $_POST['newsLetter'];

        //prüft, ob ein Benutzername/Email valide ist
        $isValid = true;
        //Prüft für jeden bereits existierenden User, ob Username oder Email bereits vorkommen
        $sql = "SELECT * FROM user WHERE uname='$username' OR email='$email'";
        try{
            $user = $this->info->pdo->query($sql);
            if($user === false){
                echo "Benutzer konnten nicht abgerufen werden";
            } else {
                $anzahl_user = $user -> rowCount () ;
                if ($anzahl_user == 0) $isValid=true;
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        //ist der User nicht valide, wird eine Fehlermeldung ausgegeben
        if($isValid == false){
            $_SESSION['meldung'] = 'Der Username oder die Email-Adresse existiert bereits!';
        }else{
            //andernfalls wird der User zur Datenbank hinzugefügt
            $sql = "INSERT into user VALUES('$username', '$vName', '$nName', '$email', '$pw', FALSE)";
            if($this->info->pdo->exec($sql) === false){
                $_SESSION['meldung'] = 'Error inserting the user.';
            }else {
                $_SESSION['meldung'] = 'The new user is created.';
                $_SESSION['username'] = $username;
                $_SESSION['userStatus'] = true;
            }
        }
    }
}

$ver = new user($info);
if (isset($_GET['logout'])) {
    $ver->logout();
} else {
    if (isset($_GET['register'])) {
        $ver->register();
    } else {
        $ver->login();
    }
}

$info->reload();
?>
