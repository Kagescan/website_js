<?php

function wrap($text) {
	$text = wordwrap(esc($text), 42, "\n", true);
	$out = "";
	// todo : finish this.
	return $out;
}

 ?>

<svg version="1.1" baseProfile="full" width="600" height="313" xmlns="http://www.w3.org/2000/svg">
<style>
text {

}
.center {
	dominant-baseline: middle;
	text-anchor: middle;
}
.lb {
	width: 10em; height: 1.2em;

	 overflow: hidden;
	 text-overflow: ellipsis;
}
</style>

<rect width="100%" height="100%" fill="#84b89e" />

<g fill="#b93358" font-family="Helvetica, sans-serif">
	<text x="50%" y="50px" font-size="65" font-weight="bold" class="center">
		404
		<tspan dx="0.2em" font-size="0.7em" font-weight="bold">/ Not found /</tspan>
	</text>
</g>
<g fill="#782c33" font-family="Courier New">
<text y="100" font-size="16" class="center">
	<tspan x="50%">▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬</tspan>
	<tspan x="50%" dy="2em">The image [redbeansoup] is registered in the database,</tspan>
	<tspan x="50%" dy="1.2em">but physically unavailable in the storage. </tspan>
	<tspan x="50%" dy="1.2em">This should not happen !</tspan>

	<tspan x="50%" dy="1.2em"></tspan>
	<tspan x="50%" dy="2em">▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬</tspan>
	<!-- <tspan><?= esc($title)?></tspan> -->
	<!-- <tspan x="10" y="45"><?= esc($description)?></tspan> -->
</text>
</g>

<text dominant-baseline="text-bottom" text-anchor="end" x="95%" y="95%" opacity="0.2">Kagescan-cms 2.0</text>
</svg>
