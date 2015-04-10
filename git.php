<?
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once('vendor/autoload.php');

define('ROOT_DIR', '/Users/brianseitel/Code/php-git');

$null   = $argv[0];
$action = null;
$file   = null;

if (isset($argv[1])) {
	$action = $argv[1];
} else {
	throw new Exception("Action is required.");
}

switch ($action) {
	case "init": \Pit\Git::init("Brian Seitel", "brianseitel@gmail.com"); break;
	case "hash": 
		$blob = new \Pit\Blob($argv[1]);
		echo $blob->hash;
		break;
	case "hash-write":
		$blob = new \Pit\Blob($argv[1]);
		$blob->write();
		break;
	case "cat": \Pit\Git::cat_file($argv[2]); break;
	case "add":
		$file = $argv[2];
		$tree = new \Pit\Tree($file);
		$tree->write();
		$blob = new \Pit\Blob($file);
		$blob->write();
		break;
	case "commit":
		$tree    = $argv[2];
		$message = $argv[3];
		$commit  = new \Pit\Commit($tree, $message);
		$commit->write();
		break;
	default: pd("Invalid action.");
}


function pd($a) {
	die(print_r($a,1)."\n\n");
}