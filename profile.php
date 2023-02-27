<?php
if (isset($_POST["deconnect"])){
    echo "saaaaaaaaalaaaaaaaaaam";
    $_SESSION=array();
    session_destroy();
    header("Location:accuiel.php?show_element=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="agence.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>mon profile</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
            <img src="logo.png" alt="logo" class="p-3" width="10%">
            <div class="d-flex me-5">
                <form class="form-inline" action="ajoute.php"  method="POST">
                <button class="btn btn-outline-success my-2 my-sm-0 me-2 ">Ajouter+</button>
                </form>
                <a href="accuiel.php" class="btn btn-outline-dark">Accuiel</a>
                <form class="form-inline"  method="POST" >
                    <button class="btn btn-outline-dark ms-2" type="submit" name="deconnect">Déconcter</button>
                </form>
                
            </div>
        </nav>
        <h1 class="text-center">Mon profil</h1>
    
<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['clientID'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Récupérer l'ID du client depuis la variable de session
$clientID = $_SESSION['clientID'];

// Connexion à la base de données
$servername = "localhost";
$username = "aymane";
$password = "       ";
$dbname = "gestion_des";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Exécuter une requête SQL pour récupérer les annonces du client spécifié
$stmt = $conn->prepare("SELECT * FROM annonce WHERE id_client = $clientID");
$stmt->execute();
$annonces = $stmt->fetchAll();

if(isset($_POST['supprimer'])) {
    // get the ID of the row to delete
    $iddel = $_POST['delete_row'];
    
    // delete the dependent rows in the image table
    $sql = $conn->prepare("DELETE FROM `image` WHERE id_annonce = $iddel");
    $sql->execute();

    // delete the row from the annonce table
    $sql = $conn->prepare("DELETE FROM annonce WHERE id_annonce = $iddel");
    $sql->execute();
}
$sqli_img = "SELECT url_image FROM `image` WHERE id_annonce = '$clientID' AND principal = 'true' ";
$results = $conn->prepare($sqli_img);
$results->execute();
$add = $results->fetchAll();
// echo $clientID;

// Afficher les annonces récupérées
if (count($annonces) > 0){
    foreach ($annonces as $annonce) {
        
        echo " 
            <div class='card mb-4 ' style='width: 20rem;'>
                <div class='card-body'>
                <img class='card-img-top' src='img/".$add[0]["url_image"]."' style='width:100%;'>
                    <h4><b>".$annonce["titre"]."</b></h4>
                    <p>".$annonce["description"]."</p>
                    <p>".$annonce["adresse"]."</p>
                    <p>".$annonce["ville"]."</p>
                    <p>Superficie : ".$annonce["superficie"]."m²</p>
                    <p>En".$annonce["type_annonce"]."</p>
                    <p>Prix : ".$annonce["prix"]."</p>
                    <p>date : ".$annonce["date_publication"]."</p>
                    <div class='d-flex'>
                        <input class='btn btn-outline-dark my-2 my-sm-0 me-2' name='submit' type='submit' value='éditer'>
                        <form method='POST' action='profile.php'>
                            <input type='hidden' name='delete_row' value='".$annonce["id_annonce"]."'>
                            <input class='btn btn-outline-dark my-2 my-sm-0 me-2' name='supprimer' type='submit' value='supprimer'>
                        </form>
                    </div>
                </div>
            </div>
        ";
    }
} 
else {
    echo "<h3 class='text-center'>Vous n'avez pas encore publié d'annonce.</h3>";
}
?>
<footer class="text-center p-3 text-white bg-primary">
    <h6>DIRECTED BY : AJOUMI - FRAIHI - BENOMAR :)</h6>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>





