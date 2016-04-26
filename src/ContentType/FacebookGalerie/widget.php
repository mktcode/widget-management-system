<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.18/css/lightgallery.min.css" />
<script src=" https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.18/js/lightgallery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.18/js/lg-thumbnail.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.18/js/lg-fullscreen.min.js"></script>

<script>
    var pics = null;
    $(document).ready(function () {

        $(document).on("click", ".gallerieClick", function () {

            $(this).lightGallery({
                dynamic: true,
                dynamicEl: pics[$(this).attr('data-idfb')]
            })
        });
    });
</script>
<?php

$fb = new Facebook\Facebook([
    'app_id' => $this->getData('appID', $contentId),
    'app_secret' => $this->getData('appSecret', $contentId),
    'default_graph_version' => 'v2.5',
]);

$fb->setDefaultAccessToken($this->getData('appID', $contentId) . '|' . $this->getData('appSecret', $contentId));
//top10singen?fields=videos{source,title,from,description}
try {

    $pageNameEx = explode('com/', $this->getData('url', $contentId));
    $pageName = explode('/', $pageNameEx[1]);

    $res = $fb->get('/' . $pageName[0] . '?fields=albums.limit(' . $this->getData('galeries', $contentId) . '){cover_photo,name,photos.limit(' . $this->getData('galeriePics', $contentId) . '){images,name,height},id,created_time.order(chronological)}');

    $fbGalerie = $res->getDecodedBody();

    $html = '';
    $arrayPics = array();

    if ($fbGalerie['albums']['data']) {
        foreach ($fbGalerie['albums']['data'] as $galerie) {

            if ($galerie['name'] != 'Timeline Photos' && $galerie['name'] != 'Cover Photos') {

                $html .= '<div class="fbGalerie">';
                $html .= '<div class="fbGalerieTitle">' . $galerie['name'] . '</div>';
                $html .= '<div class="fbGalerieImage gallerieClick" data-idfb="' . $galerie['id'] . '"><img width="200" src="' . $galerie['photos']['data'][0]['images'][0]['source'] . '" /></div>';
                $html .= '</div>';

                $counter = 0;
                foreach ($galerie['photos']['data'] as $pics) {
                    $arrayPics[$galerie['id']][$counter]['src'] = $pics['images'][0]['source'];
                    $arrayPics[$galerie['id']][$counter]['thumb'] = $pics['images'][0]['source'];
                    if (isset($pics['name'])) {
                        $arrayPics[$galerie['id']][$counter]['subHtml'] = $pics['name'];
                    } else {
                        $arrayPics[$galerie['id']][$counter]['subHtml'] = '';
                    }
                    $counter++;
                }
            }
        }
        $html .= '<script>pics=' . json_encode($arrayPics) . ';</script>';
    }

    print $html;

} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    // echo 'Graph returned an error: ' . $e->getMessage();
    exit;
}
?>