# 简述

- 本模板适用于快速开发一个可用的中小型的 API 服务. 如果对性能非常依赖的项目, 应答考虑直接使用 PDO 来替换 `Laravel/Database`
- 强烈建议在开发的时候, 注意解耦, 并尽可能的面向接口/抽象类进行开发, 特别是 `DAO 数据库操作层`
- 本模板默认引入的几个 PHP 依赖包都不是必须的, 可酌情进行删减

## 如何添加新的依赖
php73 composer.phar require company/lib-name

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
- 本地操作 `php migrations/create_tables.php dev`
- Production 环境 `php migrations/create_tables.php`
### 创建Mock 数据
- 仅限本地或测试环境操作 `php migrations/database_seeder.php dev`