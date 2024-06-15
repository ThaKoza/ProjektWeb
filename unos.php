
<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keyword" content="">
    <meta name="description" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
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
   <h2 class="naslovnica">Dodajte članak</h2>
    <form action="unos.php" name="Dodavanje_clanka" method="post" enctype="multipart/form-data">

        <span id="porukaNaslov" class="error"></span>
        <label for="naslov">Naslov vijesti</label>
        <input type="textarea" name="naslov" id="naslov"/>

        <span id="porukaSazetak" class="error"></span>
        <label for="sazetak">Kratki sadržaj vijesti (do 100 znakova)</label>
        <textarea name="sazetak" id="sazetak"></textarea>

        <span id="porukaSadrzaj" class="error"></span>
        <label for="sadrzaj">Upišite sadržaj</label>
        <textarea name="sadrzaj" id="sadrzaj"></textarea>
    
        <span id="porukaSlika" class="error"></span>
        <label for="slika">Slika</label>
        <input type="file" name="slika" id="slika"/>

        <span id="porukaOdabir" class="error"></span>
        <label for="odabir">Kategorija vijesti</label>
        <select name="odabir" id="odabir">
            <option value="" disabled selected>Odabir kategorije</option>
            <option value="putovanja">Putovanja</option>
            <option value="izleti">Izleti</option>
        </select>

        <span id="porukaArhiva" class="error"></span>
        <div class="checkbox-container">
        <label for="arhiva">Spremiti u arhivu:</label>
        <input type="checkbox" name="arhiva" id="arhiva"/>
        </div>

        <div class="button-container">
        <button type="reset">Poništi</button>
        <button type="submit" name = "gumb" id="gumb">Pošalji</button>
        <button type="submit" name = "povratak" id="povratak">Vrati se</button>
        </div>
        <?php
        if(isset($_POST['povratak'])){
            header('Location:administracija.php');
        } 
        ?>
     </form>
    </main>
    <footer>Copypravo 2190 Jutarnji hamburg</footer>
    <script type ="text/javascript">
        document.getElementById("gumb").onclick=function(event){
            var slanjeForme = true;

            var poljeTitle = document.getElementById("naslov");
            var title = document.getElementById("naslov").value;
            if(title.length < 5 || title.length > 30)
            {
                slanjeForme = false;
                poljeTitle.style.border="1px dashed red";
                document.getElementById("porukaNaslov").innerHTML="Naslov vijesti mora imati između 5 i 30 znakova!<br>";
            }else{
                poljeTitle.style.border="1px solid green";
                document.getElementById("porukaNaslov").innerHTML="";
            }

            var poljeAbout = document.getElementById("sazetak");
            var about = document.getElementById("sazetak").value;
            if(about.length < 10 || about.length > 100)
            {
                slanjeForme=false;
                poljeAbout.style.border="1px dashed red";
                document.getElementById("porukaSazetak").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
            }else{
                poljeAbout.style.border="1px solid green";
                document.getElementById("porukaSazetak").innerHTML="";
            }

            var poljeContent = document.getElementById("sadrzaj");
            var content = document.getElementById("sadrzaj").value;
            if(content.length == 0)
            {
                slanjeForme = false;
                poljeContent.style.border="1px dashed red";
                document.getElementById("porukaSadrzaj").innerHTML="Sadržaj mora biti unesen!<br>";
            }else{
                poljeContent.style.border="1px solid green";
            }

            var poljeSlika = document.getElementById("slika");
            var pphoto = document.getElementById("slika").value;
            if(pphoto.length == 0)
            {
                slanjeForme = false;
                poljeSlika.style.border="1px dashed red";
                document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
            }else{
                poljeSlika.style.border="1px solid green";
                document.getElementById("porukaSlika").innerHTML="";
            }

            var poljeCategory = document.getElementById("odabir");
            if(document.getElementById("odabir").selectedIndex == 0)
            {
                slanjeForme=false;
                poljeCategory.style.border="1px dashed red";
                document.getElementById("porukaOdabir").innerHTML="Kategorija mora biti odabrana!<br>";                
            }else{
                poljeCategory.style.border="1px solid green";
                document.getElementById("porukaOdabir").innerHTML="";
            }
            if(slanjeForme!=true)
            {
        
                event.preventDefault();
            }
        };
    </script>
</body>
<?php
include 'connect.php';
if(isset($_POST['gumb'])){
$slika = $_FILES['slika']['name'];
$naslov = $_POST['naslov'];
$sazetak = $_POST['sazetak'];
$sadrzaj = $_POST['sadrzaj'];
$odabir = $_POST['odabir'];
$datum = date('d.m.Y.');
if(isset($_POST['arhiva'])){
    $arhiva=1;
}
else{
    $arhiva=0;
}
$target_dir = 'img/'.$slika;
move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);

$query = "INSERT INTO clanci (datum, naslov, sazetak, tekst, slika, kategorija, arhiva)
VALUES ('$datum', '$naslov', '$sazetak', '$sadrzaj', '$slika', '$odabir', '$arhiva')";

$result = mysqli_query($dbc, $query) or die('Error querying database.');
mysqli_close($dbc);
}
?>
</html>