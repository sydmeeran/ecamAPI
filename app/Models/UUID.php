<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/10/18
 * Time: 3:14 PM
 */

namespace App;


class UUID {

    /**
     * @var
     */
    public $prefix;

    /**
     * @var
     */
    public $entropy;

    public $uuid;

    /**
     * @param string $prefix
     * @param bool $entropy
     */
    public function __construct($prefix = '', $entropy = false)
    {
        $this->uuid = uniqid($prefix, $entropy);
    }

    /**
     * Limit the UUID by a number of characters
     *
     * @param $length
     * @param int $start
     * @return $this
     */
    public function limit($length, $start = 0)
    {
        $this->uuid = substr($this->uuid, $start, $length);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->uuid;
    }
}