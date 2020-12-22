<?php
use Magento\Framework\Component\ComponentRegistrar;

$registrar = new ComponentRegistrar();

if ($registrar->getPath(ComponentRegistrar::MODULE, 'Pixelpro_Helloworld') === null) {
    ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Pixelpro_Helloworld', __DIR__);
}
