<?php

namespace App\Http\Controllers;

use App\Lesson;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use NotOnPaper\Transformers\LessonTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;


/**
 * Class LessonsController
 * @package App\Http\Controllers
 */
class LessonsController extends Controller {

    use Helpers;
    protected $request;

    /**
     * @var LessonTransformer
     */
    protected $lessonTransformer;

    /**
     * LessonsController constructor.
     * @param LessonTransformer $lessonTransformer
     */
    function __construct(LessonTransformer $lessonTransformer, Request $request)
    {
        $this->lessonTransformer = $lessonTransformer;
        $this->request = $request;
    }

    /**
     * Show all lessons
     *
     * Get a JSON representation of all the lessons.
     *
     * @Get("/api/v1/lessons")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer TOKEN_HERE", "Paginate": ""}),
     * @Respond(200, body={"id": 10, "title": "bar", "body": "foo"})
     */
    public function index()
    {
        $paginate = $this->request->header('paginate');
        if($paginate)
        {
            $lessons = Lesson::paginate($paginate);
            if($lessons){
                return $this->response->withPaginator($lessons, new LessonTransformer());
            }
        }
        else {
            $lessons = Lesson::all();
            if ($lessons) {
                return $this->response->collection($lessons, new LessonTransformer());
            }
        }
        return $this->response->errorNotFound('No lessons found');
    }

    /**
     * Get a specific lesson
     *
     * Get a JSON representation of a specific lesson.
     *
     * @Get("/api/v1/lessons/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer eyxxxxx", "contentType":"application/json"})
     * @Respond(200, body={"id": 10, "title": "bar", "body": "foo"})
     */
    public function show($id){
        $lesson = Lesson::find($id);
        if (!$lesson)
        {
            return $this->response->errorNotFound('Lesson does not exist');
        }
        return $this->response->item($lesson, new LessonTransformer());
    }

    /**
     * @param $id
     */
    public function edit($id){
        $lesson = Lesson::find($id);
        if (!$lesson)
        {
            return $this->response->errorNotFound('Lesson does not exist');
        }
        $lesson->fill($this->request->all());
    }

    /**
     *
     */
    public function store(){
        /*
       if ( ! Input::get('title') or ! Input::get('body'))
       {
           return $this->setStatusCode(422)
               ->respondWithError('Parameters failed validation for a lesson');
       }

       return $this->setStatusCode(201)->respond([
           'message' => 'Lesson successfully created.'
       ]);*/
    }

    /**
     * @param $id
     */
    public function destroy($id){

    }

}
