<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Todo\Todo;

class TodolistAPIController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['index']
        ]);
    }

    /**
     * Show the todolist.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Todo::list()->get();
    }

    /**
     * Show the todolist with also private.
     *
     * @return \Illuminate\Http\Response
     */
    public function privateIndex(Request $request)
    {
        return Todo::list()->get();
    }

    /**
     * Store new thing to do.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has('title')) {
            return redirect()->back();
        }

        $todo = new Todo;
        $todo->title = $request->input('title');
        $todo->privacy = $request->input('privacy') == 'private'
            ? 'private' : 'public';
        $todo->user()->associate(auth()->user());

        if (!$todo->save()) {
            return abort(400);
        }

        return $todo;
    }

    /**
     * Update specified task.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        if (auth()->user()->cant('update', $todo)) {
            return abort(400);
        }

        if ($request->has('privacy')) {
            $todo->privacy = (string) $request->input('privacy') == 'private'
                ? 'private' : 'public';
        }

        if ($request->has('finished')) {
            $todo->finished = ($request->input('finished')+0) == 1
                ? true : false;
        }

        if (!$todo->save()) {
            return abort(400);
        }

        return $todo;
    }

    /**
     * Delete specified task.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $todo = Todo::findOrFail($id);

        if (auth()->user()->cant('delete', $todo)) {
            return abort(400);
        }

        if (!$todo->delete()) {
            return abort(400);
        }

        return $todo;
    }
}
