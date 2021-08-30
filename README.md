## YiiFrame 2.0

### 前言

YiiFrame 是一个通用的Web编程框架，可完美运行在linux、mac和windows环境下，用于开发各种基于PHP构建的Web应用程序，包括APP、小程序、H5、网站等。 基于插件的框架结构特别适合开发大型应用系统的后端和提供接口服务，如门户网站、社区、CMS、CRM、ERP、OA、电子商务等项目。

### 特色

- 极强的可扩展性，应用化，模块化，插件化机制敏捷开发，支持国际化，内置简体中文、繁体、英语、日语等语言包。
- 极致的插件机制，微核架构，良好的功能延伸性，功能之间是隔离，可定制性高，可以渐进式地开发，逐步增加功能，安装和卸载不会对原来的系统产生影响,强大的功能完全满足各阶段的需求，支持用户多端访问(后台、微信、Api、前台等)。
- 极完善的 RBAC 权限控制管理、无限父子级权限分组、可自由分配子级权限，且按钮/链接/自定义内容/插件等都可加入权限控制。
- 只做基础底层内容，不会在上面开发过多的业务内容，满足绝大多数的系统二次开发。
- 多入口模式，多入口分为 Backend (后台)、Merchant (企业端)、Frontend (PC前端)、Html5 (手机端)、Console (控制台)、Api (对内接口)、OAuth2 Server (对外接口)、MerApi (企业接口)、Storage (静态资源)，不同的业务，不同的设备，进入不同的入口。
- 对接微信公众号且支持小程序，使用了一款优秀的微信非官方 SDK Easywechat 4.x，开箱即用，预置了绝大部分功能，大幅度的提升了微信开发效率。
- 支持第三方登录，目前有 QQ、微信、微博、GitHub 等等。
- 支持第三方支付，目前有微信支付、支付宝支付、银联支付，二次封装为网关多个支付一个入口一个出口。
- 支持 RESTful API，支持前后端分离接口开发和 App 接口开发，可直接上手开发业务。
- 一键切换云存储，本地存储、腾讯 COS、阿里云 OSS、七牛云存储都可一键切换，且增加其他第三方存储也非常方便。
- 全面监控系统报错，报错日志写入数据库，方便定位错误信息。支持直接钉钉提醒。
- 快速高效的 Servises (服务层)，遵循 Yii2 的懒加载方式，只初始化使用到的组件服务。
- 丰富的表单控件(时间、日期、时间日期、日期范围选择、颜色选择器、省市区三级联动、省市区勾选、单图上传、多图上传、单文件上传、多文件上传、百度编辑器、百度图表、多文本编辑框、地图经纬度选择器、图片裁剪上传、TreeGrid、JsTree、Markdown 编辑器)和组件(二维码生成、Curl、IP地址转地区)，快速开发，不必再为基础组件而担忧。
- 快速生成 CURD ,无需编写代码，只需创建表设置路径就能出现一个完善的 CURD ,其中所需表单控件也是勾选即可直接生成。
- 如需使用企业端，请安装企业端插件，开发只需要开发企业端即可
- 完善的文档和辅助类，方便二次开发与集成。


### 应用架构流程

![image](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/app-flow.png)

### 系统快照

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E7%B3%BB%E7%BB%9F%E9%A6%96%E9%A1%B5.png "系统首页")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E7%AB%99%E7%82%B9%E8%AE%BE%E7%BD%AE.png "站点设置")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E9%85%8D%E7%BD%AE%E7%AE%A1%E7%90%86.png "配置管理")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E5%BA%94%E7%94%A8%E7%AE%A1%E7%90%86.png "应用管理")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E6%9D%83%E9%99%90%E7%AE%A1%E7%90%86.png "权限管理")

### 案例截图

安装插件
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%AE%89%E8%A3%85%E6%8F%92%E4%BB%B6.png "屏幕截图.png")
已安装插件
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%B2%E5%AE%89%E8%A3%85%E6%8F%92%E4%BB%B6.png "屏幕截图.png")
工作流列表
![](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%A5%E4%BD%9C%E6%B5%81%E5%88%97%E8%A1%A8.png "屏幕截图.png")

