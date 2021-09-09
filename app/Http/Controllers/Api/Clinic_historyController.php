<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Clinic_history;
use App\Laravue\Models\Antiparasitic_history;
use App\Laravue\Models\Client;
use App\Laravue\Models\Personal;
use App\Laravue\Models\Pet;
use App\Laravue\Models\Vaccines_history;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class Clinic_historyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historial = Clinic_history::all()->toArray();
        return response()->json(new JsonResponse(['items' => $historial]));
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
        
        if ($request->type) {
            $veterinario = Personal::find($request->personal_id);
            $veterinario = $veterinario->first_name . ' ' . $veterinario->last_name; 
            $mascota = Pet::find($request->pet_id)->name;

            $cliente = Client::find($request->client_id);
            $details = [
                'name_client' => $cliente->first_name . ' ' . $cliente->last_name,
                'fecha' => $request->date,
                'veterinario' => $veterinario,
                'paciente' => $mascota,
                'motivo' => $request->reason,
                'diagnostico' => $request->diagnostic,
                'tratamiento' => $request->treatment,
                'receta' => $request->prescription,
            ];
            Mail::to($cliente->email)->send(new \App\Mail\NotificationPrescription($details));
        }

        $historial = new Clinic_history([
            'date' => $request->date,
            'personal_id' => $request->personal_id,
            'client_id' => $request->client_id,
            'pet_id' => $request->pet_id,
            'reason' => $request->reason,
            'anamnesis' => $request->anamnesis,
            'diagnostic' => $request->diagnostic,
            'pathology' => $request->pathology,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
        ]);
        $historial->save();
        if ($request->vaccine_id != '') {
            $vaccine = new Vaccines_history([
                'clinic_history_id' => $request->id,
                'vaccines_id' => $request->vaccine_id,
                'observation' => $request->vaccine_observation,
            ]);
            $vaccine->save();
            if ($request->antiparasitic_id != '') {
                $antiparasitic = new Antiparasitic_history([
                    'clinic_history_id' => $request->id,
                    'antiparasitic_id' => $request->antiparasitic_id,
                    'observation' => $request->antiparasitic_observation,
                ]);
                $antiparasitic->save();
            }
        } else if ($request->antiparasitic_id != '') {
            $antiparasitic = new Antiparasitic_history([
                'clinic_history_id' => $request->id,
                'antiparasitic_id' => $request->antiparasitic_id,
                'observation' => $request->antiparasitic_observation,
            ]);
            $antiparasitic->save();
        }

        $data = ['id' => $historial->toArray()['id']];

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
        $historial = Clinic_history::where('id', $id)
            ->update([
                'date' => $request->date,
                'personal_id' => $request->personal_id,
                'client_id' => $request->client_id,
                'pet_id' => $request->pet_id,
                'reason' => $request->reason,
                'anamnesis' => $request->anamnesis,
                'diagnostic' => $request->diagnostic,
                'pathology' => $request->pathology,
                'treatment' => $request->treatment,
                'prescription' => $request->prescription,
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
    public function peluqueriaList(Request $request)
    {
        //
        $searchParams = $request->all();
        $reason = Arr::get($searchParams, 'reason', '');

        $historial = Clinic_history::where('status', '=', '1')
            //->OrWhere("reason", "in", "('Baño', 'Corte', 'Limpieza dental', 'Baño Medicado', 'Baño y corte', 'Baño medicado y corte')")
            ->get()->toArray();

        if (!empty($reason)) {
            $historial = Clinic_history::where('reason', 'LIKE', '%' . $request->reason . '%')->get()->toArray();
        }
        return response()->json(new JsonResponse(['items' => $historial, 'total' => count($historial)]));
    }
}
