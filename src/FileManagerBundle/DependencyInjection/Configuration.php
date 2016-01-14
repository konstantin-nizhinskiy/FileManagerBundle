<?php

namespace FileManagerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('file_manager');
        $rootNode->children()
            ->scalarNode('web_dir') // Директория web
            ->end()
            ->scalarNode('file_manager_dir') // Директория для сохранения файлов
            ->end()
            ->arrayNode('type_file') //Типы файлов для допустипые для загрузки
            ->prototype('scalar')->end()
            ->end()
            ->end();


        return $treeBuilder;
    }
}
