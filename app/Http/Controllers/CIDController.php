<?php

namespace App\Http\Controllers;

use App\Http\Resources\CIDResource;
use App\Models\CID;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CIDController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $cids = CID::query();

        if ($request->query('search')) {
            $cids->where('description', 'like', sprintf('%%%s%%', $request->query('search')));
        }

        return CIDResource::collection($cids->get());
    }
}
