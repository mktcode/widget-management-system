<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({selector: 'textarea'});</script>

<label>
    <textarea name="content" rows="20"><?php echo $content ? $this->getData('content', $content->getId()) : ''; ?></textarea>
</label>