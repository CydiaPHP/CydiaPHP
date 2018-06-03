<?php 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	use \wapmorgan\UnifiedArchive\UnifiedArchive;
	require 'vendor/autoload.php';

	/**
	 * APT Repository Viewer
	 */

	$GLOBALS['oldLayout'] = [
		"http://apt.thebigboss.org/repofiles/cydia/",
		"http://apt.modmyi.com/",
		"http://cydia.zodttd.com/repo/cydia/",
		"http://apt.saurik.com/"
	];

	class APT {

		protected $glob;

	    public function __construct() {
	        global $GLOBALS;
	        $this->glob =& $GLOBALS;
	    }

		private function downloadFile($url, $module) {
		    if ($module == "Telesphoreo") {
		    	$ch = curl_init();
		    	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		    	curl_setopt($ch, CURLOPT_HEADER, 0);
		    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    	curl_setopt($ch, CURLOPT_URL, $url);
		    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		    	  "Accept: */*",
		    	  "Accept-Language: en-us",
		    	  "Accept-Encoding: gzip, deflate",
		    	  "User-Agent: Telesphoreo APT-HTTP/1.0.592",
		    	  "X-Machine: iPhone10,6",
		    	  "X-Firmware: 11.1.2",
		    	  "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
		    	]);
		    	$data = curl_exec($ch);
		    	curl_close($ch);

		    	return $data;
		    } elseif ($module = "Cydia") {
		    	$ch = curl_init();

		    	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		    	curl_setopt($ch, CURLOPT_HEADER, 0);
		    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    	curl_setopt($ch, CURLOPT_URL, $url);
		    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		    	  "Accept: */*",
		    	  "Accept-Language: en-us",
		    	  "Accept-Encoding: gzip, deflate",
		    	  "User-Agent: Cydia/0.9 CFNetwork/548.1.4 Darwin/11.0.0",
		    	  "X-Machine: iPhone10,6",
		    	  "X-Firmware: 11.1.2",
		    	  "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
		    	]);

		    	$data = curl_exec($ch);
		    	curl_close($ch);

		    	return $data;
		    } else {
		    	$ch = curl_init();

		    	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		    	curl_setopt($ch, CURLOPT_HEADER, 0);
		    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    	curl_setopt($ch, CURLOPT_URL, $url);
		    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		    	$data = curl_exec($ch);
		    	curl_close($ch);

		    	return $data;
		    }
		}

		private function GetBetween($content,$start,$end){
		    $r = explode($start, $content);
		    if (isset($r[1])){
		        $r = explode($end, $r[1]);
		        return $r[0];
		    }
		    return '';
		}

		private function URLToFilename($url) {
			if(substr($url, -1) == '/') {
			    $url = substr($url, 0, -1);
			}
			$unwanted  = array('http://', 'www.', '/');
		    $replacement = array('', '', '_');
		    return str_replace($unwanted, $replacement, $url);
		}

		private function repoExistance($repo, $module) {
			echo $repo;
			echo "<br>";
			// if ($module == "Telesphoreo") {
			// 	$ch = curl_init();
			// 	curl_setopt($ch, CURLOPT_URL, $repo);
			// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// 	curl_setopt($ch, CURLOPT_HTTPHEADER, [
			// 	  "Accept: */*",
			// 	  "Accept-Language: en-us",
			// 	  "Accept-Encoding: gzip, deflate",
			// 	  "User-Agent: Telesphoreo APT-HTTP/1.0.592",
			// 	  "X-Machine: iPhone10,6",
			// 	  "X-Firmware: 11.1.2",
			// 	  "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
			// 	]);

			// 	$response = curl_exec($ch);

			// 	$HTTPStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// 	echo curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// 	curl_close($ch);

			// 	if ($HTTPStatusCode == 200 || $HTTPStatusCode == 302) {
			// 		return true;
			// 	} else {
			// 		return false;
			// 	}
			// } elseif ($module == "Cydia") {
			// 	$ch = curl_init();
			// 	curl_setopt($ch, CURLOPT_URL, $repo);
			// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// 	curl_setopt($ch, CURLOPT_HTTPHEADER, [
			// 	  "Accept: */*",
			// 	  "Accept-Language: en-us",
			// 	  "Accept-Encoding: gzip, deflate",
			// 	  "User-Agent: Cydia/0.9 CFNetwork/548.1.4 Darwin/11.0.0",
			// 	  "X-Machine: iPhone10,6",
			// 	  "X-Firmware: 11.1.2",
			// 	  "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
			// 	]);

			// 	$response = curl_exec($ch);

			// 	$HTTPStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// 	curl_close($ch);

			// 	if ($HTTPStatusCode == 200 || $HTTPStatusCode == 302) {
			// 		return true;
			// 	} else {
			// 		return false;
			// 	}
			// } else {
			// 	$ch = curl_init();
			// 	curl_setopt($ch, CURLOPT_URL, $repo);
			// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// 	curl_setopt($ch, CURLOPT_HTTPHEADER, [
			// 	  "Accept: */*",
			// 	  "Accept-Language: en-us",
			// 	  "Accept-Encoding: gzip, deflate"
			// 	]);

			// 	$response = curl_exec($ch);

			// 	$HTTPStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// 	curl_close($ch);

			// 	if ($HTTPStatusCode == 200 || $HTTPStatusCode == 302) {
			// 		return true;
			// 	} else {
			// 		return false;
			// 	}
			// }
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $repo);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
			  "Accept: */*",
			  "Accept-Language: en-us",
			  "Accept-Encoding: gzip, deflate",
			  "User-Agent: Telesphoreo APT-HTTP/1.0.592",
			  "X-Machine: iPhone10,6",
			  "X-Firmware: 11.1.2",
			  "X-Unique-ID: 10aded70015040b4d455c1a551c411cec01ddeb5"
			]);

			$response = curl_exec($ch);

			$HTTPStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			echo curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);

			if ($HTTPStatusCode == 200 || $HTTPStatusCode == 302) {
				return true;
			} else {
				return false;
			}
		}

		private function downloadIcon($repo) {

			$iconURL = "";

			if ($repo == "http://apt.saurik.com/") {
                $iconURL = $repo."dists/ios/CydiaIcon.png";
			} elseif (in_array($repo, $this->glob['oldLayout'])) {
                $iconURL = $repo."dists/stable/CydiaIcon.png";
			} else {
                $iconURL = $repo."CydiaIcon.png";
			}

            if ($this->repoExistance($iconURL, "Cydia")) {
                $icon = $this->downloadFile($iconURL, "Cydia");
                $filename = $this->URLToFilename($repo);
                file_put_contents("repos/$filename.png", $icon);
            }
		}

		private function downloadRelease($repo) {
			// http://apt.thebigboss.org/repofiles/cydia/
			$label = "";
			$releaseURL = "";

			if ($repo == "http://apt.saurik.com/") {
                $releaseURL = $repo."dists/ios/Release";
			} elseif (in_array($repo, $this->glob['oldLayout'])) {
                $releaseURL = $repo."dists/stable/Release";
			} else {
                $releaseURL = $repo."Release";
			}

            if ($this->repoExistance($releaseURL, "Telesphoreo")) {
                $label = $this->GetBetween($this->downloadFile($releaseURL, "Telesphoreo"), "Label:", "\n");
                $pos = strpos($label, " ");
                if ($pos !== false) {
                    $label = substr_replace($label, "", $pos, strlen(" "));
                }

                return $label;
            } else {
            	return "Failed to fetch Release";
            }
		}

		public function reloadData() {

			$allRepos = explode("\n", file_get_contents("cydia.repos"));

			foreach ($allRepos as $repo_key => $repo) {
				$packagesURL = "";
				$isBZ2Archive = true;

				$repoInfo = explode(" : ", $repo);
				print_r($repoInfo);
				$repoInfo = [
					"name" => $repoInfo[1],
					"url" => $repoInfo[0]
				];
				echo "<br>";
				print_r($repoInfo);

				if ($repoInfo['url'] == "http://apt.saurik.com/") {
                    $packagesURL = $repoInfo['url']."dists/ios/main/binary-iphoneos-arm/Packages.bz2";
				} elseif (in_array($repoInfo['url'], $this->glob['oldLayout'])) {
					$packagesURL = $repoInfo['url']."dists/stable/main/binary-iphoneos-arm/Packages.bz2";
                } else {
                    $packagesURL = $repoInfo['url']."Packages.bz2";
                    if (!$this->repoExistance($packagesURL, "Telesphoreo")) {
                        $packagesURL = $repoInfo['url']."Packages.gz";
                        $isBZ2Archive = false;
                    }
                }

                if (!$this->repoExistance($packagesURL, "Telesphoreo")) {
                	return "Line 256";
                }

                $filename = "Packages".($isBZ2Archive ? ".bz2" : ".gz");
                echo $filename;

                if (!file_exists('repos/'.str_replace("/", "_", $repoInfo['name']))) {
                    mkdir('repos/'.str_replace("/", "_", $repoInfo['name']), 0777);
                }

                if (file_put_contents('repos/'.str_replace("/", "_", $repoInfo['name']).'/'.$filename, $this->downloadFile($packagesURL, "Telesphoreo"))) {

                } else {
                	return "Line 269";
                }

                $archive = UnifiedArchive::open('repos/'.str_replace("/", "_", $repoInfo['name']).'/'.$filename);

                // var_dump($archive->getFileNames());

                $archive->extractFiles('repos/'.str_replace("/", "_", $repoInfo['name']).'/');

                if (file_exists('repos/'.str_replace("/", "_", $repoInfo['name']).'/Packages') || file_exists('repos/'.str_replace("/", "_", $repoInfo['name']).'/PACKAGES') || file_exists('repos/'.str_replace("/", "_", str_replace("/", "_", $repoInfo['name'])).'/packages')) {

                	$filePath = "";

                	if (file_exists('repos/'.str_replace("/", "_", $repoInfo['name']).'/Packages')) {
                		$filePath = 'repos/'.str_replace("/", "_", $repoInfo['name']).'/Packages';
                	} elseif (file_exists('repos/'.str_replace("/", "_", $repoInfo['name']).'/PACKAGES')) {
                		$filePath = 'repos/'.str_replace("/", "_", $repoInfo['name']).'/PACKAGES';
                	} elseif (file_exists('repos/'.str_replace("/", "_", $repoInfo['name']).'/packages')) {
                		$filePath = 'repos/'.str_replace("/", "_", $repoInfo['name']).'/packages';
                	} else {
                		// how the f*ck did you make it here when the you don't even exist LMFAO!
                		return "Line 290";
                	}

                	$packagesCount = 0;

                	$handle = @fopen($filePath, "r");
                	if ($handle) {
                	    while (($buffer = fgets($handle, 4096)) !== false) {
                	        // echo $buffer;
                	        $packages = explode("\n\n", $buffer);
                	        $packagesCount = $packagesCount + count($packages);
                	        $packages = "";
                	    }
                	    fclose($handle);
                	} else {
                		return "Line 305";
                	}

                	$allRepos[$repo_key] = $repoInfo['url']." : ".$repoInfo['name']." : ".$packagesCount;

                	file_put_contents("cydia.repos", implode("\n", $allRepos));
                } else {
                	return "Line 312";
                }

                unlink('repos/'.str_replace("/", "_", $repoInfo['name']).'/'.$filename);
			}
		}

		private function parsePackages($packages) {
			if (file_exists($packages)) {
				
			} else {
				return false;
			}

			$packagesArray = array();

			$handle = @fopen($packages, "r");
			if ($handle) {
			    while (($buffer = fgets($handle, 4096)) !== false) {
			        // echo $buffer;
			        array_push($packagesArray, explode("\n\n", $buffer));
			    }
			    fclose($handle);
			} else {
				return false;
			}

			foreach ($packagesArray as $package_key => $package) {
				$packageInfoArray = explode("\n", $package);
				$packageInformation = array();
				foreach ($packageInfoArray as $package_key => $packageInfo) {
					$packageInfo = explode(":", $packageInfo);
					$variable = strtolower($packageInfo[0]);
					$value = $packageInfo[1];
					$packageInformation[$variable] = $value;
				}
				$packageName = $packageInformation['name'];
				$pos = strpos($packageName, " ");
				if ($pos !== false) {
				    $packageName = substr_replace($packageName, "", $pos, strlen(" "));
				}

				$packagesArray[$packageName] = $packageInformation;
			}

		}

	}

?>