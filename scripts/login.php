<?php
if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $pwd = $_POST['pwd'];


    $dbc = mysqli_connect('localhost','root','','projektim');
    if($dbc){

        $hash = password_hash($pwd, CRYPT_BLOWFISH);
        $uniqueNameQuery = "SELECT password from korisnik where name = ?";

        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $uniqueNameQuery)) {

            mysqli_stmt_bind_param($stmt,'s',$name);
            mysqli_stmt_bind_result($stmt,$pw);
            mysqli_stmt_execute($stmt);


            if (mysqli_stmt_fetch($stmt)){
                if(password_verify($pwd,$pw)){
                    session_start();
                    $_SESSION['name'] = $name;
                    if(isset($_GET['next'])){
                        header('Location: '.$_GET['next']);
                    }
                    else{
                        header('Location: index.php');
                    }
                    die();
                }
                else{
                    echo "Kriva lozinka";
                }
            }
            else{
                echo "Korisnicko ime ne postoji!";
            }



        } else {
            echo $dbc->error;
        }

    }
    else{
        echo $dbc->error;
    }

}
else{
    include 'header.php';
    echo '<h2>Prijavite se</h2>';
    if(isset($_GET['next'])){
        echo '<form action="login.php?next='.$_GET['next'].'" method="post">';
    }
    else{
        echo '<form action="login.php" method="post">';
    }

    

     echo '<label for="name">Korisnicko ime</label>
      <br />
      <input name="name" type="text" id="name" required/>
      <br />
      <label for="pwd">Lozinka</label>
      <br />
      <input name="pwd" type="password" id="pwd" required/>
      <br />
    
      <input name="submit" type="submit" value="Prijava" />
    </form>
    
    </body>
    </html>';


    include 'footer.php';
}
