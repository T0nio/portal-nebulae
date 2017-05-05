<?php

  session_start();

  $_SESSION["user"] = "";
  unset($_SESSION["user"]);

  header("Location: login.php");
