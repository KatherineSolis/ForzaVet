<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ClientController extends Controller
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

        $animals = Client::all()->toArray();

        if (!empty($name)) {
            $animals = Client::where('first_name', 'LIKE', '%' . $name . '%')
                ->OrWhere('last_name', 'LIKE', '%' . $name . '%')
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
        $client = new Client([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'direction' => $request->direction,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $client->save();
        $data = ['id' => $client->toArray()['id']];

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
        $animal = Client::where('id', $id)
        ->update([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'direction' => $request->direction,
            'email' => $request->email,
            'phone' => $request->phone,
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
