<?php
    $id =  $_GET['id'];
    $dbc = mysqli_connect('localhost', 'root', '', 'projektim');
    $query = "select * from objava where id = '$id'";
    $res = mysqli_query($dbc, $query);

    $row = 0;
    if(!($row = mysqli_fetch_array($res)))
        {
            echo "Article not found! Please contact webops";
        }
    else{
        $imageSrc = $row['image'];
        $article = $row['article'];
        $date = $row['date'];
        $name = $row['name'];
        $id = $row['id'];

        $imeSekcije = "Play Station ".$row['section'];


        include 'header.php';

        echo '        
        <section>
                <h2>'.$imeSekcije.'</h2>
                <div class="content">
                    <h3>'.$name.'</h3>
                    <time>'.$date.'</time>
                </div>
               <img src="'.$imageSrc.'" alt="'.$imageSrc.'">
    
                <div class="content">
                    <p>'.$article.'</p>
                </div>
        </section>';


        include 'footer.php';

    }



