<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * 模板测试
 * @author    Haotong Lin <lofanmi@gmail.com>
 */

namespace tests\thinkphp\library\think;

use think\Template;

class templateTest extends \PHPUnit_Framework_TestCase
{
    public function testVar()
    {
        $template = new Template();

        $content = <<<EOF
{\$name.a.b}
EOF;
        $data = <<<EOF
<?php echo \$name['a']['b']; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a??'test'}
EOF;
        $data = <<<EOF
<?php echo isset(\$name['a']) ? \$name['a'] : 'test'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a?='test'}
EOF;
        $data = <<<EOF
<?php if(!empty(\$name['a'])) echo 'test'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a?:'test'}
EOF;
        $data = <<<EOF
<?php echo !empty(\$name['a'])?\$name['a']:'test'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a?\$name.b:'no'}
EOF;
        $data = <<<EOF
<?php echo !empty(\$name['a'])?\$name['b']:'no'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a==\$name.b?='test'}
EOF;
        $data = <<<EOF
<?php if(\$name['a']==\$name['b']) echo 'test'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a==\$name.b?'a':'b'}
EOF;
        $data = <<<EOF
<?php echo (\$name['a']==\$name['b'])?'a':'b'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a|default='test'==\$name.b?'a':'b'}
EOF;
        $data = <<<EOF
<?php echo ((isset(\$name['a']) && (\$name['a'] !== '')?\$name['a']:'test')==\$name['b'])?'a':'b'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name.a|trim==\$name.b?='eq'}
EOF;
        $data = <<<EOF
<?php if(trim(\$name['a'])==\$name['b']) echo 'eq'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{:ltrim(rtrim(\$name.a))}
EOF;
        $data = <<<EOF
<?php echo ltrim(rtrim(\$name['a'])); ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{~echo(trim(\$name.a))}
EOF;
        $data = <<<EOF
<?php echo(trim(\$name['a'])); ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{++\$name.a}
EOF;
        $data = <<<EOF
