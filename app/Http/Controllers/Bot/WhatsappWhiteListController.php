<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\WhatsappWhiteList;
use Illuminate\Http\Request;

class WhatsappWhiteListController extends Controller
{
    public function index()
    {
        $whiteLists = WhatsappWhiteList::all();
        return response()->json($whiteLists);
    }
}
