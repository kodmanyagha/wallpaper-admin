<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Image;
use Illuminate\Support\Facades\Cache;

class ImageController extends ApiController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        return $this->error('Not implemented');
    }

    /**
     * @return \stdClass
     */
    protected function queryInputStandardize()
    {
        $page = (int)request()->input('page', 1);
        if ($page <= 0)
            $page = 1;

        $limit = (int)request()->input('limit', 10);
        if (!in_array($limit, [30, 60, 90]))
            $limit = 30;

        $offset = $limit * ($page - 1);

        return mo([
            'page'   => $page,
            'limit'  => $limit,
            'offset' => $offset
        ]);
    }

    /**
     *  TODO: This is infinite random method. Every page can have same images. Handle this.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function random()
    {
        $queryInputs = $this->queryInputStandardize();
        $cacheKey    = 'random_' . $queryInputs->page . '_' . $queryInputs->limit;
        $images      = s2o(Cache::get($cacheKey));

        if (is_null($images)) {
            $images = Image::all()->random($queryInputs->limit);
            foreach ($images as $image) {
                $image->category;
                $image->photographer;
            }

            Cache::put($cacheKey, o2s($images), 60);
        }

        $this->set('images', $images);
        $this->set('pagination', $queryInputs);
        return $this->success();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function image($id)
    {
        $id       = (int)$id > 0 ? (int)$id : 1;
        $cacheKey = 'image_' . $id;
        $image    = s2o(Cache::get($cacheKey));

        if (is_null($image)) {
            $image = Image::find($id);

            if (is_null($image))
                return $this->error('Image not found.');

            $image->category;
            $image->photographer;

            $image = mo($image);
            Cache::put($cacheKey, o2s($image), 60);
        }

        $this->set('image', $image);
        return $this->success();
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function category($slug)
    {
        // remove unnecessary characters
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $slug));

        $categoryCacheKey = 'category_' . $slug;
        $category         = s2o(Cache::get($categoryCacheKey));
        if (is_null($category)) {
            $category = Category::where(['slug' => $slug])->first();

            if (is_null($category))
                return $this->error('Category not found');
        }
        $category = mo($category);

        $queryInputs = $this->queryInputStandardize();
        $cacheKey    = $slug . '_images_' . $queryInputs->page . '_' . $queryInputs->limit;
        $images      = s2o(Cache::get($cacheKey));

        if (is_null($images)) {
            $images = Image::where(['category_id' => $category->id])
                ->orderBy('id', 'desc')
                ->limit($queryInputs->limit)
                ->offset($queryInputs->offset)
                ->get();

            foreach ($images as $image) {
                $image->category;
                $image->photographer;
            }

            $images = mo($images);
            Cache::put($cacheKey, o2s($images), 60);
        }

        $this->set('images', $images);
        return $this->success();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function categories()
    {
        $cacheKey   = 'categories';
        $categories = s2o(Cache::get($cacheKey));

        if (is_null($categories)) {
            $categories = Category::all();

            if (is_null($categories))
                return $this->error('Category not found.');

            $categories = mo($categories);
            Cache::put($cacheKey, o2s($categories), 60);
        }

        $this->set('categories', $categories);

        return $this->success();
    }
}
