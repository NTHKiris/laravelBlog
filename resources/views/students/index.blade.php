@php
    $isActive = false;
    $hasError = true;
@endphp
<h1>Danh sách sinh viên </h1>
<ul>
    @foreach ($students as $student)
        <li>
            <a href="{{route('students.show',$student['id'])}}">
                {{$student['name']}}
            </a>
        </li>
    @endforeach
    <hr>
    <span @class(['p-4', 'font-bold' => $isActive, 'bg-gray'=>$hasError, 'text-gray-500'=>$isActive])>helll0    </span>

</ul>
