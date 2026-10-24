<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreSessionRequest;
use App\Http\Requests\Api\V1\UpdateSessionRequest;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SessionApiController
 *
 * REST API controller managing academic sessions under /api/v1/academic/sessions.
 * Explicitly manages educational calendar terms, distinct from HTTP web sessions.
 *
 * @package App\Http\Controllers\Api\V1
 */
class SessionApiController extends ApiController
{
    /**
     * Display a listing of academic sessions.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Session::whereNull('deleted_at');

        if ($request->has('is_active')) {
            $query->where('IsActive', (int) $request->input('is_active'));
        }

        $sessions = $query->orderBy('id', 'asc')->get();

        return $this->success($sessions, 'Academic sessions retrieved successfully');
    }

    /**
     * Display the specified academic session.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $session = Session::whereNull('deleted_at')->find($id);

        if (!$session) {
            return $this->error('Academic session not found', 404);
        }

        return $this->success($session, 'Academic session retrieved successfully');
    }

    /**
     * Store a newly created academic session.
     *
     * @param StoreSessionRequest $request
     * @return JsonResponse
     */
    public function store(StoreSessionRequest $request): JsonResponse
    {
        $session = Session::create($request->validated());

        return $this->success($session, 'Academic session created successfully', 201);
    }

    /**
     * Update the specified academic session.
     *
     * @param UpdateSessionRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSessionRequest $request, $id): JsonResponse
    {
        $session = Session::whereNull('deleted_at')->find($id);

        if (!$session) {
            return $this->error('Academic session not found', 404);
        }

        $session->update($request->validated());

        return $this->success($session, 'Academic session updated successfully');
    }

    /**
     * Remove the specified academic session.
     * Prevents deletion if student registrations are linked.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $session = Session::whereNull('deleted_at')->find($id);

        if (!$session) {
            return $this->error('Academic session not found', 404);
        }

        if (method_exists($session, 'SessionInfo') && $session->SessionInfo()->count() > 0) {
            return $this->error('Cannot delete academic session: active student registrations are linked to this session', 422);
        }

        $session->delete();

        return $this->success(null, 'Academic session deleted successfully');
    }
}
