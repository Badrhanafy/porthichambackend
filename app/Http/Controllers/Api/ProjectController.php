<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::with('category')->latest()->get());
    }

    public function show(Project $project)
    {
        return response()->json($project->load('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi',
            'is_video' => 'required|boolean',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($request->is_video) {
            $path = $request->file('file')
                ->store('videos', 'public');
        } else {
            $path = $request->file('file')
                ->store('photos', 'public');
        }

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'path' => $path,
            'is_video' => $request->is_video,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project
        ], 201);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi',
            'is_video' => 'sometimes|boolean',
            'category_id' => 'sometimes|exists:categories,id'
        ]);

        if ($request->hasFile('file')) {

            if (Storage::disk('public')->exists($project->path)) {
                Storage::disk('public')->delete($project->path);
            }

            $isVideo = $request->boolean('is_video');

            if ($isVideo) {
                $path = $request->file('file')
                    ->store('videos', 'public');
            } else {
                $path = $request->file('file')
                    ->store('photos', 'public');
            }

            $project->path = $path;
            $project->is_video = $isVideo;
        }

        $project->update([
            'title' => $request->title ?? $project->title,
            'description' => $request->description ?? $project->description,
            'category_id' => $request->category_id ?? $project->category_id,
        ]);

        $project->save();

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        if (Storage::disk('public')->exists($project->path)) {
            Storage::disk('public')->delete($project->path);
        }

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }
}