流程状态
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%B5%81%E7%A8%8B%E7%8A%B6%E6%80%81.png "屏幕截图.png")
配置审核人员
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E9%85%8D%E7%BD%AE%E5%AE%A1%E6%A0%B8%E4%BA%BA%E5%91%98.png "屏幕截图.png")
工作流转
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%A5%E4%BD%9C%E6%B5%81%E8%BD%AC.png "屏幕截图.png")
新增流程节点
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%88%9B%E5%BB%BA%E6%B5%81%E7%A8%8B%E8%8A%82%E7%82%B9.png "屏幕截图.png")
待办工作
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%BE%85%E5%8A%9E%E5%B7%A5%E4%BD%9C.png "屏幕截图.png")
已办工作
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%B2%E5%8A%9E%E5%B7%A5%E4%BD%9C.png "屏幕截图.png")
审核工作
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%AE%A1%E6%A0%B8%E5%B7%A5%E4%BD%9C.png "屏幕截图.png")
创建申请
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%88%9B%E5%BB%BA%E7%94%B3%E8%AF%B7.png "屏幕截图.png")
查看进度
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%9F%A5%E7%9C%8B%E8%BF%9B%E5%BA%A6.png "屏幕截图.png")
班次管理
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E7%8F%AD%E6%AC%A1%E7%AE%A1%E7%90%86.png "屏幕截图.png")
排班管理
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%8E%92%E7%8F%AD%E7%AE%A1%E7%90%86.png "屏幕截图.png")
我的排班
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%88%91%E7%9A%84%E6%8E%92%E7%8F%AD.png "屏幕截图.png")
签到列表
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E7%AD%BE%E5%88%B0%E5%88%97%E8%A1%A8.png "屏幕截图.png")
新建打卡
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E7%AD%BE%E5%88%B0%E6%89%93%E5%8D%A1.png "屏幕截图.png")

### 开始之前

- 具备 PHP 基础知识
- 具备 Yii2 基础开发知识
- 具备 开发环境的搭建
- 仔细阅读文档，一般常见的报错可以自行先解决，解决不了再来提问
- 如果要做小程序或微信开发需要明白微信接口的组成，自有服务器、微信服务器、公众号（还有其它各种号）、测试号、以及通信原理（交互过程）
- 如果需要做接口开发(RESTful API)了解基本的 HTTP 协议，Header 头、请求方式（`GET\POST\PUT\PATCH\DELETE`）等
- 能查看日志和 Debug 技能
- 一定要仔细走一遍文档


### 官网

http://www.yiiframe.com

### 文档

http://doc.yiiframe.com

### 插件下载

https://www.yiiframe.com/category/addons/

### github
https://github.com/hjp1011/yiiframe

### gitee
https://gitee.com/hjp1011/yiiframe

### 问题反馈

在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

issues：https://github.com/hjp1011/yiiframe/issues

### 特别鸣谢

感谢以下的项目，排名不分先后

Yii：http://www.yiiframework.com

EasyWechat：https://www.easywechat.com

Bootstrap：http://getbootstrap.com

AdminLTE：https://adminlte.io

Rageframe：http://www.rageframe.com
...

### 版权信息

YiiFrame 遵循 Apache2 开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2010-2028 by YiiFrame [www.yiiframe.com](https://www.yiiframe.com)

All rights reserved。

### 更新日志
updated 2021.04.19

- 修复省市区插件long模板bug
- member会员表添加role_id字段

updated 2021.05.23

- 修复插件安装bug
- 更新数据迁移数据
- 修复左侧菜单bug
- 新增多企业版支持

updated 2021.06.08

- 新增开发模式配置
- 新增印章申请工作流
- 优化企业版用户列表和编辑功能
- 新增后台复杂密码验证规则
- 修复企业版帮助中心接口bug

updated 2021.06.09

- 新增分类代码模板
- 新增yiiframe代码模块

updated 2021.06.16

- 修复个别插件没安装行为监控模块时出错的bug

updated2021.07.08
- 接口增加伪删除方法
- 增加gii API Generator

updated2021.07.14
- 默认关闭开发模式
- 修复行为监控bug

updated2021.08.18
- 新增国际化多语言包

updated2021.08.20
- 修复客户端重置工作流bug
- 修改企业版用户角色关联bug

updated2021.08.21
- 修复不同插件路由不能跳转的bug