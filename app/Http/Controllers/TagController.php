<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function getAll(){
        $tags = Tag::all();
        return $this->responseJSON($tags, 'success', 200);
    }
}
