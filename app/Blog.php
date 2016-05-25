<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends \Eloquent
{
    protected $fillable = ['id', 'title', 'body'];
}
?>
