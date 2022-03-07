<?php

class Product
{
    private string $name;
    private int $value;
    private int $cost;

    public function __construct(string $name, int $value, int $cost)
    {
        $this->name = $name;
        $this->value = $value;
        $this->cost = $cost;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}

$day1Products = [
    new Product("Product 1", 3, 200),
    new Product("Product 2", 33, 100),
    new Product("Product 3", 100, 250),
    new Product("Product 4", 10, 500),
    new Product("Product 5", 90, 125),
];
$day2Products = [
    new Product("Product 1", 2, 1),
    new Product("Product 2", 1000, 1000),
];
$day3Products = [
    new Product("Product 1", 99, 1000),
    new Product("Product 2", 95, 100),
    new Product("Product 3", 85, 400),
    new Product("Product 4", 15, 500),
];

// Замените код вашей реализацией
function findBestCombinationValue($products, int $n = 1000): int
{
    // generate all combinations from products
    $combinations = [];
    generate($products, $combinations);

    $value = [];
    foreach ($combinations as $key => $el) {
        $value[$key] = 0;
        $cost[$key] = 0;
        foreach ($el as $e) {
            // increment product cost
            $cost[$key] += $e->cost;

            // check for cost limit
            if ($cost[$key] > $n) {
                break;
            }

            // increment product value
            $value[$key] += $e->value;
        }
    }

    // get index of max element
    $index = array_keys($value, max($value));

    // return max value of products
    return $value[$index[0]];
}

/*
 * Recursive function to generate all combinations of array elements
 */
function generate(array $arr, array &$res, array $prefix = [], $offset = 0)
{
    for ($i = $offset; $i < count($arr); $i++) {
        $nextPrfx = array_merge($prefix, [$arr[$i]]);
        array_push($res, $nextPrfx);
        generate($arr, $res, $nextPrfx, ++$offset);
    }
}

// Тесты
assert(findBestCombinationValue($day1Products) == 33 + 100 + 10 + 90);
assert(findBestCombinationValue($day2Products) == 1000);
assert(findBestCombinationValue($day3Products) == 95 + 85 + 15);
