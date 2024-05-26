<?php

namespace App\Http\Controllers;

use App\Models\QuizSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizController extends Controller
{
    /**
     * Handle the quiz submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {
        // Capture the request data
        $requestData = $request->all();

        $gender = "";
        $cid = request()->query('cid') ?? '';
        $sid = request()->query('sid') ?? '';

        switch (request()->query('g')) {
            case 'm':
                $gender = "male";
                break;
            case 'f':
                $gender = "female";
                break;
            case 'o':
                $gender = "other";
                break;

            default:
                break;
        }

        $data = [];

        // Handle metric data
        if (!empty($requestData['metrics'])) {
            $metrics = $requestData['metrics'];
            if (isset($metrics['metric_height'])) {
                $data['height'] = "{$metrics['metric_height']} cm";
                $data['weight'] = "{$metrics['metric_weight']} kg";
                $data['desired_weight'] = "{$metrics['metric_desired_weight']} kg";
            } elseif (isset($metrics['imperial_height_feet'])) {
                $data['height'] = "{$metrics['imperial_height_feet']} ft {$metrics['imperial_height_inches']} inch";
                $data['weight'] = "{$metrics['imperial_weight']} lb";
                $data['desired_weight'] = "{$metrics['imperial_desired_weight']} lb";
            }
        }

        // Decode answers if exists
        $answers = isset($requestData['answers']) ? json_decode($requestData['answers'], true) : [];

        // Organizing the answers
        foreach ($answers as $index => $answer) {
            if ($index == 22) break;
            $questionNumber = $index + 1;

            $data["answer_{$questionNumber}"] = isset($answer['answerText'])
                ? array_keys($answer)[0]
                : implode(", ", array_keys($answer));
        }

        $email = $requestData['email'];
        $data['email'] = $email;
        $data['gender'] = $gender;
        $data['cid'] = $cid;
        $data['sid'] = $sid;

        // Find or create the user based on email
        $user = User::updateOrCreate(
            ['email' => $email],
            ['gender' => $gender]
        );

        $data['user_id'] = $user->id;

        QuizSubmission::updateOrCreate(
            ['email' => $email],
            $data
        );

        // Send the data to convertkit
        $convertKitApiKey = config('convertkit.api_key');
        $formId = config('convertkit.quiz_form_id');
        $convertKitApiUrl = "https://api.convertkit.com/v3/forms/$formId/subscribe";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($convertKitApiUrl, [
            'api_key' => $convertKitApiKey,
            'email' => $email,
            'fields' => [
                'cid' => $cid,
                'sid' => $sid,
            ],
        ]);

        return view('quiz.summary');
    }
}
