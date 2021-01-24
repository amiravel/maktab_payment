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

        $drives = Drive::query()->pluck('name', 'id');

        return view('tags.create', compact('tags', 'drives'));
    }

    public function store(Request $request)
    {
        /**
         * @var $tag Tag
         */
        $tag = Tag::create([
            'parent' => $request->get('parent', null),
            'name' => $request->get('name'),
        ]);

        if (!empty($request->get('drive_id'))) {
            $tag->drive()->sync($request->get('drive_id'));
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

    public function edit(Tag $tag)
    {
        $tags = Tag::query()
            ->whereNull('parent')
            ->pluck('name', 'id')
            ->all();

        $drives = Drive::query()->pluck('name', 'id');

        return view('tags.edit', compact('tag', 'tags', 'drives'));
    }

    public function update(Tag $tag, Request $request)
    {
        $tag->update($request->only(['name', 'parent']));

        if (!empty($request->get('drive_id'))) {
            $tag->drive()->sync($request->get('drive_id'));
        }

        return redirect()->route('tags.index');
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
