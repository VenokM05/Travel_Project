<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle multi-file upload
     */
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi|max:51200', // 50MB max
            'type' => 'nullable|in:image,video,avatar,receipt',
        ]);

        $uploadedUrls = [];
        $type = $request->input('type', 'image');
        $now = now();
        $path = "uploads/{$type}/{$now->format('Y')}/{$now->format('m')}";

        foreach ($request->file('files') as $file) {
            $filename = $file->hashName();
            $filePath = $file->storeAs($path, $filename, 'public');
            $uploadedUrls[] = Storage::url($filePath);
        }

        // Update user's storage used
        $user = auth()->user();
        $totalSize = collect($request->file('files'))->sum(fn($f) => $f->getSize() / 1024 / 1024); // MB
        $user->increment('storage_used', $totalSize);

        return response()->json([
            'success' => true,
            'urls' => $uploadedUrls,
        ]);
    }

    /**
     * Delete uploaded file
     */
    public function destroy($file)
    {
        // Remove 'storage/' prefix if present
        $path = str_replace('/storage/', '', $file);
        
        if (Storage::disk('public')->exists($path)) {
            $size = Storage::disk('public')->size($path);
            Storage::disk('public')->delete($path);

            // Update user's storage used
            $user = auth()->user();
            $user->decrement('storage_used', $size / 1024 / 1024); // MB

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }

    /**
     * AJAX single photo upload (for memories create form)
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120', // 5MB max
        ]);

        $file = $request->file('file');
        $now = now();
        $path = "uploads/memory/{$now->format('Y')}/{$now->format('m')}";
        $filename = $file->hashName();
        $filePath = $file->storeAs($path, $filename, 'public');
        $url = Storage::url($filePath);

        // Update user's storage used
        $user = auth()->user();
        $user->increment('storage_used', $file->getSize() / 1024 / 1024); // MB

        return response()->json([
            'success' => true,
            'url' => $url,
            'filename' => $filename,
        ]);
    }

    /**
     * AJAX delete uploaded photo
     */
    public function deletePhoto(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        // Convert URL to storage path
        $path = str_replace('/storage/', '', $request->url);
        
        if (Storage::disk('public')->exists($path)) {
            $size = Storage::disk('public')->size($path);
            Storage::disk('public')->delete($path);

            // Update user's storage used
            $user = auth()->user();
            $user->decrement('storage_used', $size / 1024 / 1024); // MB

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }
}
