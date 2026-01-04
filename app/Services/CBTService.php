<?php

namespace App\Services;

use App\Models\CbtQuestion;
use App\Models\CbtResult;
use App\Models\Registration;
use Illuminate\Support\Collection;

class CBTService
{
    /**
     * Get random questions for CBT exam
     * 
     * @param int $count Number of questions to retrieve
     * @return Collection
     */
    public function getRandomQuestions(int $count): Collection
    {
        return CbtQuestion::active()
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
    
    /**
     * Calculate score based on answers
     * 
     * @param array $answers Array of answers with question_id and selected_option
     * @return int Score percentage (0-100)
     */
    public function calculateScore(array $answers): int
    {
        $correctCount = 0;
        $totalQuestions = count($answers);
        
        if ($totalQuestions === 0) {
            return 0;
        }
        
        foreach ($answers as $answer) {
            $question = CbtQuestion::find($answer['question_id']);
            
            if (!$question) {
                continue;
            }
            
            $correctOption = $question->correct_option;
            
            if ($correctOption && isset($answer['selected_option'])) {
                // Compare the selected option index with correct option
                $selectedIndex = $answer['selected_option'];
                
                if (isset($question->options[$selectedIndex]) && 
                    isset($question->options[$selectedIndex]['is_correct']) &&
                    $question->options[$selectedIndex]['is_correct'] === true) {
                    $correctCount++;
                }
            }
        }
        
        return (int) round(($correctCount / $totalQuestions) * 100);
    }
    
    /**
     * Save CBT result to database
     * 
     * @param Registration $registration
     * @param array $answers
     * @param int $score
     * @return CbtResult
     */
    public function saveResult(Registration $registration, array $answers, int $score): CbtResult
    {
        $correctCount = 0;
        
        foreach ($answers as $answer) {
            $question = CbtQuestion::find($answer['question_id']);
            
            if ($question && isset($answer['selected_option'])) {
                $selectedIndex = $answer['selected_option'];
                
                if (isset($question->options[$selectedIndex]) && 
                    isset($question->options[$selectedIndex]['is_correct']) &&
                    $question->options[$selectedIndex]['is_correct'] === true) {
                    $correctCount++;
                }
            }
        }
        
        // Create CBT result
        $result = CbtResult::create([
            'registration_id' => $registration->id,
            'total_questions' => count($answers),
            'correct_answers' => $correctCount,
            'score' => $score,
            'started_at' => now()->subMinutes(90), // Assuming 90 minute exam
            'completed_at' => now(),
        ]);
        
        // Update registration with CBT score
        $registration->update([
            'cbt_score' => $score,
            'cbt_completed_at' => now(),
        ]);
        
        return $result;
    }
}
