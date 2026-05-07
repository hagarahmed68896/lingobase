<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch Favorites
        $favLessons = $user->favorites()
            ->where('favoritable_type', 'App\Models\GrammarLesson')
            ->with(['favoritable.grammarLevel.language'])
            ->get();
            
        $favStories = $user->favorites()
            ->where('favoritable_type', 'App\Models\Story')
            ->with(['favoritable.storyLevel.language'])
            ->get();

        // Fetch latest placement test result
        $latestPlacementTest = \App\Models\PlacementTest::where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        // Fetch recommendations if test exists
        $recommendations = [];
        if ($latestPlacementTest) {
            $level = $latestPlacementTest->detected_level;
            $levelModel = \App\Models\GrammarLevel::where('slug', 'LIKE', "%" . strtolower($level) . "%")->first();
            if ($levelModel) {
                $recommendations = $levelModel->lessons()->limit(3)->get();
            }
        }

        return view('profile.index', compact('user', 'favLessons', 'favStories', 'latestPlacementTest', 'recommendations'));
    }

    public function update(Request $request)
    {
        \Illuminate\Support\Facades\Log::debug('Profile update started', [
            'has_avatar' => $request->hasFile('avatar'),
            'remove_avatar' => $request->boolean('remove_avatar'),
            'all_data' => $request->all()
        ]);

        $user = Auth::user();

        // Handle avatar removal first (before validation)
        if ($request->boolean('remove_avatar')) {
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
                $user->avatar = null;
            }
            $user->save();
            return redirect()->route('profile.index')->with('success', __('messages.profile_picture_removed'));
        }

        // Validate other fields
        $rules = [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'language' => 'nullable|string|in:en,ar,es',
            'in_app_notifications' => 'sometimes|boolean',
            'email_notifications' => 'sometimes|boolean',
        ];

        // Only validate avatar if a file is being uploaded
        if ($request->hasFile('avatar')) {
            $rules['avatar'] = 'image|max:5120'; // Increase to 5MB for testing
        }

        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Profile validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
             \Illuminate\Support\Facades\Log::debug('Processing avatar upload');
             if ($user->avatar) {
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
             }
             try {
                $path = $request->file('avatar')->store('avatars', 'public');
                \Illuminate\Support\Facades\Log::debug('Avatar stored at: ' . $path);
                $user->avatar = $path;
             } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Avatar storage failed', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Storage failed: ' . $e->getMessage()], 500);
             }
        }

        if ($request->filled('name')) $user->name = $request->name;
        if ($request->filled('email')) $user->email = $request->email;
        if ($request->filled('phone_number')) $user->phone_number = $request->phone_number;
        if ($request->filled('language')) $user->language = $request->language;
        
        // Notification settings
        if ($request->has('in_app_notifications') || $request->has('email_notifications')) {
            $user->in_app_notifications = $request->has('in_app_notifications');
            $user->email_notifications = $request->has('email_notifications');
        }

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();
        \Illuminate\Support\Facades\Log::debug('User saved successfully');

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => __('messages.profile_updated'),
                'avatar_url' => $user->avatar ? \Illuminate\Support\Facades\Storage::url($user->avatar) : null
            ]);
        }

        return redirect()->route('profile.index')->with('success', __('messages.profile_updated'));
    }
}
