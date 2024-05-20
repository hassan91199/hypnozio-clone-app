<?php

namespace App\Http\Controllers;

use App\Models\QuizSubmission;

use Illuminate\Http\Request;

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

        $height = "";
        $weight = "";
        $desiredWeight = "";

        if (isset($requestData['metrics']['metric_height'])) {
            $height = $requestData['metrics']['metric_height'];
            $height = "$height cm";

            $weight = $requestData['metrics']['metric_weight'];
            $weight = "$weight kg";

            $desiredWeight = $requestData['metrics']['metric_desired_weight'];
            $desiredWeight = "$desiredWeight kg";
        }

        if (isset($requestData['metrics']['imperial_height_feet'])) {
            $heightInFeet = $requestData['metrics']['imperial_height_feet'];
            $heightInInches = $requestData['metrics']['imperial_height_inches'];

            $height = "$heightInFeet ft $heightInInches inch";

            $weight = $requestData['metrics']['imperial_weight'];
            $weight = "$weight lb";

            $desiredWeight = $requestData['metrics']['imperial_desired_weight'];
            $desiredWeight = "$desiredWeight lb";
        }

        // Check if 'answers' field exists and decode the JSON string
        if (isset($requestData['answers'])) {
            $answers = json_decode($requestData['answers'], true); // true to get an associative array
        } else {
            $answers = [];
        }

        $data = [];

        // Organizing the answers
        foreach ($answers as $questionNumber => $answer) {
            $correctedQuestionNumber = $questionNumber + 1;

            if (isset($answer['answerText'])) {
                $data["answer_{$correctedQuestionNumber}"] = array_keys($answer)[0];
            } else {
                $data["answer_{$correctedQuestionNumber}"] =  implode(", ", array_keys($answer));
            }
        }

        $email = $requestData['email'];
        $data['answer_23'] = $email;

        $data['height'] = $height;
        $data['weight'] = $weight;
        $data['desired_weight'] = $desiredWeight;

        $quizSubmission = QuizSubmission::updateOrCreate(['email' => $email], $data);

        if (!isset($quizSubmission))
            return response()->json(['message' => 'There was a problem updating or creating quiz submission']);

        return response()->json(['message' => 'Quiz submission updated or created successfully']);
    }
}
