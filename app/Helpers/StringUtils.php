<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StringUtils {
	/**
	 * Türkçe ay isimleri.
	 *
	 * @var array
	 */
	static $months = [
		"Ocak",
		"Şubat",
		"Mart",
		"Nisan",
		"Mayıs",
		"Haziran",
		"Temmuz",
		"Ağustos",
		"Eylül",
		"Ekim",
		"Kasım",
		"Aralık"
	];
	/**
	 * Türkçe gün isimleri.
	 *
	 * @var array
	 */
	static $days = [
		"Pazartesi",
		"Salı",
		"Çarşamba",
		"Perşembe",
		"Cuma",
		"Cumartesi",
		"Pazar"
	];

	/**
	 * Türkçe kelimedeki karakterleri ingilizce karşılıklarıyla değiştirir.
	 *
	 * @param string $enStr
	 * @return string
	 */
	public static function tr2en( $enStr ) {
		$tr = [
			"ğ",
			"ü",
			"ş",
			"ö",
			"ç",
			"ı",
			"Ğ",
			"Ü",
			"Ş",
			"İ",
			"Ö",
			"Ç"
		];
		$en = [
			"g",
			"u",
			"s",
			"o",
			"c",
			"i",
			"G",
			"U",
			"S",
			"I",
			"O",
			"C"
		];

		return (string)\str_replace( $tr, $en, $enStr );
	}

	/**
	 * Türkçe karakterler küçük olmuyor bu yüzden manuel küçültüyoruz.
	 *
	 * @param string $str
	 * @return string
	 */
	public static function strtolower( $str ) {
		$letters1 = [
			"Ğ",
			"Ü",
			"Ş",
			"İ",
			"Ö",
			"Ç",
			"I"
		];
		$letters2 = [
			"ğ",
			"ü",
			"ş",
			"i",
			"ö",
			"ç",
			"ı"
		];

		return \strtolower( \str_replace( $letters1, $letters2, $str ) );
	}

	/**
	 * Türkçe karakterler küçük olmuyor bu yüzden manuel küçültüyoruz.
	 *
	 * @param string $str
	 * @return string
	 */
	public static function strtoupper( $str ) {
		$letters1 = [
			"Ğ",
			"Ü",
			"Ş",
			"İ",
			"Ö",
			"Ç",
			"I"
		];
		$letters2 = [
			"ğ",
			"ü",
			"ş",
			"i",
			"ö",
			"ç",
			"ı"
		];

		return \strtoupper( \str_replace( $letters2, $letters1, $str ) );
	}

	/******************************************************
	 * Period id'si belli olan bir tablodaki en büyük evrakno bilgisini alır. Eğer hiç satır yoksa sıfır dönderir.
	 *
	 * @param string $tableName
	 * @param string|int $periodId
	 * @return number
	 */
	public static function maxEvrakno( string $tableName, $periodId ) {
		$maxEvrakno = DB::table( $tableName )->where( 'period_id', (int)$periodId )->orderBy( "id", "desc" )->first();

		try {
			return (int)$maxEvrakno->evrakno;
		} catch ( \Exception $e ) {
		}

		return 0;
	}

	/******************************************************
	 *
	 * @param string $tableName
	 * @param string|int $periodId
	 * @return number
	 */
	public static function minEvrakno( string $tableName, $periodId ) {
		$maxEvrakno = DB::table( $tableName )->where( 'period_id', (int)$periodId )->orderBy( "id", "asc" )->first();

		try {
			return (int)$maxEvrakno->evrakno;
		} catch ( \Exception $e ) {
		}

		return 0;
	}

	/*******************************
	 *
	 * @param string $sql
	 * @param object $period
	 * @return array
	 */
	public static function erpQuery( string $sql, object $period ): array {
		$query = new \stdClass();

		if ( \strlen( \trim( $period->endpoint ) ) == 0 ) {
			// API ile istek atıldığında DynamicDatabaseConnection sınıfı period bilgisini alıp erp veritabanı bağlantısını
			// initalize ediyor. StringUtils.erpQuery metodu ise CRON çalışırken kullanılacak. Cron çalışırken dinamik
			// olarak period bilgisi alınıp erp db bağlantısı initialize edilmiyor. Mecburen manuel initialize ediyoruz.

			Config::set( 'database.connections.erp',
				[
					'driver' => $period->db_driver,
					'host' => $period->db_host,
					'port' => $period->db_port,
					'database' => $period->db_name,
					'username' => $period->db_username,
					'password' => $period->db_password,
					'charset' => $period->db_charset
				] );

			DB::purge( 'erp' );
			DB::reconnect( 'erp' );

			return DB::connection( "erp" )->select( $sql );
		}

		$query->connParams = [
			'driver' => $period->db_driver,
			'host' => $period->db_host,
			'port' => $period->db_port,
			'database' => $period->db_name,
			'username' => $period->db_username,
			'password' => $period->db_password,
			'charset' => $period->db_charset
		];
		$query->sql = \base64_encode( $sql );
		$url = $period->endpoint;

		$result = StringUtils::curlRequest( $url, "post", \json_encode( $query ) );

		// bazen karşı taraftan ilk istekte cevap dönmüyor. hemen peşinden ikinci isteği atınca cevap dönüyor.
		// bunun sebebini bir türlü bulamadım. her ne kadar karşı taraf firewallda sıkıntı yok desede
		// bence bu problem firewalldan kaynaklanıyor. şimdilik ikinci isteği atarak çözüyoruz ama
		// ileride bunun sebebini bulup çözmek gerekebilir.
		if ( \substr( trim( $result[ "header" ] ), 0, 9 ) != 'HTTP/1.1 ' )
			$result = StringUtils::curlRequest( $url, "post", \json_encode( $query ) );

		//Log::debug( "----------------------------------- Returned body" );
		//Log::debug( $result["body"] );

		if ( $result[ "body" ] == 'DRIVER NOT FOUND' )
			throw new \Exception( 'DRIVER NOT FOUND' );

		return \json_decode( $result[ "body" ] );
	}

	/**************************************************
	 * Create excel file from array.
	 *
	 * @param array $excelRows
	 * @param string $fileName
	 */
	public static function createExcelFile( array $excelRows, string $fileName ) {
		$spreadsheet = new Spreadsheet();
		$activeSheet = $spreadsheet->getActiveSheet();

		$activeSheet->getColumnDimension( 'A' )->setWidth( 30 );

		foreach ( $excelRows as $rowIndex => $row ) {
			$colIndex = 0;
			foreach ( $row as $col ) {
				$cell = StringUtils::excelColumnName( $colIndex ) . ( $rowIndex + 1 );

				$activeSheet->getColumnDimension( StringUtils::excelColumnName( $colIndex ) )->setWidth( 30 );
				$activeSheet->setCellValue( $cell, $col );

				if ( $rowIndex == 0 ) {
					$activeSheet->getStyle( $cell )->getFill()->setFillType( \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID )->getStartColor()->setARGB( '0842AD' );
					$activeSheet->getRowDimension( '1' )->setRowHeight( 20 );
					$activeSheet->getStyle( $cell )->getFont()->getColor()->setARGB( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE );
				}

				$colIndex++;
			}
		}

		$writer = new Xlsx( $spreadsheet );
		$writer->save( $fileName );
	}

	/**************************************************************
	 * excelColumnName(0) > A
	 * excelColumnName(26) > Z
	 * excelColumnName(27) > AA
	 *
	 *
	 * @param int $i
	 * @return string
	 */
	public static function excelColumnName( int $num ): string {
		return getNameFromNumber( $num );
	}

	/*********************************************
	 * SQL sorgularını elle yazdığımız için oraya gönderilecek olan tüm değerlerin
	 * escape edilmesi gerekiyor. adam tırnak falan yazdığı zaman sqli bozmasın.
	 *
	 * Bu metod sadece mysql için çalışıyor. SQL server için ters slaş işareti
	 * escape yapmıyor, tek tırnak işareti escape yapıyor. Bu yüzden sql server
	 * için escape yapılmak isteniyorsa StringUtils::sqlServerEscape() metodunu kullanın.
	 *
	 * @param string|array $var
	 * @return string|array
	 * @throws \Exception
	 */
	public static function addSlashes( $var ) {
		if ( \gettype( $var ) == "array" ) {
			array_walk_recursive( $var, function ( &$item, $key ) {
				$item = addslashes( $item );
			} );

			Logger::debug( $var );

			return $var;
		} else if ( \gettype( $var ) == "string" ) {
			if ( \is_numeric( $var ) ) {
				return $var;
			} else {
				return \addslashes( $var );
			}
		} else if ( \in_array( \gettype( $var ), [
			'boolean',
			'NULL',
			'resource',
			'double',
			'float'
		] ) ) {
			return $var;
		}

		throw new \Exception( 'Girilen değişken formatı hatalı.' );
	}

	/*********************************************
	 *
	 * @param string|array $var
	 * @return string|array
	 * @throws \Exception
	 */
	public static function sqlServerEscape( $var ) {
		if ( \gettype( $var ) == "array" ) {
			array_walk_recursive( $var, function ( &$item, $key ) {
				$item = str_replace( "'", "''", $item );
			} );

			Logger::debug( $var );

			return $var;
		} else if ( \gettype( $var ) == "string" ) {
			if ( \is_numeric( $var ) ) {
				return $var;
			} else {
				return str_replace( "'", "''", $var );
			}
		} else if ( \in_array( \gettype( $var ), [
			'boolean',
			'NULL',
			'resource',
			'double',
			'float'
		] ) ) {
			return $var;
		}

		throw new \Exception( 'Girilen değişken formatı hatalı.' );
	}

	/**
	 * @param string $status
	 * @return string
	 */
	public static function statusTr( $status ) {
		$status = (string)$status;

		$statuses = [
			"" => "BEKLEMEDE",
			"pending" => "BEKLEMEDE",
			"processing" => "İŞLENİYOR",
			"finished" => "TAMAMLANDI",
			"stopped" => "DURDURULDU",
			"smtp_error" => "SMTP HATASI",
			"start_verified" => "DOĞRULAMA BAŞLADI",
			"parameters_not_set" => "PARAMETRELER AYARLANMADI"
		];

		if ( isset( $statuses[ $status ] ) )
			return $statuses[ $status ];

		return $status;
	}

	/**
	 * Özel karakter içeren stringi temizler. URL oluştururken ve upload edilen dosyayı düzgün bir şekilde diske
	 * yazarken kullanılır.
	 *
	 * @param string $str
	 * @param string $case
	 * @return string
	 */
	public static function strClean( $str, $case = null ) {
		$str = StringUtils::tr2en( $str );
		$str = \preg_replace( '/[^A-Za-z0-9 _\-]/', "", $str );
		$str = \str_replace( ' ', "_", $str );

		if ( $case === "lower" )
			$str = \strtolower( $str );
		else if ( $case == "upper" )
			$str = \strtoupper( $str );

		return (string)$str;
	}

	/***********************************
	 * Get client ip address
	 *
	 * @return string
	 */
	public static function ip() {
		return isset( $_SERVER[ 'HTTP_CF_CONNECTING_IP' ] ) ? $_SERVER[ 'HTTP_CF_CONNECTING_IP' ] : \Illuminate\Support\Facades\Request::ip();
	}

	/**
	 * Örnek kullanım: turkishDate(date('d/m/Y'))
	 * Çıktı: 28 Ocak 2020 Çarşamba
	 *
	 * @param string $date
	 * @return string
	 */
	public static function turkishDate( $date = null ) {
		if ( \is_null( $date ) )
			$date = StringUtils::now();

		$dateInt = \strtotime( $date );
		$day = \date( 'j', $dateInt );
		$month = ( (int)\date( 'm', $dateInt ) ) - 1;
		$weekDay = \date( 'w', $dateInt ) - 1;
		$year = \date( 'Y', $dateInt );

		$dayTr = StringUtils::$days[ $weekDay ];
		$monthTr = StringUtils::$months[ $month ];

		return $day . " " . $monthTr . " " . $year . " " . $dayTr;
	}

	/******************************************************
	 * float2Money(143564324.9565) // 14.356.4324,95
	 *
	 * @param double $flt
	 * @return string
	 */
	public static function float2Money( $flt ) {
		return number_format( (float)$flt, 2, ',', '.' );
	}

	/**
	 * @return string
	 */
	public static function now() {
		return \date( "Y-m-d H:i:s" );
	}

	/**
	 * @return number
	 */
	public static function nowInt() {
		return \strtotime( \date( "Y-m-d H:i:s" ) );
	}

	/**
	 * param: \date( "Y-m-d H:i:s" )
	 *
	 * @param string $date
	 * @return number
	 */
	public static function date2Int( $date ) {
		return \strtotime( $date );
	}

	/**
	 * param: \date( "Y-m-d H:i:s" )
	 *
	 * @param string $date
	 * @return number
	 */
	public static function int2Date( $int ) {
		return \date( "Y-m-d H:i:s", $int );
	}

	/**
	 * Make multi curl request. Supports only GET request. For POST please use curlRequest() method.
	 *
	 * @param array $urls
	 * @param number $timeout
	 */
	public static function curlMultiRequest( $urls, $timeout = 180 ) {
		$curls = [];
		$cct = curl_multi_init();

		foreach ( $urls as $i => $url ) {
			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );

			curl_multi_add_handle( $cct, $ch );

			$curls[ $i ] = &$ch;
		}

		do {
			curl_multi_exec( $cct, $running );
		} while ( $running > 0 );

		foreach ( $curls as & $ch ) {
			curl_multi_remove_handle( $cct, $ch );
		}
		curl_multi_close( $cct );
	}

	/**
	 * Make curl request with useragent, return header and body.
	 *
	 * @param string $url
	 * @param string $method
	 * @param mixed $postData
	 * @param number $timeout
	 * @return string[]
	 */
	public static function curlRequest( $url, $method = "get", $postData = null, $timeout = 180 ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_VERBOSE, \intval( \env( "APP_ENV" ) ) == "local" );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );

		if ( intval( $method == "post" ) == 1 ) {
			curl_setopt( $ch, CURLOPT_POST, intval( $method == "post" ) );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
		}

		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );

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

	/**
	 * @param double $ms
	 */
	public static function microSec( &$ms ) {
		if ( \floatval( $ms ) == 0 ) {
			$ms = microtime( true );
		} else {
			$originalMs = $ms;
			$ms = 0;
			return (float)StringUtils::formatCurrency( microtime( true ) - $originalMs, 4 );
		}
	}

	public static function formatCurrency( $amount, $decimal = 4 ) {
		return (float)number_format( (float)$amount, $decimal, '.', '' );
	}

	public static function isValidDateTime( $input, $format ) {
		// TODO fonksiyonu yaz.
		return true;
	}

	/*****************************
	 * Datayı ekrana yazdır ve çık.
	 * @param mixed $data
	 */
	public static function printExit( ...$args ) {
		\print_r( $args );

		\ob_flush();
		\ob_end_flush();

		exit();
	}

	public static function makeArray( $mixedData ) {
		return \json_decode( \json_encode( $mixedData ), true );
	}

	public static function makeObject( $mixedData ) {
		return \json_decode( \json_encode( $mixedData ) );
	}

	public static function startsWith( $haystack, $needle ) {
		$len = strlen( $needle );
		return ( substr( $haystack, 0, $len ) === $needle );
	}

	public static function contains( $haystack, $needle ) {
		if ( \strlen( $needle ) == 0 )
			return true;

		if ( strpos( $haystack, $needle ) !== false ) {
			return true;
		}

		return false;
	}

	public static function getLastDateOfMonth( $month, $year ) {
		$date = $year . '-' . $month . '-01';
		return date( 't', strtotime( $date ) );
	}

	/**
	 * @param array $mixedData
	 * @return array
	 */
	public static function makeKeysLowercase( $mixedData ) {
		$newMixedData = [];

		foreach ( $mixedData as $key => $val ) {
			if ( \gettype( $key ) == "string" )
				$key = \strtolower( $key );

			if ( \in_array( \gettype( $val ), [
				"object",
				"array"
			] ) )
				$val = StringUtils::makeKeysLowercase( $val );

			$newMixedData[ $key ] = $val;
		}

		return $newMixedData;
	}
}
