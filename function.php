<?php
    session_start();
    // IF FOR CHOOSING FORM-ACTION
    if(isset($_POST["action"])){
      if($_POST["action"] == "register"){
        register();
      }
      else if($_POST["action"] == "login"){
        login();
      }
    }

    // REGISTER
    function register(){
      $jsonArray = [];
      $json = file_get_contents('database.json');
      $jsonArray = json_decode($json, true);
        
      $login = htmlspecialchars(($_POST["login"]));
      $password = htmlspecialchars($_POST["password"]);
      $email = htmlspecialchars($_POST["email"]);
      $username = htmlspecialchars($_POST["username"]);

      if($login !== $jsonArray['login'] && $email !== $jsonArray['email']){
        $password = md5($password);
        $jsonArray = [
          "login" => $login,
          "password" => $password,
          "email" => $email,
          "username" => $username,
        ];
        file_put_contents('database.json', json_encode($jsonArray, JSON_FORCE_OBJECT));
        session_start();
        $_SESSION['user'] = $login;
        echo "Registration Successful";
        exit(0);
        }else{
          echo "Login or email have been already taken";
          exit(0);
        }
      }

    // LOGIN
    function login(){
      $json = file_get_contents('database.json');
      $jsonArray = json_decode($json, true);

      $login = htmlspecialchars($_POST["login"]);
      $password = md5(htmlspecialchars($_POST["password"]));

      if ($login === $jsonArray['login'] && $password === $jsonArray['password']){
        echo "Login Successful";
        $_SESSION['user'] = $login;
        exit(0);
      }
      else {
        echo "Wrong Password or Login";
        exit(0);
      }
    }
?>

