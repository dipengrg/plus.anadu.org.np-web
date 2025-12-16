<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class MemberService
{
    // Get a member by ID with user
    public function getById(Member $member): Member
    {
        return $member->load('user');
    }

    // Get all members ordered with user
    public function getAllOrderedWithUser() : Member
    {
        return Member::with('user')->orderBy('id', 'DESC')->get();
    }

    // Create a member
    public function create(array $data) : Member
    {
        $member = new Member;
        $member->user_id = $data['user_id'] ?? null;
        $member->title = $data['title'];
        $member->name = $data['name'];
        $member->gender = $data['gender'];
        $member->dob = $data['dob'];
        $member->address = $data['address'];
        $member->current_residence = $data['current_residence'];
        $member->status = $data['status'] ?? null;
        $member->save();

        return $member;
    }

    // Update a member
    public function update(Member $member, array $data): Member
    {
        $member->update([
            'user_id' => $data['user_id'] ?? null,
            'title' => $data['title'] ?? null,
            'name' => $data['name'],
            'gender' => $data['gender'] ?? null,
            'dob' => $data['dob'] ?? null,
            'address' => $data['address'] ?? null,
            'current_residence' => $data['current_residence'] ?? null,
            'status' => $data['status'] ?? null,
        ]);

        return $member;
    }

    // Delete a member
    public function delete(Member $member): void
    {
        $member->delete();
    }

    // Update member avatar
    public function updateAvatar(Member $member, UploadedFile $file): string
    {
        $oldPhoto = $member->photo;

        $photoName = sha1($member->id . time()) . '.' . $file->getClientOriginalExtension();

        // Store original file
        Storage::disk('public')->put($photoName, File::get($file));

        // Resize image
        $manager = new ImageManager(new Driver());
        $image = $manager->read(storage_path('app/public/' . $photoName));
        $image->cover(600, 600);
        $image->save();

        // Delete old photo if exists
        if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
            Storage::disk('public')->delete($oldPhoto);
        }

        // Update member
        $member->update([
            'photo' => $photoName,
        ]);

        return $photoName;
    }
}
