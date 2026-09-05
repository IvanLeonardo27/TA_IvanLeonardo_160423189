<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\QuizQuestion;
use App\Models\QuizSet;
use Illuminate\Http\Request;

class CustomerQuizAttemptController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'quiz_set_id' => ['required', 'integer', 'exists:quiz_masters,id'],
            'player_name' => ['nullable', 'string', 'max:80'],
            'score' => ['required', 'integer', 'min:0', 'max:100'],
            'answers' => ['nullable', 'array'],
            'answers.*.question_id' => ['required', 'integer'],
            'answers.*.chosen_index' => ['nullable', 'integer', 'min:0', 'max:50'],
            'answers.*.time_ms' => ['nullable', 'integer', 'min:0', 'max:600000'],
        ]);

        $quizSet = QuizSet::query()->findOrFail($data['quiz_set_id']);

        $playerName = trim((string) ($data['player_name'] ?? ''));
        if ($playerName === '') {
            $playerName = 'Guest';
        }

        if ($quizSet->max_attempts_per_player !== null) {
            $attemptCount = QuizAttempt::query()
                ->where('quiz_set_id', $quizSet->id)
                ->where('player_name', $playerName)
                ->count();

            if ($attemptCount >= $quizSet->max_attempts_per_player) {
                return response()->json([
                    'message' => 'Batas percobaan kuis sudah tercapai.',
                ], 429);
            }
        }

        $attempt = QuizAttempt::query()->create([
            'quiz_set_id' => $quizSet->id,
            'player_name' => $playerName,
            'score' => (int) $data['score'],
            'taken_at' => now(),
        ]);

        $answers = $data['answers'] ?? [];
        if (!empty($answers)) {
            $questionIds = collect($answers)->pluck('question_id')->unique()->values();

            $questions = QuizQuestion::query()
                ->where('quiz_set_id', $quizSet->id)
                ->whereIn('id', $questionIds)
                ->get(['id', 'correct_index']);

            $correctMap = $questions->keyBy('id');

            foreach ($answers as $ans) {
                $qid = (int) $ans['question_id'];
                $question = $correctMap->get($qid);
                if (!$question) {
                    continue;
                }

                $chosen = array_key_exists('chosen_index', $ans) ? $ans['chosen_index'] : null;
                $isCorrect = $chosen !== null && (int) $chosen === (int) $question->correct_index;

                QuizAttemptAnswer::query()->create([
                    'quiz_attempt_id' => $attempt->id,
                    'quiz_question_id' => $qid,
                    'chosen_index' => $chosen,
                    'is_correct' => $isCorrect,
                    'time_ms' => $ans['time_ms'] ?? null,
                ]);
            }
        }

        return response()->json([
            'attempt_id' => $attempt->id,
        ]);
    }
}