<?php echo ++\$name['a']; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{/*\$name*/}
EOF;
        $data = '';

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$0a}
EOF;
        $data = '{$0a}';

        $template->parse($content);
        $this->assertEquals($data, $content);

    }

    public function testVarFunction()
    {
        $template = new Template();

        $content = <<<EOF
{\$name.a.b|default='test'}
EOF;
        $data    = <<<EOF
<?php echo (isset(\$name['a']['b']) && (\$name['a']['b'] !== '')?\$name['a']['b']:'test'); ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$create_time|date="y-m-d",###}
EOF;
        $data    = <<<EOF
<?php echo date("y-m-d",\$create_time); ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
{\$name}
{\$name|trim|substr=0,3}
EOF;
        $data    = <<<EOF
<?php echo \$name; ?>
<?php echo substr(trim(\$name),0,3); ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);
    }

    public function testVarIdentify()
    {
        $config['tpl_begin']        = '<#';
        $config['tpl_end']          = '#>';
        $config['tpl_var_identify'] = '';
        $template                   = new Template($config);

        $content = <<<EOF
<#\$info.a??'test'#>
EOF;
        $data    = <<<EOF
<?php echo (is_array(\$info)?\$info['a']:\$info->a) ? (is_array(\$info)?\$info['a']:\$info->a) : 'test'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
<#\$info.a==\$info.b?='test'#>
EOF;
        $data    = <<<EOF
<?php if((is_array(\$info)?\$info['a']:\$info->a)==(is_array(\$info)?\$info['b']:\$info->b)) echo 'test'; ?>
EOF;

        $template->parse($content);
        $this->assertEquals($data, $content);

        $content = <<<EOF
<#\$info.a|default='test'?'yes':'no'#>
EOF;
        $data    = <<<EOF
<?php echo ((is_array(\$info)?\$info['a']:\$info->a) !== ''?(is_array(\$info)?\$info['a']:\$info->a):'test')?'yes':'no'; ?>
EOF;
        $template->parse($content);
        $this->assertEquals($data, $content);

        $template2 = new Template();
        $template2->tpl_var_identify = 'obj';
        $content = <<<EOF
{\$info2.b|trim?'yes':'no'}
EOF;
        $data = <<<EOF
<?php echo trim(\$info2->b)?'yes':'no'; ?>
EOF;
        $template2->parse($content);
        $this->assertEquals($data, $content);
    }

    public function testTag()
    {
        $config['tpl_path'] = dirname(__FILE__) . '/';
        $config['tpl_suffix'] = '.html';
        $template = new Template($config);

        $content = <<<EOF
{extend name="extend" /}
{block name="main"}
    {include file="include" name="\$user.name" value="\$user.account" /}
    {\$message}{literal}{\$message}{/literal}
{/block}
EOF;
        $data = <<<EOF
<nav>
<div>
    <input name="<?php echo \$info['name']; ?>" value="<?php echo \$info['value']; ?>">

    <input name="<?php echo \$user['name']; ?>" value="<?php echo \$user['account']; ?>">
    <?php echo \$message; ?>{\$message}


    {\$name}

    <?php echo 'php code'; ?>
</div>
</nav>
EOF;
        $template->parse($content);
        $this->assertEquals($data, $content);
    }

    public function testThinkVar()
    {
        $config['tpl_begin'] = '{';
        $config['tpl_end'] = '}';
        $template = new Template($config);

        $_SERVER['SERVER_NAME'] = 'server_name';
        $_GET['action'] = 'action';
        $_POST['action'] = 'action';
        \think\Cookie::set('action', ['name' => 'name']);
        \think\Session::set('action', ['name' => 'name']);
        define('SITE_NAME', 'site_name');

        $content = <<<EOF
{\$Think.SERVER.SERVER_NAME}<br/>
{\$Think.GET.action}<br/>
{\$Think.POST.action}<br/>
{\$Think.COOKIE.action}<br/>
{\$Think.COOKIE.action.name}<br/>
{\$Think.SESSION.action}<br/>
{\$Think.SESSION.action.name}<br/>
{\$Think.ENV.OS}<br/>
{\$Think.REQUEST.action}<br/>
{\$Think.CONST.SITE_NAME}<br/>
{\$Think.LANG.action}<br/>
{\$Think.CONFIG.action.name}<br/>
{\$Think.NOW}<br/>
{\$Think.VERSION}<br/>
{\$Think.LDELIM}<br/>
{\$Think.RDELIM}<br/>
{\$Think.SITE_NAME}<br/>
{\$Think.SITE.URL}
EOF;
        $data = <<<EOF
<?php echo \$_SERVER['SERVER_NAME']; ?><br/>
<?php echo \$_GET['action']; ?><br/>
<?php echo \$_POST['action']; ?><br/>
<?php echo \\think\\Cookie::get('action'); ?><br/>
<?php echo \$_COOKIE['action']['name']; ?><br/>
<?php echo \\think\\Session::get('action'); ?><br/>
<?php echo \$_SESSION['action']['name']; ?><br/>
<?php echo \$_ENV['OS']; ?><br/>
<?php echo \$_REQUEST['action']; ?><br/>
<?php echo SITE_NAME; ?><br/>
<?php echo \\think\\Lang::get('action'); ?><br/>
<?php echo \\think\\Config::get('action.name'); ?><br/>
<?php echo date('Y-m-d g:i a',time()); ?><br/>
<?php echo THINK_VERSION; ?><br/>
<?php echo '{'; ?><br/>
<?php echo '}'; ?><br/>
<?php echo SITE_NAME; ?><br/>
<?php echo ''; ?>
EOF;
        $template->parse($content);
        $this->assertEquals($data, $content);
    }

    public function testDisplay()
    {
        $template = new Template();
        $template->assign('name', 'name');
        $config = [
            'strip_space' => true,
            'tpl_path' => dirname(__FILE__) . '/',
        ];
        $data = ['name' => 'value'];
        $template->display('display', $data, $config);
        $this->expectOutputString('value');
    }

    public function testFetch()
    {
        $template = new Template();
        $template->tpl_path = dirname(__FILE__) . '/';
        $data = ['name' => 'value'];
        $content = <<<EOF
{\$name}
EOF;

        $template->fetch($content, $data);
        $this->expectOutputString('value');
    }

    public function testVarAssign()
    {
        $template = new Template();
        $template->assign('name', 'value');
        $value = $template->get('name');
        $this->assertEquals('value', $value);
    }
}
