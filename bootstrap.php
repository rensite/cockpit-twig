<?php

if (!COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {

  $this->module("twig")->extend([

    "use" => function(\Twig\Environment $env) use($app) {

      $twig_funcs = array();

      // Singletons
      $twig_funcs[] = new \Twig\TwigFunction('singleton', function($name, $field){
        return cockpit('singletons')->getFieldValue($name, $field);
      });

      // COLLECTIONS
      $twig_funcs[] = new \Twig\TwigFunction('collection', function($name, $query = [], $array = true){
        $items = cockpit('collections')->find($name, $query);
        return $items;
      });

      // COLLECTION ENTRY
      $twig_funcs[] = new \Twig\TwigFunction('collection_entry', function($name, $query = [], $array = true){
        $item = cockpit('collections')->findOne($name, $query);
        return $item;
      });

      // echo "<pre>";
      // var_dump($app->module('cockpit')->thumbnail($image, $width, $height, $options));

      // MEDIAMANAGER
      $twig_funcs[] = new \Twig\TwigFunction('thumbnail', function($image, $width = null, $height = null, $options = [])  use($app) {
        // return $app->module('cockpit')->thumbnail($image, $width, $height, $options);
        
        $options = array_merge([
          'src' => $image,
          'width' => $width,
          'height' => $height,
        ], $options);

        return $app->module('cockpit')->thumbnail($options);
      });

      $twig_funcs[] = new \Twig\TwigFunction('thumbnail_url', function($image, $width = null, $height = null, $options = []) {
        return thumbnail_url($image, $width, $height, $options);
      });

      // GALLERIES
      $twig_funcs[] = new \Twig\TwigFunction('gallery', function($name){
        return cockpit("galleries")->gallery($name);
      });

      // FORMS
      $twig_funcs[] = new \Twig\TwigFunction('form', function($name, $options = []){
        cockpit("forms")->form($name, $options);
      });

      // AUTH
      $twig_funcs[] = new \Twig\TwigFunction('get_user', function(){
        return cockpit('auth')->getUser();
      });
      $twig_funcs[] = new \Twig\TwigFunction('has_access', function($resource, $action){
        return cockpit('auth')->hasaccess($resource, $action);
      });

      // Add functions to Twig.
      foreach ($twig_funcs as $func) {
        $env->addFunction($func);
      }
    }

  ]);

}
