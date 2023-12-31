<?php

namespace Kirby\Cms;

class FieldTest extends TestCase
{
	public function test__debuginfo()
	{
		$field = new Field(null, 'title', 'Title');
		$this->assertSame(['title' => 'Title'], $field->__debugInfo());
	}

	public function testKey()
	{
		$field = new Field(null, 'title', 'Title');
		$this->assertSame('title', $field->key());
	}

	public function testExists()
	{
		$parent = new Page([
			'slug' => 'test',
			'content' => [
				'a' => 'Value A'
			]
		]);

		$this->assertTrue($parent->a()->exists());
		$this->assertFalse($parent->b()->exists());
	}

	public function testModel()
	{
		$model = new Page(['slug' => 'test']);
		$field = new Field($model, 'title', 'Title');

		$this->assertSame($model, $field->model());
	}

	public function testParent()
	{
		$parent = new Page(['slug' => 'test']);
		$field  = new Field($parent, 'title', 'Title');

		$this->assertSame($parent, $field->parent());
	}

	public function testToString()
	{
		$field = new Field(null, 'title', 'Title');

		$this->assertSame('Title', $field->toString());
		$this->assertSame('Title', $field->__toString());
		$this->assertSame('Title', (string)$field);
	}

	public function testToArray()
	{
		$field = new Field(null, 'title', 'Title');
		$this->assertSame(['title' => 'Title'], $field->toArray());
	}

	public function testValue()
	{
		$field = new Field(null, 'title', 'Title');
		$this->assertSame('Title', $field->value());
	}

	public function testValueSetter()
	{
		$field = new Field(null, 'title', 'Title');
		$this->assertSame('Title', $field->value());
		$field = $field->value('Modified');
		$this->assertSame('Modified', $field->value());
	}

	public function testValueCallbackSetter()
	{
		$field = new Field(null, 'title', 'Title');
		$this->assertSame('Title', $field->value());
		$field = $field->value(function ($value) {
			return 'Modified';
		});
		$this->assertSame('Modified', $field->value());
	}

	public function testInvalidValueSetter()
	{
		$this->expectException('Exception');
		$this->expectExceptionMessage('Invalid field value type: object');

		$field = new Field(null, 'title', 'Title');
		$field->value(new Page(['slug' => 'yay']));
	}

	public function testCloningInMethods()
	{
		Field::$methods = [
			'test' => function ($field) {
				$field->value = 'Test';
				return $field;
			}
		];

		$original = new Field(null, 'title', 'Title');
		$modified = $original->test();

		$this->assertSame('Title', $original->value);
		$this->assertSame('Test', $modified->value);
	}

	public function emptyDataProvider()
	{
		return [
			['test', false],
			['0', false],
			[0, false],
			[true, false],
			['true', false],
			[false, false],
			['false', false],
			[null, true],
			['', true],
		];
	}

	/**
	 * @dataProvider emptyDataProvider
	 */
	public function testIsEmpty($input, $expected)
	{
		$field = new Field(null, 'test', $input);
		$this->assertSame($expected, $field->isEmpty());
	}

	/**
	 * @dataProvider emptyDataProvider
	 */
	public function testIsNotEmpty($input, $expected)
	{
		$field = new Field(null, 'test', $input);
		$this->assertSame(!$expected, $field->isNotEmpty());
	}

	public function testCallNonExistingMethod()
	{
		$field  = new Field(null, 'test', 'value');
		$result = $field->methodDoesNotExist();

		$this->assertSame($field, $result);
	}

	public function testOrWithFieldFallback()
	{
		$fallback = new Field(null, 'fallback', 'fallback value');
		$field    = new Field(null, 'test', '');
		$result   = $field->or($fallback);

		$this->assertSame($fallback, $result);
	}
}
