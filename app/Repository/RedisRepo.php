<?php

namespace App\Repository;
use Redis;

class RedisRepo{
    private Redis $redis;
    private $minute;
    private $hour;
    private $day;
    
    public static $prefix = 'laravel_database_';
    public function __construct(){
        $this->setRedis(new Redis());
        $this->redis->pconnect(env('REDIS_HOST','127.0.0.1'), env('REDIS_PORT',6379), 2.5);
        $this->redis->auth(env('REDIS_PASSWORD'));
        $this->minute = 60*60;
        $this->hour = $this->minute*60;
        $this->day = $this->hour*24;
    }

    public function setValue(string $key, $values){
        $this->redis->set(self::$prefix.$key,json_encode($values));
    }
    public function getValue(string $key) : int
    {
        $result = json_decode($this->redis->get(self::$prefix.$key));
        if(!is_int($result)){
            $result = 0;
        }
        return $result;
    }
	/**
	 * @return Redis
	 */
	function getRedis(): Redis {
		return $this->redis;
	}
	
	/**
	 * @param Redis $redis 
	 * @return RedisRepo
	 */
	function setRedis(Redis $redis): self {
		$this->redis = $redis;
		return $this;
	}
}