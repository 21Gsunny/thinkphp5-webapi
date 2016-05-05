## 基本流程

1. fork本项目；
2. 克隆（clone）你 fork 的项目到本地；
3. 新建分支（branch）并检出（checkout）新分支；
4. 添加本项目到你的本地 git 仓库作为上游（upstream）；
5. 进行修改，若你的修改包含方法或函数的增减，请记得修改[单元测试文件](thinkphp/tests)；
6. 变基（衍合 rebase）你的分支到上游 master 分支；
7. push 你的本地仓库到 github；
8. 提交 pull requests；
9. 等待 CI 验证（若不通过则重复 5~7，github 会自动更新你的 pull requests）；
10. 等待管理员处理，并及时 rebase 你的分支到上游 master 分支（若上游 master 分支有修改），若有必要，可以 `git push -f` 强行推送 rebase 后的分支到自己的 github fork。

## 注意事项

* 本项目代码格式化标准选用 **PSR-2**；
* 类名和类文件名遵循 **PSR-4**；
* 若对上述修改流程有任何不清楚的地方，请查阅 GIT 教程，如 [这个](http://backlogtool.com/git-guide/cn/)；
* CI 会在 PHP 5.4 5.5 5.6 7.0 和 HHVM 上进行测试，其中 HHVM 下的测试容许报错，请确保你的修改符合 PHP 5.4~5.6 和 PHP 7.0 的语法规范；
* 管理员不会合并造成 CI faild 的修改，若出现 CI faild 请检查自己的源代码或修改相应的[单元测试文件](thinkphp/tests)；
* 对于代码**不同方面**的修改，请在自己 fork 的项目中**创建不同的分支**（原因参见`修改流程`第9条备注部分）；
* 对于 Issues 的处理，请在 pull requests 时使用诸如 `fix #xxx(Issue ID)` 的 title 直接关闭 issue。
* 变基及交互式变基操作参见 [Git 交互式变基](http://pakchoi.me/2015/03/17/git-interactive-rebase/)

## 推荐资源

### 开发环境

* XAMPP for Windows 5.5.x
* WampServer (for Windows)
* upupw Apache PHP5.4 ( for Windows)

或自行安装

- Apache / Nginx
- PHP 5.4 ~ 5.6
- MySQL / MariaDB

*Windows 用户推荐添加 PHP bin 目录到 PATH，方便使用 composer*
*Linux 用户自行配置环境， Mac 用户推荐使用内嵌 Apache 配合 Homebrew 安装 PHP 和 MariaDB*

### 编辑器

Sublime Text 3 + phpfmt 插件

phpfmt 插件参数

```json
{
	"enable_auto_align": true,
	"indent_with_space": true,
	"psr1_naming": true,
	"psr2": true,
	"version": 1
}
```

或其他 编辑器 / IDE 配合 PSR2 自动格式化工具

### Git GUI

* SourceTree
* GitHub Desktop

或其他 Git 图形界面客户端
