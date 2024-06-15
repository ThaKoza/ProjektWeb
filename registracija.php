
<?php
$registriranKorisnik='';
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Registracija</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keyword" content="">
        <meta name="description" content="">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
       </head>
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
    <body>
    <main>
    <div class="naslovnica"><h2>Registracija</h2></div>
<form method="post" action="registracija.php" name="prijava">

<label for="username">Korisničko ime</label>
<input type="text" name="username" id="username"/>
<span id="porukaUsename" class="error"></span>

<label for="ime">Unesite svoje ime</label>
<input type="text" name="ime" id="ime"/>
<span id="porukaIme" class="error"></span>

<label for="prezime">Unesite svoje prezime</label>
<input type="text" name="prezime" id="prezime"/>
<span id="porukaPrezime" class="error"></span>

<label for="password">Lozinka</label>
<input type="password" name="password" id="password"/>
<span id="porukaPassword" class="error"></span>

<label for="password1">Potvrda lozinke</label>
<input type="password" name="password1" id="password1"/>
<span id="porukaPassword1" class="error"></span>
<div class="button-container">
<button type="submit" id="gumb">Prijava</button>
</div>

</form> 
</main>
<footer>Copypravo 2190 Jutarnji hamburg</footer>
</body>
<script type = "text/javascript">
document.getElementById("gumb").onclick = function(event) {
var slanje_forme = true;


var poljeUsername = document.getElementById("username");
var username = document.getElementById("username").value;
if (username.length < 3 || username.length > 32) {
    slanje_forme = false;
    poljeUsername.style.border = "1px solid red";
    document.getElementById("porukaUsename").innerHTML = "Korisničko ime ne smije biti manje od 3 ili veće od 32 znaka<br>";
}

var poljePassword = document.getElementById("password");
var password = document.getElementById("password").value;
var poljePassword1 = document.getElementById("password1");
var password1 = document.getElementById("password1").value;

if (password != password1 || password == null || password.length==0) {
    slanje_forme = false;
    poljePassword.style.border = "1px solid red";
    poljePassword1.style.border = "1px solid red";
    document.getElementById("porukaPassword1").innerHTML = "Lozinke moraju biti iste, te lozinka ne smije biti prazna<br>";
}
var ime = document.getElementById("ime").value;
var poljeIme = document.getElementById("ime");
if (ime.length <3 || ime.length>32)
{
    slanje_forme=false;
    poljeIme.style.border = "1px solid red";
    document.getElementById("porukaIme").innerHTML = "Ime ne smije biti manje od 3 ili veće od 32 znaka<br>";
}
var prezime = document.getElementById("prezime").value;
var poljePrezime = document.getElementById("prezime");
if (prezime.length <3 || prezime.length>32)
{
    slanje_forme=false;
    poljePrezime.style.border = "1px solid red";
    document.getElementById("porukaPrezime").innerHTML = "Prezime ne smije biti manje od 3 ili veće od 32 znaka<br>";
}


if (slanje_forme != true) {
    event.preventDefault();
}
}
</script>
<?php
include "connect.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $ime = $_POST['ime'];
    $password = $_POST['password'];
    $zasticenaLozinka = password_hash($password, CRYPT_BLOWFISH);
    $razina=0;
    $registriranKorisnik='';
    $prezime = $_POST['prezime'];

        $query = "SELECT * FROM korisnik WHERE korisnickoime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if(mysqli_stmt_prepare($stmt,$query)){
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }
        if(mysqli_stmt_num_rows($stmt) >0){
            echo'<script type = "text/javascript">var a = "Korisnik već postoji!";alert(a);</script>';
        }else{
            $query = "INSERT INTO korisnik (korisnickoime, ime, prezime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            if(mysqli_stmt_prepare($stmt,$query)){
                mysqli_stmt_bind_param($stmt,'ssssd',$username,$ime,$prezime,$zasticenaLozinka,$razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik=true;
            }
        }
        
    mysqli_close($dbc);
    }
?>
<?php
if($registriranKorisnik == true){
           echo'<script type = "text/javascript">var a = "Korisnik je uspješno registriran!";alert(a);</script>';
}
?>
</html>