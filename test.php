<?php 
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include 'apt.class.php';
	// use Mishak\ArchiveTar\Reader;
	// use \wapmorgan\UnifiedArchive\UnifiedArchive;
	// require 'vendor/autoload.php';

	$APT = new APT();

	// var_dump($APT->reloadData());

	// $zippy = Zippy::load();

	// $archive = $zippy->open('repos/BigBoss/Packages.tar.bz2');

	// $archive->extract('repos/BigBoss/');

	// $filename = 'repos/Cydia_Telesphoreo/Packages.bz2';
	// $archive = UnifiedArchive::open($filename);
	// // var_dump($archive->getFileNames());
	// // echo "<br>";
	// // var_dump($archive->getFileData('Packages'));
	// $archive->extractFiles('repos/Cydia_Telesphoreo/');

	// copy('repos/Cydia_Telesphoreo/Packages', 'repos/Cydia_Telesphoreo/Packages2.bz2');
	// $filename = 'repos/Cydia_Telesphoreo/Packages2.bz2';
	// $archive = UnifiedArchive::open($filename);
	// // var_dump($archive->getFileNames());
	// // echo "<br>";
	// // var_dump($archive->getFileData('Packages'));
	// $archive->extractFiles('repos/Cydia_Telesphoreo/');
?>
<pre><?php print_r($APT->loadRepos()); ?></pre>
<?php

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://apt.thebigboss.org/repofiles/cydia/');
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//   "Accept: */*",
//   "Accept-Language: en-us",
//   "Accept-Encoding: gzip, deflate",
//   "User-Agent: Telesphoreo APT-HTTP/1.0.592",
//   "X-Machine: iPhone10,6",
//   "X-Firmware: 11.1.2",
//   "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
// ]);
// $response = curl_exec($ch);

// echo 'HTTP Status Code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . PHP_EOL;
// echo 'Response Body: ' . $response . PHP_EOL;

// curl_close($ch);

// $repo = "http://apt.thebigboss.org/repofiles/cydia/";

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $repo);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//   "Accept: */*",
//   "Accept-Language: en-us",
//   "Accept-Encoding: gzip, deflate",
//   "User-Agent: Telesphoreo APT-HTTP/1.0.592",
//   "X-Machine: iPhone10,6",
//   "X-Firmware: 11.1.2",
//   "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
// ]);

// $response = curl_exec($ch);

// $HTTPStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// echo curl_getinfo($ch, CURLINFO_HTTP_CODE);

// curl_close($ch);

// if ($HTTPStatusCode == 200 || $HTTPStatusCode == 302) {
// 	return true;
// } else {
// 	return false;
// }


?>