<?php

namespace common\components;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;
use common\enums\AppEnum;
use common\helpers\AddonHelper;

/**
 * Class Debris
 * @package common\components
 * @author YiiFrame <21931118@qq.com>
 */
class Debris
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * 返回配置名称
     *
     * @param string $name 字段名称
     * @param bool $noCache true 不从缓存读取 false 从缓存读取
     * @param string $merchant_id
     * @return string|null
     */
    public function config($name, $noCache = false, $merchant_id = '')
    {
        !$merchant_id && $merchant_id = Yii::$app->services->merchant->getId();
        $app_id = !$merchant_id ? AppEnum::BACKEND : AppEnum::MERCHANT;

        // 获取缓存信息
        $info = $this->getConfigInfo($noCache, $app_id, $merchant_id);

        return isset($info[$name]) ? trim($info[$name]) : null;
    }

    /**
     * 返回配置名称
     *
     * @param bool $noCache true 不从缓存读取 false 从缓存读取
     * @return array|bool|mixed
     */
    public function configAll($noCache = false, $merchant_id = '')
    {
        !$merchant_id && $merchant_id = Yii::$app->services->merchant->getId();
        $app_id = !$merchant_id ? AppEnum::BACKEND : AppEnum::MERCHANT;

        $info = $this->getConfigInfo($noCache, $app_id, $merchant_id);

        return $info ? $info : [];
    }

    public function addonConfig($noCache = false,$name='', $merchant_id = '')
    {
//        !$merchant_id && $merchant_id = Yii::$app->services->merchant->getId();
        $app_id = !$merchant_id ? AppEnum::BACKEND : AppEnum::MERCHANT;

        $info = AddonHelper::findConfig($noCache,$merchant_id,$name,$app_id);
        return $info ? $info : [];
    }
    /**
     * 返回配置名称
     *
     * @param string $name 字段名称
     * @param bool $noCache true 不从缓存读取 false 从缓存读取
     * @param string $merchant_id
     * @return string|null
     */
    public function backendConfig($name, $noCache = false)
    {
        // 获取缓存信息
        $info = $this->getConfigInfo($noCache, AppEnum::BACKEND);

        return isset($info[$name]) ? trim($info[$name]) : null;
    }

    /**
     * 返回配置名称
     *
     * @param bool $noCache true 不从缓存读取 false 从缓存读取
     * @return array|bool|mixed
     */
    public function backendConfigAll($noCache = false)
    {
        $info = $this->getConfigInfo($noCache, AppEnum::BACKEND);

        return $info ? $info : [];
    }

    /**
     * 获取当前企业配置
     *
     * @param $name
     * @param bool $noCache
     * @return string|null
     */
    public function merchantConfig($name, $noCache = false, $merchant_id = '')
    {
        !$merchant_id && $merchant_id = Yii::$app->services->merchant->getId();
        !$merchant_id && $merchant_id = 1;

        // 获取缓存信息
        $info = $this->getConfigInfo($noCache, AppEnum::MERCHANT, $merchant_id);

        return isset($info[$name]) ? trim($info[$name]) : null;
    }

    /**
     * 获取当前企业的全部配置
     *
     * @param bool $noCache
     * @return array|bool|mixed
     */
    public function merchantConfigAll($noCache = false, $merchant_id = '')
    {
        !$merchant_id && $merchant_id = Yii::$app->services->merchant->getId();
        !$merchant_id && $merchant_id = 1;

        $info = $this->getConfigInfo($noCache, AppEnum::MERCHANT, $merchant_id);

        return $info ? $info : [];
    }
    public function getAllInfo($noCache, $app_id, $merchant_id = '')
    {
        // 获取缓存信息
        $cacheKey = 'config:' . $merchant_id . $app_id;
        if ($noCache == false && !empty($this->config[$cacheKey])) {
            return $this->config[$cacheKey];
        }

        if ($noCache == true || !($this->config[$cacheKey] = Yii::$app->cache->get($cacheKey))) {
            $config = Yii::$app->services->config->findAllWithValue($app_id, $merchant_id);
            $this->config[$cacheKey] = [];

            foreach ($config as $row) {
                $this->config[$cacheKey][$row['name']] = $row['value']['data'] ?? $row['default_value'];
            }

            Yii::$app->cache->set($cacheKey, $this->config[$cacheKey], 60 * 60);
        }

        return $this->config[$cacheKey];
    }
    /**
     * 获取全部配置信息
     *
     * @param $noCache true 不从缓存读取 false 从缓存读取
     * @param int $merchant_id 强制从某个企业读取
     * @return array|mixed
     */
    protected function getConfigInfo($noCache, $app_id, $merchant_id = '')
    {
        // 获取缓存信息
        $cacheKey = 'config:' . $merchant_id . $app_id;
        if ($noCache == false && !empty($this->config[$cacheKey])) {
            return $this->config[$cacheKey];
        }

        if ($noCache == true || !($this->config[$cacheKey] = Yii::$app->cache->get($cacheKey))) {
            $config = Yii::$app->services->config->findAllWithValue($app_id, $merchant_id);
            $this->config[$cacheKey] = [];

            foreach ($config as $row) {
                $this->config[$cacheKey][$row['name']] = $row['value']['data'] ?? $row['default_value'];
            }

            Yii::$app->cache->set($cacheKey, $this->config[$cacheKey], 60 * 60);
        }

        return $this->config[$cacheKey];
    }

    /**
     * 获取设备客户端信息
     *
     * @return mixed|string
     */
    public function detectVersion()
    {
        /** @var \Detection\MobileDetect $detect */
        $detect = Yii::$app->mobileDetect;
        if ($detect->isMobile()) {
            $devices = $detect->getOperatingSystems();
            $device = '';

            foreach ($devices as $key => $valaue) {
                if ($detect->is($key)) {
                    $device = $key . $detect->version($key);
                    break;
                }
            }

            return $device;
        }

        return $detect->getUserAgent();
    }

    /**
     * 打印
     *
     * @param mixed ...$array
     */
    public function p(...$array)
    {
        echo "<pre>";

        if (count($array) == 1) {
            print_r($array[0]);
        } else {
            print_r($array);
        }

        echo '</pre>';
    }

    /**
     * 解析系统报错
     *
     * @param \Exception $e
     * @return array
     */
    public function getSysError(\Exception $e)
    {
        return [
            'errorMessage' => $e->getMessage(),
            'type' => get_class($e),
            'file' => method_exists($e, 'getFile') ? $e->getFile() : '',
            'line' => $e->getLine(),
            'stack-trace' => explode("\n", $e->getTraceAsString()),
        ];
    }

    /**
     * 解析微信是否报错
     *
     * @param array $message 微信回调数据
     * @param bool $direct 是否直接报错
     * @return bool
     * @throws UnprocessableEntityHttpException
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getWechatError($message, $direct = true)
    {
        if (isset($message['errcode']) && $message['errcode'] != 0) {
            // token过期 强制重新从微信服务器获取 token.
            if ($message['errcode'] == 40001) {
                Yii::$app->wechat->app->access_token->getToken(true);
            }

            if ($direct) {
                throw new UnprocessableEntityHttpException($message['errmsg']);
            }

            return $message['errmsg'];
        }

        return false;
    }

    /**
     * 解析错误
     *
     * @param $fistErrors
     * @return string
     */
    public function analyErr($firstErrors)
    {
        if (!is_array($firstErrors) || empty($firstErrors)) {
            return false;
        }

        $errors = array_values($firstErrors)[0];
        return $errors ?? '未捕获到错误信息';
    }

    /**
     * 当前版本号
     *
     * @return mixed|string
     * @throws NotFoundHttpException
     */
    public function version()
    {
        $file = Yii::getAlias('@common') . '/config/version.php';
        if (!file_exists($file)) {
            throw new NotFoundHttpException("找不到版本号文件");
        }

        $version = require $file;

        return $version;
    }
}