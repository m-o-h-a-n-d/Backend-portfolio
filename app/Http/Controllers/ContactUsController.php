<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Jobs\SendContactUsNotificationJob;
use App\Services\ContactUsService;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected ContactUsService $contactUsService) {}

    public function index()
    {
        $data = $this->contactUsService->getAll();

        if ($data->isEmpty()) {
            return apiResponce(404, 'Not Found');
        }

        return apiResponce(200, 'Success', $data);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactUsRequest $request)
    {
        $data = $request->validated();

        $contactUs = $this->contactUsService->store($data);

        if (! $contactUs) {
            return apiResponce(400, 'Bad Request');
        }

        // Dispatch asynchronous queue job for real-time notification & mail
        SendContactUsNotificationJob::dispatch($contactUs);

        return apiResponce(200, 'Success', $contactUs);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! $this->contactUsService->delete($id)) {
            return apiResponce(404, 'Not Found');
        }

        return apiResponce(200, 'Success');
    }

    public function markRead(string $id)
    {
        $contactUs = $this->contactUsService->markRead($id);

        if (! $contactUs) {
            return apiResponce(404, 'Not Found');
        }

        return apiResponce(200, 'Success', $contactUs);
    }
}
