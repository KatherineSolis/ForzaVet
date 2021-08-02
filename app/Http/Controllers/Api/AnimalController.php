<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $searchParams = $request->all();
        $name = Arr::get($searchParams, 'name', '');

        $animals = Animal::all()->toArray();

        if (!empty($name)) {
            $animals = Animal::where('name', 'LIKE', '%' . $name . '%')->get()->toArray();
        }
        return response()->json(new JsonResponse(['items' => $animals, 'total' => count($animals)]));
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

        $animal = new Animal([
            'name' => $request->name,
            'observation' => $request->observation,
            'breed_id' => 1,
        ]);
        
        $animal->save();
        $data = ['id' => $animal->toArray()['id']];

        return response()->json(new JsonResponse(['items' => $data, 'total' => 15]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $animal = Animal::where('id', $id)
        ->update([
            'name' => $request->name,
            'breed_id' => $request->breed_id,
            'observation' => $request->observation,
            'status' => $request->status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
