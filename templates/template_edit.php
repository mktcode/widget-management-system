<?php
include 'header.php';
?>
    <h1>Template bearbeiten</h1>
    <h2>
        <?php echo '/' . $vars['file']; ?>
    </h2>

    <form class="uk-form" method="post" action="<?php echo $this->getUrl('template_edit', ['file' => $vars['file']]); ?>">
        <button type="submit" class="uk-button uk-button-success uk-margin-top uk-margin-bottom">
            <i class="uk-icon-check"></i>
            Speichern
        </button>
        <label>
            <textarea id="file" name="file"><?php echo $vars['content']; ?></textarea>
        </label>
        <button type="submit" class="uk-button uk-button-success uk-margin-top uk-margin-bottom">
            <i class="uk-icon-check"></i>
            Speichern
        </button>
    </form>

    <script>
        var mixedMode = {
            name: "htmlmixed",
            scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                mode: null},
                {matches: /(text|application)\/(x-)?vb(a|script)/i,
                    mode: "vbscript"}]
        };
        var editor = CodeMirror.fromTextArea(document.getElementById("file"), {
            mode: mixedMode,
            selectionPointer: true,
            lineNumbers: true
        });
    </script>

<?php include 'footer.php'; ?>