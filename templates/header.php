<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->getParameter('page.title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/tooltip.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/codemirror.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/tooltip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/vbscript/vbscript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.12.0/mode/htmlmixed/htmlmixed.min.js"></script>
    <style type="text/css">
        .logout:hover {
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
            background-color: #32628A;
            color: #fff;
        }

        .button-instagram:hover,
        .button-instagram:active,
        .button-instagram:focus {
            background-color: #43739B;
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

        .snippet-input {
            border: none;
            width: 100%;
            color: #d05;
            background: transparent;
        }

        .CodeMirror {
            border: 1px solid #eee;
            height: auto;
        }
    </style>
</head>
<body>
<nav class="uk-navbar">
    <a href="<?php echo $this->getUrl('index'); ?>" class="uk-navbar-brand">
        <i class="uk-icon-cubes"></i>
        <span class="uk-hidden-small">HTML Widgetizer</span>
    </a>
    <div class="uk-navbar-flip">
        <ul class="uk-navbar-nav">
            <li>
                <a href="<?php echo $this->getUrl('index'); ?>" data-uk-tooltip title="Inhalte">
                    <i class="uk-icon-file-text uk-icon-small"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->getUrl('content_types'); ?>" data-uk-tooltip title="Neuer Inhalt">
                    <i class="uk-icon-plus uk-icon-small"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->getUrl('template'); ?>" data-uk-tooltip title="Templates">
                    <i class="uk-icon-file-code-o uk-icon-small"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->getUrl('template_clearcache'); ?>" data-uk-tooltip title="Cache löschen">
                    <i class="uk-icon-refresh uk-icon-small"></i>
                </a>
            </li>
            <li>
                <a href="/" data-uk-tooltip title="Seite ansehen" target="_blank">
                    <i class="uk-icon-eye uk-icon-small"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->getUrl('logout'); ?>" data-uk-tooltip title="Abmelden" class="logout">
                    <i class="uk-icon-power-off uk-icon-small"></i>
                    <span class="uk-hidden-small"><?php echo $_SESSION['user']['username']; ?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="uk-navbar-content uk-navbar-center uk-hidden-small"><?php echo $this->getParameter('page.title'); ?></div>
</nav>
<div class="uk-container uk-container-center uk-margin-large-top">
