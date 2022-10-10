<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

use App\Models\SurveyForm;
use App\Models\SurveyQuestion;

class SurveyFormController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
			'form_title' => 'required',
            'questions' => 'required',
            'course_id' => 'required',
		]);
		
		if ($validator->fails()) {
			return response([
				'message'=> 'Data is required.'
			], 400);
		}
		
		$newSurveyForm = new SurveyForm();
		$newSurveyForm->fill([
			'form_title' => $request->form_title,
            'course_id' => $request->course_id,
		]);

		if ($newSurveyForm->save()) {
            foreach ($request->questions as $question) {
                $newSurveyQuestion = new SurveyQuestion();
                $newSurveyQuestion->fill([
                    'question' => $question['question'],
                    'highest_answer' => $question['highest_answer'],
                ]);
                $newSurveyForm->surveyQuestions()->save($newSurveyQuestion);
            }
            return response(["data" => $newSurveyForm, "status" => true], 201);
        }
		else return response([
			'message' => 'Error in creating survey form.',
            'status' => false
		], 500); 
    }

    public function list() {
        return response(SurveyForm::orderBy("id", "desc")->get(), 201);
    }

    public function view($id) {
        $collection = new Collection();

        $surveyForm = SurveyForm::find($id);
        $surveyQuestions = $surveyForm->getSurveyQuestions($id);

        return response(['survey_form' => $surveyForm, 'survey_questions' => $surveyQuestions], 201);
    }
}
