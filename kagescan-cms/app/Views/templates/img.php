<h2><?= esc($title) ?></h2>

<?php if (! empty($images) && is_array($images)) : ?>

    <?php foreach ($images as $news_item): ?>

        <h3><?= esc($news_item['name']) ?></h3>
        <img src="view/<?=$news_item['name'] // todo : security?>" alt="<?=$news_item['alt'] // todo : security?>">
        <div class="main">
            <?= esc($news_item['description']) ?>
            <?= esc($news_item['upload_comment']) ?>
        </div>

    <?php endforeach; ?>

<?php else : ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>
