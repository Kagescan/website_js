
<main>
<?php if (! empty($images) && is_array($images)) : ?>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Preview</th><th>Description</th><th>Last edited</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($images as $image): ?>
            <tr>
                <td><?= esc($image['name']) ?></td>
                <td><img src="view/<?=esc($image['name'], "url")?>" alt="<?=esc($image['alt'], "attr")?>"></td>
                <td><?= esc($image['description']) ?></td>
                <td><?= esc($image['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>

    <h3>No Images</h3>

    <p>Unable to find any images for you.</p>

<?php endif ?>
</main>