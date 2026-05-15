<?php

namespace App\Services;

class AICoachService
{
    /**
     * Generate coaching insights based on user data.
     * Returns an array of ['type' => 'success|warning|info', 'message' => '...']
     */
    public function analyze(array $data): array
    {
        $insights = [];

        $workoutsThisWeek   = $data['workouts_this_week'] ?? 0;
        $workoutsLastWeek   = $data['workouts_last_week'] ?? 0;
        $streak             = $data['streak'] ?? 0;
        $totalWorkouts      = $data['total_workouts'] ?? 0;
        $goal               = $data['goal'] ?? null;
        $weightTrend        = $data['weight_trend'] ?? 0;  // positive = gaining
        $avgCaloriesPerWeek = $data['avg_calories_per_week'] ?? 0;
        $prsBroken          = $data['prs_broken_this_week'] ?? 0;
        $missedMuscleGroups = $data['missed_muscle_groups'] ?? [];

        // ── Rule 1: PR Celebration ─────────────────────────────────────────────
        if ($prsBroken > 0) {
            $insights[] = [
                'type'    => 'success',
                'message' => "🏆 You broke {$prsBroken} personal record(s) this week. Keep applying progressive overload — add 2.5–5kg next session!",
            ];
        }

        // ── Rule 2: Workout Frequency ──────────────────────────────────────────
        if ($workoutsThisWeek === 0) {
            $insights[] = [
                'type'    => 'warning',
                'message' => '⚠️ No workouts logged this week yet. Even one session resets your momentum — get back on track today!',
            ];
        } elseif ($workoutsThisWeek < 3) {
            $insights[] = [
                'type'    => 'warning',
                'message' => "📉 Only {$workoutsThisWeek} workout(s) this week. Aim for 4–5 sessions for optimal progress. Try scheduling tomorrow now.",
            ];
        } elseif ($workoutsThisWeek >= 5) {
            $insights[] = [
                'type'    => 'success',
                'message' => "🔥 Excellent frequency! {$workoutsThisWeek} sessions this week. You're in the top 10% of consistent athletes.",
            ];
        }

        // ── Rule 3: Muscle Gain Goal + Weight Stalling ────────────────────────
        if ($goal === 'muscle_gain') {
            if ($weightTrend <= 0) {
                $insights[] = [
                    'type'    => 'warning',
                    'message' => '💪 Your weight is not increasing. For muscle gain, you need a caloric surplus. Aim for +300–500 kcal above maintenance and increase protein to 2g per kg of bodyweight.',
                ];
            }
            if ($avgCaloriesPerWeek > 0 && $avgCaloriesPerWeek < 1500) {
                $insights[] = [
                    'type'    => 'warning',
                    'message' => '🍗 Your calorie burn is very high relative to your intake estimate. Ensure you are eating enough to support muscle growth — consider adding a post-workout meal.',
                ];
            }
        }

        // ── Rule 4: Weight Loss Goal ───────────────────────────────────────────
        if ($goal === 'weight_loss') {
            if ($weightTrend > 0.5) {
                $insights[] = [
                    'type'    => 'info',
                    'message' => '📊 Weight is trending upward. Review your calorie intake and ensure you are in a deficit. Try replacing one meal with a high-protein, low-calorie option.',
                ];
            } elseif ($weightTrend < 0) {
                $insights[] = [
                    'type'    => 'success',
                    'message' => '✅ Your weight is trending down consistently. The calorie deficit is working — stay the course!',
                ];
            }
        }

        // ── Rule 5: Maintenance Goal ───────────────────────────────────────────
        if ($goal === 'maintenance' && abs($weightTrend) > 1) {
            $insights[] = [
                'type'    => 'info',
                'message' => '⚖️ Your weight has shifted by more than 1kg. For maintenance, track your macros more closely and keep workout intensity consistent.',
            ];
        }

        // ── Rule 6: Streak Recognition ─────────────────────────────────────────
        if ($streak >= 30) {
            $insights[] = [
                'type'    => 'success',
                'message' => "🏅 LEGEND STATUS — {$streak} day streak! You are building an unbreakable habit. Keep going!",
            ];
        } elseif ($streak >= 7) {
            $insights[] = [
                'type'    => 'success',
                'message' => "⚡ {$streak}-day streak! You've built serious momentum. One week of consistency rewires your brain — this is how elite athletes are made.",
            ];
        } elseif ($streak < 3 && $totalWorkouts > 3) {
            $insights[] = [
                'type'    => 'info',
                'message' => "📅 Your current streak is {$streak} day(s). Try logging every day — even rest days — to build the habit loop.",
            ];
        }

        // ── Rule 7: Volume Drop ────────────────────────────────────────────────
        if ($workoutsLastWeek > 0 && $workoutsThisWeek < $workoutsLastWeek) {
            $drop = $workoutsLastWeek - $workoutsThisWeek;
            if ($drop >= 2) {
                $insights[] = [
                    'type'    => 'warning',
                    'message' => "📉 Training volume dropped by {$drop} session(s) vs last week. If this is intentional (deload), great. Otherwise, identify what blocked you and remove the obstacle.",
                ];
            }
        }

        // ── Default if no insights ─────────────────────────────────────────────
        if (empty($insights)) {
            $insights[] = [
                'type'    => 'info',
                'message' => '🚀 Keep logging your workouts and weight to unlock personalised AI coaching insights here.',
            ];
        }

        return $insights;
    }
}
