<?php

class Animal5920 {}
class Cat5920 extends Animal5920 {}
class Dog5920 extends Animal5920 {}
class Vegetable5920 {}

class ReturnTypeTest5920 {
    /** @return Animal5920 */
    public function getAnimalNoRealType() {
        return random_int(0, 1) ? new Cat5920() : new Dog5920();
    }

    /**
     * @return Vegetable5920
     * @suppress PhanTypeMismatchDeclaredReturn
     */
    public function getMislabeledAnimal(): Animal5920 {
        return new Cat5920();
    }

    /** @return int */
    public function getRealTypeMismatch(): int {
        // @phan-suppress-next-line PhanTypeMismatchReturnReal
        return new Cat5920();
    }
}

class PropertyTypeTest5920 {
    /** @var Vegetable5920 */
    public $phpdoc_only_prop;

    /** @var Vegetable5920 */
    public Animal5920 $real_type_compatible_prop;

    /** @var int */
    public int $real_type_mismatch_prop;

    public function __construct() {
        // @phan-suppress-next-line PhanTypeMismatchPropertyProbablyReal
        $this->phpdoc_only_prop = new Cat5920();
        // @phan-suppress-next-line PhanTypeMismatchPropertyProbablyReal
        $this->real_type_compatible_prop = new Cat5920();
        // @phan-suppress-next-line PhanTypeMismatchPropertyReal
        $this->real_type_mismatch_prop = new Cat5920();
    }
}

/* @phan-suppress-next-line PhanUnreferencedFunction */
function testReturnTypes5920(): void {
    $obj = new ReturnTypeTest5920();

    // No real type: Cat and Dog accumulated alongside declared Animal
    $a = $obj->getAnimalNoRealType();
    '@phan-debug-var $a';

    // Real type Animal: Cat compatible, accumulated
    $b = $obj->getMislabeledAnimal();
    '@phan-debug-var $b';

    // Real type int: Cat incompatible, NOT accumulated
    $c = $obj->getRealTypeMismatch();
    '@phan-debug-var $c';
}

// --- Array element resolution test (Money pattern) ---

class C5920 {}

/** @return array */
function flatten5920() {
    return ['a' => 1];
}

class ArrayTest5920 {
    /** @var array */
    public $d;

    public function __construct() {
        $this->d = [];
        $this->d['tax'] = ['a' => new C5920()];
        $this->d['total'] = ['a' => new C5920(), 'extra' => new C5920()];
    }

    /* @phan-suppress-next-line PhanUnreferencedPublicMethod */
    public function run(): void {
        $d = $this->d;
        $d['tax'] = flatten5920();
        // With track_all_inferred_types, C5920 is preserved from the typed array
        $val = $d['total']['extra'];
        '@phan-debug-var $val';
    }
}

/* @phan-suppress-next-line PhanUnreferencedFunction */
function testPropertyTypes5920(): void {
    $obj = new PropertyTypeTest5920();

    // No real type: Cat accumulated alongside declared Vegetable
    $d = $obj->phpdoc_only_prop;
    '@phan-debug-var $d';

    // Real type Animal: Cat compatible, accumulated
    $e = $obj->real_type_compatible_prop;
    '@phan-debug-var $e';

    // Real type int: Cat incompatible, NOT accumulated
    $f = $obj->real_type_mismatch_prop;
    '@phan-debug-var $f';
}
