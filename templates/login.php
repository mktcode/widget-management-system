<!DOCTYPE html>
<html class="uk-height-1-1">
<head>
    <title><?php echo $this->getParameter('backend.title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.min.css"/>
    <style type="text/css">
        body {
            background-color: <?php echo $this->getParameter('backend.bg'); ?>;
            color: <?php echo $this->getParameter('backend.color'); ?>;
            padding-top: 100px;
        }

        h1, h2 {
            color: <?php echo $this->getParameter('backend.color'); ?>;
        }

        .uk-panel-box {
            background: transparent;
            color: <?php echo $this->getParameter('backend.color'); ?>;
        }
    </style>
</head>

<body class="uk-height-1-1">

<div class="uk-text-center uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 uk-container-center">

    <h1 class="uk-margin-top">
        <i class="uk-icon-cubes"></i><br>
        <?php echo $this->getParameter('backend.title'); ?>
    </h1>

    <form class="uk-panel uk-panel-box uk-form" method="post">
        <?php
        if ($vars['message']) {
            echo $vars['message'];
        }
        ?>
        <div class="uk-form-row uk-text-left">
            <small><?php echo $this->translate('login.username'); ?>:</small><br>
            <input class="uk-width-1-1 uk-form-large" type="text" placeholder="<?php echo $this->translate('login.username'); ?>" name="user"
                   value="<?php echo $_POST['user']; ?>" autofocus>
        </div>
        <div class="uk-form-row uk-text-left">
            <small><?php echo $this->translate('login.password'); ?>:</small><br>
            <input class="uk-width-1-1 uk-form-large" type="password" placeholder="<?php echo $this->translate('login.password'); ?>" name="pass">
        </div>
        <div class="uk-form-row">
            <button class="uk-width-1-1 uk-button uk-button-success uk-button-large"><?php echo $this->translate('login.login'); ?></button>
        </div>
    </form>
</div>

</body>

</html>