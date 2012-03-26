<?php

$error_map = array(
	UPLOAD_ERR_INI_SIZE   => "The uploaded file exceeds the maximum allowed size of " . ini_get('upload_max_filesize') . " bytes",
	UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded.",
	UPLOAD_ERR_NO_FILE    => "No file was uploaded.",
	UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
	UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
);

$params = array();
if (isset($_FILES['import'])) {
	if ($_FILES['import']['error'] === 0) {
		$file = $_FILES['import']['tmp_name'];
		
		// This simulates processing the file asynchronously.
		$base_dir = dirname(__DIR__);
		$output = shell_exec("php {$base_dir}/normalize.php < {$file}");

		if ($output) {
			$params['error'] = $output;
		} else {

			// Revenue calculation could happen in the same step as normalization
			// but it is a bit cleaner, though less efficient, to make it a 
			// separate step. It should also occur as part of an asynchronous 
			// workflow.
			$params['revenue'] = shell_exec("awk -F t 'NR>1 {sum += $3 * $4} END {printf \"%.2f\", sum}' {$file}");

		}
	} else {
		$params['error'] = $error_map[$_FILES['import']['error']];
	}
} else {
	$params['error'] = $error_map[UPLOAD_ERR_NO_FILE];
}

header('Location: import_complete.php?' . http_build_query($params));
