<?

namespace Pit;

class Git {
	const CONFIG_PATH = '/.pit/config';

	public static function init($name, $email) {
		@mkdir(dirname(ROOT_DIR.self::CONFIG_PATH), 0777, true);
		if (file_exists(ROOT_DIR.self::CONFIG_PATH)) {
			unlink(ROOT_DIR.self::CONFIG_PATH);
		}

		file_put_contents(ROOT_DIR.self::CONFIG_PATH, "[user]\nname = {$name}\nemail = {$email}");
	}

	public static function cat_file($hash) {
		$path = self::path_from_hash($hash);
		$data = file_get_contents($path);

		$contents = @gzuncompress($data);

		if ($contents) {
			$parts = explode("\0", $contents);
			list($type, $size) = explode(" ", $parts[0]);
			$contents = $parts[1];

			pd("{$type}\t{$size}\t{$contents}");
		} else {
			pd($data);
		}
	}

	public static function path_from_hash($hash) {
		$dir          = substr($hash, 0, 2);
		$rest_of_hash = substr($hash, 2);

		return ROOT_DIR."/.pit/{$dir}/{$rest_of_hash}";
	}
}