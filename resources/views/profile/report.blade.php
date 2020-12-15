@extends('layouts.admin')
@section('title')
	{{Auth::user()->firstname}}
@endsection
@section('content')

<div class="card">
    <div class="card-body">
        <table id="table_data" class="table">
            <thead>
                <td>Serial No.</td>
                <td>Event Title</td>
                <td>Event Type</td>
                <td>Date</td>
            </thead>
            <tbody>
                @php $index = 1 @endphp
                @foreach($data['events'] as $record)
                    <tr>
                        <td> {{ $index++ }}</td>
                        <td> {{ $record->task_title }}</td>
                        <td> {{ $record->task_type }} </td>
                        <td> {{ $record->task_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    InitTable();
</script>
@endsection