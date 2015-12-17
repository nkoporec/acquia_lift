<?php

/**
 * @file
 * Contains \Drupal\acquia_lift\Tests\Service\Helper\NodeTypeThumbnailFormHelperTest.
 */

namespace Drupal\acquia_lift\Tests\Service\Helper;

use Drupal\Tests\UnitTestCase;
use Drupal\acquia_lift\Service\Helper\NodeTypeThumbnailFormHelper;
use Drupal\acquia_lift\Tests\Traits\SettingsDataTrait;

require_once(__DIR__.'/../../../Traits/SettingsDataTrait.php');

/**
 * NodeTypeThumbnailFormHelper Test.
 *
 * @coversDefaultClass Drupal\acquia_lift\Service\Helper\NodeTypeThumbnailFormHelper
 * @group acquia_lift
 */
class NodeTypeThumbnailFormHelperTest extends UnitTestCase {

  use SettingsDataTrait;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  private $configFactory;

  /**
   * @var \Drupal\Core\Entity\EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
   */
  private $entityManager;

  /**
   * @var \Drupal\Core\Config\Config|\PHPUnit_Framework_MockObject_MockObject
   */
  private $settings;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->configFactory = $this->getMock('Drupal\Core\Config\ConfigFactoryInterface');
    $this->entityManager = $this->getMock('Drupal\Core\Entity\EntityManagerInterface');
    $this->settings = $this->getMockBuilder('Drupal\Core\Config\Config')
      ->disableOriginalConstructor()
      ->getMock();

    $this->configFactory->expects($this->once())
      ->method('getEditable')
      ->with('acquia_lift.settings')
      ->willReturn($this->settings);
    $this->settings->expects($this->at(0))
      ->method('get')
      ->with('thumbnail')
      ->willReturn($this->getValidThumbnailSettings());
  }

  /**
   * Tests the getForm() method.
   *
   * @covers ::getForm
   */
//  public function testGetForm() {
//  }

  /**
   * Tests the saveSettings() method.
   *
   * @covers ::saveSettings
   */
  public function testSaveSettings() {
    $set_settings = ['article' => ['some_settings']];
    $this->settings->expects($this->at(1))
      ->method('set')
      ->with('thumbnail', $set_settings)
      ->willReturn($this->settings);
    $this->settings->expects($this->at(2))
      ->method('save');

    $form_helper = new NodeTypeThumbnailFormHelper($this->configFactory, $this->entityManager);

    $settings = ['some_settings'];
    $form_helper->saveSettings('article', $settings);
  }
}
