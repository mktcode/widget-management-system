<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->getParameter('backend.title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/tooltip.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/codemirror.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.2/css/components/datepicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.2/css/components/form-advanced.css"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/tooltip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/vbscript/vbscript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.2/js/components/datepicker.min.js"></script>
    <style type="text/css">
        .logout:hover,
        .logout:focus,
        .logout:active {
            background-color: #f00 !important;
            color: #fff !important;
        }

        .button-huge {
            font-size: 25px;
            line-height: 35px;
            padding: 15px 20px;
        }

        .button-enormous {
            font-size: 55px;
            line-height: 65px;
            padding: 25px 30px;
        }

        .button-facebook {
            background-color: #3B5999;
            color: #fff;
        }

        .button-facebook:hover,
        .button-facebook:active,
        .button-facebook:focus {
            background-color: #4C6aaa;
            color: #fff;
        }

        .button-instagram {
            background-color: #3f729b;
            color: #fff;
        }

        .button-instagram:hover,
        .button-instagram:active,
        .button-instagram:focus {
            background-color: #43739B;
            color: #fff;
        }

        .button-twitter {
            background-color: #55acee;
            color: #fff;
        }

        .button-twitter:hover,
        .button-twitter:active,
        .button-twitter:focus {
            background-color: #00405d;
            color: #fff;
        }

        .button-whatsapp {
            background-color: #25D366;
            color: #fff;
        }

        .button-youtube {
            background-color: #cd201f;
            color: #fff;
        }

        .button-youtube:hover,
        .button-youtube:active,
        .button-youtube:focus {
            background-color: #e24141;
            color: #fff;
        }

        .button-whatsapp {
            background-color: #25D366;
            color: #fff;
        }

        .button-whatsapp:hover,
        .button-whatsapp:active,
        .button-whatsapp:focus {
            background-color: #36E477;
            color: #fff;
        }

        .button-soundcloud {
            background-color: #ff3300;
            color: #fff;
        }

        .button-soundcloud:hover,
        .button-soundcloud:active,
        .button-soundcloud:focus {
            background-color: #ff8800;
            color: #fff;
        }

        .snippet-input {
            border: none;
            outline: none;
            color: #d05;
            background: transparent;
            min-width: 260px;
        }

        table .snippet-input {
            width: 100%;
        }

        .CodeMirror {
            border: 1px solid #eee;
            height: auto;
        }

        .uk-navbar {
            background-color: <?php echo $this->getParameter('backend.bg'); ?>;
        }

        .uk-navbar,
        .uk-navbar-brand,
        .uk-navbar-brand:hover,
        .uk-navbar-brand:focus,
        .uk-navbar-brand:active,
        .uk-navbar-nav > li > a {
            color: <?php echo $this->getParameter('backend.color'); ?>;
        }


    </style>
</head>
<body>
<div class="uk-container uk-container-center uk-margin-top">
<?php
foreach ($this->getSession()->getFlashbag()->get('success') as $message) {
    echo '<div class="uk-alert uk-alert-success" data-uk-alert>
            <a href="" class="uk-alert-close uk-close"></a>

            <p>
                <i class="uk-icon-check"></i>
                ' . $message . '
            </p>
        </div>';
}

foreach ($this->getSession()->getFlashbag()->get('error') as $message) {
    echo '<div class="uk-alert uk-alert-danger" data-uk-alert>
        <a href="" class="uk-alert-close uk-close"></a>

        <p>
            <i class="uk-icon-warning"></i>
            ' . $message . '
        </p>
    </div>';
}