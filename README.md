# 简述

- 项目地址 https://www.webmelbourne.com/page/blog/php-yaf-mvc-framework
- 本模板适用于快速开发一个可用的中小型的 API 服务. 如果对性能非常依赖的项目, 后期考虑直接使用 PDO 来替换 `Laravel/Database`
- 强烈建议在开发的时候, 注意解耦, 并尽可能的面向接口/抽象类进行开发, 特别是 `DAO 数据库操作层`
- 本模板默认引入的几个 PHP 依赖包都不是必须的, 可酌情进行删减

## 如何添加新的依赖
php73 composer.phar require company/lib-name

## 安装PHP扩展

- 注意使用pecl安装的时候, 注意要通过 `pecl channel-update pecl.php.net` 命令更新pecl的channel信息
- 必须安装: yaf (我推荐通过直接编译php的源码, yaf的源码来进行安装, 特别是生产环境. 在测试环境中, 可以通过 `pecl install yaf` 命令也没问题)
- 选择安装: uuid (推荐), 如果要生产uuid字符串, 那么最好通过扩展的方式. 源码安装uuid扩展或者通过 `pecl install uuid` 进行安装. 注意该扩展需要操作系统已经安装了 `libuuid` 库

## 使用数据库 ORM: Eloquent
https://github.com/illuminate/database

## 运行测试用例
- 测试用例仅限于在本地开发环境和测试环境运行, 严禁在 Production 服务器运行
```bash
php73 ./vendor/bin/phpunit

OR

php73 ./vendor/bin/phpunit --filter=your_test_case
```

## 数据库的 migration
### 创建数据库表

在创建数据库表之前, 请先拷贝 `migrations/get_db_connection.example.php` 文件并命名一个新文件 `migrations/get_db_connection.php`
- 本地操作 `php migrations/create_tables.php dev`
- Production 环境 `php migrations/create_tables.php`

### 创建Mock 数据
- 仅限本地或测试环境操作 `php migrations/database_seeder.php dev`

## 目录结构

> project  应用部署目录

    .
    ├── .htaccess               # 用于 apache 的重写
    ├── README.md               # README 文件
    ├── phpunit.xml             # 单元测试配置文件
    ├── composer.json           # 这个就不用说了
    ├── application             # 应用程序主目录
    │   ├── Bootstrap.php           # yaf引导程序 yaf全局配置入口
    │   ├── controllers             # 控制器目录
    │   ├── helpers                 # 公共帮助方法目录
    │   ├── library                 # yaf本地类库目录
    │   ├── models                  # DB 模型目录
    │   ├── plugins                 # 插件目录
    │   ├── services                # 自己创建类库目录
    │   │   ├── database                # 数据库工具类
    │   │   ├── queue                   # 队列工具类
    │   │   ├── redis                   # Redis工具类
    │   │   │   ├── contracts               # Redis工具类抽象接口定义
    │   │   │   └── impl                    # Redis工具类实现类
    │   │   │       ├── phpredis
    │   │   │       └── predis
    │   │   ├── requests                # 进入应用程序的请求类
    │   │   ├── responses               # 应用程序的响应类
    │   │   └── utils                   # 自定义的任意工具类
    │   │       ├── contracts               # 自定义的任意工具类抽象接口
    │   │       └── impl                    # 自定义的任意工具类的实现
    │   └── views                   # 视图文件目录
    │       ├── error
    │       └── index
    ├── conf                    # yaf的配置文件
    ├── migrations              # 数据库生成文件
    ├── vendor                  # 第三方类库目录（Composer）
    ├── public                  # WEB 部署目录（对外访问目录）
    │   ├── index.php           # 项目入口文件
    └── tests                   # 测试用例目录
        ├── feature                 # 功能测试
        └── unit                    # 单元测试


