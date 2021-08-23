<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body class="align-bottom" style=" display: flex; align-items: center;justify-content: center;">

    <form>
        <img src="<?='../' . $_SESSION['user']['avatar'] ?>" width="200" alt="">
        <h2 style="margin: 10px 0;"><?= $_SESSION['user']['full_name'] ?></h2>
        <a href="#"><?= $_SESSION['user']['email'] ?></a>
        <a href="vendor/logout.php" class="logout">Выход</a>
    </form>

    <div class="cntainer mt-5" style=" display: flex; align-items: center;justify-content: center;">
        <div class="row post-list">

        </div>
    </div>


<script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
<script type="application/javascript">
    $.ajax({
        type: "POST",
        url: "getUsers.php",
        data: { name: "John", location: "Boston" }
    }).done(function( users ) {
        // console.log(users);

        let target = document.querySelector('.post-list');


        // target.insertAdjacentHTML('beforeEnd', '<p>!</p>');
        users.forEach((user) => {


            let cardDiv = document.createElement('div');
            cardDiv.className = "Card";
            cardDiv.style = "width: 18rem; margin: 3rem; background-color: RGB(107, 196, 255);";

            let img = document.createElement("img");
            img.className = "card-img-top";
            img.src = '../'+ user['photo'];

            cardDiv.appendChild(img);

            let bodyDiv = document.createElement('div');
            bodyDiv.className = "card-body";

            let h = document.createElement('h5')
            h.className = "card-title";
            h.innerText = user['name'];

            let p = document.createElement('p');
            p.innerHTML = user['email'];

            bodyDiv.appendChild(h);
            bodyDiv.appendChild(p);

            cardDiv.appendChild(bodyDiv);

            target.appendChild(cardDiv);
            // target.insertAdjacentHTML('beforeEnd', p);
        })
        // <div class="card" style="width: 18rem;">
        //     <img src="..." class="card-img-top" alt="...">
        //     <div class="card-body">
        //     <h5 class="card-title">Card title</h5>
        // <p class="card-text">Some quickof the card's content.</p>
        // </div>
        // </div>


    })
</script>

</body>
</html>