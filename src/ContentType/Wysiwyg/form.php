<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: "hr link image textcolor charmap paste print anchor searchreplace code fullscreen media table",
        toolbar1: 'undo redo | cut copy paste pastetext searchreplace | removeformat print code fullscreen',
        toolbar2: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify alignnone | outdent indent | bullist numlist blockquote | subscript superscript | hr link unlink anchor',
        toolbar3: 'formatselect fontselect fontsizeselect | forecolor backcolor | image media table charmap',
        convert_urls: false,
        image_advtab: true,
        file_picker_callback: function (callback, value, meta) {
            tinymce.activeEditor.windowManager.open({
                title: '<?php echo $this->translate('file.files'); ?>',
                url: '<?php echo $this->routing->urlGenerator->generate('files_tinymce'); ?>',
                width: 650,
                height: 550,
            }, {
                oninsert: function (url) {
                    callback(url);
                }
            });
        }
    });
</script>

<label>
    <textarea name="content" rows="20"><?php echo $content ? $this->getData('content', $content->getId()) : ''; ?></textarea>
</label>