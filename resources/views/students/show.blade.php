<h2>Student</h2>
@if($student)
    <ul>
        @foreach ($student as $index => $item)
            <li>
                {{$index . ": " . $item}}
            </li>
        @endforeach
    </ul>
@else 
    <p>Student not found</p>
@endif