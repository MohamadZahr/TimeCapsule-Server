<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Capsule;
use App\Models\Location;

class CapsuleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'message'     => 'required|string',
            'private'     => 'required|boolean',
            'surprise'    => 'required|boolean',
            'color'       => 'nullable|string|max:50',
            'revealed_at' => 'nullable|date',
            'location'    => 'nullable|array',
            'location.longitude' => 'nullable|numeric',
            'location.latitude'  => 'nullable|numeric',
            'location.city'      => 'nullable|string',
            'location.country'   => 'nullable|string',
            'location.address'   => 'nullable|string',
            'tag_ids'     => 'nullable|array',
            'tag_ids.*'   => 'exists:tags,id',
            'image_base64' => 'nullable|string',
            'audio_base64' => 'nullable|string',
        ]);

        // Step 1: Create Location
        $location = Location::create($request->location);

        // Step 2: Handle file decoding
        $imagePath = $this->saveBase64File($request->image_base64, 'images');
        $audioPath = $this->saveBase64File($request->audio_base64, 'audios');

        // Step 3: Create Capsule
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

        // Step 4: Attach Tags
        if ($request->filled('tag_ids')) {
            $capsule->tags()->attach($request->tag_ids);
        }

        return response()->json([
            'message' => 'Capsule created successfully',
            'data' => $capsule->load('tags', 'location'),
        ], 201);
    }

    private function saveBase64File($base64String, $folder)
    {
        if (!$base64String) return null;

        try {
            $data = explode(',', $base64String);
            $decoded = base64_decode(end($data));
            $extension = $this->getBase64Extension($base64String);
            $filename = Str::uuid() . '.' . $extension;
            $path = "$folder/$filename";

            Storage::disk('public')->put($path, $decoded);

            return "storage/$path";
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getBase64Extension($base64)
    {
        preg_match("/data:image\/(.*?);base64/", $base64, $imgMatch);
        if (isset($imgMatch[1])) return $imgMatch[1];

        preg_match("/data:audio\/(.*?);base64/", $base64, $audioMatch);
        if (isset($audioMatch[1])) return $audioMatch[1];

        return 'bin';
    }
}
