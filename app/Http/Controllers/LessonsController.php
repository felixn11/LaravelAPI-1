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
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var LessonTransformer the transformer used for transforming data
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
     * @Request(headers={"Authorization": "Bearer eyxxxxx"})
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
     * Update a specific lesson
     *
     * Give ID of a lesson as URL parameter and add title and body info so it get's updated
     *
     * @Put("/api/v1/lessons/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer eyxxxxx", "title": "", "body" : ""})
     * @Respond(202)
     */
    public function update($id){
        $lesson = Lesson::find($id);
        if (!$lesson)
        {
            return $this->response->errorNotFound('Lesson does not exist');
        }

        $title = $this->request->header('title');
        $body = $this->request->header('body');

        if($title)
            $lesson['title'] = $title;
        if($body)
        $lesson['body'] = $body;

        if($lesson->save()){
            $message = $lesson['title'] . " updated";
            return $this->response->accepted($message);
        }
    }

    /**
     * Add a specific lesson
     *
     * Add a lesson with title and body to API
     *
     * @Post("/api/v1/lessons")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer eyxxxxx", "title": "", "body" : ""})
     * @Respond(202)
     */
    public function store(){
        $lesson = new Lesson;
        $lesson->title = $this->request->header('title');
        $lesson->body = $this->request->header('body');
        if($lesson->save())
            return $this->response->accepted($lesson . " created");
        else
            return $this->response->error('could_not_create_lesson', 500);
    }

    /**
     * @param $id
     */
    public function destroy($id){

    }

}
