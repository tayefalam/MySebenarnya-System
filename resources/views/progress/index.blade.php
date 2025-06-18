<!DOCTYPE html>
<html>
<head>
    <title>Inquiry Progress List</title>
</head>
<body>
    <h2>Inquiry Progress Tracking</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/progress">
        @csrf
        <label>Inquiry ID: <input type="number" name="inquiry_id" required></label><br>
        <label>Agency ID: <input type="text" name="agency_id"></label><br>
        <label>MCMC ID: <input type="text" name="mcmc_id"></label><br>
        <label>Status: <input type="text" name="status" required></label><br>
        <label>Remarks: <textarea name="remarks"></textarea></label><br>
        <button type="submit">Add Progress</button>
    </form>

    <hr>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Updated At</th>
            <th>Remarks</th>
        </tr>
        @foreach($progress as $item)
            <tr>
                <td>{{ $item->inquiry_id }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->update_timestamp }}</td>
                <td>{{ $item->remarks }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
