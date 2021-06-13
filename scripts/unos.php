<?php
if(isset($_POST["submit"])){
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
    $query = "insert into objava(section,name,date,summary,article,image, archive) values (?,?,?,?,?,?,?)";
    $stmt=mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt,'ssssssi',$section,$name,$date,$summary,$article,$putdoslike, $pohrana);
        mysqli_stmt_execute($stmt);

    }
    else{
        echo "Doslo je do greske prilikom spremanja u bazu";
    }

    if(is_uploaded_file($tmpName)){
        if(move_uploaded_file($tmpName, $putdoslike)){
            include 'header.php';
            echo '
                <section>
                <input type="hidden">
                        <h2>'.$sectionName.'</h2>
                        <div class="content">
                            <h3>'.$name.'</h3>
                            <time>'.$date.'</time>
                        </div>
                        <img src='.$putdoslike.' alt="">
            
                        <div class="content">
                            <p>'.$article.'</p>
                        </div>
                </section>';

            include 'footer.php';
        }
        else{
            echo "Error while moving the picture";
        }
    }
    else{
        echo "Error while uploading the picture";
    }
}
else{
    include 'header.php';
    echo '
            <form method="post" action="unos.php" enctype="multipart/form-data" name="unosclanka">
                <label for="section">Sekcija</label>
                <select name="section" id="section" size="1">
                    <option value="1">Play Station 1</option>
                    <option value="2">Play Station 2</option>
                    <option value="3">Play Station 3</option>
                    <option value="4">Play Station 4</option>
                </select><br>

                <label for="name">Ime clanka</label>
                <input type="text" name="name" id="name"><br>

                <label for="date">Datum objave clanka</label>
                <input type="date" name="date" id="date"><br>

                <label for="summary">Ukratko</label>
                <input type="text" name="summary" id="summary" size="100"><br>

                <label for="article">Clanak</label><br>
                <textarea name="article" id="article" rows="10" cols="95"></textarea><br>

                <label for="articleImage">Slika</label>
                <input type="file" name="articleImage" id="articleImage"><br>

                <label for="pohrana">Spremiti u arhivu?</label>
                <input type="checkbox" name="pohrana" id="pohrana" ><br>

                <input name="submit" type="submit" value="Postavi">
            </form>';
 include 'footer.php';
}