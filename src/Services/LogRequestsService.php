<?php
namespace BabeRuka\ProfileHub\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestsService
{
    /**
     * Handle the incoming request.
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        return $this->logRequest($request);
    }
    public function logRequest(Request $request): void
    {
        $logData = [
            'ip_address' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            // Add more data as needed
        ];

        Log::info('Incoming Request:', $logData);
    }
}
