<label>
    Tweet<br>
    <input type="url" class="uk-width-1-1"
           value="<?php echo $content ? $this->getData('url', $content->getId()) : ''; ?>" name="url"
           placeholder="http://..." required/>
</label>
<label>
    <br/>
    <input type="checkbox" class="uk-width-1-1"
           <?php echo $content ? $this->getData('withvideo', $content->getId()) ? 'checked="checked"' : '' : ''; ?>
           name="withvideo"/>
    Tweet enthält ein Video<br/>
</label>

