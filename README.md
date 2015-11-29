# R::io -> Rational numbers

PHP library for work with rational numbers.

## Install
<pre>
composer require math/ratio
</pre>

## Create new number
- use constructor:

```php
$n = New \Ratio\R(1, 2);
print $n; // printing "1/2"
```


- use method io:

```php
// use two parameters
$n = R::io(1, 2);
print $n; // printing "1/2"

// use array
$n = R::io([1,2]);
print $n; // printing "1/2"

// use string
$n = R::io('1 / 2');
print $n; // printing "1/2"

$n = R::io('-1%2');
print $n; // printing "-1/2"

$n = R::io('1 : 2');
print $n; // printing "1/2"
```

## Arithmetic

```php
// addition
$a = R::io('1/2');
$b = R::io('2/3');

$c = $a->plus($b);
print "$a + $b = $c"; // printing 1/2 + 2/3 = 7/6

$c = $a->minus($b);
print "$a + $b = $c"; // printing 1/2 + 2/3 = -1/6

// multiplication
$c = $a->multipliedBy($b);
print "$a * $b = $c"; // printing 1/2 * 2/3 = 1/3

// division
$c = $a->dividedBy($b);
print "$a : $b = $c"; // printing 1/2 : 2/3 = 3/4

//Exponentiation
$c = $a->pow(2);
print "$a ^ 2 = $c"; // printing 1/2 ^ 2 = 1/4
```

## Comparison operations

```php
$a = R::io('1/2');
$b = R::io('2/3');

$result = $a->equalTo($b);
var_dump($result); // bool(false)

$result = $a->lessThan($b);
var_dump($result); // bool(true)

$result = $a->lessOrEqualThan($b);
var_dump($result); // bool(true)

$result = $a->greaterThan($b);
var_dump($result); // bool(false)

$result = $a->greaterOrEqualThan($b);
var_dump($result); // bool(false)
```
