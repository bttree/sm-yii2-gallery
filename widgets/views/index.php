<?php

use yii\helpers\Html;

?>

<?php if($pictures): ?>
        <div id="<?= $id;?>" class="<?= $class;?>">

            <?php foreach ($pictures as $picture): ?>
                <?= Html::img($picture->getImageUrl(), ['width' => 60]);?>
            <?php endforeach; ?>

        </div>
<?php endif; ?>
