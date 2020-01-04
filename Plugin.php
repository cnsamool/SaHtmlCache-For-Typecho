<?php
/**
 * <strong style="color:blue;">HTML静态文件生成</strong>
 * @package SaHtmlCache
 * @author Samool
 * @version 1.0.0
 * @dependence 10.8.0-*
 * @link https://www.dayong.wang
 *
 * 历史版本
 * version 1.0.0 at 2020-01-04
 * 实现插件生成html静态文件功能
 *
 */

class SaHtmlCache_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return string
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        //文章、页面  新建和修改自动生成缓存页面
		/*
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = array('SaHtmlCache_Plugin', 'buildHtmlFile');
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishDelete = array('SaHtmlCache_Plugin', 'buildHtmlFile');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishPublish = array('SaHtmlCache_Plugin', 'buildHtmlFile');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishDelete = array('SaHtmlCache_Plugin', 'buildHtmlFile');
		*/
	   return _t('SaHtmlCache静态HTML插件启用，请到设置里生成文件');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
	{

	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) {

		if (isset($_GET['action']) && $_GET['action'] == 'sa_GetIndexHtml') {
            self::sa_GetIndexHtml();
        }
		
		if (isset($_GET['action']) && $_GET['action'] == 'sa_GetNewCommentsHtml') {
		    self::sa_GetNewCommentsHtml();
		}	
		
        if (isset($_GET['action']) && $_GET['action'] == 'buildDate1') {
            self::buildDate1();
        }
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildDate7') {
		    self::buildDate7();
		}
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildDate30') {
		    self::buildDate30();
		}
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildDate60') {
		    self::buildDate60();
		}
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildDate90') {
		    self::buildDate90();
		}
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildDate180') {
		    self::buildDate180();
		}
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildDate365') {
		    self::buildDate365();
		}
		
		if (isset($_GET['action']) && $_GET['action'] == 'buildAll') {
		    self::buildAll();
		}		
		

		
		$form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('首页生成HTML'), NULL));
        $queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();        
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('将首页生成静态HTML页'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=sa_GetIndexHtml',Helper::options()->adminUrl));
		$form->addItem($queryBtn);
		
		$form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('有新留言的文章生成HTML'), NULL));
		$queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();        
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('1周内有新留言的文章生成静态HTML页'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=sa_GetNewCommentsHtml',Helper::options()->adminUrl));
		$form->addItem($queryBtn);
		
		
        $form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('今日文章生成HTML'), NULL));
        $queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();        
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('将今日发布的文章生成静态HTML页'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=buildDate1',Helper::options()->adminUrl));
		$form->addItem($queryBtn);
		
		$form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('本周文章生成HTML'), NULL));
		$queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();  
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('将本周发布的文章生成静态HTML页'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=buildDate7',Helper::options()->adminUrl));
		$form->addItem($queryBtn);
		
		$form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('30天内文章生成HTML'), NULL));
		$queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();  
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('将30天内发布的文章生成静态HTML页'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=buildDate30',Helper::options()->adminUrl));
		$form->addItem($queryBtn);		
		
		
		$form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('365天内文章生成HTML'), NULL));
		$queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();  
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('将365天内发布的文章生成静态HTML页'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=buildDate365',Helper::options()->adminUrl));
		$form->addItem($queryBtn);
		
		$form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('全部文章生成HTML'), NULL));
		$queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();  	
		$queryBtn->value(_t('生成HTML'));
		$queryBtn->description(_t('通常只需要在第一次启用插件的时候，手动点击该按钮。在发布、修改文章的时候会自动构建新的缓存文件'));
		$queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
		$queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=SaHtmlCache&action=buildAll',Helper::options()->adminUrl));
		
        $form->addItem($queryBtn);

    }

  
   /**
    * 生成今日对象
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate1()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 1)
			);
       foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
	   
	   Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }
   
   
   /**
    * 生成7天内
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate7()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
   			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 7)
   			);
       foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
	   Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }
   
   /**
    * 生成7天内
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate30()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
   			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 30)
   			);
			foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
       Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }
   
   /**
    * 生成60天内
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate60()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
   			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 60)
   			);
       foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
      Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }
   
   /**
    * 生成90天内
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate90()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
   			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 90)
   			);
       foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
      Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }
   
   /**
    * 生成180天内
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate180()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
   			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 180)
   			);
		foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
      Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }
   
   /**
    * 生成365天内
    *
    * @access private
    * @param $type
    * @return array
    */
   private static function buildDate365()
   {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
   			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(modified))<=?', 365)
   			);
       foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
      Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
   }

    /**
     * 生成所有对象
     *
     * @access private
     * @param $type
     * @return array
     */
    private static function buildAll()
    {
        $db = Typecho_Db::get();
        $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type <> ?', 'attachment')
			->where('table.contents.type <> ?', 'page_draft')
            ->where('table.contents.status = ?', 'publish'));
        foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
        }
       Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
    }
	
    /**
     * 首页生成HTML文件内容
     *
     * @access private
     * @param $cid
     * @return htmlcontent
     */
    private static function sa_GetIndexHtml()
    {
        //配置您的域名地址
        $domain	= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/';
        
        $url = $domain.'index.php';
		$savefile = __DIR__.'/cache/'.'index.html';
		if(file_exists($savefile)){
			unlink($savefile);
		}
        
        ob_start(); //打开缓冲区
        include($url);   //获取html内容
        $time = date("Y/m/d h:i:s");
        $content  ="<!-- SaCache created ".$time."-->\n";
        $content .= ob_get_contents(); //得到缓冲区的内容
        //写入文件
        file_put_contents($savefile, $content);
        Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
    }	

    /**
     * 最近一个月有新留言的文章生成HTML文件内容
     *
     * @access private
     * @param $cid
     * @return htmlcontent
     */
    private static function sa_GetNewCommentsHtml()
    {
       $db = Typecho_Db::get();
       $rows = $db->fetchAll($db->select('cid')->from('table.comments')
   			->where('DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(created))<=?', 30)
			->group('cid')
   			);
       foreach ($rows as $row) {
            $cid = $row['cid'];
			self::sa_GetHtmlContent($cid);
       }
      Typecho_Widget::widget('Widget_Notice')->set(_t("HTML生成成功，去博客试试效果吧"), 'success');
    }	


    /**
     * 根据 cid 生成HTML文件内容
     *
     * @access private
     * @param $cid
     * @return htmlcontent
     */
    private static function sa_GetHtmlContent($cid)
    {
        //配置您的域名地址
        $domain	= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/';
        
        $url = $domain.$cid.'.html';
		
		$savefile = __DIR__.'/cache/'.$cid.'.html';
		if(file_exists($savefile)){
			unlink($savefile);
		}
        
        ob_start(); //打开缓冲区
        include($url);   //获取html内容
		$time = date("Y/m/d h:i:s");
        $content  ="<!-- SaCache created ".$time."-->\n";
        $content .= ob_get_contents(); //得到缓冲区的内容
		//写入文件
		file_put_contents($savefile, $content);	
    }
	
	/**
	 * 个人用户的配置面板
	 * 
	 * @access public
	 * @param Typecho_Widget_Helper_Form $form
	 * @return void
	 */
	public static function personalConfig(Typecho_Widget_Helper_Form $form) {}


}


class Title_Plugin extends Typecho_Widget_Helper_Form_Element
{

    public function label($value)
    {
        /** 创建标题元素 */
        if (empty($this->label)) {
            $this->label = new Typecho_Widget_Helper_Layout('label', array('class' => 'typecho-label', 'style'=>'font-size: 2em;border-bottom: 1px #ddd solid;padding-top:2em;'));
            $this->container($this->label);
        }

        $this->label->html($value);
        return $this;
    }

    public function input($name = NULL, array $options = NULL)
    {
        $input = new Typecho_Widget_Helper_Layout('p', array());
        $this->container($input);
        $this->inputs[] = $input;
        return $input;
    }

    protected function _value($value) {}

}