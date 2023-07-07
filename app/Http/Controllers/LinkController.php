<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::whereUserId(auth()->id())
            ->paginate(10);

        return LinkResource::collection($links);
    }

    public function show($id)
    {
        $link = Link::whereUserId(auth()->id())
            ->findOrFail($id);

        return LinkResource::make($link);
    }

    public function create(CreateLinkRequest $request)
    {
        DB::beginTransaction();

        try {
            $link = new Link;
            $link->user_id = auth()->id();
            $link->title = $request->title;
            if (null == $request->slug) {
                $link->slug = uniqid();
            }else{
                $link->slug = $request->slug;
            }
            $link->url = $request->url;
            $link->save();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            throw new BadRequestException('Something went wrong.');
        }

        return LinkResource::make($link);
    }

    public function update($id, UpdateLinkRequest $request)
    {
        $link = Link::whereUserId(auth()->id())
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            $link->title = $request->title;
            $link->slug = $request->slug;
            $link->url = $request->url;
            $link->save();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw new BadRequestException();
        }

        return LinkResource::make($link);
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            Link::whereUserId(auth()->id())
                ->whereId($id)
                ->delete();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw new BadRequestException();
        }

        return response()->noContent();
    }
}
