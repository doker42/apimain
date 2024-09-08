<?php

namespace App\Services\Images;

use Exception;
use Tinify\ClientException;
use Tinify\Source;
use Tinify\Tinify;

class TinifyService
{

    public string $apikey;

    public $client;

    /**
     * Get api key from env, fail if any are missing.
     * Instantiate API client and set api key.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->apikey = config('tinify.api_key');
        if (!$this->apikey) {
            throw new \InvalidArgumentException('Please set TINIFY_APIKEY in environment variables or in config.');
        }
        $this->client = new Tinify();
        $this->client->setKey($this->apikey);
    }


    /**
     * @param $path
     * @return Source
     */
    public function fromFile($path)
    {
        return Source::fromFile($path);
    }


    /**
     * @param $string
     * @return Source
     */
    public function fromBuffer($string)
    {
        return Source::fromBuffer($string);
    }


    /**
     * @param string $fileContent
     * @param array $options
     * @return Source
     */
    public function resize(string $fileContent, array $options = []): Source
    {
        $source = Source::fromBuffer($fileContent);

        $options = $this->getOptions($options);

        return $source->resize($options);
    }


    /**
     * @param array $options
     * @return array
     */
    private function getOptions(array $options): array
    {
        if (!count($options)) {
            return [
                "method" => "fit",
                "width"  => 70,
                "height" => 70
            ];
        }

        //todo validate options

        return $options;
    }


    public function fromUrl($string)
    {
        return Source::fromUrl($string);
    }

}


