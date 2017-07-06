<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Typer pilkarski</title>
    <link href="http://{$smarty.server.HTTP_HOST}{$subdir}css/ramka.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="http://{$smarty.server.HTTP_HOST}{$subdir}css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://{$smarty.server.HTTP_HOST}{$subdir}css/starter-template.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Home">Home</a></li>
                {if isset($login) and $access == 2}
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Ustawienia<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Kolejka">Kolejki</a></li>
                        <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Sezon">Sezonu</a></li>
                    </ul>
                </li>
                {elseif isset($login) and $access == 1}
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Typ">Typuj</a></li>
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Typ/historia">Historia</a></li>
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Klasyfikacja">Klasyfikacja</a></li>
                {else}
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Uzytkownik/add">Zarejestruj</a></li>
                {/if}

            </ul>

            <ul class="nav navbar-nav navbar-right">
                {if !isset($login)}
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Access/logform">Zaloguj</a></li>
                {elseif isset($login) and $access == 2}
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Uzytkownik/showone/{$name}">Profil(Administrator)</a></li>
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Access/logout">Wyloguj</a></li>
                {elseif  isset($login) and $access == 1}
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Uzytkownik/showone/{$name}">Profil({$Uzytkownik['login']})</a></li>
                <li><a href="http://{$smarty.server.HTTP_HOST}{$subdir}Access/logout">Wyloguj</a></li>
                {/if}
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
</body>
</html>



