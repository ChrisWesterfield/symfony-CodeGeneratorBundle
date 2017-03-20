<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 21:29
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\Console\Input\InputInterface;

class CreateBundleService extends AbstractService implements CodeGeneratorInterface
{

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return AbstractService|CreateBundleService
     */
    public function setInput(InputInterface $input): AbstractService
    {
        return parent::setInput($input);
    }

    public function process()
    {
        // TODO: Implement process() method.
    }
}
