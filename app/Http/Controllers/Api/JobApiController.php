<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    public function index(Request $req)
    {
        $q = JobVacancy::query();
        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                ->orWhere('company', 'like', "%$kw%")
                ->orWhere('location', 'like', "%$kw%");
            });
        }
        $jobs = $q->orderBy('created_at','desc')->paginate($req->get('per_page', 10));
        return response()->json($jobs);
    }

    public function show(JobVacancy $job) {
        return response()->json($job);
    }

    public function store(Request $req) {
        // cek role admin
        if ($req->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'nullable|integer',
        ]);
        $job = JobVacancy::create($data);
        return response()->json(['message'=>'Created', 'job'=>$job], 201);
    }
    public function update (Request $req, JobVacancy $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'location' => 'sometimes|required',
            'company' => 'sometimes|required',
            'salary' => 'nullable|integer',
        ]);

        $job->update($data);
        return response()->json(['message'=>'Updated','job'=>$job]);
    }

    public function destroy(Request $req, JobVacancy $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $job->delete();
        return response()->json(['message'=>'Deleted']);
    }
}