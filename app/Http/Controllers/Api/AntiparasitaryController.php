<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Antiparasitic;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AntiparasitaryController extends Controller
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
        $name = Arr::get($searchParams, 'name_antiparasitic', '');

        $vaccines = Antiparasitic::all()->toArray();

        if (!empty($name)) {
            $vaccines = Antiparasitic::where('name_antiparasitic', 'LIKE', '%' . $name . '%')->get()->toArray();
        }
        return response()->json(new JsonResponse(['items' => $vaccines, 'total' => count($vaccines)]));
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

        $vaccine = new Antiparasitic([
            'name_antiparasitic' => $request->name_antiparasitic,
            'detail' => $request->detail,
        ]);

        $vaccine->save();
        $data = ['id' => $vaccine->toArray()['id']];

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
        $vaccine = Antiparasitic::where('id', $id)
            ->update([
                'name_antiparasitic' => $request->name_antiparasitic,
                'detail' => $request->detail,
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
