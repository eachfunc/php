<?php


/**
 * @param array $list
 * @param null $callback
 * @return array|mixed
 */
function each_func($list = [], $callback = null)
{
    if (!is_callable($callback)) {
        return $list;
    }

    $new_list = [];
    foreach ($list as $key => $item) {
        $result = $callback($item, $key);
        if($result !== null){
            $new_list[$key] = $result;
        }
    }
    return $new_list;
}


/**
 * Class DefJson
 */
class EachFunc
{
    // IN

    /** @var array */
    public $list = [];

    /** @var function|null */
    public $callback;

    // OUT

    /** @var array */
    public $new_list = [];

    /**
     * EachFunc constructor.
     * @param array $list
     * @param function|null $callback
     */
    public function __construct(array $list = [], $callback = null){
        $this->list = $list;
        $this->callback = $callback;
    }


    public function exec()
    {
        $this->new_list = each_func($this->list, $this->callback);
    }

    /**
     * @param $callback
     */
    function each($callback)
    {
        foreach ($this->list as $item) {
            if (is_callable($callback)) {
                $callback($item);
            }
        }
    }

}