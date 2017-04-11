<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Exception\NoContentException;
use MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException;

/**
 * Class RenderedOutput
 *
 * @package   MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class RenderedOutput
{
    const TYPE_METHOD = 'method';
    const TYPE_SETUP = 'setup';
    const TYPE_TEST_METHOD = 'test';
    const ALLOWED_TYPES = [
        self::TYPE_METHOD,
        self::TYPE_SETUP,
        self::TYPE_TEST_METHOD,
    ];

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return RenderedOutput
     * @throws \MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException
     */
    public function setType(string $type): RenderedOutput
    {
        if(!in_array($type, self::ALLOWED_TYPES))
        {
            throw new TypeNotAllowedException('The Type '.$type.' is not an allowed type. (Allowed: '.implode(', ',self::ALLOWED_TYPES).')');
        }
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return RenderedOutput
     * @throws \MjrOne\CodeGeneratorBundle\Exception\NoContentException
     */
    public function setContent(string $content): RenderedOutput
    {
        if($content === null)
        {
            throw new NoContentException('No Output submited to add Method');
        }
        $this->content = $content;

        return $this;
    }

    /**
     * RenderedOutput constructor.
     *
     * @param string $type
     * @param string $output
     *
     * @throws \MjrOne\CodeGeneratorBundle\Exception\NoContentException
     * @throws \MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException
     */
    public function __construct(string $type,string $output)
    {
        $this->setContent($output);
        $this->setType($type);
    }
}
