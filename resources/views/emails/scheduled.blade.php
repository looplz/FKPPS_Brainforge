<!DOCTYPE html>
<html>

<body>
    <h2>Presentation Confirmed</h2>
    <p>The presentation schedule for <strong>{{ $schedule->submission->title }}</strong> has been finalized.</p>

    <div style="background: #f3f4f6; padding: 15px; border-left: 4px solid #1e3a8a;">
        <p><strong>Student:</strong> {{ $schedule->submission->student->name }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->presentation_date)->format('d M Y') }}</p>
        <p><strong>Time:</strong> {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
        <p><strong>Venue:</strong> {{ $schedule->venue }}</p>
    </div>

    <p>Please ensure you arrive 15 minutes before the session begins.</p>
    <p>Thank you,<br>Postgraduate Manager</p>
</body>

</html>
