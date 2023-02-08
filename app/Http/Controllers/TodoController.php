<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Models\Todos;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class TodoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $todo = TodoResource::collection(Todos::all());
        if ($request->has('activity_group_id')) {
            $todo = $todo->where('activity_group_id', $request->get('activity_group_id'));
        }
        return $this->sendResponse($todo);
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
                'activity_group_id'   => 'required',
                'is_active'   => 'required',
            ],
            [
                'title.required' => 'title cannot be null',
                'activity_group_id.required' => 'activity_group_id cannot be null',
                'is_active.required' => 'is_active cannot be null',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400, "Bad Request");
        } else {
            try {
                $todo = Todos::create($request->all());
                return $this->sendResponse(new TodoResource($todo));
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
        $todo = Todos::find($id);
        if (is_null($todo)) {
            return $this->sendError("Activity with ID $id Not Found");
        } else {
            return $this->sendResponse(new TodoResource($todo));
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
        try {
            $todo = Todos::find($id);
            if (is_null($todo)) {
                return $this->sendError("Activity with ID $id Not Found");
            } else {
                $todo->update($request->all());
                return $this->sendResponse(new TodoResource($todo->fresh()));
            }
        } catch (QueryException $e) {
            return $this->sendError($e->getMessage(), $e->getMessage());
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
            $todo = Todos::find($id);
            if (is_null($todo)) {
                return $this->sendError("Activity with ID $id Not Found");
            } else {
                $todo->delete();
                return $this->sendResponse((object)array());
            }
        } catch (QueryException $e) {
            return $this->sendError($e->getMessage(), $e->getMessage());
        }
    }
}
