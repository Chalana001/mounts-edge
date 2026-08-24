You have received a new {{ $enquiry->type }} enquiry from the website:

Name: {{ $enquiry->name }}
Email: {{ $enquiry->email }}
Phone: {{ $enquiry->phone }}
Inquiry Type: {{ $enquiry->type }}
@foreach ($enquiry->formatted_details as $label => $value)
{{ $label }}: {{ $value }}
@endforeach
@if (filled($enquiry->message))

Message:
{{ $enquiry->message }}
@endif
