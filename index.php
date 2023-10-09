<?php
require_once 'connec.php';

$pdo = new \PDO(DSN, USER, PASS);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // récupération des donneés du formulaire
    $firstname = htmlentities(trim($_POST['firstname'])); 
    $lastname = htmlentities(trim($_POST['lastname']));

    if (isset($_POST["firstname"]) && !empty($_POST['firstname']) && strlen($_POST['firstname']) < 45 &&
        isset($_POST["lastname"]) && !empty($_POST['lastname']) && strlen($POST['lastname']) < 45)
    {
        // traitement anti injection SQL et insertion dans DB
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->execute();
        header('Location: index.php');
        die();
    }
    else {
        $error = 'Veuillez entrer un prénom ou un nom de famille correct.';
    }
}


// sélectionner données
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php foreach ($friends as $friend) :?>
            <li><?= $friend['firstname'] .' '. $friend['lastname'] ?></li>
            <?php endforeach ?>
    </ul>

    <form action="" method="post">
        <div>
            <label for="firstname">Firstname : </label>
            <input type="text" id="firstname" name="firstname" required>
        </div>
        <div>
            <label for="lastname">Lastname : </label>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        <div>
            <button type="submit">Send</button>
        </div>
    </form>

    <?php if (!empty($error)) {
        echo $error;
    } ?>
</body>
</html>