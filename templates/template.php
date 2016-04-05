<?php
include 'header.php';
?>
    <h1>Templates</h1>
    <h2>
        <a class="uk-button" href="<?php echo $this->getUrl('template'); ?>">/</a>
        <?php
        $path = '';
        foreach (array_filter(explode('/', $vars['dir'])) as $subdir) {
            $path .= '/' . $subdir;
            ?><a class="uk-button"href="<?php echo $this->getUrl(
                'template',
                ['dir' => trim($path, '/')]
            ); ?>"><?php echo $subdir; ?></a> <?php
        }
        ?>
    </h2>
    <table class="uk-table uk-table-hover uk-margin-large-top">
        <tr>
            <th>
                Datei
            </th>
            <th>
                Typ
            </th>
            <th></th>
        </tr>
        <?php
        /** @var Symfony\Component\Finder\SplFileInfo $file */
        foreach ($vars['finder'] as $file) {
            ?>
            <tr>
            <td>
                <?php
                if ($file->isDir()) {
                    ?><ahref="<?php echo $this->getUrl(
                        'template',
                        ['dir' => trim($vars['dir'] . '/' . $file->getRelativePathname(), '/')]
                    ) ?>" class="uk-button uk-width-1-1 uk-text-left"><i
                        class="uk-icon-folder-o"></i> <?php echo $file->getRelativePathname(); ?></a> <?php
                } else {
                    ?><span style="padding: 0 12px; line-height: 30px;"><i
                        class="uk-icon-file-code-o"></i> <?php echo $file->getRelativePathname(); ?></span> <?php
                }
                ?>
            </td>
            <td style="width: 50px; line-height: 30px;">
                <?php echo $file->getExtension(); ?>
            </td>
            <td class="uk-text-right" style="width: 80px;">
                <a href="<?php echo $this->getUrl(
                    'template_edit',
                    ['file' => trim($vars['dir'] . '/' . $file->getRelativePathname(), '/')]
                ) ?>"
                   class="uk-button uk-button-success" data-uk-tooltip title="Template bearbeiten">
                    <i class="uk-icon-edit"></i>
                </a>
                <a href="#" class="uk-button uk-button-danger"  data-uk-tooltip title="Template löschen">
                    <i class="uk-icon-trash"></i>
                </a>
            </td>
            </tr><?php
        }
        ?>
    </table>

<?php include 'footer.php'; ?>