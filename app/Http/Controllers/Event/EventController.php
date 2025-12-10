<?php
namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\EventVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.view event'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $events = Event::with([
            'images' => function($q){ $q->latest(); },
            'coverImage'
        ])->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create(): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.create event'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $event = Event::create($request->only(['name', 'description']));

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('events', 'public');
            $img = $event->images()->create(['image_path' => $path]);
            $event->update(['cover_image_id' => $img->id]);
        }
        
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function show(Event $event): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.view event'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $event->load(['images','videos']);
        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View|RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.edit event'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.edit event'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $event->update($request->only(['name', 'description']));

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('events', 'public');
            $img = $event->images()->create(['image_path' => $path]);
            $event->update(['cover_image_id' => $img->id]);
        }
        
        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.delete event'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        foreach ($event->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $event->delete();
        
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function uploadImages(Request $request, Event $event)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.upload event image'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $uploadedImages = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('events', 'public');
                $eventImage = $event->images()->create(['image_path' => $path]);
                $uploadedImages[] = [
                    'id' => $eventImage->id,
                    'url' => Storage::url($path)
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully!',
            'images' => $uploadedImages
        ]);
    }

    public function deleteImage(EventImage $image)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.delete event image'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        
        return response()->json(['success' => true, 'message' => 'Image deleted successfully!']);
    }

    // New: unified media upload (images + videos)
    public function uploadMedia(Request $request, Event $event)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'file|max:51200' // 50MB per file (handled by per-type checks below as well)
        ]);

        $images = [];
        $videos = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $mime = $file->getMimeType();
                if (str_starts_with($mime, 'image/')) {
                    // validate image types
                    $extOk = in_array($file->extension(), ['jpg','jpeg','png','gif','webp']);
                    if (!$extOk || $file->getSize() > 2 * 1024 * 1024) {
                        return response()->json(['success' => false, 'message' => 'Invalid image file or exceeds 2MB'], 422);
                    }
                    $path = $file->store('events', 'public');
                    $eventImage = $event->images()->create(['image_path' => $path]);
                    $images[] = [
                        'id' => $eventImage->id,
                        'url' => Storage::url($path),
                    ];
                } elseif (str_starts_with($mime, 'video/')) {
                    // validate video types
                    $extOk = in_array($file->extension(), ['mp4','mov','m4v','webm','ogg']);
                    if (!$extOk || $file->getSize() > 50 * 1024 * 1024) {
                        return response()->json(['success' => false, 'message' => 'Invalid video file or exceeds 50MB'], 422);
                    }
                    $path = $file->store('events/videos', 'public');
                    $eventVideo = $event->videos()->create([
                        'video_path' => $path,
                        'mime' => $mime,
                        'size' => $file->getSize(),
                    ]);
                    $videos[] = [
                        'id' => $eventVideo->id,
                        'url' => Storage::url($path),
                        'mime' => $mime,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Media uploaded successfully!',
            'images' => $images,
            'videos' => $videos,
        ]);
    }

    public function deleteVideo(EventVideo $video)
    {
        Storage::disk('public')->delete($video->video_path);
        $video->delete();
        return response()->json(['success' => true, 'message' => 'Video deleted successfully!']);
    }

    // Stream/open media through Laravel to avoid web server 403s
    public function openImage(EventImage $image)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.view event image'))) {
            abort(403);
        }
        $path = $image->image_path;
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
        $mime = Storage::disk('public')->mimeType($path) ?: 'image/jpeg';
        return Storage::disk('public')->response($path, null, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    public function downloadImage(EventImage $image)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Events Management.download event image'))) {
            abort(403);
        }
        $path = $image->image_path;
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
        return Storage::disk('public')->download($path, basename($path));
    }

    public function openVideo(EventVideo $video)
    {
        $path = $video->video_path;
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
        $mime = $video->mime ?: Storage::disk('public')->mimeType($path) ?: 'video/mp4';
        return Storage::disk('public')->response($path, null, [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    public function downloadVideo(EventVideo $video)
    {
        $path = $video->video_path;
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
        return Storage::disk('public')->download($path, basename($path));
    }
}
