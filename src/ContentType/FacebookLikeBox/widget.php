<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="fb-page" data-href="<?php echo $this->getData('url', $contentId); ?>" data-tabs="timeline" data-small-header="false"
     data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
    <div class="fb-xfbml-parse-ignore">
        <blockquote cite="<?php echo $this->getData('url', $contentId); ?>"><a href="<?php echo $this->getData('url', $contentId); ?>">Facebook</a>
        </blockquote>
    </div>
</div>