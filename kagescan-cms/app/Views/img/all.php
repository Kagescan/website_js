
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

    <table id="table">
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