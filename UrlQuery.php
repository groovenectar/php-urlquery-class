<?php

/*
echo (
	new UrlQuery('https://user:pass@example.org/?test=this&this=too')
)->add(['other' => 'something', 'other2' => 'something2'])
 ->remove(['test', 'other2']);
*/

class UrlQuery {
	private $url;
	private $extractedQuery = [];

	public function __construct($url = null) {
		$this->url = parse_url($url ?? $_SERVER['REQUEST_URI']);
		if (!empty($this->url['query'])) {
			parse_str($this->url['query'], $this->extractedQuery);
		}
	}

	public function add(array $input) {
		$this->extractedQuery = array_merge($this->extractedQuery, $input);
		return $this;
	}

	public function remove(array $input) {
		$this->extractedQuery = array_diff_key($this->extractedQuery, array_flip($input));
		return $this;
	}

	public function __toString() {
		if (!empty($this->extractedQuery)) {
			$this->url['query'] = http_build_query($this->extractedQuery);
		}
		return $this->unparse_url($this->url);
	}

	// https://www.php.net/manual/en/function.parse-url.php#106731
	// http_build_url() can also be used with a module
	public function unparse_url($parsed_url) {
		$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
		$pass     = ($user || $pass) ? "$pass@" : '';
		$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}
}
