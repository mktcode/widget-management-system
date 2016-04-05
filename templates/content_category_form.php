<?php
use App\Entity\ContentCategory;

include 'header.php';

/** @var ContentCategory $category */
$category = $vars['category'];
$categories = $vars['categories'];
?>
    <h1>
        <i class="uk-icon-folder"></i>
        Kategorie
    </h1>

    <form action="" method="post" class="uk-form">
        <label class="uk-margin-bottom uk-display-block">
            <input type="text" name="name" class="uk-form-large uk-width-1-1"
                   style="font-size: 24px; line-height: 26px;"
                   placeholder="Name eingeben..."
                   value="<?php if ($category) {
                       echo $category->getName();
                   } ?>" required/>
        </label>

        <?php
        if (count($categories) && (!$category || $categories[0]->getId() != $category->getId())) {
            ?><label class="uk-margin-bottom uk-display-block">
            Elternkategorie<br>
            <select name="parent" class="uk-form-large uk-width-1-1">
                <option value=""></option>
                <?php
                /** @var ContentCategory $cat */
                foreach ($categories as $cat) {
                    if ($category && ($cat->getId() == $category->getId() || ($cat->getParent() && $cat->getParent(
                                )->getId() != $category->getId()))
                    ) {
                        continue;
                    }
                    $selected = $category && $category->getParent() && $cat->getId() == $category->getParent()->getId();
                    ?>
                    <option value="<?php echo $cat->getId(); ?>"<?php if ($selected) {
                        echo ' selected="selected"';
                    } ?>><?php echo $cat->getName(); ?></option><?php
                }
                ?>
            </select>
            </label><?php
        }
        ?>

        <button type="submit" class="uk-button uk-button-success uk-margin-top uk-margin-top">
            <i class="uk-icon-check"></i>
            Speichern
        </button>
    </form>

<?php include 'footer.php'; ?>