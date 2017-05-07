<?php
    session_start();

    /*if(empty($_SESSION["user"])){
        header("Location: login.php");
    }*/
    if($_SESSION["user"]["gidnumber"][0] != 501){
      header("Location: index.php");
    }

    require "functions.php";

    if(!empty($_POST)){
      $name = $_POST["name"];
      $myName = $_POST["myName"];
      $doesExist = $bdd->prepare("SELECT * FROM accessCode WHERE myName = :name");
      $doesExist->execute(array('name' => $myName));
      if(!$doesExist->fetch()){
        $code = crypt($myName, "nebulae");
        $insert = $bdd->prepare("INSERT INTO accessCode (code, name, myName, used) VALUES (:code, :name, :myName, 0)");
        $insert->execute(array(
            "code" => $code,
            "name" => $name,
            "myName" => $myName
        ));
      }else{
        $error = "Ce nom existe déjà";
      }
    }

    $codes = $bdd->query('SELECT * FROM accessCode');

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
            <li><a href="/profile.php">Modifier mon profile</a></li>
            <?php 
              if($_SESSION['user']["gidnumber"][0] == 501):
            ?>
            <li class="active"><a href="/admin.php">Admin</a></li>
            <?php 
              endif;
            ?>
            <li><a href="/logout.php">Déconnexion</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="container main-cont">
        <form class="form-inline" action="" method="POST">
          <h2 class="text-center">Ajouter un accès</h2>
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
          <?php 
            if(isset($success)):
          ?>
          <div class="alert alert-success" role="alert">
            <?= $success; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <?php
            endif;
          ?>
          <div class="center-form">
            <div class="form-group">
              <label for="name">Prenom</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Marcel">
            </div>
            <div class="form-group">
              <label for="myName">Nom de gestion</label>
              <input type="text" class="form-control" name="myName" id="myName" placeholder="Marcel K">
            </div>
            <button type="submit" name="submitProfile" class="btn btn-default">Ajouter un utilisateur</button>
          </div>
          </form>

         <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Prenom</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                while($code = $codes->fetch()){
                ?>
                <tr>
                  <td><?= $code["code"]; ?></td>
                  <td><?= $code["myName"]; ?></td>
                  <td class="<?= $code["used"]?"green":"red"; ?>"><?= $code["used"]?"Utilisé":"Non utilisé"; ?></td>
                </tr>
                <?php
                }
              ?>
            </tbody>
          </table>     


        </div>
      </div>
    </div> <!-- /container -->

		
		<!-- jQuery --> 
		<script src="/js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

