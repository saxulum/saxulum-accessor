# saxulum-accessor

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-accessor.png?branch=master)](https://travis-ci.org/saxulum/saxulum-accessor)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-accessor/downloads.png)](https://packagist.org/packages/saxulum/saxulum-accessor)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-accessor/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-accessor)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/saxulum/saxulum-accessor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/saxulum/saxulum-accessor/?branch=master)

## Features

 * Contains a [accessor trait][1] which allows to register accessors
 * Contains a [add accessor][2], which means you don't have to write simple adders anymore
 * Contains a [get accessor][3], which means you don't have to write simple getters anymore
 * Contains a [is accessor][4], which means you don't have to write simple is anymore
 * Contains a [remove accessor][5], which means you don't have to write simple removers anymore
 * Contains a [set accessor][6], which means you don't have to write simple setters anymore


## Requirements

 * PHP 5.4+


## Installation

Through [Composer](http://getcomposer.org) as [saxulum/saxulum-accessor][7].

### Bootstrap:

``` {.php}
AccessorTrait::registerAccessor(new Add());
AccessorTrait::registerAccessor(new Get());
AccessorTrait::registerAccessor(new Is());
AccessorTrait::registerAccessor(new Remove());
AccessorTrait::registerAccessor(new Set());
```

## Usage

``` {.php}
/**
 * @method $this setName(string $name)
 * @method string getName()
 * @method boolean isName()
 * @method $this addValue(string $value)
 * @method $this removeValue(string $value)
 * @method string getValue()
 * @method boolean isValue()
 */
class MyObject
{
    use AccessorTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $value = array();

    protected function initializeProperties()
    {
        $this->prop(
            (new Prop('name', Hint::HINT_STRING))
                ->method(Get::PREFIX)
                ->method(Is::PREFIX)
                ->method(Set::PREFIX)
        );
        $this->prop(
            (new Prop('value', Hint::HINT_STRING))
                ->method(Add::PREFIX)
                ->method(Get::PREFIX)
                ->method(Is::PREFIX)
                ->method(Remove::PREFIX)
        );
    }
}

$object = new MyObject();
$object
    ->setName('name')
    ->addValue('value')
    ->removeValue('value')
;

$object->getName();
$object->getValue();

$object->isName();
$object->isValue();
```


## Arguments

### Pros:

- less code to write
- less code to debug
- scalar type hints

### Cons:

- no auto generation of `@method` phpdoc (not yet)
- slower (no benchmark)
- more complex code to debug
- `method_exists` does not work


## FAQ

#### Does it work with doctrine orm (proxy)

Yes it does, thx to remove final keyword on [__call][8], [__get][9], [__set][10]

#### Does it work with twig

Yes it does, thx to the plain [property method call wrapper][11]


## Copyright

* Dominik Zogg <dominik.zogg@gmail.com>


## Contributors

* Dominik Zogg
* Patrick Landolt


[1]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/AccessorTrait.php
[2]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/Accessors/Add.php
[3]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/Accessors/Get.php
[4]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/Accessors/Is.php
[5]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/Accessors/Remove.php
[6]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/Accessors/Set.php
[7]: https://packagist.org/packages/saxulum/saxulum-accessor
[8]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/AccessorTrait.php#L33
[9]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/AccessorTrait.php#L86
[10]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/AccessorTrait.php#L109
[11]: https://github.com/saxulum/saxulum-accessor/blob/master/src/Saxulum/Accessor/AccessorTrait.php#L51
