<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 04/12/2018
 * Time: 14:51
 */

namespace App\Controller;


use Behat\Transliterator\Transliterator;

trait HelperTrait
{
    /**
     * permet de générer un slug à partir d'un string
     * @param string $text
     * @return string
     */
    public function slugify(string $text):string
    {
        return Transliterator::transliterate($text);
    }
}