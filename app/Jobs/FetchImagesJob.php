<?php

namespace App\Jobs;

use App\Category;
use App\Image;
use App\Models\Location;
use App\Models\Picture;
use App\Models\RandomUser;
use App\Models\Street;
use App\Models\Timezone;
use App\Models\User;
use App\PexelsFetcherRecord;
use App\Photographer;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class FetchImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $runAgain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($runAgain = true)
    {
        $this->runAgain = $runAgain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $httpClient         = new Client();
        $selectedCategoryId = null;
        $categories         = Category::all();

        // find category id which never handled
        foreach ($categories as $category) {
            $existingCategory = PexelsFetcherRecord::where(['category_id' => $category->id])->first();
            if (is_null($existingCategory)) {
                $selectedCategoryId = $category->id;
                break;
            }
        }
        if (is_null($selectedCategoryId)) {
            $ordered = PexelsFetcherRecord::select(
                DB::raw('MAX(id) as id, category_id, MAX(created_at) as created_at, MAX(updated_at) as updated_at')
            )->groupBy('category_id')->orderBy('id', 'desc')->get();

            $ordered = mo($ordered);
            $ordered = array_reverse($ordered);

            $selectedCategoryId = $ordered[0]->category_id;
        }
        /** @var Category $selectedCategory */
        $selectedCategory = Category::find($selectedCategoryId);
        PexelsFetcherRecord::insert(['category_id' => $selectedCategoryId]);

        $pages = [1, rand(2, 20)];

        foreach ($pages as $page) {
            $response     = $httpClient->get('https://api.pexels.com/v1/search?query=' . urlencode($selectedCategory->slug) . '&per_page=80&page=' . $page, [
                "headers" => [
                    'Authorization' => '' . env('PEXELS_API_KEY', ''),
                ]
            ]);
            $responseJson = json_decode($response->getBody()->getContents());
            $photographer = null;
            $image        = null;

            // TODO: We don't do anything with this for now. Must you save this value to db?
            $totalImageAdded = 0;
            foreach ($responseJson->photos as $photo) {
                $photographer = Photographer::where(['remote_id' => $photo->photographer_id])->first();
                if (is_null($photographer)) {
                    $photographer            = new Photographer();
                    $photographer->remote_id = $photo->photographer_id;
                    $photographer->name      = $photo->photographer;
                    $photographer->url       = $photo->photographer_url;
                    $photographer->save();
                }

                $image = Image::where(['remote_id' => $photo->id])->first();
                if (is_null($image)) {
                    $totalImageAdded++;

                    $image                  = new Image();
                    $image->remote_id       = $photo->id;
                    $image->category_id     = $selectedCategoryId;
                    $image->photographer_id = $photographer->id;
                    $image->height          = $photo->height;
                    $image->width           = $photo->width;
                    $image->avg_color       = $photo->avg_color;
                    $image->url             = $photo->url;
                    $image->original_url    = $photo->src->original;
                    $image->tiny_url        = $photo->src->tiny;
                    $image->save();
                }
            }
            lgi($selectedCategory->id . ': ' . $selectedCategory->title . ', Page: ' . $page . ', Added: ' . $totalImageAdded);

            sleep(1);
        }
    }

    protected function tzConvert($tz)
    {
        $tz = explode("T", $tz);
        return $tz[0] . ' ' . explode('.', $tz[1])[0];
    }
}
