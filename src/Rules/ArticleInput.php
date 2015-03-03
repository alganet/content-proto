<?php

namespace Supercluster\Content\Rules;

use Respect\Validation\Rules as r;

class ArticleInput extends r\AllOf
{
    public function __construct()
    {
        return $this->addRules([
            new r\Key('name',        new r\String),
            new r\Key('articleBody', new r\String),
        ]);
    }
}
