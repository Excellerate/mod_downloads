<?php

/**
 * Get friendly file size
 *
 * http://php.net/manual/en/function.filesize.phpuser contributed example
 */
function formatBytes($bytes, $decimals = 2) { 
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
