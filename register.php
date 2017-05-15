<?php
	session_start();

    require "functions.php";
	// Check the token
    $userRequest = $bdd->prepare("SELECT * FROM accessCode WHERE code = :code");
    $userRequest->execute(array('code' => $_GET["code"]));
    $user = $userRequest->fetch();
    $name = $user["name"]; 

    if(!empty($_POST)){
        if(!empty($_POST["uid"]) && !empty($_POST["sn"]) && !empty($_POST["cn"]) && !empty($_POST["displayName"]) && !empty($_POST["password"]) && !empty($_POST["confirmPassword"])){
            if($_POST["password"] == $_POST["confirmPassword"]){
                if(strlen($_POST['password']) >= 6){
                    if(strlen($_POST["uid"]) >= 2){
                        if($_POST["uid"] == strtolower($_POST["uid"]) && preg_match("#^[a-z0-9._-]+$#", $_POST['uid'])){
                            
                            $ldapconn = ldap_connect("ldap://192.168.100.30")
                                or die("Could not connect to LDAP server.");
                            ldap_set_option($ldapconn, LDAP_OPT_DEBUG_LEVEL, 7);
                            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                            if ($ldapconn) {
                                $ldapbind = ldap_bind($ldapconn, $adminDN, $adminPWD);
                                if ($ldapbind) {
                                    $ldaprdn  = 'uid='.$_POST["uid"].',ou=People,dc=nebulae,dc=co';
                                    $result = ldap_read($ldapconn, $ldaprdn, '(objectclass=*)');
                                    if(!$result){
                                        $search = ldap_search($ldapconn, "ou=People,dc=nebulae,dc=co", "(objectclass=*)", array("uidnumber"));
                                        $entries = ldap_get_entries($ldapconn, $search);

                                        $uids = array();
                                        foreach ($entries as $e) {
                                            if(isset($e["uidnumber"])){
                                                $uids[] = $e["uidnumber"][0];    
                                            }
                                        }
                                        sort($uids, SORT_NUMERIC);

                                        $uidnumber =  ($uids[sizeof($uids)-1])+1;

                                        $uid = $_POST["uid"];
                                        $dn = "uid=".$uid.",ou=People,dc=nebulae,dc=co";

                                        $ldapUser["objectclass"][0] = "inetOrgPerson";
                                        $ldapUser["objectclass"][1] = "posixAccount";
                                        $ldapUser["objectclass"][2] = "top";
                                        $ldapUser["cn"] = $_POST["cn"];
                                        $ldapUser["displayname"] = $_POST["displayName"];
                                        $ldapUser["gidnumber"] = "500";
                                        $ldapUser["homedirectory"] = "/home/users/".$uid;
                                        $ldapUser["mail"] = $uid."@nebulae.co";
                                        $ldapUser["sn"] = $_POST["sn"];
                                        $ldapUser["uidnumber"] = $uidnumber;
                                        $ldapUser["userpassword"] = generate_password($_POST["password"]);
                                        if(ldap_add($ldapconn, $dn, $ldapUser)){
                                            $groupDN = "cn=Member,ou=Groups,dc=nebulae,dc=co";
                                            $entry["memberuid"] = $uid;

                                            if(ldap_mod_add($ldapconn, $groupDN, $entry)){
                                                $req = $bdd->prepare("UPDATE accessCode SET used = 1 WHERE code = :code");
                                                $req->execute(array("code" => $user["code"]));
                                                header("Location: login.php?new=1&uid=".$uid);                                                
                                            }else{
                                                $error = "Une erreur est survenue.4";
                                            }

                                        }else{ 
                                            $error = "Une erreur est survenue.3";
                                        }


                                    }else{
                                        $error = "Ce nom d'utilisateur existe déjà.";
                                    }
                                }else{
                                    $error = "Une erreur est survenue.2";
                                }
                            }else{
                                $error = "Une erreur est survenue.";
                            }
                        }else{
                            $error = "Le nom d'utilisateur doit être en minuscules, sans accent.";
                        }
                    }else{
                        $error = "Merci de choisir un nom d'utilisateur plus long.";
                    }
                }else{
                    $error = "Merci de choisir un mot de passe plus fort.";
                }
            }else{
                $error = "Les mots de passe ne correspondent pas.";
            }
        }else{
            $error = "Merci de remplir tous les champs";
        }
    }
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
        <?php 
            if($name){
        ?>

      <form class="form-signin" action="" method="POST">
      	<img src="/img/Nebulae.png" alt="Logo Nebulae">
        <h2 class="form-signin-heading text-center">Salut <?= $name;?></h2>
        <h3  class="form-signin-heading text-center">Tu peux t'inscrire!</h3>
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
        <label for="uid" class="sr-only">Nom d'utilisateur*</label>
	    <div class="input-group marginbottom10">
	      <input type="text" id="uid" name="uid" class="form-control" placeholder="Nom d'utilisateur*" value="<?= (isset($_POST["uid"]))?$_POST["uid"]:""; ?>" required>
	      <div class="input-group-addon">@nebulae.co</div>
	    </div>

        <label for="sn" class="sr-only">Nom*</label>
        <input type="text" id="sn" name="sn" class="form-control" placeholder="Nom*" value="<?= (isset($_POST["sn"]))?$_POST["sn"]:""; ?>" required>
        
        <label for="cn" class="sr-only">Prénom*</label>
        <input type="text" id="cn" name="cn" class="form-control" placeholder="Prénom*" value="<?= (isset($_POST["cn"]))?$_POST["cn"]:""; ?>" required>

        <label for="displayName" class="sr-only">Nom à afficher*</label>
        <input type="text" id="displayName" name="displayName" class="form-control" placeholder="Nom à afficher*" value="<?= (isset($_POST["displayName"]))?$_POST["displayName"]:""; ?>" required>
        
        <label for="password" class="sr-only">Mot de passe*</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe*" required>
        
        <label for="confirmPassword" class="sr-only">Confirmation*</label>
        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirmation du mot de passe*" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Inscription!</button>
      </form>
      <?php 
        }elseif($user["used"]){
            echo "Deso le token est déjà utilisé!";
        }else{
            echo "Déso les inscriptions sont pas encore ouvertes";
        }
      ?>

    </div> <!-- /container -->

		
		<!-- jQuery --> 
		<script src="/js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

