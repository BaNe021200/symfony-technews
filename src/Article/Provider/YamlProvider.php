<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 29/11/2018
 * Time: 10:37
 */

namespace App\Article\Provider;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider
{
    /**
     * retourner des articles de articles.yaml sous forme de tableau
     */
    public function getArticles()
    {
        try
        {
            return Yaml::parseFile(__DIR__.'/articles.yaml')['data'];
        }catch (ParseException $exception)
        {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }



       // return $data;

    }
}