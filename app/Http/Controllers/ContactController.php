<?php

namespace App\Http\Controllers;

use App\Mail\NewEnquiryNotification;
use App\Models\Enquiry;
use App\Models\RoomType;
use App\Models\SiteSetting;
use App\Models\WeddingHall;
use App\Models\WeddingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    /**
     * The contact page. Dropdown options come from the database so room types
     * and halls added later in the admin panel appear here automatically.
     * Query params allow deep links such as
     * /contact?type=Room+Booking&room_type=Deluxe+Rooms
     */
    public function index(Request $request): View
    {
        $requestedType = $request->query('type');

        return view('contact', [
            'roomTypes' => RoomType::orderBy('name')->get(),
            'weddingHalls' => WeddingHall::orderBy('name')->get(),
            'weddingPackages' => WeddingPackage::orderBy('name')->get(),
            'preselectedType' => in_array($requestedType, Enquiry::TYPES, true) ? $requestedType : '',
            'preselectedRoomType' => (string) $request->query('room_type', ''),
            'preselectedHall' => (string) $request->query('hall', ''),
        ]);
    }

    public function sendEnquiry(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'type' => ['required', Rule::in(Enquiry::TYPES)],
            // Optional once the visitor has answered the structured questions,
            // but required for a general enquiry where it is the only content.
            'message' => ['required_if:type,'.Enquiry::TYPE_GENERAL, 'nullable', 'string', 'max:5000'],

            'details.room_type' => ['nullable', 'string', Rule::exists('room_types', 'name')],
            'details.check_in' => ['required_if:type,'.Enquiry::TYPE_ROOM, 'nullable', 'date', 'after_or_equal:today'],
            'details.check_out' => ['required_if:type,'.Enquiry::TYPE_ROOM, 'nullable', 'date', 'after:details.check_in'],
            'details.guests' => ['required_if:type,'.Enquiry::TYPE_ROOM, 'nullable', 'integer', 'min:1', 'max:50'],
            'details.rooms' => ['nullable', 'integer', 'min:1', 'max:20'],

            'details.hall' => ['nullable', 'string', Rule::exists('wedding_halls', 'name')],
            'details.package' => ['nullable', 'string', Rule::exists('wedding_packages', 'name')],
            'details.event_date' => ['required_if:type,'.Enquiry::TYPE_WEDDING, 'nullable', 'date', 'after_or_equal:today'],
            'details.event_guests' => ['required_if:type,'.Enquiry::TYPE_WEDDING, 'nullable', 'integer', 'min:1', 'max:2000'],

            'details.dining_date' => ['required_if:type,'.Enquiry::TYPE_DINING, 'nullable', 'date', 'after_or_equal:today'],
            'details.dining_time' => ['required_if:type,'.Enquiry::TYPE_DINING, 'nullable', 'date_format:H:i'],
            'details.party_size' => ['required_if:type,'.Enquiry::TYPE_DINING, 'nullable', 'integer', 'min:1', 'max:100'],
        ], [
            'details.check_in.required_if' => 'Please choose your check-in date.',
            'details.check_out.required_if' => 'Please choose your check-out date.',
            'details.check_out.after' => 'The check-out date must be after the check-in date.',
            'details.guests.required_if' => 'Please tell us how many guests are staying.',
            'details.event_date.required_if' => 'Please choose your event date.',
            'details.event_guests.required_if' => 'Please tell us how many guests you expect.',
            'details.dining_date.required_if' => 'Please choose a date for your reservation.',
            'details.dining_time.required_if' => 'Please choose a time for your reservation.',
            'details.party_size.required_if' => 'Please tell us how many people are dining.',
        ]);

        $data['details'] = $this->detailsForType($data['type'], $data['details'] ?? []);
        // The message column is NOT NULL, so an omitted optional message is
        // stored as an empty string; filled() then hides it in the admin
        // view and the notification email.
        $data['message'] = $data['message'] ?? '';

        $enquiry = Enquiry::create($data);

        try {
            $notificationEmail = SiteSetting::current()->notification_email;
            Mail::to($notificationEmail)->send(new NewEnquiryNotification($enquiry));
        } catch (Throwable $exception) {
            // NewEnquiryNotification::failed() already reports + records the
            // failure when the queued send itself fails; this catch only
            // covers a synchronous queue connection re-throwing, or a
            // failure before dispatch (e.g. resolving $notificationEmail).
            report($exception);
            $enquiry->update(['email_notification_failed' => true]);
        }

        return back()->with('success', 'Thank you! Your inquiry has been sent successfully.');
    }

    /**
     * Keep only the detail keys that belong to the chosen type and drop empty
     * values. Hidden fields still post, so this cannot be left to the browser.
     *
     * @param  array<string, mixed>  $details
     * @return array<string, mixed>
     */
    private function detailsForType(string $type, array $details): array
    {
        $allowed = Enquiry::TYPE_DETAIL_KEYS[$type] ?? [];

        return array_filter(
            array_intersect_key($details, array_flip($allowed)),
            fn ($value) => $value !== null && $value !== ''
        );
    }
}
