<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ActivityResource;
use App\Models\Activities;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ActivityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->sendResponse(ActivityResource::collection(Activities::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'     => 'required',
                'email'   => 'required',
            ],
            [
                'title.required' => 'title cannot be null',
                'email.required' => 'email cannot be null',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400, "Bad Request");
        } else {
            try {
                $activity = Activities::create($request->all());
                return $this->sendResponse(new ActivityResource($activity));
            } catch (QueryException $e) {
                return $this->sendError($e->getMessage(), $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $activity = Activities::find($id);
        if (is_null($activity)) {
            return $this->sendError("Activity with ID $id Not Found");
        } else {
            return $this->sendResponse(new ActivityResource($activity));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'     => 'required',
            ],
            [
                'title.required' => 'title cannot be null',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400, "Bad Request");
        } else {
            try {
                $activity = Activities::find($id);
                if (is_null($activity)) {
                    return $this->sendError("Activity with ID $id Not Found");
                } else {
                    $activity->update($request->all());
                    return $this->sendResponse(new ActivityResource($activity->fresh()));
                }
            } catch (QueryException $e) {
                return $this->sendError($e->getMessage(), $e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $activity = Activities::find($id);
            if (is_null($activity)) {
                return $this->sendError("Activity with ID $id Not Found");
            } else {
                $activity->delete();
                return $this->sendResponse((object)array());
            }
        } catch (QueryException $e) {
            return $this->sendError($e->getMessage(), $e->getMessage());
        }
    }
}
