<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\User;
use App\Laravue\Models\Pet;
use App\Laravue\Models\Client;
use App\Laravue\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      

        $users = User::all()->toArray();
        $pets = Pet::where('status', '=' , '1')
                ->get()
                ->toArray();
        $clients = Client::where('status', '=' , '1')
                ->get()
                ->toArray();
    
        $personals = Personal::where('status', '=' , '1')
                ->get()
                ->toArray();
                  
        return response()->json(new JsonResponse(['total_usuario' => count($users), 'total_mascotas' => count($pets),'total_clientes' => count($clients),'total_personals' => count($personals) ]));
    }

   
}
