<?php
	session_start();

	// Check the token
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>The Nebulae - Portail</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/portal.css">


	</head>
	<body>

    <div class="container">

      <form class="form-signin" action="" method="POST">
      	<img src="/img/Nebulae.png" alt="Logo Nebulae">
        <h2 class="form-signin-heading text-center">Inscris toi!</h2>
        <?php 
        	if(isset($error)):
        ?>
        <div class="alert alert-danger" role="alert">
        	<?= $error; ?>
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php
        	endif;
        ?>
        <label for="userName" class="sr-only">Nom d'utilisateur*</label>
	    <div class="input-group marginbottom10">
	      <input type="text" id="userName" name="userName" class="form-control" placeholder="Nom d'utilisateur*" required>
	      <div class="input-group-addon">@nebulae.co</div>
	    </div>

        <label for="sn" class="sr-only">Nom</label>
        <input type="text" id="sn" name="sn" class="form-control" placeholder="Nom">
        
        <label for="cn" class="sr-only">Prénom</label>
        <input type="text" id="cn" name="cn" class="form-control" placeholder="Prénom">

        <label for="displayName" class="sr-only">Nom à afficher*</label>
        <input type="text" id="displayName" name="displayName" class="form-control" placeholder="Nom à afficher*" required>
        
        <label for="password" class="sr-only">Mot de passe*</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe*" required>
        
        <label for="confirmPassword" class="sr-only">Confirmation*</label>
        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirmation du mot de passe*" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Inscription!</button>
      </form>

    </div> <!-- /container -->

		
		<!-- jQuery --> 
		<script src="/js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

