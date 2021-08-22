<?= \Config\Services::validation()->listErrors() ?>

<h3>Upload Image</h3>

<p>This is a basic upload feature, that supports actually only one image.</p>

<p>It's possible to override an image</p>

<form action="<?=$backURL?>upload" method="POST"  enctype="multipart/form-data">
    <?= csrf_field() ?>

	<label for="image">Insert image</label>
	<input type="file" name="image" /> <br>

	<label for="name">Image identifier (default is filename)</label>
    <input type="text" name="name" value="" /> <br>

    <label for="alt">Short description (alt tag)</label>
    <input type="text" name="alt" value="" /> <br>

    <label for="description">Complete description (context)</label>
    <input type="text" name="description" value="" /> <br>

    <label for="upload_comment">An optional <em>commit message</em>.</label>
    <input type="text" name="upload_comment" value="" /> <br>

    <input type="submit" name="submit" value="Upload" />

    <!-- TODO : dynamic validation -->
</form>

<p><a href="<?=$backURL?>">Back</a></p>
