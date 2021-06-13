<?php
include 'header.php';

session_start();

if(!isset($_SESSION['name'])){
    if (!isset($_POST['submit'])) {
        echo '<h2>Registrirajte se</h2>

        <form action="register.php" method="post">
        
          <label for="ime">Korisnicko ime</label>
          <br />
          <input name="ime" type="text" id="ime" required/>
          <br />
          
          <label for="lozinka">Lozinka</label>
          <br />
          <input name="lozinka" type="text" id="lozinka" required/>
          <br />
        
          <input name="submit" type="submit" value="Registracija" />
        </form>';
    } else {
        $ime = $_POST['ime'];
        $pwd = $_POST['lozinka'];

        $uniqueNameQuery = "SELECT * from korisnik where name = ?";
        $query = "INSERT INTO korisnik (name, password) values (?, ?)";

        $dbc = mysqli_connect('localhost', 'root', '', 'projektim');

        $stmt = mysqli_stmt_init($dbc);

        $postoji = false;

        $hash = password_hash($pwd, CRYPT_BLOWFISH);

        //gleda je li unique ime
        if (mysqli_stmt_prepare($stmt, $uniqueNameQuery)) {


            mysqli_stmt_bind_param($stmt, 's',$ime);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $rows = mysqli_stmt_num_rows($stmt);

            $postoji = $rows > 0;


        } else {
            echo "greska";
        }

        //ako je unique tj ako ne postoji sprema formu u bazu
        if (!$postoji) {


            if (mysqli_stmt_prepare($stmt, $query)) {


                mysqli_stmt_bind_param($stmt, 'ss',$ime,$hash);
                mysqli_stmt_execute($stmt);

                echo "Uspjesna registracija!";

            } else {
                echo "greska";
            }
        } else {
            echo "Ime zauzeto";
        }

    }
}
else{
    if (isset($_POST['submit'])) {
        session_destroy();
        echo  "izbrisano";
        header('Location: index.php');
        die();
    } else {
        echo
        '<form action="register.php" method="post">
            <label>Vec ste prijavljeni... Odjava?</label>
            <input name="submit" type="submit" value="Odjava" >
        </form>';
    }
}

include "footer.php";