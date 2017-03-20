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
 * Time: 21:09
 */

namespace MjrOne\CodeGeneratorBundle\Tests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MjrOne\CodeGeneratorBundle\Traits\CodeGenerator\Tests\TraitMutatorServiceTest;
use MjrOne\CodeGeneratorBundle\Traits\CodeGenerator\Tests\TraitServiceServiceTest;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Doctrine\ORM\Mapping as ORM;
use MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle;
use MjrOne\CodeGeneratorBundle\Services\RenderService;

/**
 * Class ServiceTest
 *
 * @package MjrOne\CodeGeneratorBundle\Tests
 * @Route( service="mjr_one.code_generator_bundle.tests.service_test",path="/test")
 * @CG\Service\Service(
 *     name="test",
 *     controller=true,
 *     constructorMethods={
 *          @CG\Service\Construction(
 *              method="test",
 *              variables={
 *                  @CG\Service\Variable(
 *                      name="test",
 *                      type="string"
 *                  ),
 *                  @CG\Service\Variable(
 *                      name="test2",
 *                      type="string"
 *                  )
 *              }
 *          )
 *      }
 * )
 * @CG\Service\Injection(cache=true, event=true, em=true, router=true, url=true, twig=true)
 * @CG\Service\Tag(name="test", channel="test2")
 * @CG\Service\Alias(name="test2", alias="mjr_one.code_generator_bundle.tests.service_test")
 * @CG\Mutator\Mutator(visibility="protected")
 * @CG\Entity\Entity()
 * @CG\Repository\Repository(em=true)
 * @ORM\Entity(repositoryClass="\MjrOne\CodeGeneratorBundle\Repository\ServiceTestRepository", readOnly=false);
 */
class ServiceTest
{
    use TraitMutatorServiceTest;
    use TraitServiceServiceTest;
    /**
     * test
     * @CG\Mutator\Property(getter=false)
     * @var bool
     */
    protected $test;

    /**
     * @var RenderService
     * @CG\Service\Property(
     *     service="@mjrone.codegenerator.renderer",
     *     className="MjrOne\CodeGeneratorBundle\Services\RenderService",
     *     classShort="RenderService",
     *     optional=@CG\Service\Optional(
     *          ignore=true,
     *          variables={
     *              @CG\Service\Variable(
     *                  name="test",
     *                  type="string"
     *              )
     *          }
     *     )
     * )
     */
    protected $test2;

    /**
     * @param string $var
     */
    public function test33(string $var)
    {

    }

    /**
     * @param string $var1
     * @param string $var2
     */
    public function test(string $var1,string $var2)
    {

    }

    /**
     * @CG\Service\Property(
     *     service="@mjrone.codegenerator.renderer",
     *     className="MjrOne\CodeGeneratorBundle\Services\RenderService",
     *     classShort="RenderService",
     *     constructorMethod={
     *          @CG\Service\Construction(
     *              method="test33",
     *              variables={
     *                  @CG\Service\Variable(
     *                      name="test3",
     *                      type="string"
     *                  )
     *              }
     *          )
     *      }
     * )
     * @var string
     */
    protected $test3;

    /**
     * @var MjrOneCodeGeneratorBundle
     */
    protected $test4;

    /**
     * @var array
     */
    protected $test5;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $test6;

    /**
     * @var ArrayCollection
     */
    protected $test7;

    /**
     * @var string[]
     */
    protected $test8;

    /**
     * @var string[]
     * @CG\Mutator\Property(getter=false,setter=false,visibility="public")
     */
    protected $test9;

    public function __construct()
    {
        echo 'test';
    }
}
