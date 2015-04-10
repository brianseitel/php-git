<?

namespace Pit;

class Blob {
	public $hash;
	private $contents;

	public function __construct($file) {
		if (!is_file($file)) {
			throw new Exception("File missing: {$file}");
		}

		$filedata = file_get_contents($file);
		$size     = strlen($filedata);
		$content  = "blob {$size}\0{$filedata}";

		$this->hash = sha1($content);
		$this->content = $content;
	}

	public function write() {
		$path = Git::path_from_hash($this->hash);
		@mkdir(dirname($path), 0777, true);
		file_put_contents($path, gzcompress($this->content, 9, ZLIB_ENCODING_DEFLATE));
		return true;
	}
}