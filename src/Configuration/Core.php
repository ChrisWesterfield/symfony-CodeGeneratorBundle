<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class Service
 *
 * @package   MjrOne\CodeGeneratorBundle\Configuration
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Core extends AbstractConfig
{
    /**
     * @var string
     */
    public $redirect;

    /**
     * @var string
     */
    public $response;

    /**
     * @var string
     */
    public $request;

    /**
     * @var string
     */
    public $kernel;

    /**
     * Service constructor.
     *
     * @param array $service
     */
    public function __construct(array $service)
    {
        $this->redirect = $service['redirectClass'];
        $this->response = $service['responseClass'];
        $this->request = $service['requestClass'];
        $this->kernel = $service['AppKernel'];
    }

    /**
     * @return string
     */
    public function getRedirect(): string
    {
        return $this->redirect;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getKernel(): string
    {
        return $this->kernel;
    }

}
