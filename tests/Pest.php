<?php

use App\Models\Card;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');
uses(TestCase::class, RefreshDatabase::class)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function buildWorld()
{
    foreach (func_get_args() as $class) {
        $string = Str::plural(strtolower(class_basename($class)));
        $path = base_path("tests/{$string}.json");

        $records = collect(json_decode(file_get_contents($path), true))
            ->when($class === Card::class, fn ($collection) => $collection->map(function ($row) use ($class) {
                foreach ($class::casts() as $key => $cast) {
                    if ($cast === AsCollection::class || 'array') {
                        $row[$key] = json_decode($row[$key], true);
                    }
                }
                return $row;
            }));
        $class::factory()->createMany($records);
    }
}
