<label>
    <textarea id="content" name="content" rows="20"><?php echo $content ? $this->getData('content', $content->getId()) : ''; ?></textarea>

    <script>
        var mixedMode = {
            name: "htmlmixed",
            scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                mode: null},
                {matches: /(text|application)\/(x-)?vb(a|script)/i,
                    mode: "vbscript"}]
        };
        var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
            mode: mixedMode,
            selectionPointer: true,
            lineNumbers: true
        });
    </script>
</label>