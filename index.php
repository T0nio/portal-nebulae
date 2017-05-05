<?php
    session_start();

    /*if(empty($_SESSION["user"])){
        header("Location: login.php");
    }*/

    //gidnumber

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
            <li class="active"><a href="/">Portail</a></li>
            <li><a href="/profile.php">Modifier mon profile</a></li>
            <li><a href="/admin.php">Admin</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container main-cont">
      <div class="jumbotron">
        <h1>Portail Nebulae</h1>
        <p>	Bla bla bla bienvenue sur la béta de Nebulae! <br>
        	Auth unique. Utilise ce compte partout! (n'essaye pas de créer un compte sur les autres services)<br>
        	Reviens ici régulièrement pour savoir ce qui est sorti de nouveau!
        </p>
        <p>
          <a class="btn btn-lg btn-primary" href="#services" role="button">Jetter un oeil aux services déjà en place!</a>
        </p>
      </div>
      <div id="services">
      	<div class="row">
	      	<div class="col-md-4">
	      		<a href="https://mail.nebulae.co"><img src="/img/NebulaeMail.png" alt="Nebulae Mail"></a>
	      		<p>Remplassons GMAIL! Pour l'instant une adresse unique</p>
	      	</div>
	      	<div class="col-md-4">
	      		<a href="https://wiki.nebulae.co"><img src="/img/NebulaeWiki.png" alt="Nebulae Wiki"></a>
	      		<p>Pour partager la connaissance ! Il y a déjà quelques tutos, n'hésitez pas à en rajouter!</p>
	      	</div>
	      	<div class="col-md-4">
	      		<a href="https://forum.nebulae.co"><img src="/img/NebulaeForum.png" alt="Nebulae Forum"></a>
	      		<p>Le retour du Forum ! ahah. Bon j'ai pas eu le temps de backup l'ancien, du coup j'ai des copies des discissions précedentes, mais on a pas gardé ce qu'il y avait.</p>
	      	</div>
      	</div>
      	<div class="row">
      		<div class="col-md-4">
      			<a href="https://calendrier.nebulae.co"><img src="/img/Nebulae.png" alt="Nebulae Calendrier"></a>
      			<p>Syncronisez votre calendrier entre tous vos appareils!<br/>
				<strong>Tip</strong> les deux plateformes Calendrier &amp; Contacts sont en fait la même plateforme (accessible <a href="https://dav.nebulae.co">ici</a> aussi)</p>
      		</div>
	      	<div class="col-md-4">
	      		<a href="https://contact.nebulae.co"><img src="/img/Nebulae.png" alt="Nebulae Contacts"></a>
	      		<p>Syncroniser vos contacts avec tous vos appareils! <br/>
	      		<strong>Tip</strong> les deux plateformes Calendrier &amp; Contacts sont en fait la même plateforme (accessible <a href="https://dav.nebulae.co">ici</a> aussi)</p>
	      	</div>
      		
      	</div>
      </div>    	
    </div> <!-- /container -->

		
		<!-- jQuery --> 
		<script src="/js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="/js/bootstrap.min.js"></script>
	</body>
</html>

