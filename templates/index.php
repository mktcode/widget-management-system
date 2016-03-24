<?php

use App\Entity\Content;

include 'header.php';
?>
    <div class="uk-text-center">
        <a href="<?php echo $this->getUrl('content_types'); ?>" class="uk-button uk-button-success uk-button-large button-huge">
            <i class="uk-icon-plus"></i>
            Neuer Inhalt
        </a>
    </div>
    <table class="uk-table uk-table-striped uk-table-hover uk-margin-large-top">
        <tr>
            <th width="15"></th>
            <th>
                Titel
                <i class="uk-icon-question-circle" data-uk-tooltip
                   title="Der Titel wird im Template nicht angezeigt. Er dient nur der internen Bezeichnung von Inhalten."></i>
            </th>
            <th>
                Snippet
                <i class="uk-icon-question-circle" data-uk-tooltip
                   title="Das Snippet muss im Template eingefügt werden. An dieser Stelle erscheint dann der Inhalt."></i>
            </th>
            <th></th>
        </tr>
        <?php
        /** @var Content $content */
        foreach ($vars['contents'] as $content) {
            $contentType = $this->services->get($content->getType());
            ?>
            <tr>
            <td>
                <?php
                if ($contentType->getIcon()) {
                    ?><i class="uk-icon-<?php echo $contentType->getIcon(); ?>"></i><?php
                }
                ?>
            </td>
            <td><?php echo $content->getTitle(); ?></td>
            <td><input class="snippet-input" onclick="this.select();"
                       value="&lt;!--<?php echo $content->getHash(); ?>--&gt;"/></td>
            <td class="uk-text-right">
                <a href="<?php echo $this->getUrl('content_types', ['id' => $content->getId()]); ?>" class="uk-button uk-button-success"><i class="uk-icon-edit"></i></a>
                <a href="#" class="uk-button uk-button-danger"><i class="uk-icon-trash"></i></a>
            </td>
            </tr><?php
        }
        ?>
    </table>

<?php include 'footer.php'; ?>