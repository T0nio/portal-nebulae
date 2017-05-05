<?php
    session_start();

    /*if(empty($_SESSION["user"])){
        header("Location: login.php");
    }*/

    if(!empty($_POST)){
        if(isset($_POST["submitProfile"])){

        }elseif (isset($_POST["submitPassword"])) {
          # code...
        }else{
          $error = "Veuillez utiliser le formulaire de la bonne manière";
        }
    }

    //gidnumber
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Profile - The Nebulae - Portail</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/portal.css">


	</head>
	<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand logo-header" href="/"><img src="/img/Nebulae.png" alt="Logo"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/">Portail</a></li>
            <li class="active"><a href="/profile.php">Modifier mon profile</a></li>
            <?php 
              if($_SESSION['user']["gidnumber"][0] == 501):
            ?>
            <li><a href="/admin.php">Admin</a></li>
            <?php 
              endif;
            ?>
            <li><a href="/logout.php">Déconnexion</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container main-cont">
      <form class="form-horizontal" action="" method="POST">
        <h2 class="text-center">Mon profile</h2>
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
        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="mail" placeholder="Email" value="<?= $_SESSION["user"][0]["mail"][0]; ?>" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="uid" class="col-sm-2 control-label">Nom d'utilisateur</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="uid" name="uid" placeholder="Login" value="<?= $_SESSION["user"][0]["uid"][0]; ?>" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="displayname" class="col-sm-2 control-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="displayname" name="displayname" placeholder="Nome" value="<?= $_SESSION["user"][0]["displayname"][0]; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="submitProfile" class="btn btn-default">Modifier mon profile</button>
          </div>
        </div>
        <hr>
        <h3>Changer mon mot de passe</h3>
        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Mot de passe</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
          </div>
        </div>
        <div class="form-group">
          <label for="confirmPassword" class="col-sm-2 control-label">Confirmer le mot de passe</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmer le mot de passe">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="submitPassword" class="btn btn-default">Modifier mon mot de passe</button>
          </div>
        </div>
      </form>
    </div> <!-- /container -->

		
		<!-- jQuery --> 
		<script src="/js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

