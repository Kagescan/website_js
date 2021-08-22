
{if $src !== ">"}
    <p> Upload complete (image ID : <span style="font-family: monospace">{src}</span>) <br>
        If everything went well, you should see the original picture and the thumbnail below.</p>

    <img src="{backURL}thumb/{src}" class="noOverflow" alt="{src} thumbnail">
    <img src="{backURL}view/{src}" class="noOverflow" alt="{src} full size image">
{else}
    <p>This page is meant to be used after an upload.</p>
{endif}


<p><a href="{backURL}">Go back</a> or <a href="{backURL}upload">Upload again</a></p>
