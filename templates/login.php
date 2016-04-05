<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->config['page.title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.min.css"/>
</head>

<body class="uk-height-1-1">

<div class="uk-vertical-align uk-text-center uk-height-1-1">
    <div class="uk-vertical-align-middle uk-margin-top">

        <h1>
            <i class="uk-icon-cubes"></i><br>
        </h1>

        <?php
        if ($vars['message']) {
            echo $vars['message'];
        }
        ?>

        <form class="uk-panel uk-panel-box uk-form" method="post">
            <div class="uk-form-row">
                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Benutzername" name="user"
                       value="<?php echo $_POST['user']; ?>" autofocus>
            </div>
            <div class="uk-form-row">
                <input class="uk-width-1-1 uk-form-large" type="password" placeholder="Passwort" name="pass">
            </div>
            <div class="uk-form-row">
                <button class="uk-width-1-1 uk-button uk-button-success uk-button-large">Login</button>
            </div>
        </form>

    </div>
</div>

</body>

</html>