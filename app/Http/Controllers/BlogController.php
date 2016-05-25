<?php

namespace App\Http\Controllers;

use App\Blog;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use NotOnPaper\Transformers\BlogTransformer;


/**
 * Class BlogsController
 * @package App\Http\Controllers
 */
class BlogController extends Controller {

    use Helpers;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Blogtransformer the transformer used for transforming data
     */
    protected $blogTransformer;

    /**
     * BlogsController constructor.
     * @param Blogtransformer $blogTransformer
     */
    function __construct(BlogTransformer $blogTransformer, Request $request)
    {
        $this->blogTransformer = $blogTransformer;
        $this->request = $request;
    }

    /**
     * Show all blogs
     *
     * Get a JSON representation of all the blogs.
     *
     * @Get("/api/v1/blogs")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer TOKEN_HERE", "Paginate": ""}),
     * @Respond(200, body={"id": 10, "title": "bar", "body": "foo"})
     */
    public function index()
    {
        $paginate = $this->request->header('paginate');
        if($paginate)
        {
            $blogs = Blog::paginate($paginate);
            if($blogs){
                return $this->response->withPaginator($blogs, new BlogTransformer());
            }
        }
        else {
            $blogs = Blog::all();
            if ($blogs) {
                return $blogs;
                return $this->response->collection($blogs, new BlogTransformer());
            }
        }
        return $this->response->errorNotFound('no_blogs_found');
    }

    /**
     * Get a specific blog
     *
     * Get a JSON representation of a specific blog.
     *
     * @Get("/api/v1/blogs/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer eyxxxxx"})
     * @Respond(200, body={"id": 10, "title": "bar", "body": "foo"})
     */
    public function show($id){
        $blog = Blog::find($id);
        if (!$blog)
        {
            return $this->response->errorNotFound('blog_does_not_exist');
        }
        return $this->response->item($blog, new BlogTransformer());
    }

    /**
     * Update a specific blog
     *
     * Give ID of a blog as URL parameter and add title and body info so it get's updated
     *
     * @Put("/api/v1/blogs/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer eyxxxxx", "title": "", "body" : ""})
     * @Respond(202)
     */
    public function update($id){
        $blog = Blog::find($id);
        if (!$blog)
        {
            return $this->response->errorNotFound('blog_does_not_exist');
        }

        $title = $this->request->header('title');
        $body = $this->request->header('body');

        if($title)
            $blog['title'] = $title;
        if($body)
            $blog['body'] = $body;

        if($blog->save()){
            $message = $blog['title'] . " updated";
            return $this->response->accepted($message);
        }
    }

    /**
     * Add a specific blog
     *
     * Add a blog with title and body to API
     *
     * @Post("/api/v1/blogs")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer eyxxxxx", "title": "", "body" : ""})
     * @Respond(202)
     */
    public function store(){
        $blog = new Blog;
        $blog->title = $this->request->header('title');
        $blog->body = $this->request->header('body');
        if($blog->save())
            return $this->response->accepted($blog . " created");
        else
            return $this->response->error('could_not_create_blog', 500);
    }

    /**
     * @param $id
     */
    public function destroy($id){

    }

}
