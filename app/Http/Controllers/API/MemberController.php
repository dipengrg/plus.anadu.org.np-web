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
use App\Services\MemberService;

class MemberController extends Controller
{
    // Dependency Injection
    public $memberService;

    // Constructor
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    // Get all members
    public function getMembers()
    {
        return ApiResponse::success([
            'message' => __('member.listed'), 
            'data' => $this->memberService->getAllOrderedWithUser()
        ]);
    }

    // Post a member
    public function postMember(MemberAddRequest $request) {
        // Create member
        $this->memberService->create($request->validated());

        // Return a success response
        return ApiResponse::success(['message' => __('member.posted'), 'member' => $member]);
    }

    // Get a single member
    public function getMember(Member $member)
    {
        return ApiResponse::success([
            'message' => __('member.retrieved'), 
            'data' => $this->memberService->getById($member)
        ]);
    }

    // Post member avatar
    public function postMemberAvatar(FileUploadRequest $request, Member $member) {
        // Update avatar
        $photo_name = $this->memberService->updateAvatar($member, $request->file('file'));

        // Return a success response
        return ApiResponse::success([
            'message' => __('member.avatar_uploaded'), 
            'data' => $photo_name
        ]);
    }

    // Update member
    public function updateMember(MemberAddRequest $request, Member $member)
    {
        // Update member
        $updatedMember = $this->memberService->update($member, $request->validated());

        // Return a success response
        return ApiResponse::success([
            'message' => __('member.updated'), 
            'member' => $updatedMember
        ]);
    }

    // Delete member
    public function deleteMember(Member $member)
    {
        // Delete member
        $this->memberService->delete($member);

        // Return a success response
        return ApiResponse::success(['message' => __('member.deleted')]);
    }
}
