
<main>
<?php if (! empty($images) && is_array($images)) : ?>
<style>
    /*https://www.w3schools.com/css/tryit.asp?filename=trycss_table_fancy*/
    #table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #table td, #table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #table tr:nth-child(even){background-color: #f2f2f2;}

    #table tr:hover {background-color: #ddd;}

    #table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
    .successMsg {
        padding: 0.5em;
        margin: 0.5em;
        background: green;
        color: white;
        text-align: center;
    }
</style>
    <p><a href="<?=$backURL?>">Back to the menu</a></p>
    <?php
        if (!empty($successMsg)) {
            echo '<div class="successMsg">', esc($successMsg), '</div>';
        }
    ?>
    <table id="table">
        <caption>All images uploaded at this site.</caption>
        <thead>
            <tr>
                <th scope="col">Action</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Last edited</th>
                <th scope="col">Thumb</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($images as $image): ?>
            <tr>
                <td><a href="<?= $backURL?>delete/<?=esc($image['name'], "url")?>">Delete image</a></td>
                <td><?= esc($image['name']) ?></td>
                <td><?= esc($image['description']) ?></td>
                <td><?= esc($image['created_at']) ?></td>
                <td>
                    <a href="<?= $backURL?>view/<?=esc($image['name'], "url")?>" title="click to see full">
                        <img src="<?= $backURL?>thumb/<?=esc($image['name'], "url")?>" alt="<?=esc($image['alt'], "attr")?>">
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>

    <h3>No Images</h3>

    <p>Unable to find any images for you.</p>

    <p><a href="<?=$backURL?>">Back</a></p>
<?php endif ?>
</main>
