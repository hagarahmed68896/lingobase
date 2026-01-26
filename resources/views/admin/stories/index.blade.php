@extends('layouts.admin')

@section('title', 'Manage Stories')

@section('content')
<div class="table-container">
    <div class="table-header" style="flex-wrap: wrap; gap: 1rem;">
        <form action="{{ route('admin.stories.index') }}" method="GET" style="display: flex; gap: 1rem; flex: 1;">
            <input type="text" name="search" class="search-input" placeholder="Search stories..." value="{{ request('search') }}">
            <select name="language_id" class="search-input" style="width: 200px;" onchange="this.form.submit()">
                <option value="">All Languages</option>
                @foreach($languages as $language)
                    <option value="{{ $language->id }}" {{ request('language_id') == $language->id ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request('search') || request('language_id'))
                <a href="{{ route('admin.stories.index') }}" class="btn" style="background: #e5e7eb; color: #374151;">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
            <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Story
        </a>
    </div>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Language</th>
                    <th>Level</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stories as $story)
                    <tr>
                        <td>{{ $story->id }}</td>
                        <td style="font-weight: 600;">{{ $story->title }}</td>
                        <td><span class="badge badge-success">{{ $story->storyLevel->language->name }}</span></td>
                        <td><span class="badge badge-blue">{{ $story->storyLevel->name }}</span></td>
                        <td style="color: #6b7280;">{{ $story->updated_at->format('M d, Y') }}</td>
                        <td style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.stories.edit', $story) }}" style="color: var(--primary);">Edit</a>
                            <form action="{{ route('admin.stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem; color: #6b7280;">
                            No stories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($stories->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid #f3f4f6;">
            {{ $stories->links() }}
        </div>
    @endif
</div>
@endsection
