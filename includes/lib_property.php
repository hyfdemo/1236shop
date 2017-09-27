<?php

/**
 * 属性相关函数
 * ============================================================================

 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: niqingyang $
 * $Id: lib_common.php 17217 2016-01-19 06:29:08Z niqingyang $
 */

/**
 * 新增或更新一个属性
 *
 * @param string $key
 *        	键
 * @param string $value
 *        	值
 * @return boolean
 */
function put_property ($key, $value)
{
	if(contains_key($key))
	{
		// 更新
		
		$property = array(
			"pro_value" => $value
		);
		/* update */
		return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('property'), $property, 'UPDATE', "pro_key = '$key'");
	}
	else
	{
		// 新增
		
		$property = array(
			'pro_key' => $key,"pro_value" => $value
		);
		/* insert */
		return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('property'), $property, 'INSERT');
	}
}

/**
 * 判断是否包含Key
 *
 * @param string $key
 *        	键
 * @return boolean true-存在 false-不存在
 */
function contains_key ($key)
{
	$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('property') . " WHERE pro_key = '$key'";
	$count = $GLOBALS['db']->getOne($sql);
	return $count > 0 ? true : false;
}

/**
 * 根据指定的Key获取一个属性
 *
 * @param string $key
 *        	键
 * @param string $def_value
 *        	默认值
 * @return <p>存在则返回 array(key, value)</p>
 *         <p>不存在则返回 默认值</p>
 */
function get_property ($key, $def_value)
{
	$sql = "SELECT pro_key, pro_value FROM " . $GLOBALS['ecs']->table('property') . " WHERE pro_key = '$key'";
	
	$property = $GLOBALS['db']->getOne($sql);
	
	if(! empty($property))
	{
		if(empty($property['pro_value']))
		{
			$property['pro_value'] = $def_value;
		}
	}
	else
	{
		$property['pro_key'] = $key;
		$property['pro_value'] = $def_value;
	}
	
	return $property;
}

/* ------------------------------------------------------ */
// -- 属性KEY
/* ------------------------------------------------------ */

class KEYS {
	/**
	 * OpenFire登录的用户名
	 * @var string
	 */
	public static $CHAT_OF_USER_NAME = 'ecs.chat.of.user.name';
	/**
	 * OpenFire登录的密码
	 * @var string
	 */
	public static $CHAT_OF_USER_PASSWORD = 'ecs.chat.of.user.password';
	/**
	 * OpenFire服务器的IP地址
	 * @var string
	 */
	public static $CHAT_OF_SERVER_IP = 'ecs.chat.of.server.ip';
	/**
	 * OpenFire服务的端口号
	 * @var int
	 */
	public static $CHAT_OF_SERVER_PORT = 'ecs.chat.of.server.port';
	/**
	 * OpenFire服务http-bind的端口号
	 * @var int
	 */
	public static $CHAT_OF_HTTP_BIND_PROT = 'ecs.chat.of.http.bind.port';
}

?>