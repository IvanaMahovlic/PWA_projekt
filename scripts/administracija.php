<?php
session_start();

if(!isset($_SESSION['name'])){
    header('Location: login.php?next=administracija.php');
    die();
}

$dbc = mysqli_connect('localhost','root','','projektim');

if(isset($_POST['delete'])){
    $query = "delete from objava where id = ". $_GET['id'];
    if($res = mysqli_query($dbc,$query)){
        header('Location: administracija.php');
        die();
    }
    else{
        echo "Greska: <br>".$dbc->error;
    }
}
else if(isset($_POST['update'])){
    $section = $_POST["section"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $summary = $_POST["summary"];
    $article = $_POST["article"];

    $pohrana = isset($_POST["pohrana"]);

    $putdoslike = "../images/";
    $sectionName = "Play Station ".$section;


    $imagename = $_FILES["articleImage"]["name"];
    $tmpName = $_FILES["articleImage"]["tmp_name"];

    $putdoslike .= $imagename;
    $arhiva = $pohrana ? 1 : 0;
    $dbc = mysqli_connect('localhost','root','','projektim');
    $query = "UPDATE objava set section = ?,name = ?,date = ?,summary = ?,article = ?,image = ?, archive = ? where id=".$_GET['id'];
    $stmt=mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt,'ssssssi',$section,$name,$date,$summary,$article,$putdoslike, $pohrana);
        mysqli_stmt_execute($stmt);

        header('Location: administracija.php');
        die();
    }
    else{
        echo "Doslo je do greske prilikom spremanja u bazu<br>".$dbc->error;
    }
}
else{
    include 'header.php';

    $dbc = mysqli_connect('localhost','root','','projektim');
    $query = "select * from objava";
    $res = mysqli_query($dbc,$query);

    while ($row = mysqli_fetch_array($res)){
        $id = $row['id'];
        $sekcija = $row['section'];

        $imageSrc = $row['image'];
        $summary = $row['summary'];
        $article = $row['article'];
        $date = $row['date'];
        $name = $row['name'];

        $archive = $row['archive'] == 1;

        $opcije = [1, 2, 3, 4];



        echo '
            <form method="post" action="administracija.php?id='.$id.'" enctype="multipart/form-data">
                <label for="section">Sekcija</label>
                <select name="section" id="section" size="1">';

        foreach ($opcije as $item) {
            echo '<option value="'.$item.'"';

            if($item == $sekcija){
                echo "selected";
            }
            echo ' >Play Station '.$item.'</option>';
        }

        echo '
                </select><br>

                <label for="name">Ime clanka</label>
                <input type="text" name="name" id="name" value="'.$name.'"><br>

                <label for="date">Datum objave clanka</label>
                <input type="date" name="date" id="date" value="'.$date.'"><br>

                <label for="summary">Ukratko</label> 
                <input type="text" name="summary" id="summary" size="100" value="'.$summary.'"><br>

                <label for="article">Clanak</label><br>
                <textarea name="article" id="article"  rows="10" cols="95">'.$article.'</textarea><br>

                <label for="articleImage">Slika</label>
                <input type="file" name="articleImage" id="articleImage"><br>
                <img src="'.$imageSrc.'" style="height: 100px" alt="'.$imageSrc.'"> <br>

                <label for="pohrana">Spremiti u arhivu?</label>
                <input type="checkbox" name="pohrana" id="pohrana"
                
                ';
           if($archive){
               echo "checked";
           }
            echo'><br>

                <input name="delete" type="submit" value="Izbrisi">
                <input name="update" type="submit" value="Promijeni">
            </form>
            
            <hr>';


    }
    include 'footer.php';
}




