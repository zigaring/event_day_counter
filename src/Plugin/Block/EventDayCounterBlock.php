<?php

namespace Drupal\event_day_counter\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\event_day_counter\EventDayCounter;

/**
 *
 * @Block(
 *   id = "event_day_counter",
 *   admin_label = @Translation("Event Day Counter"),
 *   category = @Translation("Custom")
 * )
 */
class EventDayCounterBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The event day counter block service.
   *
   * @var \Drupal\event_day_counter\EventDayCounter
   */
  protected $eventDayCounter;

  /**
   * Constructs an EventDayCounter object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\event_day_counter\EventDayCounter $eventDayCounter
   *   The event day counter block service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EventDayCounter $eventDayCounter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->eventDayCounter = $eventDayCounter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('event_day_counter.service')
    );
  }
    
    public function build() {
      $node = \Drupal::routeMatch()->getParameter('node');
      $event_date = $node->field_date->value;

      $days_diff = $this->eventDayCounter->getDaysDiff($event_date);
      

      if ($days_diff > 1) {
        $message = "$days_diff days left until event starts";
      }
      elseif ($days_diff == 1) {
        $message = "$days_diff day left until event starts";
      }
      elseif ($days_diff == 0) {
        $message = "This event is happening today";
      }
      else {
        $message = "This event already passed";
      }

      return [
        '#markup' => $message,
        '#cache' => ['max-age' => 0,],
      ];
    }

  }