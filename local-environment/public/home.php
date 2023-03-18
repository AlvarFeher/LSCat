<?php
session_start();
require_once "../vendor/autoload.php";

use GuzzleHttp\Client;

function catApiRequest($breed_id){
    $key = "live_tPBZz9RfNviNtAE5adA2BHJKXQhKez94lYkQK0FdjS4iSPmMhgmEbe26TeS7Wey2";
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.thecatapi.com']);
    return $client->request('GET','/v1/images/search?api_key='.$key.'&breed_ids='.$breed_id.'&limit=30');
}

function storeSearchDB(){
    if(!empty($_POST['search'])){
        $search = $_POST['search'];
    }
    $userMail = $_SESSION['name'];
    $user ='sql7605255';
    $pass = 'ngRS3aGLYw';
    $db = new PDO("mysql:host=sql7.freemysqlhosting.net;dbname=sql7605255",$user,$pass);



    $statement = $db->prepare('INSERT INTO SEARCH_STRINGS(email,search) values (:email,:search)');
    $statement->bindParam(':email', $userMail, PDO::PARAM_STR);
    $statement->bindParam(':search', $search, PDO::PARAM_STR);
    $statement->execute();
}

function displayCats($res){
    $cats = json_decode($res->getBody(), TRUE);
    //var_dump($cats[0]['breeds'][0]);
 echo '<div class = "gridBlock">';
 foreach( $cats as $cat){
     //echo'<div class = "catPictureBlock"> </div>';
     echo ' <img class="cat"'  . "src=" . $cat['url'] . ' alt="Cat not loaded" width="200" height="200">' .'<img>';
    }
 echo '</div>';
}

function getCatSearch(){
    if (!empty($_POST['search'])) {
        $breed_id = $_POST['search'];
        $res = catApiRequest($breed_id);
        displayCats($res);
    }
}
?>

<!DOCTYPE html>
<html>

<body>
<h1>LS CAT</h1>
<div>
    <div class="inputBlock">
        <form action="home.php" method="post">
            <input type="search" required value="" name = "search"  placeholder="cat breed" >
            <button type="submit" class="btn btn-outline-light btn-lg px-5 mb-5">GIMME CATS</button>
        </form>
    </div>
    <div class="grid">
        <?php getCatSearch(); storeSearchDB();?>
    </div>
</div>
</body>

<style>

    html{
        height: 100%;
        background: linear-gradient(to bottom right,#eacda3,#d6ae7b);
    }
    h1{
        font-family: "Courier New", serif;
        font-size: 70px;
        font-weight: bolder;
        display: flex;
        justify-content: center;
        color: aliceblue;
    }
    .grid{
        display: grid;
        grid-template-columns: auto auto auto;
    }
    .inputBlock{
        margin: auto;
        width: 50%;
        padding: 10px;

    }
    input {
        margin-left: 70px;
        text-align: center;
        border-radius: 10px;
        min-height: 50px;
        min-width: 300px;
        color: #ffd5af;
        background: linear-gradient(to right, #ffd5af 50%, #052b4a 50%);
        background-size: 200% 100%;
        background-position: right bottom;
        border-style: solid;
        border-color: #ffd5af;
    }
    button {
        font-size: large;
        padding: 15px 10px 15px;
        border-radius: 5px;
        border: 1px solid #ffd5af;
        background: #052b4a;
        color: #ffd5af;
        outline: none;
    }

    input::placeholder {
        color: #ffd5af;
    }

    img:hover {
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

</html>
