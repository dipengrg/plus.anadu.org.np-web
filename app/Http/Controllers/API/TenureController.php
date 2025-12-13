<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenure;
use App\Http\Responses\ApiResponse;
use App\Http\Requests\TenureMemberAddRequest;
use App\Models\Member;

class TenureController extends Controller
{
    // Get list of tenures
    public function getTenures(Tenure $tenures)
    {
        return ApiResponse::success([
            'message' => __('tenure.listed'), 
            'data' => $tenures->orderBy('id', 'ASC')->get()
        ]);
    }

    // Get a tenure
    public function getTenure(Tenure $tenure)
    {
        return ApiResponse::success([
            'message' => __('tenure.view'), 
            'data' => $tenure
        ]);
    }

    // Create a new tenure
    public function postTenure(Request $request)
    {
        $tenure = new Tenure;
        $tenure->title = $request->get('title');
        $tenure->started_on = $request->get('started_on');
        $tenure->ended_on = $request->get('ended_on');
        $tenure->save();

        return ApiResponse::success([
            'message' => __('tenure.created'), 
            'data' => $tenure
        ]);
    }

    // Delete a tenure
    public function deleteTenure(Tenure $tenure)
    {
        $tenure->delete();

        return ApiResponse::success([
            'message' => __('tenure.deleted'), 
            'data' => $tenure
        ]);
    }

    // Add member to a tenure
    public function postTenureMember(TenureMemberAddRequest $request, Tenure $tenure)
    {
        $tenure->members()->attach(
            $request->member_id,
            [
                'designation' => $request->designation,
                'level' => $request->level,
            ]
        );

        return ApiResponse::success([
            'message' => __('tenure.member_added'), 
            'data' => $tenure
        ]);
    }

    // Remove member from a tenure
    public function deleteTenureMember(Tenure $tenure, Member $member)
    {
        $tenure->members()->detach($member->id);

        return ApiResponse::success([
            'message' => __('tenure.member_removed'), 
            'data' => $tenure
        ]);
    }
}
