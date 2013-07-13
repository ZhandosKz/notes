<?php
class UrlRule extends CBaseUrlRule
{
	public $connectionID = 'db';

	public function createUrl($manager,$route,$params,$ampersand)
	{
		if ($route==='ads/ads/view')
		{
			if (isset($params['alias']))
			{
				$url = 'ads/'.$params['alias'];
				unset($params['alias']);
				if (!empty($params))
				{
					$url .= '?'.implode('&', array_map(function($key, $value){
							return $key.'='.$value;
						}, array_keys($params), array_values($params)));
				}
				return $url;
			}
		}
		return false;
	}

	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		if (preg_match('/^([a-z0-9-]+)$/i', $pathInfo, $matches))
		{
			$url = Url::model()->find('path = :path', array(':path' => $matches[1]));
			if (!$url instanceof Url)
			{
				return FALSE;
			}

			//$_GET['alias'] = $ads->alias;
			return 'ads/ads/view';
		}
		return false;
	}
}