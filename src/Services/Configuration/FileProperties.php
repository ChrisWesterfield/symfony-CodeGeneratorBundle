<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 22:21
 */

namespace MjrOne\CodeGeneratorBundle\Services\Configuration;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle;

class FileProperties extends AbstractConfig
{
    /**
     * @var bool
     */
    public $hideGeneratedBy;
    /**
     * @var string
     */
    public $copyRight;
    /**
     * @var string
     */
    public $license;
    /**
     * @var bool
     */
    public $useStrictTypes;
    /**
     * @var bool
     */
    public $useNamespace;
    /**
     * @var string
     */
    public $link;
    /**
     * @var ArrayCollection
     */
    public $authors;

    /**
     * @var string
     */
    public $generatorVersion;

    /**
     * @var string
     */
    public $generatorString;

    /**
     * FileProperties constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->hideGeneratedBy = $config['hide_generated_by'];
        $this->copyRight = $config['copyright'];
        $this->license = $config['license'];
        $this->useStrictTypes = $config['use_strict_types'];
        $this->useNamespace = $config['use_namespace'];
        $this->link = $config['link'];
        $this->authors = new ArrayCollection();
        $this->generatorVersion = MjrOneCodeGeneratorBundle::VERSION;
        $this->generatorString = MjrOneCodeGeneratorBundle::GENERATOR_INSERT_STRING;
        if(!empty($config['authors']))
        {
            foreach($config['authors'] as $id=>$author)
            {
                if($id===0 && count($config['authors'])>1)
                {
                    continue;
                }
                $this->authors->add(new Author($author));
            }
        }
    }

    /**
     * @return bool
     */
    public function isHideGeneratedBy(): bool
    {
        return $this->hideGeneratedBy;
    }

    /**
     * @param bool $hideGeneratedBy
     *
     * @return FileProperties
     */
    public function setHideGeneratedBy(bool $hideGeneratedBy): FileProperties
    {
        $this->hideGeneratedBy = $hideGeneratedBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getCopyRight(): string
    {
        return $this->copyRight;
    }

    /**
     * @param string $copyRight
     *
     * @return FileProperties
     */
    public function setCopyRight(string $copyRight): FileProperties
    {
        $this->copyRight = $copyRight;

        return $this;
    }

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * @param string $license
     *
     * @return FileProperties
     */
    public function setLicense(string $license): FileProperties
    {
        $this->license = $license;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUseStrictTypes(): bool
    {
        return $this->useStrictTypes;
    }

    /**
     * @param bool $useStrictTypes
     *
     * @return FileProperties
     */
    public function setUseStrictTypes(bool $useStrictTypes): FileProperties
    {
        $this->useStrictTypes = $useStrictTypes;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUseNamespace(): bool
    {
        return $this->useNamespace;
    }

    /**
     * @param bool $useNamespace
     *
     * @return FileProperties
     */
    public function setUseNamespace(bool $useNamespace): FileProperties
    {
        $this->useNamespace = $useNamespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return FileProperties
     */
    public function setLink(string $link): FileProperties
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAuthors(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->authors;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $authors
     *
     * @return FileProperties
     */
    public function setAuthors(\Doctrine\Common\Collections\ArrayCollection $authors): FileProperties
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneratorVersion(): string
    {
        return $this->generatorVersion;
    }

    /**
     * @param string $generatorVersion
     *
     * @return FileProperties
     */
    public function setGeneratorVersion(string $generatorVersion): FileProperties
    {
        $this->generatorVersion = $generatorVersion;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneratorString(): string
    {
        return $this->generatorString;
    }

    /**
     * @param string $generatorString
     *
     * @return FileProperties
     */
    public function setGeneratorString(string $generatorString): FileProperties
    {
        $this->generatorString = $generatorString;

        return $this;
    }

}
