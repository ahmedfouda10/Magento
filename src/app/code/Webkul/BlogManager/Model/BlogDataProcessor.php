<?php
namespace Webkul\BlogManager\Model;

class BlogDataProcessor
{
    public function process(array $data)
    {
        // Remove any empty or null values
        return array_filter($data, function($value) {
            return $value !== null && $value !== '';
        });
    }
}
