<?php
    session_start();
    $servername = "localhost";
    $username = "aymane";
    $password = "       ";
    $databaseName = "gestion_des";
        $conn = new mysqli($servername, $username, $password, $databaseName);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

    $id = $_POST['id'];
    $sth = $conn->prepare("SELECT * FROM `annonce` WHERE id_annonce = ? ");
    $sth->bind_param('i', $id);
    $sth->execute();
    $response = $sth->get_result()->fetch_all(MYSQLI_ASSOC);

    $sql_img ="SELECT url_image
            FROM `image`
            where id_annonce = $id ";
    
    $result=mysqli_query($conn,$sql_img);
    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        

    </head>
            <nav class="navbar navbar-light bg-light">
                <img src="logo.png" alt="logo" class="p-3" width="10%">
            </nav>
    <body>
    <?php 
        echo"<div class='ms-5 mb-4 p-5 card-body' style='width: 50%;'>";
        echo"<div class='card-body'>";
        while ($query=mysqli_fetch_assoc($result)) {
            ?>
                <img src="img/<?php echo $query["url_image"]; ?>" style='width:50%;'>
            <?php
        }
        foreach($response as $ligne){
            echo "
                
                    <h4><b>titre :<span class='text-secondary'>".$ligne["titre"]."</span></b></h4>
                    <h4>description :<span class='text-secondary'>".$ligne["description"]."</span></h4>
                    <h4>adresse :<span class='text-secondary'>".$ligne["adresse"]."</span></h4>
                    <h4>Superficie :<span class='text-secondary'>".$ligne["superficie"]."m²</span> </h4>
                    <h4>type :<span class='text-secondary'>".$ligne["type_annonce"]."</span></h4>
                    <h4>Prix :<span class='text-secondary'>".$ligne["prix"]."</span></h4>
                    <h4>date :<span class='text-secondary'>".$ligne["date_publication"]."</span></h4>
                    <div class='d-flex'>
                    <form action='accuiel.php' method='post'><button class='btn btn-outline-dark'>Retour</button>
                    </form>
                    <input class='col-4 btn btn-outline-dark ms-2' data-bs-toggle='modal' data-bs-target='#staticBackdrop'  type='submit' value='CONTACTER LE VENDEUR'>
                    </div>
                    
            </div> ";
        }
        echo "</div>";
        echo "</div>";


                            
                        
                
            ?>
        <?php 
    
            $sql_user ="SELECT nom , prenom , Numero_tele 
            FROM client
            INNER JOIN annonce ON client.id_client = annonce.id_client
            where id_annonce = $id ";
            $join= $conn->query($sql_user);
            $resultat = $join->fetch_assoc();
                echo '
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <!-- <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5> -->
                            <img src="img/Capture.PNG" alt="attention" style="width:100%">
                        </div>
                        <div>
                        <p>'.$resultat["prenom"].'</p>
                        <p>'.$resultat["Numero_tele"].'</p>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            
                        </div>
                        </div>
                    </div>
                    </div>';
        
        ?>
        <footer class="text-center p-3 text-white bg-primary">
            <h6>DIRECTED BY : AJOUMI - FRAIHI - BENOMAR :)</h6>
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
    </html>