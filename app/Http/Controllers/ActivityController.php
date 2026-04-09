<?php

namespace App\Http\Controllers;

use App\Models\Activity;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createActivity()
    {
        $response = (object)[];

        try {

            $validatedData = request()->validate([
                'user_id' => 'required|integer',
                'activity_type' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $activity = new Activity();
            
            $activity->user_id = $validatedData['user_id'];
            $activity->activity_type = $validatedData['activity_type'];
            $activity->description = $validatedData['description'];
            $activity->save();

            $response -> status = '200';
            $response -> message = 'Activity created successfully.';
            $response -> data = $activity;
                
        } catch (\Exception $e) {
            $response -> status = '500';
            $response -> message = 'Failed to create activity.';
            $response -> error = $e->getMessage();
        }
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
