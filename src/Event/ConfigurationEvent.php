<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 02:42
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\ConfigurationService;
use Symfony\Component\EventDispatcher\Event;

class ConfigurationEvent extends Event
{
    /**
     * @var ConfigurationService
     */
    protected $subject;

    /**
     * @var array
     */
    protected $config;

    /**
     * @return \MjrOne\CodeGeneratorBundle\Services\ConfigurationService
     */
    public function getSubject(): \MjrOne\CodeGeneratorBundle\Services\ConfigurationService
    {
        return $this->subject;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Services\ConfigurationService $subject
     *
     * @return ConfigurationEvent
     */
    public function setSubject(\MjrOne\CodeGeneratorBundle\Services\ConfigurationService $subject): ConfigurationEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return ConfigurationEvent
     */
    public function setConfig(array $config): ConfigurationEvent
    {
        $this->config = $config;

        return $this;
    }
}
