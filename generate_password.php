<?php
  $password="Reagan23;;";
  $hash=password_hash($password,PASSWORD_DEFAULT);
  echo "Password:". $password."<br>";
  echo "Hashed Password: <br><textarea rows='2' cols='80'>$hash</textarea>";


?>