<?php
    session_start();
    require_once ('config.php');

    $salt = bin2hex(random_bytes(32));
    $hashed_password = password_hash('RZXi0AuSW1Wf', PASSWORD_BCRYPT);
    $statement = $pdo->prepare('INSERT INTO administrateurs (Nom, Prenom, Email, Mot_De_Passe, Salt) VALUES (:nom, :prenom, :email, :motdepasse, :salt)');
    $statement->execute(array(
        'nom' => 'Hirthe',
        'prenom' => 'Robert',
        'email' => 'rhirthe1@ameblo.jp',
        'motdepasse' => $hashed_password,
        'salt' => $salt
    ));

    echo "L'administrateur a été créé avec succès."
?>