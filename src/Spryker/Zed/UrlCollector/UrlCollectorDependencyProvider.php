<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\UrlCollector;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\UrlCollector\Dependency\Facade\UrlCollectorToCollectorFacadeBridge;
use Spryker\Zed\UrlCollector\Dependency\QueryContainer\UrlCollectorToUrlQueryContainerBridge;

/**
 * @method \Spryker\Zed\UrlCollector\UrlCollectorConfig getConfig()
 */
class UrlCollectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COLLECTOR = 'FACADE_COLLECTOR';
    public const SERVICE_DATA_READER = 'SERVICE_DATA_READER';
    public const QUERY_CONTAINER_TOUCH = 'QUERY_CONTAINER_TOUCH';
    public const QUERY_CONTAINER_URL = 'QUERY_CONTAINER_URL';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $this->addCollectorFacade($container);
        $this->addDataReaderService($container);
        $this->addTouchQueryContainer($container);
        $this->addUrlQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addCollectorFacade(Container $container)
    {
        $container->set(static::FACADE_COLLECTOR, function (Container $container) {
            return new UrlCollectorToCollectorFacadeBridge($container->getLocator()->collector()->facade());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addDataReaderService(Container $container)
    {
        $container->set(static::SERVICE_DATA_READER, function (Container $container) {
            return $container->getLocator()->utilDataReader()->service();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addTouchQueryContainer(Container $container)
    {
        $container->set(static::QUERY_CONTAINER_TOUCH, function (Container $container) {
            return $container->getLocator()->touch()->queryContainer();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addUrlQueryContainer(Container $container)
    {
        $container->set(static::QUERY_CONTAINER_URL, function (Container $container) {
            return new UrlCollectorToUrlQueryContainerBridge($container->getLocator()->url()->queryContainer());
        });
    }
}
