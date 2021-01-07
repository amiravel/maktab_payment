<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index()
    {
        return view('tags.index');
    }

    public function create()
    {
        $tags = Tag::query()
            ->whereNull('parent')
            ->pluck('name', 'id')
            ->all();

        $drives = Drive::all();

        return view('tags.create', compact('tags', 'drives'));
    }

    public function store(Request $request)
    {
        $tag = Tag::create([
            'parent' => $request->get('parent', null),
            'name' => $request->get('name'),
        ]);

        if ($request->has('drive')) {
            if (array_key_exists('id', $request->get('drive'))) {
                Drive::findOrFail($request->get('drive')['id'])
                    ->replicate(['tag_id'])
                    ->fill(['tag_id' => $tag->id])
                    ->save();
            } else {
                $drive = Drive::create([
                    'tag_id' => $tag->id,
                    'name' => $request->get('drive')['name'],
                    'value' => $request->get('drive')['value'],
                ]);
            }
        }

        return redirect()->route('tags.index');
    }

    public function show(Tag $tag)
    {
        $tags = Tag::query()
            ->whereNull('parent')
            ->pluck('name', 'id')
            ->all();

        $drives = Drive::all();

        return view('tags.show', compact('tag', 'tags', 'drives'));
    }

    public function all()
    {
        $tags = Tag::query()
            ->with(['children'])
            ->whereNull('parent')
            ->get();

        return responder()
            ->success($tags);
    }
}
