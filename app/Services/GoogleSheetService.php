<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    /**
     * Append a booking row to Google Sheets via Apps Script Web App.
     *
     * @param  array<string, mixed>  $bookingData
     */
    public function appendBooking(array $bookingData): bool
    {
        $url = config('services.google_sheets.apps_script_url');

        if (empty($url)) {
            Log::warning('Google Sheets Apps Script URL is not configured.');

            return false;
        }

        try {
            $response = Http::timeout(15)
                ->post($url, $bookingData);

            if ($response->successful()) {
                Log::info('Booking data sent to Google Sheets.', [
                    'booking_code' => $bookingData['booking_code'] ?? 'N/A',
                ]);

                return true;
            }

            Log::error('Google Sheets API returned error.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send data to Google Sheets.', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
