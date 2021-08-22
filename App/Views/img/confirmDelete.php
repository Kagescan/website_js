
{if $src === ">"}
    <p>No image provided !</p>
    <a href="{backURL}all">Go back to uploaded images</a>
{elseif $imageDontExists}
    <p>The image <span class="mono">{src}</span> don't exists in the database</p>
    <a href="{backURL}all">Go back to uploaded images</a>
{else}
    {+ validation_errors +}

    <p>Are you sure to delete the image <span class="mono">{src}</span>?</p>

    <p><em>(note : the server owner can still recover the image if they haven't purged their trash)</em></p>

    <a href="{backURL}view/{src}">
        <img src="{backURL}thumb/{src}" class="noOverflow" alt="{src} thumbnail">
    </a>

    <form action="{backURL}delete/{src}" method="POST"  enctype="multipart/form-data">
        <input type="submit" name="confirm" value="Yes, delete" />
        <a href="{backURL}all">No, go back !</a>
    </form>
{endif}
