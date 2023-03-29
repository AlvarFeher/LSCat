<?php
session_start();
$valid = True;
foreach (glob("Classes/*.php") as $filename) {  // include Classes directory
    include $filename;
}
if(empty($_POST['email']) || empty($_POST['password'])){  // initialize vars
    $email = 'blank';
    $password = 'blank';
}else{
    $email = $_POST['email'];
    $password = $_POST['password'];
}
$currentUser = new \Classes\User();
$currentUser->setEmail($email);
$currentUser->setPassword($password);

function isEmailValid($email){ // validate email
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isPwdValid($pwd): bool{  // validate password
    $number = preg_match('@[0-9]@', $pwd);
    if(strlen($pwd) < 8 || !$number){
        return false;
    }else
        return true;
}

if( !isEmailValid($currentUser->getEmail()) && $currentUser->getEmail() != "blank"){
    $valid = false;
}else
    $valid=true;

if( !isPwdValid($currentUser->getPassword()) && $currentUser->getPassword() != "blank"){
    $valid = false;
}else
    $valid=true;

if ($valid){
    $db = new PDO('mysql:host=db;dbname=LSCat', 'root', 'admin', []);
    $statement = $db->prepare('SELECT count(distinct(Users.user_id)) FROM Users WHERE email=? AND password=?');
    $statement->bindParam(1,$email, PDO::PARAM_STR);
    $statement->bindParam(2,$password,PDO::PARAM_STR);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    if((int)$results[0]["count(distinct(Users.user_id))"] > 0){
        $_SESSION['name'] = $currentUser->getEmail();
        header("Location: home.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
<div>
    <div class title>
        <h1 class="title">LS Cat</h1>
    </div>
    <div class="logInBox">
        <h1 class="logInTitle">Log In</h1>
        <form action="login.php" method="POST" accept-charset="utf-8">
            <div class="emailInput">
                <input required value="" name = "email"  placeholder="email" >

                <span class="error"></span>
            </div>
            <div class="passwordInput">
                <input name = "password" type="password" placeholder="password">
                <?php
                if($valid == False){
                    echo '<p>Invalid credentials</p>';
                }
                ?>
            </div>
                <button class= "submit" type="submit">SUBMIT</button>
            <div class="signUpLink">
                <p>Don't have an account?  <a  class="signUpLink" href="signUp.php"> Register here </a> </p>
            </div>
        </form>
    </div>
</div>


<style>
  html{
      height: 100%;
      background: linear-gradient(to bottom right,#eacda3,#d6ae7b);
  }

  form {
      margin-bottom: 20%;
  }

  p{
      font-family: "Courier New", serif;
      display: flex;
      justify-content: center;
      color: black;
  }

  .signUpLink p{
      font-family: "Courier New", serif;
      color: aliceblue;
  }
  .signUpLink a{
      font-family: "Courier New", serif;
      color: #052b4a;
  }
  button {
      font-size: large;
      padding: 15px 100px 15px;
      border-radius: 30px;
      border: 1px solid #ffd5af;
      background: #052b4a;
      color: #ffd5af;
      cursor: pointer;
      outline: none;
      transform: scaleX(1);
      transition: 0.5s all ease;
  }

  input {
      text-align: center;
      border-radius: 20px;
      display: flex;
      min-height: 50px;
      min-width: 300px;
      color: #ffd5af;
      background: linear-gradient(to right, #ffd5af 50%, #052b4a 50%);
      background-size: 200% 100%;
      background-position: right bottom;
      transition: all 0.5s ease;
      border-style: solid;
      border-color: #ffd5af;
  }

  input::placeholder {
      color: #ffd5af;
  }

  .title{
        font-family: "Courier New", serif;
        font-size: 70px;
        font-weight: bolder;
        display: flex;
        justify-content: center;
        color: aliceblue;
    }
    .logInTitle{
        font-family: "Courier New", serif;
        display: flex;
        justify-content: center;
        color: aliceblue;
    }
    .logInBox{
        position: absolute;
        top: 50%;
        left: 50%;
        padding: 40px;
        transform: translate(-50%, -50%);
        box-sizing: border-box;
        border-radius: 10px;
        background: rgba(0,0,0,0);
    }
    .emailInput{
        padding: 10px;
    }
    .passwordInput{
        padding: 10px;
    }
   .submit{
       margin-top: 8%;
   }
   .signUpLink{
       font-weight: bold;
   }

  button:hover {
      animation: shake 0.5s;
      animation-iteration-count: infinite;
  }

  @keyframes shake {
      0% { transform: translate(1px, 1px) rotate(0deg); }
      10% { transform: translate(-1px, -2px) rotate(-1deg); }
      20% { transform: translate(-3px, 0px) rotate(1deg); }
      30% { transform: translate(3px, 2px) rotate(0deg); }
      40% { transform: translate(1px, -1px) rotate(1deg); }
      50% { transform: translate(-1px, 2px) rotate(-1deg); }
      60% { transform: translate(-3px, 1px) rotate(0deg); }
      70% { transform: translate(3px, 1px) rotate(-1deg); }
      80% { transform: translate(-1px, -1px) rotate(1deg); }
      90% { transform: translate(1px, 2px) rotate(0deg); }
      100% { transform: translate(1px, -2px) rotate(-1deg); }
  }
</style>

</body>

</html>

<?php

?>