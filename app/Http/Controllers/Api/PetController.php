<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Pet;
use App\Laravue\Models\Client;
use App\Laravue\Models\Clinic_history;
use App\Laravue\Models\Antiparasitic_history;
use App\Laravue\Models\Vaccines_history;
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
            'pets.name',
            'pets.age',
            'pets.sex',
            'pets.weight',
            'pets.color',
            'pets.chip',
            'pets.client_id',
            PET::raw("CONCAT(clients.first_name,' ',clients.last_name) AS nombre_cliente"),
            'pets.specie',
            'pets.breed',
            'pets.castrated',
            'pets.aggressiveness',
            'pets.status'
        )
            ->join('clients', 'clients.id', '=', 'pets.client_id')
            ->get();

        if (!empty($name)) {
            $animals = Pet::select(
                'pets.id',
                'pets.name',
                'pets.age',
                'pets.sex',
                'pets.weight',
                'pets.color',
                'pets.chip',
                'pets.client_id',
                PET::raw("CONCAT(clients.first_name,' ',clients.last_name) AS nombre_cliente"),
                'pets.specie',
                'pets.breed',
                'pets.castrated',
                'pets.aggressiveness',
                'pets.status'
            )
                ->join('clients', 'clients.id', '=', 'pets.client_id')
                ->where('clients.first_name', 'LIKE', '%' . $name . '%')
                ->OrWhere('clients.last_name', 'LIKE', '%' . $name . '%')
                ->OrWhere('pets.name', 'LIKE', '%' . $name . '%')
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
        //dd($request);
        $pet = new Pet([
            'name' => $request->name,
            'age' => $request->age,
            'sex' => $request->sex,
            'weight' => $request->weight,
            'color' => $request->color,
            'chip' => $request->chip,
            'client_id' => $request->client_id,
            'specie' => $request->specie,
            'breed' => $request->breed,
            'castrated' => $request->castrated,
            'aggressiveness' => $request->aggressiveness,
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
                'breed' => $request->breed,
                'castrated' => $request->castrated,
                'aggressiveness' => $request->aggressiveness,
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
        $clients = Client::where('status', '=', '1')->get()->toArray();

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
            'pets.name',
            'pets.age',
            'pets.sex',
            'pets.weight',
            'pets.color',
            'pets.chip',
            'pets.client_id',
            PET::raw("CONCAT(clients.first_name,' ',clients.last_name) AS nombre_cliente"),
            'clients.email as email_cliente',
            'pets.specie',
            'pets.breed',
            'pets.castrated',
            'pets.aggressiveness',
            'pets.status',
            'clinic_histories.id as clinic_id'
        )
            ->join('clients', 'clients.id', '=', 'pets.client_id')
            ->leftjoin('clinic_histories', 'clinic_histories.pet_id', '=', 'pets.id')
            ->where('pets.id', $id)
            ->get();

        $historial = Clinic_history::select(
            'clinic_histories.id',
            'clinic_histories.date',
            'clinic_histories.reason',
            'clinic_histories.personal_id',
            'clinic_histories.pet_id',
            'pets.name',
            'clinic_histories.client_id',
            'clinic_histories.anamnesis',
            'clinic_histories.diagnostic',
            'clinic_histories.pathology',
            'clinic_histories.treatment',
            'clinic_histories.prescription',
            'clinic_histories.status',
            PET::raw("CONCAT(personals.first_name,' ',personals.last_name) AS nombre_veterinario"),
            'personals.email as email_veterinario'
        )
            ->join('personals', 'personals.id', '=', 'clinic_histories.personal_id')
            ->join('pets', 'pets.id', '=', 'clinic_histories.pet_id')
            ->where('clinic_histories.pet_id', $id)
            ->get();

        $vaccine = Vaccines_history::select(
            'clinic_histories.id',
            'vaccines_histories.id as vaccines_histories_id',
            'clinic_histories.date',
            'clinic_histories.reason',
            'clinic_histories.personal_id',
            'clinic_histories.anamnesis',
            'clinic_histories.diagnostic',
            'clinic_histories.pathology',
            'clinic_histories.treatment',
            'clinic_histories.prescription',
            'clinic_histories.client_id',
            'vaccines_histories.vaccines_id',
            'vaccines.name_vaccines',
            'vaccines_histories.observation as vaccine_observation',
            'clinic_histories.pet_id',
            'pets.name',
            'pets.weight',
            'clinic_histories.status',
        )
            ->join('clinic_histories', 'clinic_histories.id', '=', 'vaccines_histories.clinic_history_id')
            ->join('pets', 'pets.id', '=', 'clinic_histories.pet_id')
            ->join('vaccines', 'vaccines.id', '=', 'vaccines_histories.vaccines_id')
            ->where('clinic_histories.pet_id', $id)
            ->where('clinic_histories.status', '1')
            ->get();

        $antiparasitic = Antiparasitic_history::select(
            'clinic_histories.id',
            'antiparasitic_histories.id as antiparasitic_histories_id',
            'clinic_histories.date',
            'clinic_histories.reason',
            'clinic_histories.personal_id',
            'clinic_histories.client_id',
            'clinic_histories.pet_id',
            'clinic_histories.anamnesis',
            'clinic_histories.diagnostic',
            'clinic_histories.pathology',
            'clinic_histories.treatment',
            'clinic_histories.prescription',
            'antiparasitic_histories.antiparasitic_id',
            'antiparasitics.name_antiparasitic',
            'antiparasitic_histories.observation as antiparasitic_observation',
            'pets.name',
            'pets.weight',
            'clinic_histories.status',
        )
            ->join('clinic_histories', 'clinic_histories.id', '=', 'antiparasitic_histories.clinic_history_id')
            ->join('pets', 'pets.id', '=', 'clinic_histories.pet_id')
            ->join('antiparasitics', 'antiparasitics.id', '=', 'antiparasitic_histories.antiparasitic_id')
            ->where('clinic_histories.pet_id', $id)
            ->where('clinic_histories.status', '1')
            ->get();

        $peluqueria = Clinic_history::select(
            'clinic_histories.id',
            'clinic_histories.date',
            'clinic_histories.reason',
            'clinic_histories.diagnostic',
            'clinic_histories.client_id',
            PET::raw("CONCAT(clients.first_name,' ',clients.last_name) AS nombre_cliente"),
            'clinic_histories.pet_id',
            'pets.name',
            'clinic_histories.status',
            'clinic_histories.updated_at'
        )
            ->join('pets', 'pets.id', '=', 'clinic_histories.pet_id')
            ->join('clients', 'clients.id', '=', 'clinic_histories.client_id')
            ->where('clinic_histories.pet_id', $id)
            ->where('clinic_histories.status', '1')
            ->whereIn('clinic_histories.reason', ['Baño', 'Corte', 'Limpieza dental', 'Baño Medicado', 'Baño y corte', 'Baño medicado y corte'])
            ->get();

        $visit = Pet::select(
            'pets.id as pet_id',
            'pets.client_id',
            'pets.status',
        )
            ->where('pets.id', $id)
            ->get();

        return response()->json(new JsonResponse(['items' => $pet, 'historial' => $historial, 'vaccine' => $vaccine, 'antiparasitic' => $antiparasitic, 'peluqueria' => $peluqueria, 'visit' => $visit]));
    }
}
