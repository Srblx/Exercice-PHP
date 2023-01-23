<div>Nom : <?php echo  $_POST['lastname']; ?></div>
<div>Nom : <?php echo  $_POST['firstname']; ?></div>
<?php
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];

if (isset($_POST['submit'])) {

    $maxSize = 2000000;
    $validExt = array('.jpg', '.jpeg', '.png');
    // Si rien n'est envoyé une erreur remonte
    if ($_FILES['file']['error'] > 0) {
        echo "Error occurred during the transfer.";
        die;
    }

    // Deffinition de la taille maximal du fichier partagé
    $fileSize = $_FILES['file']['size'];
    echo $fileSize;

    if ($fileSize > $maxSize) {
        echo "The file is too big.";
        die;
    }
    // Definition du type de fichier qui est telechargable
    // strtolower --> Renvoie une chaine en minuscules 
    // substr --> Retourne un segment de chaine
    // strrchr --> Trouve la derniere occurence d'un caractère dans une chaine 
    $fileName = $_FILES['file']['name'];
    $fileExt = "." . strtolower(substr(strrchr($fileName, "."), 1));

    if (!in_array($fileExt, $validExt)) {
        echo "This file is not an picture.";
        die;
    }


    //Transfert du fichier dans le dossier voulu (Upload)
    // md5 --> Calcule le md5 d'une chaine de caracteres en utilisant un algorithme
    // uniqid --> Genere un identifiant unique
    // Genere un entier aleatoire (doit rester vide)
    $tmpName = $_FILES['file']['tmp_name'];
    $idUniqueName = md5(uniqid(rand(), true));
    $fileName = "Upload/" . $idUniqueName . $fileExt;
    $result = move_uploaded_file($tmpName, $fileName);

    if ($result) {
        echo "Upload succes !";
    }
}

// Echantillon de code qui bloque l'upload de tout les fichiers 
/* // Verifie l'extension du fichier 
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    if (in_array_key_exists($ext, $validExt)) {
        die("Erreur : Veuillez sélectionner un format de fichier valide.");
    }
*/
$timesTamp = date('l jS \of F Y h:i:s A');

date_default_timezone_set('GMT');
echo $timesTamp;

$file = 'log.txt';
// Ouvre un fichier pour lire un contenu existant
$current = file_get_contents($file);
// Ajoute une ligne
$current .= $fileName . $timesTamp . $lastname . $firstname .  "\n";
// Écrit le résultat dans le fichier
file_put_contents($file, $current);
