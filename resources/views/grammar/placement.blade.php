@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .hero-section {
        background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);
        padding: 4rem 2rem;
        color: white;
        text-align: center;
    }
    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .content-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    .quiz-card {
        background: white;
        border-radius: 1.5rem;
        padding: 3rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    .question-item {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .question-item:last-child {
        border-bottom: none;
    }
    .question-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1rem;
    }
    .options-grid {
        display: grid;
        gap: 0.75rem;
    }
    .option-label {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .option-label:hover {
        border-color: #4338ca;
        background: #eef2ff;
    }
    .option-label input {
        margin-right: 1rem;
        accent-color: #4338ca;
    }
    .submit-btn {
        background: #4338ca;
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s;
    }
    .submit-btn:hover {
        background: #3730a3;
    }
    .result-section {
        display: none;
        text-align: center;
        padding: 2rem;
        background: #f0fdf4;
        border: 2px solid #16a34a;
        border-radius: 1rem;
        margin-top: 2rem;
    }
    .result-title {
        color: #166534;
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    .result-desc {
        color: #15803d;
        margin-bottom: 1.5rem;
    }
    .level-btn {
        display: inline-block;
        background: #16a34a;
        color: white;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="hero-section">
    <h1 class="hero-title">English Level Placement Test</h1>
    <p style="opacity: 0.9; font-size: 1.1rem;">Answer 10 questions to find your approximate English grammar level.</p>
</div>

<div class="content-wrapper">
    <div class="quiz-card">
        <form id="placement-form">
            <!-- Beginner (A1/A2) Questions -->
            <div class="question-item">
                <p class="question-text">1. I _____ from France.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q1" value="a">is</label>
                    <label class="option-label"><input type="radio" name="q1" value="b">are</label>
                    <label class="option-label"><input type="radio" name="q1" value="c" data-correct>am</label>
                    <label class="option-label"><input type="radio" name="q1" value="d">be</label>
                </div>
            </div>

            <div class="question-item">
                <p class="question-text">2. She _____ like coffee.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q2" value="a" data-correct>doesn't</label>
                    <label class="option-label"><input type="radio" name="q2" value="b">don't</label>
                    <label class="option-label"><input type="radio" name="q2" value="c">isn't</label>
                    <label class="option-label"><input type="radio" name="q2" value="d">not</label>
                </div>
            </div>

            <!-- Pre-Intermediate (A2/B1) Questions -->
            <div class="question-item">
                <p class="question-text">3. What _____ you doing yesterday at 5 PM?</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q3" value="a">are</label>
                    <label class="option-label"><input type="radio" name="q3" value="b">did</label>
                    <label class="option-label"><input type="radio" name="q3" value="c" data-correct>were</label>
                    <label class="option-label"><input type="radio" name="q3" value="d">was</label>
                </div>
            </div>
            
            <div class="question-item">
                <p class="question-text">4. I have _____ been to London.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q4" value="a">ever</label>
                    <label class="option-label"><input type="radio" name="q4" value="b" data-correct>never</label>
                    <label class="option-label"><input type="radio" name="q4" value="c">already</label>
                    <label class="option-label"><input type="radio" name="q4" value="d">yet</label>
                </div>
            </div>

            <!-- Intermediate (B1/B2) Questions -->
            <div class="question-item">
                <p class="question-text">5. If I _____ enough money, I would buy a car.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q5" value="a">have</label>
                    <label class="option-label"><input type="radio" name="q5" value="b" data-correct>had</label>
                    <label class="option-label"><input type="radio" name="q5" value="c">would have</label>
                    <label class="option-label"><input type="radio" name="q5" value="d">had had</label>
                </div>
            </div>

            <div class="question-item">
                <p class="question-text">6. The book _____ by JK Rowling.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q6" value="a">wrote</label>
                    <label class="option-label"><input type="radio" name="q6" value="b" data-correct>was written</label>
                    <label class="option-label"><input type="radio" name="q6" value="c">was writing</label>
                    <label class="option-label"><input type="radio" name="q6" value="d">is writing</label>
                </div>
            </div>
            
            <!-- Upper Intermediate (B2) Questions -->
            <div class="question-item">
                <p class="question-text">7. I look forward _____ from you soon.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q7" value="a">hear</label>
                    <label class="option-label"><input type="radio" name="q7" value="b">to hear</label>
                    <label class="option-label"><input type="radio" name="q7" value="c" data-correct>to hearing</label>
                    <label class="option-label"><input type="radio" name="q7" value="d">hearing</label>
                </div>
            </div>

            <div class="question-item">
                <p class="question-text">8. You'd better _____ a doctor.</p>
                <div class="options-grid">
                    <label class="option-label"><input type="radio" name="q8" value="a">to see</label>
                    <label class="option-label"><input type="radio" name="q8" value="b" data-correct>see</label>
                    <label class="option-label"><input type="radio" name="q8" value="c">seeing</label>
                    <label class="option-label"><input type="radio" name="q8" value="d">saw</label>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submit-btn">Check My Level</button>
        </form>

        <div class="result-section" id="result-section">
            <h2 class="result-title">Your Level: <span id="level-result"></span></h2>
            <p class="result-desc">Based on your score (<span id="score-result"></span>), we recommend you start with: <strong id="rec-level"></strong></p>
            <a href="#" id="start-link" class="level-btn">Start Learning</a>
        </div>
    </div>
</div>

<script>
document.getElementById('placement-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let score = 0;
    const total = 8;
    const inputs = document.querySelectorAll('input[type="radio"]:checked');
    
    inputs.forEach(input => {
        if (input.hasAttribute('data-correct')) {
            score++;
        }
    });

    let level = 'A1 (Beginner)';
    let levelSlug = 'a1'; // Adjust based on your DB slugs
    
    if (score >= 7) {
        level = 'B2 (Upper Intermediate)';
        levelSlug = 'b2';
    } else if (score >= 5) {
        level = 'B1 (Intermediate)';
        levelSlug = 'b1';
    } else if (score >= 3) {
        level = 'A2 (Elementary)';
        levelSlug = 'a2';
    } else {
        level = 'A1 (Beginner)';
        levelSlug = 'a1';
    }

    document.getElementById('placement-form').style.display = 'none';
    const resultSection = document.getElementById('result-section');
    resultSection.style.display = 'block';
    
    document.getElementById('level-result').textContent = level;
    document.getElementById('score-result').textContent = `${score}/${total}`;
    document.getElementById('rec-level').textContent = level;
    
    // Construct link - assuming 'english' language slug for now
    document.getElementById('start-link').href = `/grammar/english/${levelSlug}`;
});
</script>
@endsection
