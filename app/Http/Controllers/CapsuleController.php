<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Capsule;
use App\Models\Location;
use App\Services\IpLocationService;
use App\Services\MediaService;

class CapsuleController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'message'     => 'required|string',
            'private'     => 'required|boolean',
            'surprise'    => 'required|boolean',
            'color'       => 'nullable|string|max:50',
            'revealed_at' => 'nullable|date',
            'tag_ids'     => 'nullable|array',
            'tag_ids.*'   => 'exists:tags,id',
            'image_base64' => 'nullable|string',
            'audio_base64' => 'nullable|string',
        ]);

        $locationArray = IpLocationService::getLocation($request);
        $location = Location::create($locationArray);

        $imagePath = null;
        $audioPath = null;
        if ($request->filled('image_base64')) {
            $imagePath = MediaService::saveBase64File($request->image_base64, 'images');
        }
        if ($request->filled('audio_base64')) {
            $audioPath = MediaService::saveBase64File($request->audio_base64, 'audios');
        }

        $capsule = Capsule::create([
            'user_id'     => Auth::id(),
            'location_id' => $location->id,
            'title'       => $request->title,
            'message'     => $request->message,
            'private'     => $request->private,
            'surprise'    => $request->surprise,
            'image_path'  => $imagePath,
            'audio_path'  => $audioPath,
            'color'       => $request->color,
            'revealed_at' => $request->revealed_at ? Carbon::parse($request->revealed_at) : null,
        ]);

        if ($request->filled('tag_ids')) {
            $capsule->tags()->attach($request->tag_ids);
        }
        $capsule->tags()->attach($location);

        return $this->responseJSON($capsule->load('tags', 'location'),  'Capsule created successfully', 201);
    }

    public function getPublicRevealed()
    {
        $capsule = Capsule::with(['tags', 'location', 'user'])
            ->where('private', 0)
            ->where('revealed_at', '<=', now())
            ->where('surprise', 0)
            ->get();
        return $this->responseJSON($capsule, 'success', 200);
    }

    public function getPublicUpcoming()
    {
        $capsule = Capsule::with(['tags', 'location', 'user'])
            ->where('private', 0)
            ->where('revealed_at', '>', now())
            ->where('surprise', 0)
            ->get();
        return $this->responseJSON($capsule, 'success', 200);
    }

    public function getPrivateRevealed()
    {
        $id = Auth::id();
        $capsule = Capsule::with(['tags', 'location', 'user'])
            ->where('revealed_at', '<=', now())
            ->where('surprise', 0)
            ->where('user_id', $id)
            ->get();
        return $this->responseJSON($capsule, 'success', 200);
    }

    public function getPrivateUpcoming()
    {
        $id = Auth::id();
        $capsule = Capsule::with(['tags', 'location', 'user'])
            ->where('revealed_at', '>', now())
            ->where('surprise', 0)
            ->where('user_id', $id)
            ->get();
        return $this->responseJSON($capsule, 'success', 200);
    }
}
