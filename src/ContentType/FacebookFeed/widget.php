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

$fb = new Facebook\Facebook([
    'app_id' => $this->getData('appID', $contentId),
    'app_secret' => $this->getData('appSecret', $contentId),
    'default_graph_version' => 'v2.5',
]);

$fb->setDefaultAccessToken($this->getData('appID', $contentId) . '|' . $this->getData('appSecret', $contentId));
try {

    $pageNameEx = explode('com/', $this->getData('url', $contentId));
    $pageName = explode('/', $pageNameEx[1]);

    $res = $fb->get('/' . $pageName[0] . '?fields=feed.limit(40){description,message,created_time,id,from,status_type,name,attachments{media,url,type,title},type},id');

    $fbFeed = $res->getDecodedBody();

    $html = '';
    $arrayPics = array();

    $counter=0;
    if ($fbFeed['feed']['data']) {
        foreach ($fbFeed['feed']['data'] as $feed) {

        if($this->getData('beitrag', $contentId)>$counter)
        {

            if($feed['from']['id']==$fbFeed['id'])
            {
                $html .= '<div class="fbFeed">';

                if(isset($feed['description']))
                {

                    $html.='<div class="fbFeedDesc">'.$feed['description'].'</div>';

                }
                if(isset($feed['message']))
                {
                    $html.='<div class="fbFeedDesc">'.$feed['message'].'</div>';
                }
                if(isset($feed['attachments']['data'][0]['media']['image']['src']) && $feed['type']=="photo")
                {
                    $html.='<div class="fbFeedImage"><img src="'.$feed['attachments']['data'][0]['media']['image']['src'].'" alt="'.$feed['attachments']['data'][0]['title'].'" /></div>';

                }

                if($feed['type']=="video")
                {

                    if($feed['attachments']['data'][0]['type']=="video_inline")
                    {

                        $html.='<div class="fbFeedVideo"><div class="fb-video" data-allowfullscreen="1"data-href="'.$feed['attachments']['data'][0]['url'].'?type=3"></div></div>';
                    }
                    elseif($feed['attachments']['data'][0]['type']=="video_share_youtube")
                    {
                        $exPlodeUrl=explode('v%3D',$feed['attachments']['data'][0]['url']);
                        $youtube=explode('%26',$exPlodeUrl[1]);
                        $html.='<div class="fbFeedVideo"><iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$youtube[0].'" frameborder="0" allowfullscreen></iframe></div>';
                    }

                }

                $html.='</div>';
                $counter++;
            }
        }
        else{
             break;
        }

        }

    }

    print $html;

} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
     echo 'Graph returned an error: ' . $e->getMessage();
    exit;
}
?>
