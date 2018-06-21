### 解决的问题

1. 页面标题、按钮等的多语言呈现
2. 请求接口错误提示支持多语言

**效果如下图**

![中文.png](https://upload-images.jianshu.io/upload_images/8189586-7037c158bf38e6ef.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![英文.png](https://upload-images.jianshu.io/upload_images/8189586-0a20160cf84f8d80.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

### 安装

1. 把morelang文件夹放在application/extend/即可

### 使用(1):

**页面标题、按钮等的多语言呈现**

**流程**

![页面呈现流程.png](https://upload-images.jianshu.io/upload_images/8189586-d8a262fe7b1ca2ea.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

1. 服务端

   * 在需要加载语言包的地方调用return Morelang::loadLangFile();
   * 建议写在父级控制器的构造方法或者,控制器方法的前置钩子方法中
   * 在使用时一定记得类的顶部引入命名空间use Morelang\Morelang;

   

2. 语言包的加载顺序:当前模块的lang/->application/lang->框架的lang/

   * 仅本模块使用的放在当前模块的lang/下

   * 本架构项目公用的:比如公司名称、返回按钮等建议写在application/lang

   * 建议中文简体包命名zh-cn.php，英语建议en-us.php如果有扩展，命名请和extend/morelang/Morelang.php里面的方法getFileName()，getBrowserLangType()以及extend/morelang/LangEnum.php()做好相应扩展

     ~~~php+HTML
     <?php
     /**语言包基本格式：扩展语言时，key值保持统一不变，value修改为对应语言
     * 项目-中文语言文件（zh-cn.php）
     */
     return [
         'return'=>'返回',
         'logout'=>'退出',
     ];
     ~~~

     ~~~php+HTML
     <?php
     /**语言包基本格式：扩展语言时，key值保持统一不变，value修改为对应语言
     * 项目-英语语言文件（en-us.php）
     */
     return [
         'return'=>'return',
         'logout'=>'Logout',
     ];
     ~~~

   * **记住是3个地方相应扩展**

3. 客户端

   ~~~html
   //{$Tink.lang.语言包的key}
   <button class="button">{$Think.lang.logout}</button>
   ~~~

4. 前端一键切换

   * 如果需要做此功能服务端只需要为客户端提供一个切换语言接口，传递参数lang此参数需要和extend/morelang/LangEnum.php()做对应，当ajax请求成功后刷新此页面即可

   * 服务端调用Morelang::changeLang();就可实现

     ~~~php
     //此接口主要看执行的一行代码，其余的可以忽略
     public function changeLang()
         {
             #参数验证
             (New LangtypeVal())->goCheck($scene = '');
             # 执行
             Morelang::changeLang();
             #返回
             throw New SuccessEx();
         }//pf
     ~~~

     

### 使用(2):

**请求接口错误提示支持多语言**

待完善。。。



