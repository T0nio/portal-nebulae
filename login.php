<?php
	session_start();

	if(!empty($_POST)){
		if(!empty($_POST["userName"]) && !empty($_POST["password"])){
			// LDAP Bind
			$userName = $_POST["userName"];
			
			$ldaprdn  = 'uid='.$userName.',ou=People,dc=nebulae,dc=co';
			$ldappass = $_POST["password"];
                        
                        ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
                        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

			// connect to ldap server
			$ldapconn = ldap_connect("ldap://192.168.100.30")
			    or die("Could not connect to LDAP server.");

			if ($ldapconn) {
        		    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

			    if ($ldapbind) {
                                $justthese = array("uid", "mail", "displayname");
                                $result = ldap_read($ldapconn, $ldaprdn, '(objectclass=*)', $justthese);
                                $info = ldap_get_entries($ldapconn, $result);
                                $_SESSION["user"] = $info[0];
                                #header("Location: index.php");
			    } else {
			        $error= "Nom d'utilisateur ou mot de passe incorrect.";
			    }
                            ldap_close($ldapconn);   
			}
		}else{
			$error = "Entre ton nom d'utilisateur <strong>et</strong> ton mot de passe!";
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

      <form class="form-signin" action="" method="POST">
      	<img src="/img/Nebulae.png" alt="Logo Nebulae">
        <h2 class="form-signin-heading text-center">Connectes toi!</h2>
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
        <label for="userName" class="sr-only">Utilisateur</label>
        <input type="text" id="userName" name="userName" class="form-control" placeholder="Email address" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

		
		<!-- jQuery --> 
		<script src="/js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

