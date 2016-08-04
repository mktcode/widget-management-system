<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: "hr link image textcolor charmap paste print anchor searchreplace code fullscreen media table",
        toolbar1: 'undo redo | cut copy paste pastetext searchreplace | removeformat print code fullscreen',
        toolbar2: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify alignnone | outdent indent | bullist numlist blockquote | subscript superscript | hr link unlink anchor',
        toolbar3: 'formatselect fontselect fontsizeselect | forecolor backcolor | image media table charmap'
    });
</script>

<label>
    <textarea name="content" rows="20"><?php echo $content ? $this->getData('content', $content->getId()) : ''; ?></textarea>
</label>