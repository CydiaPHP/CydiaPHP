<?php 

	$oldLayout = [
		"http://apt.thebigboss.org/repofiles/cydia/",
		"http://apt.modmyi.com/",
		"http://cydia.zodttd.com/repo/cydia/",
		"http://apt.saurik.com/"
	];

	if (in_array($_GET['repo'], $oldLayout)) {
		echo "Yeah its there";
	} else {
		echo "Nah bruh.";
	}
?>