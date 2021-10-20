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
use App\Laravue\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $name = Arr::get($searchParams, 'name', '');

        $citas = Appointment::select(
            'appointments.id',
            'appointments.description',
            'appointments.registration_date',
            'appointments.hours',
            'appointments.end',
            Appointment::raw("CONCAT(appointments.registration_date,' ',appointments.hours) AS dateTime"),
            'appointments.personal_id',
            PET::raw("CONCAT(personals.first_name,' ',personals.last_name) AS nombre_veterinario"),
            'appointments.client_id',
            PET::raw("CONCAT(clients.first_name,' ',clients.last_name) AS nombre_cliente"),
            'pets.name',
            'appointments.pet_id',
            'appointments.status',
        )
            ->join('pets', 'pets.id', '=', 'appointments.pet_id')
            ->join('personals', 'personals.id', '=', 'appointments.personal_id')
            ->join('clients', 'clients.id', '=', 'appointments.client_id')
            ->where('appointments.status', '1')
            ->orderby('appointments.registration_date', 'desc')->get()->toArray();

        if (!empty($name)) {
            $citas = Appointment::select(
                'appointments.id',
                'appointments.description',
                'appointments.registration_date',
                'appointments.hours',
                'appointments.end',
                Appointment::raw("CONCAT(appointments.registration_date,' ',appointments.hours) AS dateTime"),
                'appointments.personal_id',
                PET::raw("CONCAT(personals.first_name,' ',personals.last_name) AS nombre_veterinario"),
                'appointments.client_id',
                PET::raw("CONCAT(clients.first_name,' ',clients.last_name) AS nombre_cliente"),
                'pets.name',
                'appointments.pet_id',
                'appointments.status',
            )
                ->join('pets', 'pets.id', '=', 'appointments.pet_id')
                ->join('personals', 'personals.id', '=', 'appointments.personal_id')
                ->join('clients', 'clients.id', '=', 'appointments.client_id')
                ->where('appointments.status', '1')
                ->where('appointments.description', 'LIKE', '%' . $name . '%')
                ->OrWhere('pets.name', 'LIKE', '%' . $name . '%')
                ->orderby('appointments.registration_date', 'desc')->get()->toArray();
        }
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
        $cliente = Client::find($request->client_id);
        $details = [
            'fecha_cita' => $request->registration_date,
            'hora_cita' => $request->hours,
            'name' => $cliente->first_name . ' ' . $cliente->last_name,
        ];
        Mail::to($cliente->email)->send(new \App\Mail\NotificationAppointment($details));

        $cita = new Appointment([
            'registration_date' => $request->registration_date,
            'hours' => $request->hours,
            'end' => $request->end,
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
                'end' => $request->end,
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
        $personals = Personal::where('status', '1')->get()->toArray();
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
        //dd($request);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function citaConsulta(Request $request, $id)
    {
        //
        if ($id >= 1) {
            $appointment = Appointment::select(
                'appointments.pet_id',
                'appointments.personal_id',
                'appointments.client_id',
                'appointments.status',
                'appointments.description',
                Appointment::raw("CONCAT(appointments.registration_date,' ',appointments.hours) AS dateTime"),
            )
                ->join('clients', 'clients.id', '=', 'appointments.client_id')
                ->join('pets', 'pets.id', '=', 'appointments.pet_id')
                ->join('personals', 'personals.id', '=', 'appointments.personal_id')
                ->where('appointments.id', $id)
                ->get();
        }

        return response()->json(new JsonResponse(['items' => $appointment]));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function todasMascota()
    {
        $pets = Pet::where('status', '1')->get()->toArray();
        return response()->json(new JsonResponse(['items' => $pets]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clinicConsulta(Request $request, $id)
    {
        //
        if ($id >= 1) {
            $appointment = Pet::select(
                'pets.id as pet_id',
                'pets.client_id',
                'pets.status',
            )->where('pets.id', $id)->get();
        }

        return response()->json(new JsonResponse(['items' => $appointment]));
    }
}
