<!DOCTYPE html>
<html>

<body>
    <p>Dear Dr. {{ $submission->supervisor->name }},</p>

    <p>Your student, <strong>{{ $submission->student->name }}</strong>, has submitted a new application for
        <strong>{{ ucfirst($submission->presentation_type) }}</strong>.</p>

    <p><strong>Submission Details:</strong><br>
        Title: {{ $submission->title }}<br>
        Date: {{ now()->format('d M Y') }}</p>

    <p>Please login to your dashboard to review the document and nominate examiners.</p>

    <p>
        <a href="{{ route('login') }}"
            style="background: #1e3a8a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Go
            to Dashboard</a>
    </p>

    <p>Thank you.</p>
</body>

</html>
