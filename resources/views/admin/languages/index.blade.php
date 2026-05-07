@extends('layouts.admin')

@section('title', 'Manage Languages')

@section('content')
<div class="table-container">
    <div class="table-header">
        <form action="{{ route('admin.languages.index') }}" method="GET" style="display: flex; gap: 1rem;">
            <input type="text" name="search" class="search-input" placeholder="Search languages by name..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.languages.index') }}" class="btn" style="background: #e5e7eb; color: #374151;">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.languages.create') }}" class="btn btn-primary">
            <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Language
        </a>
    </div>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Slug</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($languages as $language)
                    <tr>
                        <td>{{ $language->id }}</td>
                        <td style="font-weight: 600;">{{ $language->name }}</td>
                        <td><span class="badge badge-blue">{{ $language->code }}</span></td>
                        <td>{{ $language->slug }}</td>
                        <td style="color: #6b7280;">{{ $language->created_at->format('M d, Y') }}</td>
                        <td style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.languages.edit', $language) }}" style="color: var(--primary);">Edit</a>
                            <form action="{{ route('admin.languages.destroy', $language) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem; color: #6b7280;">
                            No languages found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($languages->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid #f3f4f6;">
            {{ $languages->links() }}
        </div>
    @endif
</div>
@endsection
