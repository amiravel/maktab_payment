<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagCollection;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tags = Tag::query()
            ->where('public', true)
            ->whereNull('parent')
            ->get();

        return response()
            ->json([
                'code' => 200,
                'message' => 'Received information successfully.',
                'data' => new TagCollection($tags),
            ]);
    }
}
