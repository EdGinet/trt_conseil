<?php 

    session_start();
    require_once('php/config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style-inscription.css">
    <title>Accueil - TRT Conseil</title>
</head>
<body>
    <header>
        <nav>
            <a href="index.php"><img src="images/TrtConseil.svg" id="img-title" alt="Trt Conseil Logo" /></a>
            <div id="menu">
                <ul>
                    <li><a class="nav-btn" href="index.php">Accueil</a></li>
                    <li><a class="nav-btn" href="#">Notre Histoire</a></li>
                    <li><a class="nav-btn" href="#">Contacts</a></li>
                    <li><a class="connexion-btn" href="connexion.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <section>
        <div class="container">
            <div id="subscribe-form-container">
                <h1 class="form-title">Inscription</h1>
                <form class="subscribe-form" action="php/newUser.php" method="POST">
                    <label for="statut">Vous êtes</label>
                    <select id="statut" name="statut" placeholder="Définissez votre statut" required onchange="toggleFields()" >
                        <option value="1">Un candidat</option>
                        <option value="2">Une entreprise</option>
                    </select>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required />

                    <label for="prenom" id="prenom-label">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required />

                    <label for="date" id="date-label">Date de naissance</label>
                    <input type="date" id="date_de_naissance" name="date_de_naissance" required />

                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse-candidat" name="adresse" required />

                    <label for="code-postal">Code postal</label>
                    <input type="text" class="form-control" id="cp" name="cp"   minlength="5" maxlength="5" required />

                    <label for="Tel">Téléphone</label>
				    <input type="text" class="form-control" id="tel" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" name="tel" required  />

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required />

                    <label for="password">Mot de passe</label>
                    <input type="password" name="pswd" required />

                    <label for="profession" id="job-candidat-label">Profession</label>
                    <input type="text" id="job-candidat" name="job" required />

                    


                    <button type="submit" value="login" name="login" class="submit-btn">Inscription</button> 
                </form>

                <p class="account">Vous avez déjà un compte ?</p>
                <a href="connexion.php" class="subscribe-link">Connectez-vous</a>
            </div>
        </div>
    </section>

    <script src="js/inscription.js" async></script>
</body>
</html>