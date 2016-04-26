<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


<?php
if (($this->getData('von', $content->getId())<=date('Y-m-d') && ($this->getData('bis', $content->getId())>=date('Y-m-d')) || $this->getData('bis', $content->getId())=='' ) || $this->getData('von', $content->getId())=='' ) {
    if ($this->getData('modal', $content->getId()) == 1) {
        ?>
        <style>
            .wms-modal {
                display: block;
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1010;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                background: rgba(0, 0, 0, .6);
                opacity: 0;
                -webkit-transition: opacity .15s linear;
                transition: opacity .15s linear;
                touch-action: cross-slide-y pinch-zoom double-tap-zoom;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                opacity: 1;
            }

            .wms-modal-dialog {
                position: relative;
                box-sizing: border-box;
                margin: 150px auto;
                padding: 20px;
                width: 600px;
                max-width: 100%;
                max-width: calc(100% - 20px);
                background: #fff;
                opacity: 0;
                -webkit-transform: translateY(-100px);
                transform: translateY(-100px);
                -webkit-transition: opacity .3s linear, -webkit-transform .3s ease-out;
                transition: opacity .3s linear, transform .3s ease-out;
                opacity: 1;
            }

            .wms-modal-dialog > .wms-close:first-child {
                margin: -10px -10px 0 0;
                float: right;
            }

            .wms-close {
                -webkit-appearance: none;
                margin: 0;
                border: none;
                overflow: visible;
                font: inherit;
                color: inherit;
                text-transform: none;
                padding: 0;
                background: 0 0;
                display: inline-block;
                box-sizing: content-box;
                width: 20px;
                line-height: 20px;
                text-align: center;
                vertical-align: middle;
                opacity: .3;
                cursor: pointer;
            }

            .wms-close:hover {
                opacity: 1;
            }

        </style>
        <script>
            $(document).ready(function () {

                $(document).on("click", ".wms-close", function () {

                    $(this).parent().parent().remove();
                });
                $(document).on("click", ".wms-modal", function () {

                    $(this).remove();
                });
            });
        </script>

        <div id="modal_<?php print  $content->getId(); ?>" class="wms-modal">
            <div class="wms-modal-dialog">
                <a class="wms-modal-close wms-close">x</a>

                <div class="fb-video" data-allowfullscreen="1"
                     data-href="<? print $this->getData('url', $content->getId()); ?>?type=3"></div>
            </div>
        </div>
        <script>

        </script>

    <?php
    } else {
        ?>
        <div class="fb-video" data-allowfullscreen="1"
             data-href="<? print $this->getData('url', $content->getId()); ?>?type=3"></div>
    <?php
    }
}
?>