<?php

use App\ContentType\ContentType;
use App\Entity\Content;

include 'header.php';
?>
    <div class="uk-text-center">
        <a href="<?php echo $this->getUrl('content_types'); ?>"
           class="uk-button uk-button-success uk-button-large button-huge">
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
            /** @var ContentType $contentType */
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
                <a href="<?php echo $this->getUrl('content_form', ['contentTypeId' => $content->getType(), 'contentId' => $content->getId()]); ?>"
                   class="uk-button uk-button-success"><i class="uk-icon-edit"></i></a>
                <a href="<?php echo $this->getUrl('content_delete', ['contentId' => $content->getId()]); ?>"
                   class="open-delete-modal uk-button uk-button-danger"><i class="uk-icon-trash"></i></a>
            </td>
            </tr><?php
        }
        ?>
    </table>

    <div id="delete-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>

            <div class="uk-modal-header">
                <h2><i class="uk-icon-trash-o"></i> Löschen bestätigen</h2>
            </div>
            Möchten Sie diesen Inhalt wirklich löschen?
            <div class="uk-modal-footer">
                <a href="#" class="uk-button uk-button-danger uk-modal-close">
                    <i class="uk-icon-times"></i>
                    Nein!
                </a>
                <a href="#" class="uk-button uk-button-success uk-float-right">
                    <i class="uk-icon-check"></i>
                    Ja, jetzt löschen!
                </a>
            </div>
        </div>
    </div>

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

<?php include 'footer.php'; ?>