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
        $query = CID::query();

        if ($search = $request->query('search')) {
            $like = sprintf('%%%s%%', $search);
            $query->where(function ($q) use ($like) {
                $q->where('code', 'like', $like)
                  ->orWhere('description', 'like', $like);
            });
        }

        return CIDResource::collection($query->limit(50)->get());
    }
}
