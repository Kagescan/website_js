
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
</style>
    <p><a href="<?=$backURL?>">Back</a></p>
    <table id="table">
        <caption>All images uploaded at this site.</caption>
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Last edited</th>
                <th scope="col">Thumb</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($images as $image): ?>
            <tr>
                <td><?= esc($image['name']) ?></td>
                <td><?= esc($image['description']) ?></td>
                <td><?= esc($image['created_at']) ?></td>
                <td>
                    <a href="./view/<?=esc($image['name'], "url")?>" title="click to see full">
                        <img src="./thumb/<?=esc($image['name'], "url")?>" alt="<?=esc($image['alt'], "attr")?>">
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
