<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectez vous ou Inscrivez vous</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link href="{{ asset('css/blog.css')}}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body >

    <header class="header">
        <a href="{{ route('login') }}" class="logo">
            <img src="image/blog.png" alt="" width="75" height="80">
        </a>
        <a href="{{ route('login') }}" class="logox">Blog</a>

        <nav class="navbar">
            <!-- <a href=""></a>
            <a href=""></a> -->
            <a href="{{ route('login') }}">Connexion</a>
            <a href="{{ route('register') }}">Inscription</a>
        </nav>
    </header>

    <section class="home">
        <div class="home-content">
            <h1>Connectez vous à votre compte Blog</h1>
            <h3>et partagez avec le monde</h3>
                <p>Le blog est devenu un moyen d'expression privilégié 
                    pour rester en contact avec les internautes. 
                    Voici pourquoi vous devez créer un blog dès maintenant,
                     pour communiquer et être plus visible dans les résultats de recherche.
                </p>

                <div class="btn-box">
                    <a href="{{ route('login') }}">Découvrire</a>
                    <a href="{{ route('login') }}">Poster</a>
                </div>
        </div>

        <div class="home-sci">
            <a href="{{ route('login') }}"><i class='bx bxl-google' ></i></a>
            <a href="{{ route('login') }}"><i class='bx bxl-linkedin' ></i></a>
            <a href="{{ route('login') }}"><i class='bx bxl-facebook'></i></a>
        </div>

        <span class="home-imgHover"></span>

    </section>

</body>

</html>