<?php

namespace App\Http\Controllers;

use App\Models\UnitAddress;
use Illuminate\Http\Request;
use App\Http\Resources\UnitAddresses as UnitAddressesResources;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UnitAddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitAdresses = UnitAddress::query();

        if ($request->query('search')) {
            $unitAdresses->where('unit_name', 'like', sprintf('%s%%', $request->query('search')));
        }

        $unitAdresses->orderBy('unit_name');

        return UnitAddressesResources::collection($unitAdresses->cursorPaginate(25)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitAdresses  $unitAdresses
     * @return \Illuminate\Http\Response
     */
    public function show(UnitAddress $unitAdresses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitAdresses  $unitAdresses
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitAddress $unitAdresses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitAdresses  $unitAdresses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitAddress $unitAdresses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitAdresses  $unitAdresses
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitAddress $unitAdresses)
    {
        //
    }
}
