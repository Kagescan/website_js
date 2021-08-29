<?php

function generateTextPanel($text) {
	$text = wordwrap(esc($text), 55, "\n", true);
    $arrayOut = explode("\n", $text);
    $out = '<text y="100" font-size="16" class="center">';
    foreach ($arrayOut as $key => $line) {
        if (empty($line)) { // better than xml:space="preserve"
            $line = "<tspan fill='#00000000'>.</tspan>";
        }
        $out .= "<tspan x='50%' dy='". ($key == 0 ? '2' : '1.2') ."em'>". $line ."</tspan>\n";
    }
    $out .= "</text>";
    $out .= '<rect width="80%" height="0.3em" x="10%" y="100"  />';
    $out .= '<rect width="80%" height="0.3em" x="10%" y="'. (3.5 + (1.2 * (count($arrayOut)-1) )) .'em" transform="translate(0 100)"/>';
	return $out;
}

 ?>

<svg version="1.1" baseProfile="full" width="600" height="313" xmlns="http://www.w3.org/2000/svg">
<style>
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
		<?=esc($error)?>
        <tspan dx="0.2em" font-size="0.7em" font-weight="bold">/ <?=esc($title)?> /</tspan>
	</text>
</g>

<g fill="#782c33" font-family="Courier New">
    <?= generateTextPanel($text)?>
</g>

<text dominant-baseline="text-bottom" text-anchor="end" x="95%" y="95%" opacity="0.2">Kagescan-cms 2.0</text>
</svg>
