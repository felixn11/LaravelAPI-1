<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use NotOnPaper\Transformers\LessonTransformer;


/**
 * Class LessonsController
 * @package App\Http\Controllers
 */
class LessonsController extends ApiController {

    /**
     * @var LessonTransformer
     */
    protected $lessonTransformer;

    /**
     * LessonsController constructor.
     * @param LessonTransformer $lessonTransformer
     */
    function __construct(LessonTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;
    }

    /**
     * Show all lessons
     *
     * Get a JSON representation of all the lessons.
     *
     * @Get("/api/v1/lessons")
     * @Versions({"v1"})
     * @Request("Authorization = Bearer eyxxxxx", contentType="application/json")
     * @Respond(200, body={"id": 10, "title": "bar", "body": "foo"})
     */
    public function index()
    {
        $lessons = Lesson::all();

        if (!$lessons)
        {
            return $this->respondNotFound('No lessons found');
        }
        return $this->respond([
            'data' => $this->lessonTransformer->transformCollection($lessons->toArray())
        ]);

    }

    /**
     * Get a specific lesson
     *
     * Get a JSON representation of a specific lesson.
     *
     * @Get("/api/v1/lessons/{id}")
     * @Versions({"v1"})
     * @Request("Authorization = Bearer eyxxxxx", contentType="application/json")
     */
    public function show($id){
        $lesson = Lesson::find($id);

        if (!$lesson)
        {
            return $this->respondNotFound('Lesson does not exist');
        }

        return $this->respond([
            'data' => $this->lessonTransformer->transform($lesson)
        ]);
    }

    /**
     * @param $id
     */
    public function edit($id){


    }

    /**
     *
     */
    public function store(){
       if ( ! Input::get('title') or ! Input::get('body'))
       {
           return $this->setStatusCode(422)
               ->respondWithError('Parameters failed validation for a lesson');
       }

       return $this->setStatusCode(201)->respond([
           'message' => 'Lesson successfully created.'
       ]);
    }

    /**
     * @param $id
     */
    public function destroy($id){

    }

}
