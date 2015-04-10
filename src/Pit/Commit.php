<?

namespace Pit;

class Commit {
	public $hash;
	private $comment;

	public function __construct($tree, $message = '') {
		$path = Git::path_from_hash($tree);

		if (!file_exists($path)) {
			throw new Exception("Invalid tree: {$tree}");
		}

		if (!strlen($message)) {
			throw new Exception("Message required for commit");
		}

		$config = parse_ini_file(ROOT_DIR.Git::CONFIG_PATH);
		$name   = $config['name'];
		$email  = $config['email'];

		$timestamp = time();
		$commit  = "tree {$tree}\n";
		$commit .= "author {$name} <{$email}> {$timestamp} -0700\n";
		$commit .= "committer {$name} <{$email}> {$timestamp} -0700\n";
		$commit .= "\n";
		$commit .= $message;

		$this->hash   = sha1($commit);
		$this->commit = $commit;
	}

	public function write() {
		$path = Git::path_from_hash($this->hash);
		@mkdir(dirname($path), 0777, true);

		file_put_contents($path, $this->commit);
	}
}