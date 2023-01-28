<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html {
            font-size: 62.5%;
            line-height: 1.6rem;
            font-family: 'Urbanist', sans-serif;
            box-sizing: border-box;
        }

        #container {
            display: flex;
            justify-content: center;
            background-color: #d19c97;
            margin: 0 450px;
            margin-top: 150px;
            padding: 50px 0;
        }

        h1 {
            font-size: 4rem;
        }

        p {
            font-size: 2rem;
            margin: 50px 0;
        }

        a {
            font-size: 2rem;
            text-decoration: none;
            color: #000;
            transition: .3s ease-in;
        }

        a:hover {
            color: #fff;
            transition: .3s ease-in;
        }
    </style>
</head>

<body>
    <?php require_once "../../config.php" ?>
    <div id="container">
        <div class="">
            <h1>Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã mua hàng của chúng tôi!</p>
            <a href="<?php echo $ROOT_URL ?>">Tiếp tục mua hàng...</a>
        </div>
    </div>

</body>

</html>