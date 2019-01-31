<?php

namespace Solarium\Core\Client;

use Solarium\Core\Configurable;

/**
 * Class for describing an endpoint.
 */
class Endpoint extends Configurable
{
    /**
     * Default options.
     *
     * The defaults match a standard Solr example instance as distributed by
     * the Apache Lucene Solr project.
     *
     * @var array
     */
    protected $options = [
        'scheme' => 'http',
        'host' => '127.0.0.1',
        'port' => 8983,
        'path' => '/solr',
        'collection' => null,
        'core' => null,
        'timeout' => 5,
        'leader' => false,
    ];

    /**
     * Magic method enables a object to be transformed to a string.
     *
     * Get a summary showing significant variables in the object
     * note: uri resource is decoded for readability
     *
     * @return string
     */
    public function __toString()
    {
        $output = __CLASS__.'::__toString'."\n".'base uri: '.$this->getCoreBaseUri()."\n".'host: '.$this->getHost()."\n".'port: '.$this->getPort()."\n".'path: '.$this->getPath()."\n".'collection: '.$this->getCollection()."\n".'core: '.$this->getCore()."\n".'timeout: '.$this->getTimeout()."\n".'authentication: '.print_r($this->getAuthentication(), 1);

        return $output;
    }

    /**
     * Get key value.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->getOption('key');
    }

    /**
     * Set key value.
     *
     * @param string $value
     *
     * @return self Provides fluent interface
     */
    public function setKey($value): self
    {
        $this->setOption('key', $value);
        return $this;
    }

    /**
     * Set host option.
     *
     * @param string $host This can be a hostname or an IP address
     *
     * @return self Provides fluent interface
     */
    public function setHost($host): self
    {
        $this->setOption('host', $host);
        return $this;
    }

    /**
     * Get host option.
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->getOption('host');
    }

    /**
     * Set port option.
     *
     * @param int $port Common values are 80, 8080 and 8983
     *
     * @return self Provides fluent interface
     */
    public function setPort($port): self
    {
        $this->setOption('port', $port);
        return $this;
    }

    /**
     * Get port option.
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->getOption('port');
    }

    /**
     * Set path option.
     *
     * If the path has a trailing slash it will be removed.
     *
     * @param string $path
     *
     * @return self Provides fluent interface
     */
    public function setPath($path): self
    {
        if ('/' === substr($path, -1)) {
            $path = substr($path, 0, -1);
        }

        $this->setOption('path', $path);
        return $this;
    }

    /**
     * Get path option.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getOption('path');
    }

    /**
     * Set collection option.
     *
     * @param string $collection
     *
     * @return self Provides fluent interface
     */
    public function setCollection($collection): self
    {
        $this->setOption('collection', $collection);
        return $this;
    }

    /**
     * Get collection option.
     *
     * @return string|null
     */
    public function getCollection(): ?string
    {
        return $this->getOption('collection');
    }

    /**
     * Set core option.
     *
     * @param string $core
     *
     * @return self Provides fluent interface
     */
    public function setCore($core): self
    {
        $this->setOption('core', $core);
        return $this;
    }

    /**
     * Get core option.
     *
     * @return string|null
     */
    public function getCore(): ?string
    {
        if (null === $this->getOption('core') && null !== $this->getOption('collection')) {
            return $this->getCollection();
        }

        return $this->getOption('core');
    }

    /**
     * Set timeout option.
     *
     * @param int $timeout
     *
     * @return self Provides fluent interface
     */
    public function setTimeout($timeout): self
    {
        $this->setOption('timeout', $timeout);
        return $this;
    }

    /**
     * Get timeout option.
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->getOption('timeout');
    }

    /**
     * Set scheme option.
     *
     * @param string $scheme
     *
     * @return self Provides fluent interface
     */
    public function setScheme($scheme): self
    {
        $this->setOption('scheme', $scheme);
        return $this;
    }

    /**
     * Get scheme option.
     *
     * @return string
     */
    public function getScheme(): string
    {
        return $this->getOption('scheme');
    }

    /**
     * Get the base url for all SolrCloud requests.
     *
     * Based on host, path, port and collection options.
     *
     * @return string
     */
    public function getCollectionBaseUri(): string
    {
        $uri = $this->getServerUri();
        $collection = $this->getCollection();

        if (null !== $collection) {
            $uri .= $collection.'/';
        }

        return $uri;
    }

    /**
     * Get the base url for all requests.
     *
     * Based on host, path, port and core options.
     *
     * @return string
     */
    public function getCoreBaseUri(): string
    {
        $uri = $this->getServerUri();
        $core = $this->getCore();

        if (!empty($core)) {
            $uri .= $core.'/';
        }

        return $uri;
    }

    /**
     * Get the base url for all requests.
     *
     * Based on host, path, port and core options.
     *
     * @deprecated Please use getCollectionBaseUri, getCoreBaseUri or getServerUri now, will be removed in Solarium 5
     *
     * @return string
     */
    public function getBaseUri(): string
    {
        $message = 'Endpoint::getBaseUri is deprecated since Solarium 4.2, will be removed in Solarium 5.'.
            'please use getServerUri or getCoreBaseUri now.';
        @trigger_error($message, E_USER_DEPRECATED);

        return $this->getCoreBaseUri();
    }

    /**
     * Get the server uri, required for non core/collection specific requests.
     *
     * @return string
     */
    public function getServerUri(): string
    {
        return $this->getScheme().'://'.$this->getHost().':'.$this->getPort().$this->getPath().'/';
    }

    /**
     * Set HTTP basic auth settings.
     *
     * If one or both values are NULL authentication will be disabled
     *
     * @param string $username
     * @param string $password
     *
     * @return self Provides fluent interface
     */
    public function setAuthentication($username, $password): self
    {
        $this->setOption('username', $username);
        $this->setOption('password', $password);

        return $this;
    }

    /**
     * Get HTTP basic auth settings.
     *
     * @return array
     */
    public function getAuthentication(): array
    {
        return [
            'username' => $this->getOption('username'),
            'password' => $this->getOption('password'),
        ];
    }

    /**
     * If the shard is a leader or not. Only in SolrCloud.
     *
     * @param bool $leader
     *
     * @return $this
     */
    public function setLeader(bool $leader): self
    {
        $this->setOption('leader', $leader);
        return $this;
    }

    /**
     * If the shard is a leader or not. Only in SolrCloud.
     *
     * @return bool
     */
    public function isLeader(): bool
    {
        return $this->getOption('leader');
    }

    /**
     * Initialization hook.
     *
     * In this case the path needs to be cleaned of trailing slashes.
     *
     * @see setPath()
     */
    protected function init()
    {
        foreach ($this->options as $name => $value) {
            switch ($name) {
                case 'path':
                    $this->setPath($value);
                    break;
            }
        }
    }
}
