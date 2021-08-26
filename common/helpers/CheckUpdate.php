<?php

namespace common\helpers;
use Yii;
class CheckUpdate {
    public function actionCheck(){
        $version = './Data/version.php';
        $ver = include($version);
        $ver = $ver['ver'];
        $ver = substr($ver,-3);
        $http_type = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
        $updatehost = ''.$http_type.'weiqing.tuangou.today/api/';
        $lastver = file_get_contents(($updatehost . '?a=check&v=') . $ver);
        if($lastver !== $ver){
            $updateinfo = ('<p class="red">最新版本为：v ' . $lastver) . '</p><span>
		   <a href="javascript:if(confirm(\'升级前,请确认已经做好数据库和程序备份!\'))location=\'./index.php?g=System&m=Update&a=updatenow\'">点击这里在线升级</a>
           </span>';
            $chanageinfo = file_get_contents(($updatehost . '?a=chanage&v=') . $lastver);
        }else{
            $updateinfo = ('<p class="red">最新版本为：v ' . $lastver) . '</p><span>已经是最新系统 不需要升级</span>';
        }
//        $this -> assign('updateinfo', $updateinfo);
//        $this -> assign('chanageinfo', $chanageinfo);
//        $this -> display();
    }
    public function actionUpdatenow(){
        include('Update.class.php');
//        $version = './Data/version.php';
//        $ver = include($version);
//        $ver = $ver['ver'];
        $ver = Yii::$app->debris->version()['version'];
        $hosturl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        $updatehost = 'http://weiqing.tuangou.today/api/';
        $updatehosturl = $updatehost . '?a=update&v=' . $ver . '&u=' . $hosturl;
        $updatenowinfo = file_get_contents($updatehosturl);
        if (strstr($updatenowinfo, 'zip')){
            $pathurl = $updatehost . '?a=down&f=' . $updatenowinfo;
            $updatedir = './Data/logs/Temp/update';
            delDirAndFile($updatedir);
            get_file($pathurl, $updatenowinfo, $updatedir);
            $updatezip = $updatedir . '/' . $updatenowinfo;
            $archive = new PclZip($updatezip);
            if ($archive -> extract(PCLZIP_OPT_PATH, './', PCLZIP_OPT_REPLACE_NEWER) == 0){
                $updatenowinfo = "远程升级文件不存在.升级失败</font>";
            }else{
                $sqlfile = $updatedir . '/update.sql';
                $sql = file_get_contents($sqlfile);
                if($sql){
                    $sql = str_replace("wy_", C('DB_PREFIX'), $sql);
                    $Model = new Model();
                    error_reporting(0);
                    foreach(split(";[\r\n]+", $sql) as $v){
                        @mysql_query($v);
                    }
                }
                $updatenowinfo = "<font color=red>升级完成 {$sqlinfo}</font><span><a href=./index.php?g=System&m=Update>点击这里 查看是否还有升级包</a></span>";
            }
        }
        //delDirAndFile($updatedir);
//        $this -> assign('updatenowinfo', $updatenowinfo);
//        $this -> display();
    }
}
