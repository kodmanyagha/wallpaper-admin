<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if ( !function_exists( 'makeApiCall' ) ) {

	/*************
	 *
	 *
	 * @param string $str
	 * @param boolean $assoc
	 * @return mixed
	 */
	function makeApiCall( $method, $endpoint, $cmd, $apiKey, $postData = null ) {
		$ch = curl_init();
		$authorization = "Authorization: Bearer " . $apiKey;

		curl_setopt( $ch, CURLOPT_URL, $endpoint . $cmd );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );

		if ( in_array( $method, [
			'post',
			'put',
			'patch'
		] ) ) {
			if ( $method == 'post' )
				curl_setopt( $ch, CURLOPT_POST, 1 );
			else
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, strtoupper( $method ) );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
		}

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			$authorization
		) ); // Inject the token into the header

		curl_setopt( $ch, CURLOPT_TIMEOUT, 90 );
		$result = curl_exec( $ch );

		$header_size = curl_getinfo( $ch, CURLINFO_HEADER_SIZE );
		$header = substr( $result, 0, $header_size );
		$body = substr( $result, $header_size );

		curl_close( $ch );

		return array(
			"header" => $header,
			"body" => $body
		);
	}
}

if ( !function_exists( 's2o' ) ) {

	/*************
	 * String to object (json)
	 *
	 * @param string $str
	 * @param boolean $assoc
	 * @return mixed
	 */
	function s2o( $str, $assoc = false ) {
		return json_decode( $str, $assoc );
	}
}

if ( !function_exists( 'o2s' ) ) {

	/*************
	 * Object to string
	 *
	 * @param mixed $obj
	 * @return string
	 */
	function o2s( $obj, $pretty = false ) {
		if ( $pretty )
			return json_encode( $obj, JSON_PRETTY_PRINT );

		return json_encode( $obj );
	}
}

if ( !function_exists( 'mo' ) ) {

	/*************
	 * Make object
	 *
	 * @param mixed $obj
	 * @return stdClass
	 */
	function mo( $obj ) {
		return s2o( o2s( $obj ) );
	}
}

if ( !function_exists( 'ma' ) ) {

	/*************
	 * Make array
	 *
	 * @param mixed $obj
	 * @return array
	 */
	function ma( $obj ) {
		return s2o( o2s( $obj ), true );
	}
}

if ( !function_exists( 'rq' ) ) {

	/********************
	 * rq: random query
	 *
	 * @return object
	 */
	function rq() {
		if ( env( 'APP_ENV' ) == 'local' )
			return microtime( true );
		return date( 'i' );
	}
}

if ( !function_exists( 'ee' ) ) {

	/********************
	 * ee: export and exit
	 *
	 * @return object
	 */
	function ee() {
		echo "<pre>";
		$args = func_get_args();

		foreach ( $args as $arg ) {
			print_r( $arg );
		}

		exit();
	}
}

if ( !function_exists( 'cts' ) ) {

	/********************
	 * cts: current time stamp
	 *
	 * @return object
	 */
	function cts( &$table ) {
		$table->timestamp( 'created_at' )->default( DB::raw( 'CURRENT_TIMESTAMP' ) );
		$table->timestamp( 'updated_at' )->default( DB::raw( 'CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP' ) );
	}
}

if ( !function_exists( 'getNameFromNumber' ) ) {

	/********************
	 * cts: current time stamp
	 *
	 * @return object
	 */
	function getNameFromNumber( int $num ): string {
		$numeric = $num % 26;
		$letter = chr( 65 + $numeric );
		$num2 = intval( $num / 26 );
		if ( $num2 > 0 ) {
			return getNameFromNumber( $num2 - 1 ) . $letter;
		} else {
			return $letter;
		}
	}
}

if ( !function_exists( 'gp' ) ) {

	/********************
	 * gp: Get Params
	 *
	 * @return array
	 */
	function gp() {
		$params = request()->route()->parameters();
		return array_values( $params );
	}
}

if ( !function_exists( 'lg' ) ) {

	/********************
	 * lg: log
	 *
	 */
	function lg( $anything, $type = 'debug' ) {
		if ( !in_array( gettype( $anything ), [
			'string',
			'number'
		] ) ) {
			$anything = o2s( $anything, true );
		}

		$bt = debug_backtrace();

		foreach ( $bt as $i => $b ) {
			if ( $i > 10 )
				break;
		}
		$cwd = base_path();

		$caller = array_shift( $bt );
		$file = $caller[ 'file' ];
		$file = substr( $file, strlen( $cwd ) );

		if ( $file == '/app/Helpers/Helpers.php' )
			$caller = array_shift( $bt );

		$file = $caller[ 'file' ];
		$line = $caller[ 'line' ];

		$file = substr( $file, strlen( $cwd ) );

		$message = $file . ':' . $line . ' ' . $anything;

		if ( strtolower( $type ) == 'debug' )
			Log::debug( $message );
		else if ( strtolower( $type ) == 'info' )
			Log::info( $message );
		else if ( strtolower( $type ) == 'warning' )
			Log::warning( $message );
		else if ( strtolower( $type ) == 'error' )
			Log::error( $message );
	}

	function lgd() {
		$args = func_get_args();
		if ( count( $args ) == 1 )
			lg( $args[ 0 ], 'debug' );
		else
			lg( $args, 'debug' );
	}

	function lgi() {
		$args = func_get_args();
		if ( count( $args ) == 1 )
			lg( $args[ 0 ], 'info' );
		else
			lg( $args, 'info' );
	}

	function lgw() {
		$args = func_get_args();
		if ( count( $args ) == 1 )
			lg( $args[ 0 ], 'warning' );
		else
			lg( $args, 'warning' );
	}

	function lge() {
		$args = func_get_args();
		if ( count( $args ) == 1 )
			lg( $args[ 0 ], 'error' );
		else
			lg( $args, 'error' );
	}
}
