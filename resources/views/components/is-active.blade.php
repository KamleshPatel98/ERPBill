@props(['isActive'])

<span class="badge {{ $isActive ? 'bg-success' : 'bg-danger' }}">
    {{ $isActive ? 'Active' : 'Inactive' }}
</span>