<?php
foreach (glob("Classes/*.php") as $filename) {
    include $filename;
}

if(empty($_POST['email']) || empty($_POST['pwd'])){
    $email = 'blank';
    $pwd = 'blank';
    $valid= false;
}else{
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $valid = true;
}
$currentUser = new \Classes\User();
$currentUser->setEmail($email);
$currentUser->setPassword($pwd);
function isEmailValid($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isPwdValid($pwd): bool{
    $number = preg_match('@[0-9]@', $pwd);
    if(strlen($pwd) < 8 || !$number){
        return false;
    }else
        return true;
}

if($valid){
    $user ='sql7605255';
    $pass = 'ngRS3aGLYw';
    $currentDate = date("Y-m-d H:i:s");
    $db = new PDO('mysql:host=db;dbname=LSCat', 'root', 'admin', []);
    $statement = $db->prepare("INSERT INTO Users (email, password, created_at, updated_at) VALUES(:email, :password, :currdate, :update)");
    $statement->bindParam(':name', $email, PDO::PARAM_STR);
    $statement->bindParam(':pwd', $pwd, PDO::PARAM_STR);
    $statement->bindParam(':currdate', $currentDate, PDO::PARAM_STR);
    $statement->bindParam(':update', $currentDate, PDO::PARAM_STR);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
<div class title>
    <h1 class="title">LS Cat</h1>
</div>

<div class="logInBox">
    <h1 class="logInTitle">Sign Up</h1>
    <form action="signUp.php" method="POST" accept-charset="utf-8">
        <div class="emailInput">
            <input required value="" name = "email"  placeholder="email" >
            <?php
            if( !isEmailValid($currentUser->getEmail()) && $currentUser->getEmail() != "blank"){
                echo '<p> Enter a valid email </p>';
                $valid = false;
            } ?>
            <span class="error"></span>
        </div>
        <div class="passwordInput">
            <input name = "pwd" type="password" placeholder="password">
            <?php
            if( !isPwdValid($currentUser->getPassword()) && $currentUser->getPassword() != "blank"){
                echo '<p> Enter a valid password </p>';
                $valid = false;
            } ?>
        </div>
        <button class= "submit" type="submit">SUBMIT</button>
        <div class="signUpLink">
            <p>Already have an account?  <a  class="signUpLink" href="login.php"> Login here </a> </p>
        </div>
    </form>
</div>



<style>
    html{
        height: 100%;
        background: linear-gradient(to bottom right,#eacda3,#d6ae7b);
    }

    form {
        margin-bottom: 20%;
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
</style>

</body>


</html>

