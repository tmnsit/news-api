<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/news",
     *     description="news list",
     *     @OA\Parameter(name="page",in="query",required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="select",in="query",required=false, @OA\Schema(type="string"), description="Values separated by commas (title, description, date_publish, images, author)"),
     *     @OA\Parameter(name="sort",in="query",required=false, @OA\Schema(type="string"), description="desc, asc"),
     *     @OA\Response(response="default", description="Json")
     * )
     */
    public function index(Request $request)
    {
        $fillable = [
            'title',
            'description',
            'date_publish',
            'images',
            'author'
        ];

        $query = News::query();

        $selectFields = explode(',', $request->get('select'));
        if (count($selectFields)) {
            foreach ($selectFields as $filed) {
                if (in_array($filed, $fillable)) {
                    $query->selectRaw($filed);
                }
            }
        }

        $sort = $request->get('sort');
        if($sort == 'desc' || $sort == 'asc'){
           $query->orderBy('date_publish', $sort);
        }else{
            $query->orderBy('date_publish');
        }


        return new NewsCollection($query->paginate());
    }
}
