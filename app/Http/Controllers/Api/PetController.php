<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Pet;
use App\Laravue\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PetController extends Controller
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

        $animals = Pet::select(
            'pets.id',
            'pets.name AS nombre_mascota',
            'pets.age',
            'pets.sex',
            'pets.weight',
            'pets.color',
            'pets.chip',
            'pets.client_id',
            PET::raw("CONCAT(first_name,' ',last_name) AS nombre_cliente"),
            'pets.specie',
            'pets.breed',
            'pets.status'
        )
            ->join('clients', 'clients.id', '=', 'pets.client_id')
            ->get();

        if (!empty($name)) {
            $animals = Pet::select(
                'pets.id',
                'pets.name AS nombre_mascota',
                'pets.age',
                'pets.sex',
                'pets.weight',
                'pets.color',
                'pets.chip',
                'pets.client_id',
                PET::raw("CONCAT(first_name,' ',last_name) AS nombre_cliente"),
                'pets.specie',
                'pets.breed',
                'pets.status'
            )
                ->join('clients', 'clients.id', '=', 'pets.client_id')
                ->where('nombre_cliente', 'LIKE', '%' . $name . '%')
                ->OrWhere('nombre_mascota', 'LIKE', '%' . $name . '%')
                ->get()
                ->toArray();
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
        $pet = new Pet([
            'name' => $request->name,
            'age' => $request->age,
            'sex' => $request->sex,
            'weight' => $request->weight,
            'color' => $request->color,
            'chip' => $request->chip,
            'client_id' => $request->client_id,
            'specie' => $request->specie,
            'breed_id' => $request->breed,

        ]);

        $pet->save();
        $data = ['id' => $pet->toArray()['id']];

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
        $pet = Pet::where('id', $id)
            ->update([
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'weight' => $request->weight,
                'color' => $request->color,
                'chip' => $request->chip,
                'client_id' => $request->client_id,
                'specie' => $request->specie,
                'breed_id' => $request->breed,
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function client()
    {
        $clients = Client::all()->toArray();

        return response()->json(new JsonResponse(['items' => $clients]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function petConsulta(Request $request, $id)
    {
        //
        $pet = Pet::select(
            'pets.id',
            'pets.name AS nombre_mascota',
            'pets.age',
            'pets.sex',
            'pets.weight',
            'pets.color',
            'pets.chip',
            'pets.client_id',
            PET::raw("CONCAT(first_name,' ',last_name) AS nombre_cliente"),
            'pets.specie',
            'pets.breed',
            'pets.status'
        )
            ->join('clients', 'clients.id', '=', 'pets.client_id')
            ->where('pets.id', $id)
            ->get();
        /*->update([
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'weight' => $request->weight,
                'color' => $request->color,
                'chip' => $request->chip,
                'client_id' => $request->client_id,
                'specie' => $request->specie,
                'breed_id' => $request->breed,
                'status' => $request->status,
            ]);*/
        return response()->json(new JsonResponse(['items' => $pet]));
    }
}
