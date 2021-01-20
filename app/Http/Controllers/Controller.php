<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/*****************
	 *
	 * @var \stdClass
	 */
	protected $viewData;

	public function __construct() {
		$this->viewData = new \stdClass();
		$this->viewData->breadcrumbs = [];

		App::setLocale('tr');

		// constructor içerisinde doğrudan session datasına ulaşamıyoruz.
		// bu yüzden middleware metodunu kullanmamız gerekiyor.
		$this->middleware(function ($request, $next) {
			$this->viewData->titlePage = __('Mainpage');

			return $next($request);
		});
	}

	protected function addBreadcrumb($link, $title = null) {
		if (is_null($title)) {
			$title = $link;
			$link = 'javascript:;';
		}

		$this->viewData->breadcrumbs[] = [
			'link' => $link,
			'title' => $title
		];
	}

	protected function set($key, &$data) {
		$this->viewData->{$key} = $data;
	}

	protected function json($data = null) {
		if (is_null($data))
			return response()->json($this->viewData);

		return response()->json($data);
	}

	/***************
	 * Klasik yöntemde metodlardan view return ediliyor. Bunu yaparken
	 * her seferinde viewData propertysini diziye çevirip göndermek gerekiyor.
	 * Bu zahmeti ortadan kaldırmak için bu metodu çağırarak return ediyoruz.
	 *
	 * @param string $view
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	protected function view($view = null) {
		if (is_null($view)) {
			$class = substr(get_class($this), strlen('App\\Http\\Controllers\\'));
			$class = str_replace('\\', '.', $class);

			$view = $class . '.' . debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
		}

		// datayı array olarak geçirmek gerekiyor.
		// object olarak gönderirsen
		// Illuminate/View/Factory.make metodunda hata fırlatıyor
		return view($view, ma($this->viewData));
	}
}
