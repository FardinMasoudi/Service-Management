<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function create($model, array $params = [], ?int $count = null)
    {
        return $model::factory()->count($count)->create($params ?? []);
    }
}
