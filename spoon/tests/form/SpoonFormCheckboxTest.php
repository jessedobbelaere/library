<?php

use PHPUnit\Framework\TestCase;

$includePath = dirname(dirname(dirname(dirname(__FILE__))));
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);

require_once 'spoon/spoon.php';

class SpoonFormCheckboxTest extends TestCase
{
	/**
	 * @var	SpoonForm
	 */
	protected $frm;

	/**
	 * @var	SpoonFormCheckbox
	 */
	protected $chkAgree;

	public function setup()
	{
		$this->frm = new SpoonForm('checkbox');
		$this->chkAgree = new SpoonFormCheckbox('agree', true);
		$this->frm->add($this->chkAgree);
	}

	public function testGetChecked()
	{
		$this->assertTrue($this->chkAgree->getChecked());
		$this->chkAgree->setChecked(false);
		$this->assertFalse($this->chkAgree->getChecked());

		$_POST['form'] = 'checkbox';
		$_POST['agree'] = array('foo', 'bar');
		$this->assertFalse($this->chkAgree->getChecked());
	}

	public function testAttributes()
	{
		$this->chkAgree->setAttribute('rel', 'bauffman.jpg');
		$this->assertEquals('bauffman.jpg', $this->chkAgree->getAttribute('rel'));
		$this->chkAgree->setAttributes(array('id' => 'specialID'));
		$this->assertEquals(array('id' => 'specialID', 'name' => 'agree', 'class' => 'inputCheckbox', 'rel' => 'bauffman.jpg'), $this->chkAgree->getAttributes());
	}

	public function testGetValue()
	{
		$this->assertEquals(false, $this->chkAgree->getValue());
		$_POST['form'] = 'checkbox';
		$_POST['agree'] = '1';
		$this->assertTrue($this->chkAgree->getValue());

		$_POST['agree'] = array('foo', 'bar');
		$this->assertFalse($this->chkAgree->getValue());
	}

	public function testIsFilled()
	{
		$this->assertFalse($this->chkAgree->isFilled());

		$_POST['form'] = 'checkbox';
		$_POST['agree'] = '1';
		$this->assertTrue($this->chkAgree->isFilled());

		$_POST['agree'] = array('foo', 'bar');
		$this->assertFalse($this->chkAgree->isFilled());
	}
}
