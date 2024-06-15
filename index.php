<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keyword" content="">
    <meta name="description" content="">
    <title>Stranica</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>MOPO</h1>
            <p>HAMBURG Jutarnji</p>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="kategorija.php?kategorija=putovanja">PUTOVANJA</a></li>
                <li><a href="kategorija.php?kategorija=izleti">IZLETI</a></li>
                <li><a href="administracija.php">ADMINISTRACIJA</a></li>
                <li><a href="registracija.php">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <div class="main-content">
        <h2>Putovanja<br><hr></h2>
        <?php
        
        include 'connect.php';

        $query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija='putovanja' ORDER BY id DESC LIMIT 3";
        $result = mysqli_query($dbc, $query) or die('Error querying database');
        echo '<div class="articles">';
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_array($result)) {
                $imagePath = 'img/' . $row["slika"];
                echo '<div class="article-block">';
                echo '<img src="' . $imagePath . '" alt="Article Image">';
                echo '<h3><a href="clanak.php?id='.$row["id"].'">' . $row["naslov"] . '</a></h3>';
                echo '</div>';
            }
        } else {
            echo "Nema članaka";
        }
        echo '</div>';
        ?>
        <h2>Izleti<br><hr></h2>
        <?php
        $query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija='izleti' ORDER BY id DESC LIMIT 3";
        $result = mysqli_query($dbc, $query) or die('Error querying database');
        echo '<div class="articles">';
        if (mysqli_num_rows($result) > 0) {
 
            while($row = mysqli_fetch_array($result)) {
                $imagePath = 'img/' . $row["slika"];
                echo '<div class="article-block">';
                echo '<img src="' . $imagePath . '" alt="Article Image">';
                echo '<h3><a href="clanak.php?id='.$row["id"].'">' . $row["naslov"] . '</a></h3>';
                echo '</div>';
            }
        } else {
            echo "Nema članaka";
        }
        echo '</div>';
        $dbc->close();
        ?>
    </div>
    </main>
    <footer>Copypravo 2190 Jutarnji hamburg</footer>
</body>
</html>