<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ThreadController extends Controller
{
    public function index()
    {
        return Thread::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        $thread = $user->threads()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json($thread, 201);
    }

    public function show(string $id)
    {
        return Thread::with('user')->findOrFail($id);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $thread = Thread::findOrFail($id);

        if ($thread->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $thread->update($request->only('title', 'body'));

        return response()->json($thread);
    }

    public function destroy(string $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $thread = Thread::findOrFail($id);

        if ($thread->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $thread->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
