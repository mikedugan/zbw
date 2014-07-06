<?php  namespace Zbw\Start; 

use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CacheFilter {

    public function fetch(Route $route, Request $request)
    {
        $key = $this->makeCacheKey($request->url());

        //if(\Cache::has($key)) return \Cache::get($key);
    }

    public function put(Route $route, Request $request, Response $response)
    {
        $key = $this->makeCacheKey($request->url());
        //if(! \Cache::has($key)) \Cache::put($key, $response->getContent(), \Config::get('cache.times.page'));
    }

    private function makeCacheKey($url)
    {
        return 'route_' . \Str::slug($url);
    }
} 
