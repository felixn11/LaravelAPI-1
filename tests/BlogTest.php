<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
class BlogTest extends TestCase
{
    //use WithoutMiddleware;
    protected $faker;

    /**
     * @return void
     */
    public function testGetBlogs()
    {
        $this->get('http://backend/api/v1/blogs')
            ->seeStatusCode(200);
    }

    public function testPagination(){
        $paginate = "10";
        $response = $this->call('GET', 'http://backend/api/v1/blogs', [], [], [],
            ['HTTP_paginate' => $paginate]);

        // check response status is correct
        $this->assertEquals($response->getStatusCode(), 200);

        $responseArray = json_decode($response->getContent());

        // assert the returned values are equal to the paginate header
        $this->assertEquals(count($responseArray->data), $paginate);
    }

    /**
     * @return void
     */
    public function testGetSpecificBlog()
    {
        $this->faker = Faker\Factory::create();
        $randomDigit = $this->faker->numberBetween(1, 30);
        $this->get("http://backend/api/v1/blogs/". $randomDigit)
            ->seeStatusCode(200);
    }

    /**
     * @return void
     */
    public function testBlogNotAvailable()
    {
        $this->faker = Faker\Factory::create();
        $randomDigit = $this->faker->numberBetween(-100, -50);
        $this->get("http://backend/api/v1/blogs/". $randomDigit)
            ->seeStatusCode(404);
    }

    /**
     * @return void
     */
    public function testPostNewBlog()
    {
        $this->faker = Faker\Factory::create();
        $headers = ["title" => $this->faker->text, "body" => $this->faker->text];
        $this->post("http://backend/api/v1/blogs", [],
            $headers)
            ->seeStatusCode(202);
    }

    /**
     * @return void
     */
    public function testPostBlogWrongHeaders()
    {
        $this->faker = Faker\Factory::create();
        $headers = ["titl" => $this->faker->text, "body" => $this->faker->text];
        $this->post("http://backend/api/v1/blogs", [],
            $headers)
            ->seeStatusCode(500);
    }


    public function testUpdateBlog(){
        $this->faker = Faker\Factory::create();
        $randomDigit = $this->faker->numberBetween(1, 30);
        $headers = ["title" => $this->faker->text, "body" => $this->faker->text];

        $this->put("http://backend/api/v1/blogs/" . $randomDigit, [],
            $headers)
            ->seeStatusCode(201);
    }
}