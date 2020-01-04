#Typecho HTML 静态缓存插件

我这个老博客文章比较多，为了节省服务器资源，减少数据库读写次数，于是就花了点时间，做了typecho第一个插件

服务器配置高的话，基本上感觉不到差距，但是网站访问量大了之后，服务器资源就很紧缺了，节省一半的时间效果还是很明显的哇，哈哈哈


#安装方法
1、将SaHtmlCache.rar 解压后上传于站点/usr/plugins/目录下
2、将cache目录设为可读可写，Linux是777权限
3、修改站点根目录下index.php,添加以下代码

/**  SaHtmlCach 重定向到HTML静态文件 */
$safile = $_SERVER['REQUEST_URI'];
if(strpos($safile,'comment')<1){
    if ($safile=='/'||$safile=='index.php'){
        $safile = 'index.html';    
    }
    
    $sahtmlfile = './usr/plugins/SaHtmlCache/cache/'.$safile; 
    if(file_exists($sahtmlfile)){
        include($sahtmlfile);
        exit;
    }
}

4、后台启用插件，并生成HTML文件生成

#帮助说明

1、如何区分HTML缓存是否生效?
查看网页源代码，如果顶部有<!-- SaCache created 2020/01/04 05:05:15-->代码，说明已经成功

2、搜索功能是否影响?
不影响博客搜索页

3、分类目录页是否可以缓存？
暂时不支持

4、评论页是否支持HMTL缓存？
支持，需要定期生成HMTL文件

5、为何生成HTML比较卡？
全站生成HTML慎用，比较耗服务器资源，不过一劳永逸，耐心等待吧

6、我是否可以修改代码？
可以随便修改代码，如果您有优化过代码，或者新增了功能，记得发一份代码给我6042506@qq.com

文章来源于《傻猫网络日志》 https://dayong.wang/50402.html
