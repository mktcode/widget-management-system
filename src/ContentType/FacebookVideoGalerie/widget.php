<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<style>
    .fbGalerieVideo
    {
        width:200px;
    }
</style>
<?php

$fb = new Facebook\Facebook([
    'app_id' => $this->getData('appID', $contentId),
    'app_secret' => $this->getData('appSecret', $contentId),
    'default_graph_version' => 'v2.5',
]);

$fb->setDefaultAccessToken($this->getData('appID', $contentId) . '|' . $this->getData('appSecret', $contentId));
try {

    $pageNameEx = explode('com/', $this->getData('url', $contentId));
    $pageName = explode('/', $pageNameEx[1]);

    $res = $fb->get('/' . $pageName[0] . '?fields=videos.limit('. $this->getData('galeries', $contentId).'){permalink_url,title,from,description}');

    $fbGalerie = $res->getDecodedBody();

    $html = '';
    $arrayPics = array();

    if ($fbGalerie['videos']['data']) {
        foreach ($fbGalerie['videos']['data'] as $galerie) {

                $html .= '<div class="fbVideoGalerie">';
                $html .= '<div class="fbVideoGalerieTitle">' . $galerie['description'] . '</div>';
                $html .= '<div class="fbGalerieVideo" data-idfb="' . $galerie['id'] . '"><div class="fb-video" data-allowfullscreen="1"
                     data-href="https://facebook.com'.$galerie['permalink_url'].'?type=3"></div></div>';
                $html .= '</div>';
        }

    }

    print $html;

} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    // echo 'Graph returned an error: ' . $e->getMessage();
    exit;
}
?>
