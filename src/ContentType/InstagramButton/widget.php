<?php
/**
 * @var $contentId
 */
?>
<style>.ig-b- {
        display: inline-block;
    }

    .ig-b- img {
        visibility: hidden;
    }

    .ig-b-:hover {
        background-position: 0 -60px;
    }

    .ig-b-:active {
        background-position: 0 -120px;
    }

    .ig-b-v-24 {
        width: 137px;
        height: 24px;
        background: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24.png) no-repeat 0 0;
    }

    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
        .ig-b-v-24 {
            background-image: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24@2x.png);
            background-size: 160px 178px;
        }
    }</style>
<a href="https://www.instagram.com/<?php echo $this->getData('username', $contentId); ?>/?ref=badge" class="ig-b- ig-b-v-24"><img
        src="//badges.instagram.com/static/images/ig-badge-view-24.png" alt="Instagram"/></a>