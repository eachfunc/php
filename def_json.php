<?php

/**
 * @param $url
 * @param array $data
 * @param null $callback
 *
 * @return false|string
 */
function def_json($url, array $data = [], $callback = null)
{
    $json = '{}';

    if (!empty($data)) {
        $json = json_encode($data);
    }

    if ($json === false) {
        // Avoid echo of empty string (which is invalid JSON), and
        // JSONify the error message instead:
        $json = json_encode(["jsonError" => json_last_error_msg()]);
        if ($json === false) {
            // This should not happen, but we go all the way now:
            $json = '{"jsonError":"unknown"}';
        }
    }

    if (!empty($url)) {
        file_put_contents($url, $json);
    }

    if (is_callable($callback)) {
        $callback($json);
    }

    return $json;
}


/**
 * Class DefJson
 */
class DefJson
{
    // IN

    /** @var string */
    public $url = '';

    /** @var array */
    public $data = [];

    /** @var function|null */
    public $callback;

    // OUT

    /** @var string */
    public $json = '';


    /**
     * DefJson constructor.
     * @param $url
     * @param array $data
     * @param null $callback
     */
    public function __construct($url, array $data = [], $callback = null)
    {
        $this->url = $url;
        $this->data = $data;
        $this->callback = $callback;
    }


    /**
     * @return mixed
     */
    function first()
    {
        return $this->json[0];
    }


    public function exec()
    {
        $this->json = def_json($this->url, $this->data, $this->callback);
    }

    /**
     * @param $callback
     */
    function each($callback)
    {
        foreach ($this->json as $item) {
            if (is_callable($callback)) {
                $callback($item);
            }
        }
    }
}