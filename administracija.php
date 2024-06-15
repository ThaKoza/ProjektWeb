<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/'); 
?>
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
    <script src="js\izmjenavalidacija.js"></script>
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
    <?php
if((isset($_SESSION['$username']) && $_SESSION['$level'] == 1)){
    $query = "SELECT * FROM clanci";
$result = mysqli_query($dbc, $query);
echo '<br><form method="post" action="administracija.php" name="prijava">
        <div class="button-container">
        <button type="submit" name="logout">Logout</button>
        <button type="submit" name="unos">Unos</button>
        </div>
    </form>';
    if(isset($_POST['logout'])){
        unset($_SESSION['$username']);
        unset($_SESSION['$level']);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
    if(isset($_POST['unos'])){
        header('Location:unos.php');
    }
while($row = mysqli_fetch_array($result)){
    
    echo '<form enctype="multipart/form-data" action="administracija.php" method="POST" name="izmjena">

    <label for = "title">Naslov vijesti:</label>
    <input type = "text" name = "title" value="'.$row['naslov'].'">

    <label for="about">Kratki sadržaj vijesti (do 50 zankova:)</label>
    <textarea name="about" id="" cols = "30" rows = "10">'.$row['sazetak'].'</textarea>

    <label for = "content">Sadržaj vijesti:</label>
    <textarea name = "content" id = "" cols = "30" rows = "10">'.$row['tekst'].'</textarea>

    <label for = "pphoto">Slika:</label>
    <input type = "file" id = "pphoto" value="'.$row['slika'].'" name = "pphoto"/>
    <img src = "'. UPLPATH.$row['slika'] .'" width=100px>

    <label for = "category">Kategorija vijesti:</label>
    <select name = "category" id="">
        <option value="putovanja"'.($row['kategorija'] == 'putovanja' ? 'selected':'').'>Putovanja</option>
        <option value="izleti"'.($row['kategorija'] == 'izleti' ? 'selected':'').'>Izleti</option>
    </select>
    <label>Spremiti u arhivu:</label>';
    if($row['arhiva'] == 0){
        echo'<input type = "checkbox" name = "archive" id = "arhiva"/>Arhiviraj?';
    }
    else{
        echo'<input type = "checkbox" name = "archive" id = "arhiva" checked/>Arhiviraj?';
    }
    echo'<input type = "hidden" name = "id" value = "'.$row['id'].'">
    <div class="button-container">
    <button type = "reset" value="poništi">Poništi</button>
    <button type = "submit" id = "update" name = "update" value = "prihvati">Izmjeni</button>
    <button type = "submit" name = "delete" value = "izbrisi">Izbriši</button>
    </div>
    </form>';
}
if(isset($_POST['delete'])){ 
    $id = $_POST['id']; 
    $query = "DELETE FROM clanci WHERE id = ?"; 
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: ' . $_SERVER['PHP_SELF']);
}

if(isset($_POST['update'])){ 
    $picture = $_FILES['pphoto']['name']; 
    $title = $_POST['title']; 
    $about = $_POST['about']; 
    $content = $_POST['content']; 
    $category = $_POST['category']; 
    $archive = isset($_POST['archive']) ? 1 : 0; 
    $target_dir = 'img/'.$picture; 
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);  
    $id = $_POST['id']; 
    $query = "UPDATE clanci SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?"; 
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'sssssii', $title, $about, $content, $picture, $category, $archive, $id);
    mysqli_stmt_execute($stmt);
    header('Location: ' . $_SERVER['PHP_SELF']);
} 
}else if (isset($_SESSION['$username']) && $_SESSION['$level']==0){
    echo '<p class="centriraj">Bok '.$_SESSION['$username'].'! Uspješno ste prijavljeni, ali niste administrator.</p>';
    echo '<br><form method="post" action="administracija.php" name="prijava">
        <div class="button-container">
        <button type="submit" name="logout">Logout</button>
        </div>
    </form>';
    if(isset($_POST['logout'])){
        unset($_SESSION['$username']);
        unset($_SESSION['$level']);
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}else if (isset($_SESSION['$username']) == false){
    ///////////////////////////////////////////////////////
    echo' <main>
    <div class="naslovnica"><h2>Login</h2></div>
    <form method="post" action="administracija.php" name="prijava">
        <label for="username">Korisničko ime</label>
        <input name="username" type="text" id="username"/>
       
        <label for="lozinka">Lozinka</label>
        <input name="lozinka" type="password" id="username"/>
       
        <div class="button-container">
        <button type="submit">Logiraj se</button> 
        </div>
    </form>
    </main>';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
       
        $prijavaImeKorisnika = $_POST['username'];
        $prijavaLozinkaKorisnika = $_POST['lozinka'];
        $sql = "SELECT korisnickoime, lozinka, razina FROM korisnik WHERE korisnickoime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,'s',$prijavaImeKorisnika);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }
        mysqli_stmt_bind_result($stmt,$imeKorisnika,$lozinkaKorisnika,$levelKorisnika);
        mysqli_stmt_fetch($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1 && password_verify($prijavaLozinkaKorisnika,$lozinkaKorisnika)){
            $uspjesnaPrijava = true;
            if($levelKorisnika ==1){
                $admin = true;
            }else{
                $admin = false;
            }
            $_SESSION['$username'] = $imeKorisnika;
            $_SESSION['$level'] = $levelKorisnika;
            header('Location: ' . $_SERVER['PHP_SELF']);
        }else{
            $uspjesnaPrijava = false;
            echo '<script type="text/javascript">alert("Pogrešna lozinka ili korisnik ne postoji");</script>';
        }
    }
}
?>
     </main>
     <footer>Copypravo 2190 Jutarnji hamburg</footer>
</body>
</html>
