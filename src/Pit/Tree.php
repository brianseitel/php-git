<?

namespace Pit;

class Tree {
	public $hash;
	private $contents;

	public function __construct($file) {
		if (!is_file($file)) {
			throw new Exception("File missing: {$file}");
		}

		$hash        = (new Blob($file))->hash;
		$permissions = "100644"; // normal files
		$filename    = basename($file);

		$tree_contents = "{$permissions} blob {$hash} {$filename}";
		$path = Git::path_from_hash(sha1($tree_contents));
		if (file_exists($path)) {
			$data = file_get_contents($path);
			$items = explode("\n", $data);
			foreach ($items as $item) {
				list($i_permission, $i_type, $i_hash, $i_filename) = explode(" ", $item);
				if ($i_hash == $hash)
					return true;
			}

			$data .= $tree_contents;
		} else {
			@mkdir(dirname($path), 0777, true);
			$data = $tree_contents;
		}

		$this->hash     = sha1($data);
		$this->contents = $data;
	}

	public function write() {
		$path = Git::path_from_hash($this->hash);

		return file_put_contents($path, $this->contents);
	}
}