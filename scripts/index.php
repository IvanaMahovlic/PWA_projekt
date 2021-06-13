<?php
include 'header.php';

$sect = 1;
$dbc = mysqli_connect('localhost','root','','projektim');


for(; $sect < 5; $sect++){
    $query = "select * from objava where archive = 0 and section = '$sect' limit 3";
    $res = mysqli_query($dbc,$query);
    $imeSekcije = "Play Station ".$sect;

    echo "
        <section>
        <h2>$imeSekcije</h2>";

    while ($row = mysqli_fetch_array($res)){

        $imageSrc = $row['image'];
        $summary = $row['summary'];
        $date = $row['date'];
        $name = $row['name'];
        $id = $row['id'];


        echo '
            <article>
                <img src="'.$imageSrc.'" alt="'.$imageSrc.'">
                <a href="article.php?id='.$id.'"><h3>'.$name.'</h3></a>
                <p>'.$summary.'</p>
                <time>'.$date.'</time>
            </article>
        ';
    }

    echo "</section>";

}
 include 'footer.php';

