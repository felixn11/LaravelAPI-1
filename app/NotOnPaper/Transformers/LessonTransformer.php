<?php
namespace NotOnPaper\Transformers;

class LessonTransformer extends Transformer {

    public function transform($lesson)
    {
        return [
            'title' => $lesson['title'],
            'body'  => $lesson['body'],
        ];
    }
}