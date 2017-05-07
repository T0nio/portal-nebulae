<?php
    session_start();

    require "functions.php";

    if(empty($_SESSION["user"])){
        header("Location: login.php");
    }

    if(!empty($_POST)){
        if(isset($_POST["submitProfile"])){
          if(!empty($_POST["sn"]) && !empty($_POST["cn"]) && !empty($_POST["displayname"])){
            $ldaprdn  = $_SESSION["user"]["dn"];
            // connect to ldap server
            $ldapconn = ldap_connect("ldap://192.168.100.30")
                or die("Could not connect to LDAP server.");
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            if ($ldapconn) {
                $ldapbind = ldap_bind($ldapconn, $adminDN, $adminPWD);
                if ($ldapbind) {
                  //$_SESSION["user"]["userpassword"][0] = $encryptedPassword;
                  $userdata["sn"] = $_POST["sn"];
                  $userdata["cn"] = $_POST["cn"];
                  $userdata["displayname"] = $_POST["displayname"];

                  if(ldap_mod_replace ( $ldapconn , $ldaprdn , $userdata)){
                    $result = ldap_read($ldapconn, $ldaprdn, '(objectclass=*)');
                    $info = ldap_get_entries($ldapconn, $result);
                    $_SESSION["user"] = $info[0];
                    $success = "Vos infos sont bien modifiées!";
                  }else{
                    $error = "Une erreur est survenue. - 1";
                  }
                } else {
                    $error= "Une erreur est survenue. - 2";
                }
                ldap_close($ldapconn);   
            }
          }else{
            $error = "Merci de remplir tous les champs";
          }
        }elseif (isset($_POST["submitPassword"])) {
          $password = $_POST['password'];
          if(!empty($password) && !empty($_POST["confirmPassword"])){
            if($password == $_POST["confirmPassword"]){
              if(strlen($password) >= 6){
                $encryptedPassword = generate_password($password);
                $ldaprdn  = $_SESSION["user"]["dn"];
                $ldappass = $_POST["oldPassword"];
                                  

                // connect to ldap server
                $ldapconn = ldap_connect("ldap://192.168.100.30")
                    or die("Could not connect to LDAP server.");
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                if ($ldapconn) {
                    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

                    if ($ldapbind) {
                      //$_SESSION["user"]["userpassword"][0] = $encryptedPassword;
                      $userdata["userpassword"] = $encryptedPassword;
                      if(ldap_mod_replace ( $ldapconn , $ldaprdn , $userdata)){
                        $success = "Votre mot de passe a bien été modifié!";
                      }else{
                        $error = "Une erreur est survenue.";
                      }
                    } else {
                        $error= "Ancien mot de passe incorrect.";
                    }
                    ldap_close($ldapconn);   
                }
              }else{
                $error = "Veuillez entrer un mot de passe de plus de 6 caractères.";
              }
            }else{
              $error = "Veuillez entrer deux fois le même mot de passe.";
            }
          }else{
            $error = "Veuillez confirmer votre nouveau mot de passe";
          }
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
        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="mail" placeholder="Email" value="<?= $_SESSION["user"]["mail"][0]; ?>" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="uid" class="col-sm-2 control-label">Nom d'utilisateur</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="uid" name="uid" placeholder="Login" value="<?= $_SESSION["user"]["uid"][0]; ?>" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="cn" class="col-sm-2 control-label">Prenom</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="cn" name="cn" placeholder="Prenom" value="<?= $_SESSION["user"]["cn"][0]; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label for="sn" class="col-sm-2 control-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="sn" name="sn" placeholder="Prenom" value="<?= $_SESSION["user"]["sn"][0]; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label for="displayname" class="col-sm-2 control-label">Nom à afficher</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="displayname" name="displayname" placeholder="Nom à afficher" value="<?= $_SESSION["user"]["displayname"][0]; ?>" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="submitProfile" class="btn btn-default">Modifier mon profile</button>
          </div>
        </div>
        </form>
        <hr>
        <form class="form-horizontal" action="" method="POST">
        <h3>Changer mon mot de passe</h3>
        <div class="form-group">
          <label for="oldPassword" class="col-sm-2 control-label">Ancien mot de passe</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Ancien mot de passe">
          </div>
        </div>        
        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Nouveau mot de passe</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Nouveau mot de passe">
          </div>
        </div>
        <div class="form-group">
          <label for="confirmPassword" class="col-sm-2 control-label">Confirmer le nouveau mot de passe</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmer le nouveau mot de passe">
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

