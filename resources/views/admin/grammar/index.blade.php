@extends('layouts.admin')

@section('title', 'Manage Grammar Lessons')

@section('content')
@section('content')
<div class="table-container" style="border: none; background: transparent; box-shadow: none; overflow: visible;">
    <!-- Modern Header & Filters -->
    <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin: 0;">Grammar Bank</h1>
                <p style="color: #6b7280; font-size: 0.95rem; margin: 0.25rem 0 0 0;">Manage your educational content and localized explanations.</p>
            </div>
            <a href="{{ route('admin.grammar.create') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 700;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Add New Lesson
            </a>
        </div>

        <form action="{{ route('admin.grammar.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #9ca3af; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Search Title</label>
                <input type="text" name="search" class="search-input" style="width: 100%;" placeholder="Search lessons..." value="{{ request('search') }}">
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #9ca3af; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Language</label>
                <select name="language_id" class="search-input" style="width: 100%;" onchange="this.form.submit()">
                    <option value="">All Languages</option>
                    @foreach($languages as $language)
                        <option value="{{ $language->id }}" {{ request('language_id') == $language->id ? 'selected' : '' }}>
                            {{ $language->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Apply Filters</button>
                @if(request('search') || request('language_id'))
                    <a href="{{ route('admin.grammar.index') }}" class="btn" style="background: #f3f4f6; color: #374151; padding: 0.625rem 1rem;">Reset</a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Premium Table Layout -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Lesson Details</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Language & Level</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Localization</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Order</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody style="background: white;">
                    @forelse($lessons as $lesson)
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                            <td style="padding: 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 40px; height: 40px; background: #ecfdf5; color: #059669; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">
                                        {{ substr($lesson->title, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #111827; font-size: 1rem;">{{ $lesson->title }}</div>
                                        <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 0.1rem;">ID: #{{ $lesson->id }} • {{ $lesson->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1.5rem;">
                                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="width: 8px; height: 8px; background: #009150; border-radius: 50%;"></span>
                                        <span style="font-weight: 600; color: #374151; font-size: 0.9rem;">{{ $lesson->grammarLevel->language->name }}</span>
                                    </div>
                                    <div style="display: inline-flex; align-items: center; gap: 0.4rem; background: #eff6ff; color: #1d4ed8; padding: 0.2rem 0.6rem; border-radius: 1rem; width: fit-content; font-size: 0.75rem; font-weight: 700;">
                                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        {{ $lesson->grammarLevel->name }}
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1.5rem; text-align: center;">
                                @if($lesson->arabic_explanation)
                                    <span style="background: #fef3c7; color: #92400e; padding: 0.4rem 0.8rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; border: 1px solid #fde68a;">Arabic Ready</span>
                                @else
                                    <span style="background: #f3f4f6; color: #9ca3af; padding: 0.4rem 0.8rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 600;">English Only</span>
                                @endif
                            </td>
                            <td style="padding: 1.5rem;">
                                <div style="font-weight: 700; color: #111827;">{{ $lesson->order }}</div>
                            </td>
                            <td style="padding: 1.5rem; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                                    <a href="{{ route('admin.grammar.edit', $lesson) }}" style="background: #f3f4f6; color: #1f2937; padding: 0.5rem; border-radius: 0.5rem; transition: all 0.2s;" title="Edit Lesson" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.grammar.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lesson?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 0.5rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;" title="Delete Lesson" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 4rem 2rem;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; color: #9ca3af;">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="opacity: 0.5;"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"/></svg>
                                    <div style="font-weight: 600; font-size: 1.1rem;">No lessons found</div>
                                    <p style="margin: 0; font-size: 0.9rem;">Try adjusting your filters or search terms.</p>
                                    <a href="{{ route('admin.grammar.index') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; margin-top: 0.5rem;">Clear all filters</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lessons->hasPages())
            <div style="padding: 1.5rem; background: #f9fafb; border-top: 1px solid #e5e7eb;">
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing {{ $lessons->firstItem() }} to {{ $lessons->lastItem() }} of {{ $lessons->total() }} results
                    </div>
                    {{ $lessons->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
