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
 * Time: 22:19
 */

namespace MjrOne\CodeGeneratorBundle\Services\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

class Author extends AbstractConfig
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $email;

    /**
     * Author constructor.
     *
     * @param array $user
     */
    public function __construct(array $user)
    {
        $this->name = $user['name'];
        $this->email = $user['email'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Author
     */
    public function setName(string $name): Author
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Author
     */
    public function setEmail(string $email): Author
    {
        $this->email = $email;

        return $this;
    }


}
