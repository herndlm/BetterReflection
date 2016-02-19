--TEST--
Bug #42976 (Crash when constructor for newInstance() or newInstanceArgs() fails)
--FILE--
<?php require 'vendor/autoload.php';

Class C {
	function __construct(&$x) {
		$x = "x.changed";
	}
}

$x = "x.original";
new C($x); // OK
// @todo see https://github.com/Roave/BetterReflection/issues/155 --- var_dump($x);

$rc = \BetterReflection\Reflection\ReflectionClass::createFromName('C');
$x = "x.original";
$rc->newInstance($x); // causes crash
// @todo see https://github.com/Roave/BetterReflection/issues/155 --- var_dump($x);
$x = "x.original";
$rc->newInstanceArgs(array($x)); // causes crash	
// @todo see https://github.com/Roave/BetterReflection/issues/155 --- var_dump($x);

echo "Done\n";
?>
--EXPECTF--	
string(9) "x.changed"

Warning: Parameter 1 to C::__construct() expected to be a reference, value given in %sbug42976.php on line 15

Warning: ReflectionClass::newInstance(): Invocation of C's constructor failed in %sbug42976.php on line 15
string(10) "x.original"

Warning: Parameter 1 to C::__construct() expected to be a reference, value given in %sbug42976.php on line 18

Warning: ReflectionClass::newInstanceArgs(): Invocation of C's constructor failed in %sbug42976.php on line 18
string(10) "x.original"
Done