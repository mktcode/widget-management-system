<label>
    Video Url<br>
    <input type="url" class="uk-width-1-1"
           value="<?php echo $content ? $this->getData('url', $content->getId()) : ''; ?>" name="url"
           placeholder="http://..." required/>
</label>
<label>
    <br/><br/>
    <input data-uk-toggle="{target:'#apikey'}" type="checkbox" class="uk-width-1-1"
           <?php echo $content ? $this->getData('withstats', $content->getId()) ? 'checked="checked"' : '' : ''; ?>
           name="withstats"/>
    Statistik zum Video anzeigen<br/><br/>
</label>
<label id="apikey" class="<?php echo $content ? !$this->getData('withstats', $content->getId()) ? 'uk-hidden' : '' : 'uk-hidden'; ?>">
    Google API Key<br>
    <input type="text" class="uk-width-1-1"
           value="<?php echo $content ? $this->getData('apikey', $content->getId()) : ''; ?>" name="apikey"
           placeholder="" />
</label>

<a data-uk-toggle="{target:'#infobox'}"  style="display: table" class="uk-button uk-button-default">
    <i class="uk-icon-info"></i> Responsive Video
</a>
<div class="uk-alert uk-alert-info uk-hidden" id="infobox">
    Um das Video responsive darzustellen müssen Sie einmalig folgenden CSS Code in Ihr Template einbinden:<br>
    <br>
    <code>
        .responsive-video iframe {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;position: absolute;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;top: 0;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;left: 0;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;width: 100%;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;height: 100%;<br>
        }<br>
        <br>
        .responsive-video {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;position: relative;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;padding-bottom: 56.25%;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;padding-top: 0px;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;height: 0;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;overflow: hidden;<br>
        }<br>
    </code>
</div>