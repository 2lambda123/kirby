<?php

namespace Kirby\Toolkit;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
	public const FIXTURES = __DIR__ . '/fixtures/view';

	protected function _view(array $data = [])
	{
		return new View(static::FIXTURES . '/view.php', $data);
	}

	public function testFile()
	{
		$view = $this->_view();
		$this->assertSame(static::FIXTURES . '/view.php', $view->file());
	}

	public function testWithMissingFile()
	{
		$this->expectException('Exception');
		$this->expectExceptionMessage('The view does not exist: invalid-file.php');

		$view = new View('invalid-file.php');
		$view->render();
	}

	public function testData()
	{
		$view = $this->_view();
		$this->assertSame([], $view->data());

		$view = $this->_view(['test']);
		$this->assertSame(['test'], $view->data());
	}

	public function testToString()
	{
		$view = $this->_view(['name' => 'Tester']);
		$this->assertSame('Hello Tester', $view->toString());
		$this->assertSame('Hello Tester', $view->__toString());
		$this->assertSame('Hello Tester', (string)$view);
	}

	public function testWithException()
	{
		$this->expectException('Exception');
		$this->expectExceptionMessage('View exception');

		$view = new View(static::FIXTURES . '/view-with-exception.php');
		$view->render();
	}
}
