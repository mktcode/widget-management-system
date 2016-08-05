<?php
include 'header_popup.php';

/*
?>
    <div class="uk-text-center <?php if (!$vars['dir'] && !$vars['finder']->count()) {
        echo ' uk-margin-large-top';
    } ?>">
        <a href="<?php echo $this->getUrl('files'); ?>"
           class="uk-button uk-button-success uk-button-large button-huge<?php echo !$vars['dir'] && !$vars['finder']->count(
           ) ? ' button-enormous' : ''; ?> uk-width-1-1">
            <i class="uk-icon-plus"></i>
            <?php echo $this->translate('file.new_file'); ?>
        </a>
    </div>
    <div class="uk-text-center">
        <a href="<?php echo $this->getUrl('files'); ?>"
           class="uk-button uk-button-success uk-button-large<?php echo !$vars['dir'] && !$vars['finder']->count(
           ) ? ' button-huge' : ''; ?> uk-margin-top uk-width-1-1">
            <i class="uk-icon-plus"></i>
            <?php echo $this->translate('file.new_folder'); ?>
        </a>
    </div>
<?php
*/

if ($vars['dir'] || $vars['finder']->count()) {
    if ($vars['dir']) {
        ?><a class="uk-button uk-margin-small-top" href="<?php echo $this->getUrl('files_tinymce'); ?>">/</a> <?php
    }

    $path = '';
    $subdirs = array_filter(explode('/', $vars['dir']));
    foreach ($subdirs as $subdir) {
        $path .= '/' . $subdir;
        if (end($subdirs) !== $subdir) {
            ?><a class="uk-button uk-margin-small-top" href="<?php echo $this->getUrl(
                'files_tinymce',
                ['dir' => trim($path, '/')]
            ); ?>"><?php echo $subdir; ?></a> <?php
        } else {
            echo '<button class="uk-button uk-margin-small-top" disabled>' . $subdir . '</button>';
        }
    }
    ?>
    <table class="uk-table uk-table-hover">
        <tr>
            <th>
                <?php echo $this->translate('file.table.columns.file'); ?>
            </th>
            <th style="width: 40px;">
                <?php echo $this->translate('file.table.columns.type'); ?>
            </th>
            <th style="width: 40px;"></th>
        </tr>
        <?php
        /** @var Symfony\Component\Finder\SplFileInfo $file */
        foreach ($vars['finder'] as $file) {
            ?>
            <tr>
            <td>
                <?php
                if ($file->isDir()) {
                    ?>
                    <a href="<?php echo $this->getUrl(
                        'files_tinymce',
                        ['dir' => trim($vars['dir'] . '/' . $file->getRelativePathname(), '/')]
                    ) ?>" class="uk-button uk-width-1-1 uk-text-left"><i
                            class="uk-icon-folder-o"></i> <?php echo $file->getRelativePathname(); ?></a> <?php
                } else {
                    ?><span style="padding: 0 12px; line-height: 30px;"><i
                        class="uk-icon-file-code-o"></i> <?php echo $file->getRelativePathname(); ?></span> <?php
                }
                ?>
            </td>
            <td style="line-height: 30px;">
                <?php echo strtoupper($file->getExtension()); ?>
            </td>
            <td class="uk-text-right">
                <?php
                if (!$file->isDir()) {
                    ?>
                <a href="javascript:submitFile('<?php echo 'http://' . $_SERVER['HTTP_HOST'] . ($vars['dir'] ? '/' . $vars['dir'] : '') . '/' . $file->getFilename(); ?>');"
                   class="uk-button uk-button-success"
                   data-uk-tooltip title="<?php echo $this->translate('file.paste'); ?>">
                        <i class="uk-icon-paste"></i>
                    </a><?php
                }

                /*
                <a href="<?php echo $this->getUrl(
                    'file_delete',
                    ['file' => trim($vars['dir'] . '/' . $file->getRelativePathname(), '/')]
                ); ?>"
                   class="open-delete-modal uk-button uk-button-danger"
                   data-uk-tooltip title="<?php echo $this->translate('file.delete'); ?>">
                    <i class="uk-icon-trash"></i>
                </a>
                */

                ?>
            </td>
            </tr><?php
        }
        ?>
    </table>

    <?php
    /*
    <div id="delete-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>

            <div class="uk-modal-header">
                <h2><i class="uk-icon-trash-o"></i> <?php echo $this->translate('file.delete.title'); ?></h2>
            </div>
            <?php echo $this->translate('file.delete.text'); ?>
            <div class="uk-modal-footer">
                <a href="#" class="uk-button uk-button-danger uk-modal-close">
                    <i class="uk-icon-times"></i>
                    <?php echo $this->translate('content.delete.cancel'); ?>
                </a>
                <a href="#" class="uk-button uk-button-success uk-float-right">
                    <i class="uk-icon-check"></i>
                    <?php echo $this->translate('content.delete.confirm'); ?>
                </a>
            </div>
        </div>
    </div>
    */
    ?>
<?php
}

/*
?>
    <script>
        $(function () {
            var modal = UIkit.modal("#delete-modal"),
                successButton = modal.find('.uk-button-success');

            $('.open-delete-modal').click(function (e) {
                e.preventDefault();

                successButton.attr('href', this.href);
                modal.show();
            });
        });
    </script>

<?php
*/

?>
<script type="text/javascript">
    function submitFile(url) {
        top.tinymce.activeEditor.windowManager.getParams().oninsert(url);
        top.tinymce.activeEditor.windowManager.close();
    }
</script>
<?php

include 'footer.php';