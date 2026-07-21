<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'nullable|in:active,inactive,pending_approval', // Allow status to be set, default handled by migration
        ]);

        $member = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'] ?? 'active', // Set status, default to 'active' if not provided
        ]);

        $member->assignRole('anggota');

        return redirect()->route('members.index')->with('success', 'Anggota baru berhasil didaftarkan.');
    }

    /**
     * Display a listing of members, optionally filtered by status.
     */
    public function index(Request $request)
    {
        $query = User::role('anggota');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to showing active members if no status filter is applied
            $query->where('status', 'active');
        }

        $members = $query->latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    /**
     * Display the specified member.
     */
    public function show(string $id)
    {
        $member = User::role('anggota')->findOrFail($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(string $id)
    {
        $member = User::role('anggota')->findOrFail($id);
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = User::role('anggota')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive,pending_approval', // Ensure status is valid
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'status' => $validated['status'], // Update status
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($member->profile_photo_path && \Storage::disk('public')->exists($member->profile_photo_path)) {
                \Storage::disk('public')->delete($member->profile_photo_path);
            }
            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $updateData['profile_photo_path'] = $path;
        }

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $member->update($updateData);

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(string $id)
    {
        $member = User::role('anggota')->findOrFail($id);
        
        // Delete profile photo if exists
        if ($member->profile_photo_path && \Storage::disk('public')->exists($member->profile_photo_path)) {
            \Storage::disk('public')->delete($member->profile_photo_path);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil dihapus.');
    }

    /**
     * Display members pending approval.
     */
    public function pendingApproval()
    {
        $members = User::role('anggota')->where('status', 'pending_approval')->latest()->paginate(10);
        return view('members.pending', compact('members')); // Assumes a 'pending' view exists
    }

    /**
     * Approve a member's registration.
     */
    public function approve(string $id)
    {
        $member = User::role('anggota')->findOrFail($id);
        $member->update(['status' => 'active']);

        // Potentially send a notification or email to the member
        return redirect()->back()->with('success', 'Anggota berhasil diaktifkan.');
    }

    /**
     * Reject a member's registration.
     */
    public function reject(string $id)
    {
        $member = User::role('anggota')->findOrFail($id);
        $member->update(['status' => 'inactive']); // Or a 'rejected' status if preferred

        // Potentially notify the member about rejection
        return redirect()->back()->with('success', 'Anggota berhasil ditolak/dinonaktifkan.');
    }
}


