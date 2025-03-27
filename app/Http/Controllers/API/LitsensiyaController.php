<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLitsensiyaRequest;
use App\Http\Requests\UpdateLitsensiyaRequest;
use App\Models\Appointment;
use App\Models\Litsensiya;

use Illuminate\Http\Client\Request;
use Illuminate\Validation\Validator;

class LitsensiyaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $litsensiyalar = Litsensiya::all();
        return response()->json($litsensiyalar, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|string|unique:litsensiyalar',
            'expiry_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $litsensiya = Litsensiya::create($request->all());
        return response()->json($litsensiya, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $litsensiya = Litsensiya::find($id);
        if (!$litsensiya) {
            return response()->json(['message' => 'Litsensiya topilmadi'], 404);
        }
        return response()->json($litsensiya, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Litsensiya $litsensiya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $litsensiya = Litsensiya::find($id);
        if (!$litsensiya) {
            return response()->json(['message' => 'Litsensiya topilmadi'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'number' => 'sometimes|string|unique:litsensiyalar,number,' . $id,
            'expiry_date' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $litsensiya->update($request->all());
        return response()->json($litsensiya, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $litsensiya = Litsensiya::find($id);
        if (!$litsensiya) {
            return response()->json(['message' => 'Litsensiya topilmadi'], 404);
        }
        $litsensiya->delete();
        return response()->json(['message' => 'Litsensiya o‘chirildi'], 200);
    }
}
