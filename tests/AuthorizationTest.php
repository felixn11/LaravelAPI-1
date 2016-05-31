<?php

class AuthorizationTest extends TestCase
{
    protected $faker;
    protected $email;
    protected $password;

    public function testSignUp(){
        $this->faker = Faker\Factory::create();
        $headers = ["name" => $this->faker->name, "email" => $this->faker->email, "password" => $this->faker->password];
        $this->post("http://backend/auth/login", [],
            $headers);
    }

    public function testAuthorize(){

    }

}