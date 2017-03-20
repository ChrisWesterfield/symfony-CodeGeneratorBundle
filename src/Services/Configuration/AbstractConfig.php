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
 * Time: 22:06
 */

namespace MjrOne\CodeGeneratorBundle\Services\Configuration;
use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class AbstractConfig
 *
 * @package MjrOne\CodeGeneratorBundle\Services\Configuration
 */
abstract class AbstractConfig
{
    /**
     * @return array
     */
    public function toArray():array
    {
        $returnArray = [];
        foreach($this as $id=>$value)
        {
            if($value instanceof AbstractConfig)
            {
                $returnArray[$id] = $value->toArray();
            }
            else
                if($value instanceof ArrayCollection)
            {
                $returnArray[$id] = [];
                if($value->count()>0)
                {
                    foreach($value as $val)
                    {
                        /** @var AbstractConfig $val */
                        $returnArray[$id][] = $val->toArray();
                    }
                }
            }
            else
            {
                $returnArray[$id] = $value;
            }
        }
        return $returnArray;
    }
}
