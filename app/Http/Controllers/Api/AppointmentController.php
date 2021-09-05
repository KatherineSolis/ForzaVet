<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Appointment;
use App\Laravue\Models\Personal;
use App\Laravue\Models\Client;
use App\Laravue\Models\Pet;
use App\Laravue\Models\Vaccine;
use App\Laravue\Models\Antiparasitic;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $citas = Appointment::all()->toArray();
        return response()->json(new JsonResponse(['items' => $citas, 'total' => count($citas)]));
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

        $cita = new Appointment([
            'registration_date' => $request->registration_date,
            'hours' => $request->hours,
            'description' => $request->description,
            'personal_id' => $request->personal_id,
            'pet_id' => $request->pet_id,
            'client_id' => $request->client_id,
        ]);

        $cita->save();
        $data = ['id' => $cita->toArray()['id']];

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
        $cita = Appointment::where('id', $id)
            ->update([
                'registration_date' => $request->registration_date,
                'hours' => $request->hours,
                'description' => $request->description,
                'personal_id' => $request->personal_id,
                'pet_id' => $request->pet_id,
                'client_id' => $request->client_id,
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
    public function personal()
    {
        $personals = Personal::all()->toArray();
        return response()->json(new JsonResponse(['items' => $personals]));
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mascota(Request $request)
    {
        $searchParams = $request->all();
        $cliente_id = Arr::get($searchParams, 'client_id', '');
        $pets = Pet::where('client_id', '=', $cliente_id)->get()->toArray();
        return response()->json(new JsonResponse(['items' => $pets]));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vaccines()
    {
        $vaccines = Vaccine::all()->toArray();
        return response()->json(new JsonResponse(['items' => $vaccines]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function antiparasitic()
    {
        $antiparasitic = Antiparasitic::all()->toArray();
        return response()->json(new JsonResponse(['items' => $antiparasitic]));
    }
}
