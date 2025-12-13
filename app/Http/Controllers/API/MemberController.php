<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberAddRequest;
use App\Http\Requests\FileUploadRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MemberController extends Controller
{
    // Get all members
    public function getMembers(Member $members)
    {
        return ApiResponse::success([
            'message' => __('member.listed'), 
            'data' => $members->orderBy('name', 'ASC')->with(['user'])->get()
        ]);
    }

    // Post a member
    public function postMember(MemberAddRequest $request) {
        $member = new Member;
        $member->user_id = $request->has('user_id') ? $request->get('user_id') : null;
        $member->title = $request->get('title');
        $member->name = $request->get('name');
        $member->gender = $request->get('gender');
        $member->dob = $request->get('dob');
        $member->address = $request->get('address');
        $member->current_residence = $request->get('current_residence');
        $member->status = $request->has('status') ? $request->get('status') : null;
        $member->save();

        // Return a success response
        return ApiResponse::success(['message' => __('member.posted'), 'member' => $member]);
    }

    // Get a single member
    public function getMember(Member $member)
    {
        return ApiResponse::success([
            'message' => __('member.retrieved'), 
            'data' => $member->load(['user'])
        ]);
    }

    // Post member avatar
    public function postMemberAvatar(FileUploadRequest $request, Member $member) {
        // Get old photo
        $old_photo_name = $member->photo;

        $file = $request->file('photo');
        $photo_name = sha1($member->id.time()) . '.' . $file->getClientOriginalExtension();

        // Store file
        Storage::disk('public')->put($photo_name, File::get($file));

        // create image manager and resize image
        $manager = new ImageManager(new Driver());
        $image = $manager->read(storage_path($photo_name));
        $image->cover(600, 600);
        $image->save();

        // Delete file if exists
        if (Storage::disk('public')->exists($old_photo_name)) {
            Storage::disk('public')->delete($old_photo_name);
        }

        $member->photo = $photo_name;
        $member->save();

        return ApiResponse::success([
            'message' => __('member.avatar_uploaded'), 
            'data' => $photo_name
        ]);
    }

    // Update member
    public function updateMember(MemberAddRequest $request, Member $member)
    {
        $member->user_id = $request->has('user_id') ? $request->get('user_id') : null;
        $member->title = $request->get('title');
        $member->name = $request->get('name');
        $member->gender = $request->get('gender');
        $member->dob = $request->get('dob');
        $member->address = $request->get('address');
        $member->current_residence = $request->get('current_residence');
        $member->status = $request->has('status') ? $request->get('status') : null;
        $member->save();

        // Return a success response
        return ApiResponse::success([
            'message' => __('member.updated'), 
            'member' => $member
        ]);
    }

    // Delete member
    public function deleteMember(Member $member)
    {
        $member->delete();

        // Return a success response
        return ApiResponse::success(['message' => __('member.deleted')]);
    }
}
