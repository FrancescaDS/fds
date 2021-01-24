<?php


namespace Fds\FirstModule\Plugin;


class PluginSolutionSortOrder3
{
    public function beforeExecute(
        \Fds\FirstModule\Controller\Page\HelloWorld $subject)
    {
        echo "Plugin Before Execute -- sort order 30<br>";
    }

    public function afterExecute(
        \Fds\FirstModule\Controller\Page\HelloWorld $subject)
    {
        echo "<br>Plugin After Execute -- sort order 30<br>";
    }

    public function aroundExecute(
        \Fds\FirstModule\Controller\Page\HelloWorld $subject,
    callable $proceed)
    {
        echo "Before Proceed Plugin Around Execute -- sort order 30" . "</br>";
        $proceed();
        echo "</br>" . "After Proceed Plugin Around Execute -- sort order 30";
    }

}
