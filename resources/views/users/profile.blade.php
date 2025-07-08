<x-app-layout>
    <h2>User profile</h2>
    <ul>
        <li>Address: {{ $user->profile->address ?? 'Not provided' }}</li>
        <li>Phone: {{ $user->profile->phone ?? 'Not provided' }}</li>
        <li>Birth date: {{ $user->profile->birth_date ?? 'Not provided' }}</li>
    </ul>
</x-app-layout>