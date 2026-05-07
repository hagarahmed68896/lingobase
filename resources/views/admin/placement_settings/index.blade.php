@extends('layouts.admin')

@section('title', 'Placement Test Settings')

@section('content')
<div class="table-container" style="border: none; background: transparent; box-shadow: none; overflow: visible;">
    <div style="background: white; padding: 2.5rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.5rem; position: relative; z-index: 1;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ecfdf5; color: #059669; padding: 0.4rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    System Config
                </div>
                <h1 style="font-size: 2.25rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2;">Test Configuration</h1>
                <p style="color: #6b7280; font-size: 1rem; margin: 0.5rem 0 0 0; max-width: 500px;">Adjust the number of questions per level and section for the adaptive placement test.</p>
            </div>
            <a href="{{ route('admin.placement-questions.index') }}" class="btn" style="background: #f3f4f6; color: #374151; padding: 0.875rem 1.75rem; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 700;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Questions
            </a>
        </div>

        @if(session('success'))
            <div style="background: #ecfdf5; border-left: 4px solid #059669; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem;">
                <svg width="24" height="24" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.placement-settings.update') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; margin-bottom: 2.5rem;">
                <!-- Grammar Quotas -->
                <div style="background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="background: #eff6ff; color: #2563eb; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b;">Grammar Quotas</h3>
                    </div>
                    @foreach($grammarQuotas as $level => $count)
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Level {{ $level }}</label>
                            <input type="number" name="grammar_quotas[{{ $level }}]" value="{{ $count }}" class="search-input" style="width: 100%; font-weight: 700; font-size: 1.1rem; border-radius: 0.75rem;">
                        </div>
                    @endforeach
                    <p style="font-size: 0.8rem; color: #94a3b8; margin: 1rem 0 0 0;">Total grammar questions: {{ array_sum($grammarQuotas) }}</p>
                </div>

                <!-- Vocabulary Quotas -->
                <div style="background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="background: #fff7ed; color: #ea580c; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b;">Vocabulary Quotas</h3>
                    </div>
                    @foreach($vocabQuotas as $category => $count)
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Category {{ $category }}</label>
                            <input type="number" name="vocab_quotas[{{ $category }}]" value="{{ $count }}" class="search-input" style="width: 100%; font-weight: 700; font-size: 1.1rem; border-radius: 0.75rem;">
                        </div>
                    @endforeach
                </div>

                <!-- Other Sections -->
                <div style="background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="background: #f5f3ff; color: #7c3aed; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b;">Fixed Sections</h3>
                    </div>
                    @foreach($otherQuotas as $section => $count)
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">{{ ucfirst($section) }} Questions</label>
                            <input type="number" name="other_quotas[{{ $section }}]" value="{{ $count }}" class="search-input" style="width: 100%; font-weight: 700; font-size: 1.1rem; border-radius: 0.75rem;">
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem; border-radius: 1rem; font-size: 1rem; box-shadow: 0 4px 14px 0 rgba(0, 145, 80, 0.25);">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
