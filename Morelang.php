<?php
/**
 * Created by PhpStorm
 * PROJECT: water_adu
 * User: Doing<vip.dulin@gmial.com>
 * Date: 2018/6/20 0020/上午 11:57
 * Desc:多语言加载扩展类
 */

namespace Morelang;


use think\Lang;

class Morelang {
    /**加载对应语言包文件-主方法
     * @return mixed
     */
    public static function loadLangFile()
    {
        //获取语言类型 和语言包名称
        $lang_file = self::getFileName(self::getLangType());
        //模块
        $module = request()->module();
        $path = '../application/' . $module . '/lang/' . $lang_file . EXT;
        return Lang::load($path);
    }//pf

    /**自动获取浏览器语言 并转换成枚举数字
     * @return int
     */
    public static function getLangType()
    {
        //是否存在 存在就直接返回
        $type = self::isHave();
        if ($type) return $type;
        //获取浏览器语言包
        $type = self::getBrowserLangType();
        #保存语言
        self::changeLang($type);
        return $type;
    }//pub

    /** 简述:切换语言包
     *
     * @params
     * 把语言type放在当前模块的lang的session里面
     * [index][lang] = 1
     * @param string $lang
     *
     * @return bool
     */
    public static function changeLang($lang = '')
    {
        if ($lang)
        {
            $data['lang'] = $lang;
        }else
        {
            $data['lang'] = (int)input('post.lang');
        }
        session(request()->module(), $data);
        return true;
    }

    /** 简述:获取语言包文件名
     * @params $lang_type
     */
    private static function getFileName($lang_type)
    {
        switch ($lang_type)
        {
            case LangEnum::ZH_C:
                $file_name = 'zh-cn';
                break;
            case LangEnum::ENGLISH:
                $file_name = 'en-us';
                break;
        }//switch
        return $file_name;

    }//pf


    /**是否已设置过语言包
     * @return mixed
     */
    private static function isHave()
    {
        $module = request()->module();
        return session($module)['lang'];
    }//pf

    /** 简述:获取浏览器语言type
     *
     * @params
     *
     */
    private static function getBrowserLangType()
    {
        //只取前4位，这样只判断最优先的语言。如果取前5位，可能出现en,zh的情况，影响判断。
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        //默认语言:可以在配置文件写
        $type = LangEnum::ZH_C;
        if (preg_match("/zh-c/i", $lang))
            $type = LangEnum::ZH_C;
        else if (preg_match("/en/i", $lang))
            $type = LangEnum::ENGLISH;
        return $type;
    }//pf


}//class