<x-profile :sharedData="$sharedData" doctitle="Who {{ $sharedData['username'] }} Followers">
    @include('profile-following-only')
</x-profile>
