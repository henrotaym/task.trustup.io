<?php
namespace App\Http\Controllers\Api;

use App\Actions\Models\MediaModel\GetMediaFromRequest;
use App\Http\Controllers\Controller;
use App\Actions\Models\MediaModel\StoreMediaFromRequest;
use App\Http\Requests\Models\MediaModel\GetMediaRequest;
use App\Http\Requests\Models\MediaModel\StoreMediaRequest;
use App\Http\Resources\Media;

class MediaModelController extends Controller
{
    public function store(
        StoreMediaRequest $request,
        StoreMediaFromRequest $action,
    ) {
        $parsedRequest = $request->getParsed();
        $action->handle($parsedRequest);

        return response([
            'data' => Media::collection($action->getRepository()->getMedia()),
            'message' => "Files successfully uploaded."
        ]);
    }

    public function index(
        GetMediaRequest $request,
        GetMediaFromRequest $action
    ) {
        $action->handle($request->getParsed());
        
        return Media::collection($action->getMedia());
    }
}