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
<body class="pozadina">
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
    <div class="pozadina">
    <?php
    include 'connect.php';
    $id = $_GET['id'];

    $query = "SELECT slika, naslov, tekst, datum, sazetak FROM clanci WHERE id = $id";
    $result = mysqli_query($dbc, $query) or die('Error querying database');
    
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_array($result)) {
            $imagePath = 'img/' . $row["slika"];
            echo '<div class="clanci">';
            echo '<div class="pozadinaClanka">';
            echo '<h1>' . $row['naslov'] . ' - '.$row['sazetak'].'</h1>';
            echo '</div>';
            echo '<h3>'.$row['datum'].'<h3>';
            echo '<p><img src="' . $imagePath . '" alt="Article Image"><p>';
            echo '<p>' . $row['tekst'] . '</p>';
            echo '</div>';
        }
    } else {
        echo "No articles found";
    }
    $dbc->close();
    ?>
    </div>
    </main>
    <footer>Copypravo 2190 Jutarnji hamburg</footer>
</body>
</html>